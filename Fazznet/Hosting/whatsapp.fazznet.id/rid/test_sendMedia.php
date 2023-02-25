<?php
$con = $rid['sqlConnect'];
$u = $_SESSION['rid_username'];
$datadefp = $rid['dataUser'];
if ($f == 'test_sendMedia') {
    if (rid_check_x($datadefp['rid_username']) !== 'expired') {
    $u = $_SESSION['rid_username'];
    $sender = post('sender');
    $nomor = post('nomor');
    $urlmedia = post('urlmedia');
    $typemedia = post('typemedia');
    $filename = post('filename');
    $caption = post('caption');
    $noo = explode(',', $nomor);
    if (!empty($urlmedia) || !empty($typemedia) || !empty($filename) && $datadefp['send_msg'] == '1') {
        foreach ($noo as $ky) {
            $send = sendMedia($sender, $ky, $urlmedia, $typemedia, $filename, $caption);
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
            "message"=> "Please fill in the required fields"
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