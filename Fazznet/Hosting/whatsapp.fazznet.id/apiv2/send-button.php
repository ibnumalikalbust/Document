<?php
require('../require/f.php');
// Takes raw data from the request
$data = json_decode(file_get_contents('php://input'), true);
$sender = $data['sender'] ? $data['sender'] : $_POST['sender'];
$nomor = $data['number'] ? $data['number'] : $_POST['number'];
$image = $data['image'] ? $data['image'] : $_POST['image'];
$content = $data['content'] ? $data['content'] : $_POST['content'];
$footer = $data['footer'] ? $data['footer'] : $_POST['footer'];
$external_link = $data['external_link'] ? $data['external_link'] : $_POST['external_link'];
$external_link_name = $data['external_link_name'] ? $data['external_link_name'] : $_POST['external_link_name'];
$external_telp = $data['external_telp'] ? $data['external_telp'] : $_POST['external_telp'];
$external_telp_name = $data['external_telp_name'] ? $data['external_telp_name'] : $_POST['external_telp_name'];
$keyword_auto_reply = $data['keyword_auto_reply'] ? $data['keyword_auto_reply'] : $_POST['keyword_auto_reply'];
$text_button = $data['text_button'] ? $data['text_button'] : $_POST['text_button'];
$keyword_auto_replytwo = $data['keyword_auto_replytwo'] ? $data['keyword_auto_replytwo'] : $_POST['keyword_auto_replytwo'];
$text_button_two = $data['text_button_two'] ? $data['text_button_two'] : $_POST['text_button_two'];
$key = $data['api_key'] ? $data['api_key'] : $_POST['api_key'];
header('Content-Type: application/json');

if ($rid['web_setting']['rest_api'] == '1') {
if(!isset($nomor) && !isset($sender) && !isset($content) && !isset($footer) && !isset($key)){
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
$cek2 = mysqli_query($con, "SELECT * FROM device WHERE nomor = '$sender' AND pemilik = '$username'");
if($cek2->num_rows < 1){
    $ret['status'] = false;
    $ret['msg'] = "Sorry Api Key salah/tidak ditemukan! $sender, $username";
    echo json_encode($ret, true);
    exit;
}
if ($cek->fetch_assoc()['send_button'] == '2' || $dat['rest_api'] == '2' ) {
    $ret['Status'] = false;
    $ret['msg'] = "You can't access this feature";
    echo json_encode($ret, true);
    exit;
}
sleep(3);
$res = sendButton($sender, $nomor,$image,$content,$footer,$external_link,$external_link_name,$external_telp,$external_telp_name,$keyword_auto_reply,$text_button,$keyword_auto_replytwo,$text_button_two);
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
