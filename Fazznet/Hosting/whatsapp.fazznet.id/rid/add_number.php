<?php
$con = $rid['sqlConnect'];
$u = $_SESSION['rid_username'];
$datadefp = $rid['dataUser'];
$base_url = $rid['site_url'];
if ($f == 'add_number') {
    if (rid_check_x($datadefp['rid_username']) !== 'expired') {
    $u = $_SESSION['rid_username'];
    $nomor = post('nomor');
    $webhook = post("webhook") ? post("webhook") : $base_url.'/filewebhook/webhook.php'; // <- default;
    if ($datadefp['total_device'] > $datadefp['limit_device']) {
        $respona = array(
            "status"=> false,
            "message"=> "Sorry you have reached the limit, you cannot add a number back. contact admin for more."
        );
        echo json_encode($respona);
    } else if ($datadefp['limit_device'] == '0' || $datadefp['total_device'] < $datadefp['limit_device']) { 
    if (empty($u) || empty($nomor)) {
        $respona = array(
            "status"=> false,
            "message"=> "Please write number"
        );
        echo json_encode($respona);
    } else {
        $cek = mysqli_query($con, "SELECT * FROM device WHERE nomor = '$nomor' ");
        if (mysqli_num_rows($cek) > 0) {
            $respona = array(
                "status"=> false,
                "message"=> rid_lang('already_number')
            );
            echo json_encode($respona);
        } else {
            $u = $_SESSION['rid_username'];
            $q = mysqli_query($con, "INSERT INTO device VALUES (null,'$u','$nomor','$webhook', null, null, null, '1', null, null, null)");
            if ($q == true) {
                //$start = start($nomor);
                $update = mysqli_query($con, "UPDATE rid_account SET total_device = total_device + 1 WHERE rid_username = '$u'");
                $respona = array(
                    "status"=> 200,
                    "message"=> rid_lang('s_add_number')
                );
                echo json_encode($respona);
            } else {
                $respona = array(
                    "status"=> 500,
                    "message"=> 'Ada kesalahan'
                );
                echo json_encode($respona);
            }
        }
    }
    } else {
        $respona = array(
            "status"=> false,
            "message"=> "Sorry you have reached the limit, you cannot add a number back. contact admin for more"
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