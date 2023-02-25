<?php
$con = $rid['sqlConnect'];
$u = $_SESSION['rid_username'];
$datadefp = $rid['dataUser'];
if ($f == 'add_autoreply') {
    if (rid_check_x($datadefp['rid_username']) !== 'expired') {
    $u = $_SESSION['rid_username'];
    $keyword = post('keyword');
    $response = $_POST['response'];
    $sender = post('sender');
    $cek = mysqli_query($con, "SELECT * FROM auto_reply WHERE nomor = '$sender' AND keyword = '$keyword'");
    if (mysqli_num_rows($cek) > 0) {
        $respona = array(
            "status"=> false,
            "message"=> rid_lang('numb_with_key_already')
        );
        echo json_encode($respona);
    } else {
        if ($datadefp['send_msg'] == '1') {
        $q = mysqli_query($con, "INSERT INTO auto_reply VALUES ('','$keyword','$response',null,'$sender','$u',null)");
        if ($q == true) {
            $respona = array(
                "status"=> 200,
                "message"=> rid_lang('success_added')
            );
            echo json_encode($respona);
        } else {
            $respona = array(
                "status"=> false,
                "message"=> rid_lang('system_error')
            );
            echo json_encode($respona);
        }
        } else {
            $respona = array(
                "status"=> false,
                "message"=> "Your can't access this feature"
            );
            echo json_encode($respona);
        }
    }
    
    } else {
    $responya = array(
        "status"=> false,
        "message"=> "Your account has been expired"
    );
    echo json_encode($responya);
    }
}