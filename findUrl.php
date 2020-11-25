<?php
include 'db_connect.php';
$response="fail to create hash";
$myobject=array();
$success = "fail";
if(isset($_REQUEST['url'])){
   $url=  $_REQUEST['url'];
   $t =  substr($url, -8);
   if($stmt = $mysqli->prepare("SELECT `actual`,`time` from `urlhash` as u where u.url = ?" )){
        
        $stmt->bind_param('s', $t);
        $stmt->execute() or trigger_error($stmt->error);
        $stmt->bind_result($actual,$time);
        $success = "No url Found";
		$flag = 0;
		$k = 0;
            while($stmt->fetch()){
				$flag = 1;
				$k = $time - 1;
			if($time > 0){
				$myobject["url"]=$actual;
            $success = "success";
			}else{
				$myobject["url"] = "Url reterive limit is exceed";
				$success = "success";
			}
            
        }
		if($flag == 1){
			//$success = "dgdg";
			 if($stmt =$mysqli->prepare("UPDATE `urlhash` SET `time`= ? where url = ? ")){
        $stmt->bind_param('is', $k,$t);
        if ($stmt->execute()) {
            $success = "success";
        } else {
            $result=trigger_error($stmt->error);
        }
    }else{
        $result= $mysqli->error;
    }
		}
        $stmt->close();
    
    }
    else {
        die("Error: " . $mysqli->error);
    }
}
header('Content-type: application/json');
echo json_encode(array( "hashUrl" => $myobject, "success" => $success));
?>
