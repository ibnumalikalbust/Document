<?php
$con = $rid['sqlConnect'];
if ($f == 'f_data_sender') {
    $sender = $_GET['sender'];
    $check = mysqli_query($con, "SELECT * FROM device WHERE nomor = '$sender'");
    if (mysqli_num_rows($check) > 0) {
        $d = mysqli_fetch_assoc($check);
        $response = array(
            "state"=> $d['state'],
            "stts"=> $d['status'],
            "qrcode"=> $d['qrcode'] ? $d['qrcode'] : 'isLogged'
        );
        echo json_encode($response);
    }
}