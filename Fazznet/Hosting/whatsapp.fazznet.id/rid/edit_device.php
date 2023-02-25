<?php
$u = $_SESSION['rid_username'];
$con = $rid['sqlConnect'];
$datadefp = $rid['dataUser'];
if ($f == 'edit_device') {
    if (rid_check_x($datadefp['rid_username']) !== 'expired') {
    $u = $_SESSION['rid_username'];
    $id = post('id');
    $webhook = post('webhook');
    $auto_read = post('auto_read');
    if (!empty($id)) {
        $update = mysqli_query($con, "UPDATE device SET link_webhook = '$webhook', auto_read = '$auto_read' WHERE id = '$id'");
        $respona = array(
            "status"=> 200,
            "message"=> "Succesfully"
        );
        echo json_encode($respona);
    } else {
        $respona = array(
            "status"=> false,
            "message"=> "Nothing"
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