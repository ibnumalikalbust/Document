<?php
/* 
// +------------------------------------------------------------------------+
// | @author RIDPEDIA
// | @author_url 1: http://www.ridped.com
// | @author_email: ridahh23@gmail.com
// +------------------------------------------------------------------------+
*/
require_once('assetnya/require.php');
$page = '';
if ($_GET['link1']) {
    $page = $_GET['link1'];
}

if (empty($page)) {
    $page = 'welcome';
}
if ($rid['loggedin'] == true) {
    $u = $_SESSION['rid_username'];
    $d = $rid['sqlConnect']->query("SELECT * FROM rid_account WHERE rid_username = '$u'");
    if ($d->num_rows < 1) {
        setcookie("deleted_acc", "1");
        header("location: " .$rid['site_url'] . "/index.php?link1=logout");
    } else {
        $d = $d->fetch_assoc();
        if ($d['cookie'] == '') {
            setcookie("forced", "1");
            header("location: " . $rid['site_url'] . "/index.php?link1=logout");
        }
    }
}
switch($page) {
    case 'welcome':
        if ($rid['template'] == 'azures_mobile_version') {
            include('sc/welcome.php');
        } else {
            header("location: " . $rid['site_url'] . "/welcome/index.php");
        }
    break;
    case 'login':
        include('sc/login.php');
    break;
    case '404':
        include('sc/404.php');
    break;
    case 'register':
        include('sc/register.php');
    break;
    case 'auto_reply':
        include('sc/auto_reply.php');
    break;
    case 'auto_reply_button':
        include('sc/auto_reply_button.php');
    break;
    case 'autoreply_listbutton':
        include('sc/autoreply_listbutton.php');
    break;
    case 'card_image':
        include('sc/card_image.php');
    break;
    case 'edit_device':
        include('sc/edit_device.php');
    break;
    case 'ccr':
        include('sc/ccr.php');
    break;
    case 'pesan_default':
        include('sc/pesan_default.php');
    break;
    case 'pesan_s_m':
        include('sc/pesan_s_m.php');
    break;
    case 'send_button':
        include('sc/send_button.php');
    break;
    case 'rest_api':
        include('sc/rest_api.php');
    break;
    case 'test_send':
        include('sc/test_send.php');
    break;
    case 'quotemaker':
        include('sc/quotemaker.php');
    break;
    case 'nomor':
        include('sc/nomor.php');
    break;
    case 'home':
        include('sc/home.php');
    break;
    case 'pengaturan':
        include('sc/pengaturan.php');
    break;
    case 'logout':
        include('sc/logout.php');
    break;
}
if (empty($rid['content'])) {
    include('sc/404.php');
}
echo rid_LoadPage('main');
?>
