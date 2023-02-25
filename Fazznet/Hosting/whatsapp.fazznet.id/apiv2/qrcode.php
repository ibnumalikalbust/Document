<?php
require('../require/f.php');

$data = json_decode(file_get_contents('php://input'), true);
$sender = $data['sender'] ? $_POST['sender'] : $_POST['sender'];
$key = $data['api_key'] ? $_POST['api_key'] : $_POST['api_key'];
header('Content-Type: application/json');

if ($rid['web_setting']['rest_api'] == '1') {
if(!isset($sender) && !isset($key)){
    $ret['status'] = false;
    $ret['msg'] = "Parameter salah!";
    echo json_encode($ret, true);
    exit;
}

$cek = mysqli_query($con, "SELECT * FROM rid_account WHERE api_key = '$key'");
$dat = mysqli_fetch_assoc($cek);

if(date('Y-m-d') > $dat['rid_expired']) {
    $ret['status'] = false;
    $ret['msg'] = "Your account has been expired!";
    echo json_encode($ret, true);
    exit;
}

if($cek->num_rows < 1){
    $ret['status'] = false;
    $ret['msg'] = "Api Key salah/tidak ditemukan!";
    echo json_encode($ret, true);
    exit;
}
$username = $dat['rid_username'];
$cek2 = mysqli_query($con,"SELECT * FROM device WHERE nomor = '$sender' AND pemilik = '$username'");
if($cek2->num_rows < 1){
    $ret['status'] = false;
    $ret['msg'] = "Api Key salah/tidak ditemukan!";
    echo json_encode($ret, true);
    exit;
}
$cek = mysqli_query($con, "SELECT * FROM rid_account WHERE api_key = '$key'");
$dat = mysqli_fetch_assoc($cek);
if ($cek->fetch_assoc()['send_msg'] == '2' || $dat['rest_api'] == '2' ) {
    $ret['status'] = false;
    $ret['msg'] = "You can't access this feature";
    echo json_encode($ret, true);
    exit;
}
sleep(1);
$get = file_get_contents($base_url."/request/f-data-sender.php?sender=$sender");
echo $get;
} else {
    $ret['status'] = false;
    $ret['msg'] = "This feature disabled";
    echo json_encode($ret, true);
    exit;
}
