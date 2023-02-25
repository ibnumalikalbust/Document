<?php
require('../require/f.php');

// Takes raw data from the request
$data = json_decode(file_get_contents('php://input'), true);
$sender = $data['sender'] ? $data['sender'] : $_POST['sender'];
$nomor = $data['number'] ? $data['number'] : $_POST['number'];
$caption = $data['caption'] ? $data['caption'] : $_POST['caption'];
$caption = $caption;
$url = $data['url'] ? $data['url'] : $_POST['url'];
$ex = $data['ex'] ? $data['ex'] : $_POST['ex'];
$filename = $data['filename'] ? $data['filename'] : $_POST['filename'];
$key = $data['api_key'] ? $data['api_key'] : $_POST['api_key'];
header('Content-Type: application/json');

if ($rid['web_setting']['rest_api'] == '1') {
if(!isset($nomor) && !isset($url) && !isset($ex) && !isset($filename) && !isset($sender) && !isset($key)){
    $ret['status'] = false;
    $ret['msg'] = "Parameter salah!";
    echo json_encode($ret, true);
    exit;
}

$cek = mysqli_query($con,"SELECT * FROM rid_account WHERE api_key = '$key'");
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
if ($cek->fetch_assoc()['send_msg'] == '2' || $dat['rest_api'] == '2' ) {
    $ret['status'] = false;
    $ret['msg'] = "You can't access this feature";
    echo json_encode($ret, true);
    exit;
}
sleep(3);
$res = sendMedia($sender, $nomor,$url,$ex,$filename,$caption);
if($res['Status']['status'] == 200){
    $ret['status'] = true;
    $ret['msg'] = "Pesan berhasil dikirim";
    echo json_encode($ret, true);
    exit;
}else{
    $ret['status'] = false;
    $ret['msg'] = $res['Status']['message'];
    echo json_encode($ret, true);
    exit;
}
} else {
    $ret['status'] = false;
    $ret['msg'] = "This feature disabled";
    echo json_encode($ret, true);
    exit;
}
