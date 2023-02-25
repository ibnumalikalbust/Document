<?php 
ini_set('display_errors', 0);
date_default_timezone_set('Asia/Jakarta');
// include db&connection
require('../config.php');
// start session
session_start();
$con = mysqli_connect($host, $user_db, $pass_db, $db_name, 3306) or die('Gagal koneksi database!');
mysqli_set_charset($con, "utf8mb4");
// data web
$datweb = mysqli_query($con, "SELECT * FROM web_setting");
$ridwebsetting= mysqli_fetch_assoc($datweb);
$rid['web_setting'] = $ridwebsetting;
$datdefp = mysqli_query($con, "SELECT * FROM def_permission");
$datadefp = mysqli_fetch_assoc($datdefp);
$day_x = $datadefp['day_x'];
$ayena = date('Y-m-d');
$apiKey = $ridwebsetting['rid_key'];
$base_url = $site_url;
$port_app = $port_app;

function rid_key() {
    global $apiKey;
    return $apiKey;
}
function rid_tb_tgl($datenow, $day) {
    $tamahan_tgl = date('Y-m-d', strtotime(date('Y-m-d', strtotime($datenow)) . ' + ' . $day . ' day'));
    return $tamahan_tgl;
}

// timenow
function timenow() {
    $dt = date('Y-m-d H:i:s');
    $respon = array(
        "now"=> $dt
    );
    return json_encode($respon);
}

function d_now() {
    return date('Y-m-d');
}

function ucapan() {
    $jam = date('H:i');
    if ($jam > '05:30' && $jam < '10:00') {
        $ucapan = "Selamat pagi";
    } else if ($jam >= '10:00' && $jam < '15:00') {
        $ucapan = "Selamat siang";
    } else if ($jam >= '15:00' && $jam < '18:00') {
        $ucapan = "Selamat sore";
    } else {
        $ucapan = "Selamat malam";
    }
    return $ucapan;
}

function redirect($target)
{
    echo '
    <script>
    window.location = "' . $target . '";
    </script>
    ';
    exit();
}

// example get lang, without json just sample
function rid_lang($lang_keyword) {
    global $con;
    $ridlang = $_COOKIE['rid_lang'];
    $checklang = mysqli_query($con, "SELECT * FROM languages WHERE lang_keyword = '$lang_keyword' AND lang_code = '$ridlang'");
    $datlang = mysqli_fetch_assoc($checklang);
    return $datlang['str'];
}

function get($param)
{
    global $con;
    $d = isset($_GET[$param]) ? $_GET[$param] : null;
    $d = mysqli_real_escape_string($con, $d);
    $d = filter_var($d, FILTER_SANITIZE_STRING);
    return $d;
}

function post($param)
{
    global $con;
    $d = isset($_POST[$param]) ? $_POST[$param] : null;
    $d = mysqli_real_escape_string($con, $d);
    $d = filter_var($d, FILTER_SANITIZE_STRING);
    return $d;
}
// check session
function checksession() {
    global $_SESSION;
    if (!$_SESSION['rid_username']) {
        return false;
    } else {
        return $_SESSION['rid_username'];
    }
}

// data user
$checksession = checksession();
if ($checksession !== false) {
    $cekser = mysqli_query($con, "SELECT * FROM rid_account WHERE rid_username = '$checksession'");
    $riduser = mysqli_fetch_assoc($cekser);
}

function rid_check_x($u) {
    global $con;
    global $ayena;
    $cekser = mysqli_query($con, "SELECT * FROM rid_account WHERE rid_username = '$u'");
    $riduser = mysqli_fetch_assoc($cekser);
    $aupokonya = strtotime($riduser['rid_start']) - strtotime($riduser['rid_expired']);
    $ekpired = abs(floor($aupokonya / (60 * 60 * 24)));
    if ($ayena < $riduser['rid_expired']) {
        if ($ekpired > 365) {
            $rid_expired = "$ekpired hari lagi";
        } else if ($ekpired == 1) {
            $rid_expired = "$ekpired hari lagi, segera lakukan perpanjangan kepada admin sebelum akun di nonaktifkan. kami akan mengeluarkan koneksi whatsapp anda pada pukul 00:00 (WAKTU SERVER)";
        } else {
            $rid_expired = "$ekpired hari lagi.";
        }
    } else {
        $rid_expired = "expired";
    }
    return $rid_expired;
}

