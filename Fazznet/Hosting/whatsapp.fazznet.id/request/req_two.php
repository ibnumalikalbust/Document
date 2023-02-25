<?php
require('../require/f.php');
$req = get('req');

if ($req == 'ucapan') {
    $ucapan = ucapan();
    $respona = array(
        "status"=> 200,
        "message"=> $ucapan
    );
    echo json_encode($respona);
} else if ($req == 'login-with-otp') {
    $c_wa = $_GET['c_wa'];
    $cek = mysqli_query($con, "SELECT * FROM rid_account WHERE c_wa = '$c_wa'");
    if (mysqli_num_rows($cek) > 0) {
        $datauser = mysqli_fetch_assoc($cek);
        // start session
        $_SESSION['rid_username'] = $datauser['rid_username'];
        $_SESSION['rid_level'] = $datauser['level'];
        $rand = rand(10000,99999);
        mysqli_query($con, "UPDATE rid_account SET v_otp = '$rand' WHERE c_wa = '$c_wa'");
        $message = urlencode(str_replace("[OTP]", "$rand", $rid['web_setting']['msg_verification']));
        sendMSG($rid['web_setting']['no_wa'], $c_wa, $message);
        $responya = array(
            "status"=> 200,
            "msg"=> "Successfully"
        );
        echo json_encode($responya);
    } else {
        $responya = array(
            "status"=> false,
            "msg"=> "not found"
        );
        echo json_encode($responya);
    }
} else if ($req == 'verify-otp') {
    $v_otp = $_GET['v_otp'];
    $u = $_SESSION['rid_username'];
    $cek = mysqli_query($con, "SELECT * FROM rid_account WHERE rid_username = '$u' AND v_otp = '$v_otp'");
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($con, "UPDATE rid_account SET v_otp = '' WHERE rid_username = '$u'");
        $responya = array(
            "status"=> 200,
            "msg"=> "done"
        );
        echo json_encode($responya);
    } else {
        $responya = array(
            "status"=> false,
            "msg"=> "otp tidak valid"
        );
        echo json_encode($responya);
    }
} else if ($req == 'check-account') {
    $estr = $_GET['estr'];
    $ceks = mysqli_query($con, "SELECT * FROM rid_account WHERE rid_username = '$estr'");
    if (mysqli_num_rows($ceks) > 0) {
        $responya = array(
            "status"=> false,
            "msg"=> "Username already used"
        );
        echo json_encode($responya);
    } else {
        $ceks = mysqli_query($con, "SELECT * FROM rid_account WHERE c_wa = '$estr'");
        if (mysqli_num_rows($ceks) > 0) {
            $responya = array(
                "status"=> false,
                "msg"=> "Whatsapp Number already used"
            );
            echo json_encode($responya);
        } else {
            $ceks = mysqli_query($con, "SELECT * FROM rid_account WHERE email = '$estr'");
            if (mysqli_num_rows($ceks) > 0) {
                $responya = array (
                    "status"=> false,
                    "msg"=> "email already used"
                );
                echo json_encode($responya);
            } else {
                $responya = array(
                    "status"=> 200,
                    "msg"=> "ready to use"
                );
                echo json_encode($responya);
            }
        }
    }
} else if ($req == 'artinama') {
    $nama = $_GET['nama'];
    $g = json_decode(file_get_contents("https://api.ridped.com/api?feature=artinama&name=$name&apikey=R!dp3d"), true);
    if ($g['status'] == false) {
        $responya = array(
            "status"=> false,
            "msg"=> "Ada kesalahan system"
        );
        echo json_encode($responya);
    } else {
        echo json_encode($g);
    }
    
}