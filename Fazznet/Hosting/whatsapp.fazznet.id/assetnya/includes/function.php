<?php
/* 
// +------------------------------------------------------------------------+
// | @author RIDPEDIA
// | @author_url 1: http://www.ridped.com
// | @author_email: ridahh23@gmail.com
// +------------------------------------------------------------------------+
*/
require_once "ieuyeuh.php";
function rid_LoadPage($page_url = '') {
    global $rid;
    $templates = $rid['template'];
    $page         = './template/' . $templates . '/layout/' . $page_url . '.phtml';
    $page_content = '';
    ob_start();
    require($page);
    $page_content = ob_get_contents();
    ob_end_clean();
    return $page_content;
}

// example get lang, without json just sample
function rid_lang($lang_keyword) {
    global $rid;
    $con = $rid['sqlConnect'];
    $ridlang = $_COOKIE['rid_lang'];
    $checklang = mysqli_query($con, "SELECT * FROM languages WHERE lang_keyword = '$lang_keyword' AND lang_code = '$ridlang'");
    $datlang = mysqli_fetch_assoc($checklang);
    return $datlang['str'];
}


function rid_username($u) {
    global $rid;
    $f = $rid['sqlConnect']->query("SELECT * FROM rid_account WHERE rid_username = '$u'")->num_rows;
    if ($f == 1) {
        return true;
    } else {
        return false;
    }
}

function nowa_exists($no) {
    global $rid;
    $f = $rid['sqlConnect']->query("SELECT * FROM rid_account WHERE c_wa = '$no'")->num_rows;
    if ($f > 0) {
        return true;
    } else {
        return false;
    }
}

function email_exists($email) {
    global $rid;
    $f = $rid['sqlConnect']->query("SELECT * FROM rid_account WHERE email = '$email'")->num_rows;
    if ($f > 0) {
        return true;
    } else {
        return false;
    }
}