function url_wa() {
    global $base_url;
    return $base_url;
}

function totaluser() {
    global $con;
    $cek = mysqli_query($con, "SELECT * FROM rid_account");
    return mysqli_num_rows($cek);
}

function totaldevactive() {
    global $con;
    $cek = mysqli_query($con, "SELECT * FROM device WHERE state = 'CONNECTED'");
    return mysqli_num_rows($cek);
}

function totaldevnotactive() {
    global $con;
    $cek = mysqli_query($con, "SELECT * FROM device WHERE state = 'QRCODE'");
    return mysqli_num_rows($cek);
}

function totalautoreply() {
    global $con;
    $cek = mysqli_query($con, "SELECT * FROM auto_reply");
    return mysqli_num_rows($cek);
}

function totalautoreply_button() {
    global $con;
    $cek = mysqli_query($con, "SELECT * FROM autoreply_button");
    return mysqli_num_rows($cek);
}

function countDB($table, $where = null, $param = null)
{
    global $con;
    if ($where == null && $param == null) {
        $q = mysqli_query($con, "SELECT * FROM `$table`");
    } else {
        $q = mysqli_query($con, "SELECT * FROM `$table` WHERE `$where`='$param'");
    }
    $row = mysqli_num_rows($q);
    return $row;
}

// logout session
function logout_wa($sender) {
    global $base_url, $installed, $port_app;
    $url_api = '';
    if ($installed == 'shared_hosting') {
        $url_api = $base_url . "/device/Logout?sender=$sender&time=" . time();
    } else if ($installed == 'vps') {
        $url_api = $base_url . ":" . $port_app . "/device/Logout?sender=$sender&time=" . time();
    } else {
        $url_api = $base_url . ":" . $port_app . "/device/Logout?sender=$sender&time=" . time();
    }
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url_api,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 1,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET")
    );
    $rid = curl_exec($curl);
    curl_close($curl);
    return $rid;
}

function start($sender) {
    global $base_url, $installed, $port_app;
    $url_api = '';
    if ($installed == 'shared_hosting') {
        $url_api = $base_url . "/device/Start?sender=$sender&time=" . time();
    } else if ($installed == 'vps') {
        $url_api = $base_url . ":" . $port_app . "/device/Start?sender=$sender&time=" . time();
    } else {
        $url_api = $base_url . ":" . $port_app . "/device/Start?sender=$sender&time=" . time();
    }
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url_api,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_TIMEOUT => 0,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 1,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET")
    );
    $rid = curl_exec($curl);
    curl_close($curl);
    return json_decode($rid, true);
}

function restart($sender) {
    global $base_url, $installed, $port_app;
    $url_api = '';
    if ($installed == 'shared_hosting') {
        $url_api = $base_url . "/device/restart?sender=$sender&time=" . time();
    } else if ($installed == 'vps') {
        $url_api = $base_url . ":" . $port_app . "/device/restart?sender=$sender&time=" . time();
    } else {
        $url_api = $base_url . ":" . $port_app . "/device/restart?sender=$sender&time=" . time();
    }
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url_api,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 1,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET")
    );
    $rid = curl_exec($curl);
    curl_close($curl);
    return json_decode($rid, true);
}

