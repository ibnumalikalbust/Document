<?php
$con = $rid['sqlConnect'];
$u = $_SESSION['rid_username'];
$datadefp = $rid['dataUser'];
if ($f == 'edit_autoreply') {
    if (rid_check_x($datadefp['rid_username']) !== 'expired') {
    $u = $_SESSION['rid_username'];
    $keyword = post('keyword');
    $response = post('response');
    $id = post('id') ? post('id') : get('id');
    $cek = mysqli_query($con, "SELECT * FROM auto_reply WHERE id = '$id'");
    if (mysqli_num_rows($cek) > 0) {
        if (get('act') == 'del') {
            $update = mysqli_query($con, "DELETE FROM auto_reply WHERE id = '$id'");
            if ($update == true) {
                $respona = array(
                    "status"=> 200,
                    "message"=> "Succes"
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
        $update = mysqli_query($con, "UPDATE auto_reply SET keyword = '$keyword', response = '$response' WHERE id = '$id'");
        if ($update == true) {
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
            "message"=> "Nothing $response"
        );
        echo json_encode($respona);
    }
    
    } else {
    $responya = array(
        "status"=> false,
        "message"=> "Your account has been expired"
    );
    echo json_encode($responya);
    }
}