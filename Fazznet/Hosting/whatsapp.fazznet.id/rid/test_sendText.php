<?php
$con = $rid['sqlConnect'];
$u = $_SESSION['rid_username'];
$datadefp = $rid['dataUser'];
if ($f == 'test_sendText') {
    if (rid_check_x($datadefp['rid_username']) !== 'expired') {
    $u = $_SESSION['rid_username'];
    $sender = post('sender');
    $pesan = $_POST['pesan'];
    $pesan = urlencode($pesan);
    $nomor = post('nomor');
    $noo = explode(',', $nomor);
    if (!empty($pesan) && $datadefp['send_msg'] == '1') {
        foreach ($noo as $ky) {
            $send = sendMSG($sender, $ky, $pesan);
        }
        if ($send['Status']['status'] == 200) {
            $respona = array(
                "status"=> 200,
                "message"=> "Successfully"
            );
            echo json_encode($respona);
        } else {
            $respona = array(
                "status"=> false,
                "message"=> $send['Status']['message']
            );
            echo json_encode($respona);
        }
    } else if ($datadefp['send_msg'] == '2') {
        $respona = array(
            "status"=> false,
            "message"=> "Your can't access this feature"
        );
        echo json_encode($respona);
    } else {
        $respona = array(
            "status"=> false,
            "message"=> "Empty message"
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