<?php
$con = $rid['sqlConnect'];
$u = $_SESSION['rid_username'];
$datadefp = $rid['dataUser'];
if ($f == 'change_password') {
    if (rid_check_x($datadefp['rid_username']) !== 'expired') {
    $u = $_SESSION['rid_username'];
    $password = post('newpassword');
    if (strlen($password) < 5) {
        $respona = array (
            "status"=> false,
            "message"=> "Password must be more than 5 characters"
        );
        echo json_encode($respona);
    } else if (post("newpassword") != post("newpassword2")) {
        $respona = array(
            "status"=> false,
            "message"=> "Password does not match"
        );
        echo json_encode($respona);
    } else {
        $p = password_hash(post("newpassword"), PASSWORD_DEFAULT);
        $u = $_SESSION['rid_username'];
        $q = mysqli_query($con, "UPDATE rid_account SET rid_password = '$p' WHERE rid_username = '$u' ");
        if ($q == true) {
            $respona = array(
                "status"=> 200,
                "message"=> "Successfully"
            );
            echo json_encode($respona);
        } else {
            $respona = array(
                "status"=> false,
                "message"=> rid_lang('system_error')
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