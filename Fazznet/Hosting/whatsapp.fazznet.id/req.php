<?php
require_once('assetnya/require.php');
$f = '';
if (isset($_GET)) {
    $f = $_GET['f'];
}
$allow_array     = array(
    'login',
    'register',
    'add_autoreply',
    'add_button',
    'add_listbutton',
    'add_number',
    'cardimage',
    'change_password',
    'del_ccr',
    'delete_number',
    'edit_abutton',
    'edit_autoreply',
    'edit_device',
    'edit_listbutton',
    'nd',
    'quote_maker',
    'quotemaker',
    'refreshall',
    'send_button',
    'test_sendMedia',
    'test_sendText',
    'cron-blast',
    'expired',
    'f_data_sender',
    'ucapan',
    'restartall',
    'logout_wa',
    'lool',
    'hapus_pesan',
    'check_session'
);
if (!in_array($f, $allow_array)) {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            exit("Restrcited Area");
        }
    } else {
        exit("Restrcited Area");
    }
}
$files = scandir('rid');
unset($files[0]);
unset($files[1]);
if (file_exists('rid/' . $f . '.php') && in_array($f . '.php', $files)) {
    include 'rid/' . $f . '.php';
}
mysqli_close($con);
unset($rid);
exit();