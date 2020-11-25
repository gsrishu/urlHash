<?php
include 'db_connect.php';
$response="fail to create hash";
$myobject=array();
$success = "fail";
if(isset($_REQUEST['url'],$_REQUEST['time'])){
   $url=  $_REQUEST['url'];
   $l = substr(md5('$url'), 0, 2);
   $l = $l.''.substr(md5('$url'), 10, 2);
   $l = $l.''.substr(md5('$url'), 20, 2);
   $l = $l.''.substr(md5('$url'), 30, 2);
   $ti = htmlspecialchars($_REQUEST['time']);
   $dTime = 0;
    if($stmt = $mysqli->prepare("DELETE FROM `urlhash` WHERE url = ? AND time < ?")){
        $stmt->bind_param('si',$l,$dTime);
        if($stmt->execute() ){
            $s = "success";

        }else{trigger_error($stmt->error);}

        $stmt->close();
    }
    else {
        die("Error: " . $mysqli->error);
    }
	
	
     if($stmt = $mysqli->prepare("SELECT `actual`,`time` from `urlhash` as u where u.url = ?" )){
        
        $stmt->bind_param('s', $l);
        $stmt->execute() or trigger_error($stmt->error);
        $stmt->bind_result($actual,$time);
        $flag = 0;
            while($stmt->fetch()){
			if($time > 0){
				$flag = 1;
			$myobject["url"]="url already exists";
            $success = "success";
			}
            
        }
	 }

   if($flag == 0){
	     if($query = $mysqli->prepare("INSERT INTO `urlhash`(`url`, `time`,`actual`) VALUES (?,?,?)")){
		
        $query->bind_param('sss', $l,$ti,$url);  
		
        if($query->execute()){
            $success = "true";
			$myobject = "http://www.gs.com/".$l;
        }
        else{
            $myobject="Error while executing the query";
        }
        $query->close();
    
    }
    else {
        die("Error: " . $mysqli->error);
    }
   }
}
header('Content-type: application/json');
echo json_encode(array( "hashUrl" => $myobject, "success" => $success,"noOfTime"=>$ti));
?>