function rid_Register($data){
    global $rid;
    $data = json_decode($data, true);
    $username = $data['username'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $ridlevel = '2';
    $api_key = sha1(date("Y-m-d H:i:s") . rand(100000, 999999));
    $nd = $rid['web_setting']['nd_default'];
    $can_sendmsg = $rid['def_p']['send_msg'];
    $can_sendbutton = $rid['def_p']['send_button'];
    $can_datanumber = $rid['def_p']['datanumber'];
    $can_def_msg = $rid['def_p']['def_msg'];
    $can_restapi = $rid['def_p']['rest_api'];
    $total_device = "0";
    $limit_device = $rid['web_setting']['limit_device'];
    $ayena = date('Y-m-d');
    $day_x = $rid['def_p']['day_x'];
    $xpired = rid_tb_tgl($ayena, $day_x);
    $c_wa = $data['c_wa'];
    $full_name = $data['fullName'];
    $email = $data['email'];
    $v_otp = '';
    $cook = '';
    $message = urlencode(str_replace("[OTP]", "$v_otp", $rid['web_setting']['msg_verification']));
    $ridfo = '';
    if ($rid['sqlConnect']->query("INSERT INTO rid_account VALUES (null, '$username', '$password', '$ridlevel', '$api_key', '$nd', '$can_sendmsg', '$can_sendbutton', '$can_datanumber', '$can_def_msg', '$can_restapi', '$total_device', '$limit_device', '$ayena', '$xpired', '$c_wa', '$full_name', '$email', '$v_otp', '$cook')") == true) {
        return true;
    } else {
        return false;
    }
}

function redirect($target)
{
    echo '
    <script>
    window.location = "' . $target . '";
    </script>
    ';
    //exit();
}

function rid_tb_tgl($datenow, $day) {
    $tamahan_tgl = date('Y-m-d', strtotime(date('Y-m-d', strtotime($datenow)) . ' + ' . $day . ' day'));
    return $tamahan_tgl;
}

function rid_CreateLogin($u, $p) {
    global $rid;
    $d = $rid['sqlConnect']->query("SELECT * FROM rid_account WHERE rid_username = '$u'")->fetch_assoc();
    if (password_verify($p, $d['rid_password'])){
        if (password_needs_rehash($d['rid_password'])){
            $new_pass = password_hash($p, PASSWORD_DEFAULT);
            $rid['sqlConnect']->query("UPDATE rid_account SET rid_password = '$new_pass' WHERE rid_username = '$u'");
        }
        return true;
    }
    return false;
    
}

function checksession() {
    if (!$_SESSION['rid_username']) {
        return false;
    } else {
        return $_SESSION['rid_username'];
    }
}

function rid_check_x($u) {
    global $rid;
    $ayena = date('Y-m-d');
    $cekser = $rid['sqlConnect']->query("SELECT * FROM rid_account WHERE rid_username = '$u'");
    $riduser = $cekser->fetch_assoc();
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
    global $rid;
    return $rid['site_url'];
}

function totaluser() {
    global $rid;
    $cek = $rid['sqlConnect']->query("SELECT * FROM rid_account");
    return $cek->num_rows;
}

function totaldevactive() {
    global $rid;
    $cek = $rid['sqlConnect']->query("SELECT * FROM device WHERE state = 'CONNECTED'");
    return $cek->num_rows;
}

function totaldevnotactive() {
    global $rid;
    $cek = $rid['sqlConnect']->query("SELECT * FROM device WHERE state = 'QRCODE'");
    return $cek->num_rows;
}

function totalautoreply() {
    global $rid;
    $cek = $rid['sqlConnect']->query("SELECT * FROM auto_reply");
    return $cek->num_rows;
}

function totalautoreply_button() {
    global $rid;
    $cek = $rid['sqlConnect']->query("SELECT * FROM autoreply_button");
    return $cek->num_rows;
}

function get($param)
{
    global $rid;
    $con = $rid['sqlConnect'];
    $d = isset($_GET[$param]) ? $_GET[$param] : null;
    $d = mysqli_real_escape_string($con, $d);
    $d = filter_var($d, FILTER_SANITIZE_STRING);
    return $d;
}

function post($param)
{
    global $rid;
    $con = $rid['sqlConnect'];
    $d = isset($_POST[$param]) ? $_POST[$param] : null;
    $d = mysqli_real_escape_string($con, $d);
    $d = filter_var($d, FILTER_SANITIZE_STRING);
    return $d;
}

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

function rid_key() {
    global $rid;
    return $rid['web_setting']['rid_key'];
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

function countDB($table, $where = null, $param = null)
{
    global $rid;
    if ($where == null && $param == null) {
        $q = $rid['sqlConnect']->query("SELECT * FROM `$table`");
    } else {
        $q = $rid['sqlConnect']->query("SELECT * FROM `$table` WHERE `$where`='$param'");
    }
    $row = $q->num_rows;
    return $row;
}

// example function send-message
function sendMSG($sender, $number, $msg) {
    global $rid;
    $sender = urlencode($sender);
    $number = urlencode($number);
    $msg = str_replace("[ucapan]", ucapan(), $msg);
    //$msg = urlencode($msg);
    $url_api = '';
    if ($rid['installed'] == 'shared_hosting') {
        $url_api = $rid['site_url'] . "/api/sendText?sender=$sender&number=$number&msg=$msg";
    } else if ($rid['installed'] == 'vps') {
        $url_api = $rid['site_url'] . ":" . $rid['port_app'] . "/api/sendText?sender=$sender&number=$number&msg=$msg";
    } else {
        $url_api = $rid['site_url'] . ":" . $rid['port_app'] . "/api/sendText?sender=$sender&number=$number&msg=$msg";
    }
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url_api,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      //CURLOPT_MAXREDIRS => 10,
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

function sendList($sender, $number, $text, $footer, $title, $buttonText, $title_section, $title_rows_one, $title_rows_two, $title_rows_three, $title_rows_four, $title_rows_five, $title_rows_six, $title_rows_seven, $title_rows_delapan, $title_rows_one_keyword, $title_rows_two_keyword, $title_rows_three_keyword, $title_rows_four_keyword, $title_rows_five_keyword, $title_rows_six_keyword, $title_rows_seven_keyword, $title_rows_delapan_keyword) {
    global $rid;
    $sender = urlencode($sender);
    $number = urlencode($number);
    $text = str_replace("[ucapan]", ucapan(), $text);
    $footer = urlencode($footer);
    $title = urlencode($title);
    $buttonText = urlencode($buttonText);
    $title_section = urlencode($title_section);
    $title_rows_one = urlencode($title_rows_one);
    $title_rows_two = urlencode($title_rows_two);
    $title_rows_three = urlencode($title_rows_three);
    $title_rows_four = urlencode($title_rows_four);
    $title_rows_five = urlencode($title_rows_five);
    $title_rows_six = urlencode($title_rows_six);
    $title_rows_seven = urlencode($title_rows_seven);
    $title_rows_delapan = urlencode($title_rows_delapan);
    $title_rows_one_keyword = urlencode($title_rows_one_keyword);
    $title_rows_two_keyword = urlencode($title_rows_two_keyword);
    $title_rows_three_keyword = urlencode($title_rows_three_keyword);
    $title_rows_four_keyword = urlencode($title_rows_four_keyword);
    $title_rows_five_keyword = urlencode($title_rows_five_keyword);
    $title_rows_six_keyword = urlencode($title_rows_six_keyword);
    $title_rows_seven_keyword = urlencode($title_rows_seven_keyword);
    $title_rows_delapan_keyword = urlencode($title_rows_delapan_keyword);
    $url_api = '';
    if ($rid['installed'] == 'shared_hosting') {
        $url_api = $rid['site_url'] . "/api/sendList?sender=$sender&number=$number&text=$text&footer=$footer&title=$title&buttonText=$buttonText&title_section=$title_section&title_rows_one=$title_rows_one&title_rows_two=$title_rows_two&title_rows_three=$title_rows_three&title_rows_four=$title_rows_four&title_rows_five=$title_rows_five&title_rows_six=$title_rows_six&title_rows_seven=$title_rows_seven&title_rows_delapan=$title_rows_delapan&title_rows_one_keyword=$title_rows_one_keyword&title_rows_two_keyword=$title_rows_two_keyword&title_rows_three_keyword=$title_rows_three_keyword&title_rows_four_keyword=$title_rows_four_keyword&title_rows_five_keyword=$title_rows_five_keyword&title_rows_six_keyword=$title_rows_six_keyword&title_rows_seven_keyword=$title_rows_seven_keyword&title_rows_delapan_keyword=$title_rows_delapan_keyword";
    } else if ($rid['installed'] == 'vps') {
        $url_api = $rid['site_url'] . ":" . $rid['port_app'] . "/api/sendList?sender=$sender&number=$number&text=$text&footer=$footer&title=$title&buttonText=$buttonText&title_section=$title_section&title_rows_one=$title_rows_one&title_rows_two=$title_rows_two&title_rows_three=$title_rows_three&title_rows_four=$title_rows_four&title_rows_five=$title_rows_five&title_rows_six=$title_rows_six&title_rows_seven=$title_rows_seven&title_rows_delapan=$title_rows_delapan&title_rows_one_keyword=$title_rows_one_keyword&title_rows_two_keyword=$title_rows_two_keyword&title_rows_three_keyword=$title_rows_three_keyword&title_rows_four_keyword=$title_rows_four_keyword&title_rows_five_keyword=$title_rows_five_keyword&title_rows_six_keyword=$title_rows_six_keyword&title_rows_seven_keyword=$title_rows_seven_keyword&title_rows_delapan_keyword=$title_rows_delapan_keyword";
    } else {
        $url_api = $rid['site_url'] . ":" . $rid['port_app'] . "/api/sendList?sender=$sender&number=$number&text=$text&footer=$footer&title=$title&buttonText=$buttonText&title_section=$title_section&title_rows_one=$title_rows_one&title_rows_two=$title_rows_two&title_rows_three=$title_rows_three&title_rows_four=$title_rows_four&title_rows_five=$title_rows_five&title_rows_six=$title_rows_six&title_rows_seven=$title_rows_seven&title_rows_delapan=$title_rows_delapan&title_rows_one_keyword=$title_rows_one_keyword&title_rows_two_keyword=$title_rows_two_keyword&title_rows_three_keyword=$title_rows_three_keyword&title_rows_four_keyword=$title_rows_four_keyword&title_rows_five_keyword=$title_rows_five_keyword&title_rows_six_keyword=$title_rows_six_keyword&title_rows_seven_keyword=$title_rows_seven_keyword&title_rows_delapan_keyword=$title_rows_delapan_keyword";
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
    global $rid;
    $sender = urlencode($sender);
    $number = urlencode($number);
    $filename = urlencode($filename);
    $caption = str_replace("[ucapan]", ucapan(), $caption);
    $caption = urlencode($caption);
    $url_api = '';
    if ($rid['installed'] == 'shared_hosting') {
        $url_api = $rid['site_url'] . "/api/sendFiles?sender=$sender&number=$number&url=$url&ex=$ex&filename=$filename&caption=$caption";
    } else if ($rid['installed'] == 'vps') {
        $url_api = $rid['site_url'] . ":" . $rid['port_app'] . "/api/sendFiles?sender=$sender&number=$number&url=$url&ex=$ex&filename=$filename&caption=$caption";
    } else {
        $url_api = $rid['site_url'] . ":" . $rid['port_app'] . "/api/sendFiles?sender=$sender&number=$number&url=$url&ex=$ex&filename=$filename&caption=$caption";
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
    global $rid;
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
    if ($rid['installed'] == 'shared_hosting') {
        $url_api = $rid['site_url'] . "/api/sendButton?sender=$sender&number=$number&image=$image&content=$content&footer=$footer&external_link=$external_link&external_link_name=$external_link_name&external_telp=$external_telp&external_telp_name=$external_telp_name&keyword_auto_reply=$keyword_auto_reply&text_button=$text_button&keyword_auto_replytwo=$keyword_auto_replytwo&text_button_two=$text_button_two";
    } else if ($rid['installed'] == 'vps') {
        $url_api = $rid['site_url'] . ":" . $rid['port_app'] . "/api/sendButton?sender=$sender&number=$number&image=$image&content=$content&footer=$footer&external_link=$external_link&external_link_name=$external_link_name&external_telp=$external_telp&external_telp_name=$external_telp_name&keyword_auto_reply=$keyword_auto_reply&text_button=$text_button&keyword_auto_replytwo=$keyword_auto_replytwo&text_button_two=$text_button_two";
    } else {
        $url_api = $rid['site_url'] . ":" . $rid['port_app'] . "/api/sendButton?sender=$sender&number=$number&image=$image&content=$content&footer=$footer&external_link=$external_link&external_link_name=$external_link_name&external_telp=$external_telp&external_telp_name=$external_telp_name&keyword_auto_reply=$keyword_auto_reply&text_button=$text_button&keyword_auto_replytwo=$keyword_auto_replytwo&text_button_two=$text_button_two";
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

function logout_wa($sender) {
    global $rid;
    $url_api = '';
    if ($rid['installed'] == 'shared_hosting') {
        $url_api = $rid['site_url'] . "/device/Logout?sender=$sender&time=" . time();
    } else if ($rid['installed'] == 'vps') {
        $url_api = $rid['site_url'] . ":" . $rid['port_app'] . "/device/Logout?sender=$sender&time=" . time();
    } else {
        $url_api = $rid['site_url'] . ":" . $rid['port_app'] . "/device/Logout?sender=$sender&time=" . time();
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
    global $rid;
    $url_api = '';
    if ($rid['installed'] == 'shared_hosting') {
        $url_api = $rid['site_url'] . "/device/Start?sender=$sender&time=" . time();
    } else if ($rid['installed'] == 'vps') {
        $url_api = $rid['site_url'] . ":" . $rid['port_app'] . "/device/Start?sender=$sender&time=" . time();
    } else {
        $url_api = $rid['site_url'] . ":" . $rid['port_app'] . "/device/Start?sender=$sender&time=" . time();
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
    global $rid;
    $url_api = '';
    if ($rid['installed'] == 'shared_hosting') {
        $url_api = $rid['site_url'] . "/device/restart?sender=$sender&time=" . time();
    } else if ($rid['installed'] == 'vps') {
        $url_api = $rid['site_url'] . ":" . $rid['port_app'] . "/device/restart?sender=$sender&time=" . time();
    } else {
        $url_api = $rid['site_url'] . ":" . $rid['port_app'] . "/device/restart?sender=$sender&time=" . time();
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
?>