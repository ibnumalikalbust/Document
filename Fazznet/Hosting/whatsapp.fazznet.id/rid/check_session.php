<?php
if (!$_SESSION['rid_username']) {
	$status = false;
	$msg = "NotLogged";
	$responya = array(
		"status"=> $status,
		"msg"=> $msg
	);
	die(json_encode($responya));
} else {
	if ($rid['loggedin'] == true) {
		$u = $_SESSION['rid_username'];
	    $d = $rid['sqlConnect']->query("SELECT * FROM rid_account WHERE rid_username = '$u'");
	    if ($d->num_rows < 1) {
	        setcookie("deleted_acc", "1");
	        $status = false;
	        $msg = "Account was deleted!";
	        $responya = array(
	        	"status"=> $status,
	        	"msg"=> $msg
	        );
	        die(json_encode($responya));
	    } else {
	        $d = $d->fetch_assoc();
	        if ($d['cookie'] == '') {
	            setcookie("forced", "1");
	            $status = false;
		        $msg = "Account was forced!";
		        $responya = array(
		        	"status"=> $status,
		        	"msg"=> $msg
		        );
		        die(json_encode($responya));
	        }
	    }
	    $status = true;
		$msg = "Loggedin";
		$responya = array(
			"status"=> $status,
			"msg"=> $msg
		);
		die(json_encode($responya));
	} else {
		$status = false;
		$msg = "NotLogged";
		$responya = array(
			"status"=> $status,
			"msg"=> $msg
		);
		die(json_encode($responya));
	}
}