function sendMedia($sender, $number, $url, $ex, $filename, $caption)
{
    global $base_url, $installed, $port_app;
    $sender = urlencode($sender);
    $number = urlencode($number);
    $filename = urlencode($filename);
    $caption = str_replace("[ucapan]", ucapan(), $caption);
    $caption = urlencode($caption);
    $url_api = '';
    if ($installed == 'shared_hosting') {
        $url_api = $base_url . "/api/sendFiles?sender=$sender&number=$number&url=$url&ex=$ex&filename=$filename&caption=$caption";
    } else if ($installed == 'vps') {
        $url_api = $base_url . ":" . $port_app . "/api/sendFiles?sender=$sender&number=$number&url=$url&ex=$ex&filename=$filename&caption=$caption";
    } else {
        $url_api = $base_url . ":" . $port_app . "/api/sendFiles?sender=$sender&number=$number&url=$url&ex=$ex&filename=$filename&caption=$caption";
    }
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url_api,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 1,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET")
    );
    $rid = curl_exec($curl);
    curl_close($curl);
    return json_decode($rid, true);
}

function sendMSG($sender, $number, $msg) {
    global $base_url, $installed, $port_app;
    $sender = urlencode($sender);
    $number = urlencode($number);
    $msg = str_replace("[ucapan]", ucapan(), $msg);
    //$msg = urlencode($msg);
    $url_api = '';
    if ($installed == 'shared_hosting') {
        $url_api = $base_url . "/api/sendText?sender=$sender&number=$number&msg=$msg";
    } else if ($installed == 'vps') {
        $url_api = $base_url . ":" . $port_app . "/api/sendText?sender=$sender&number=$number&msg=$msg";
    } else {
        $url_api = $base_url . ":" . $port_app . "/api/sendText?sender=$sender&number=$number&msg=$msg";
    }
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url_api,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 1,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET")
    );
    $rid = curl_exec($curl);
    curl_close($curl);
    return json_decode($rid, true);
}

function sendButton($sender, $number, $image, $content, $footer, $external_link, $external_link_name, $external_telp, $external_telp_name, $keyword_auto_reply, $text_button, $keyword_auto_replytwo, $text_button_two)
{
    global $base_url, $installed, $port_app;
    $sender = urlencode($sender);
    $number = urlencode($number);
    $image = urlencode($image);
    $content = str_replace("[ucapan]", ucapan(), $content);
    $content = urlencode($content);
    $footer = urlencode($footer);
    $external_link = urlencode($external_link);
    $external_link_name = urlencode($external_link_name);
    $external_telp = urlencode($external_telp);
    $external_telp_name = urlencode($external_telp_name);
    $keyword_auto_reply = urlencode($keyword_auto_reply);
    $text_button = urlencode($text_button);
    $keyword_auto_replytwo = urlencode($keyword_auto_replytwo);
    $text_button_two = urlencode($text_button_two);
    $url_api = '';
    if ($installed == 'shared_hosting') {
        $url_api = $base_url . "/api/sendButton?sender=$sender&number=$number&image=$image&content=$content&footer=$footer&external_link=$external_link&external_link_name=$external_link_name&external_telp=$external_telp&external_telp_name=$external_telp_name&keyword_auto_reply=$keyword_auto_reply&text_button=$text_button&keyword_auto_replytwo=$keyword_auto_replytwo&text_button_two=$text_button_two";
    } else if ($installed == 'vps') {
        $url_api = $base_url . ":" . $port_app . "/api/sendButton?sender=$sender&number=$number&image=$image&content=$content&footer=$footer&external_link=$external_link&external_link_name=$external_link_name&external_telp=$external_telp&external_telp_name=$external_telp_name&keyword_auto_reply=$keyword_auto_reply&text_button=$text_button&keyword_auto_replytwo=$keyword_auto_replytwo&text_button_two=$text_button_two";
    } else {
        $url_api = $base_url . ":" . $port_app . "/api/sendButton?sender=$sender&number=$number&image=$image&content=$content&footer=$footer&external_link=$external_link&external_link_name=$external_link_name&external_telp=$external_telp&external_telp_name=$external_telp_name&keyword_auto_reply=$keyword_auto_reply&text_button=$text_button&keyword_auto_replytwo=$keyword_auto_replytwo&text_button_two=$text_button_two";
    }
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url_api,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 1,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET")
    );
    $rid = curl_exec($curl);
    curl_close($curl);
    return json_decode($rid, true);
    
}