<?php
$con = $rid['sqlConnect'];
$u = $_SESSION['rid_username'];
$datadefp = $rid['dataUser'];
if ($f == 'quotemaker') {
    if (rid_check_x($datadefp['rid_username']) !== 'expired') {
    $txt = urlencode($_POST['text'] ? $_POST['text'] : "Before you quit, remember why you started");
    $wm = urlencode($_POST['wm'] ? $_POST['wm'] : "Ridah");
    $bg = $_POST['bg'] ;
    $dataimg = imagecreatefromstring($gets);
    header('Content-Type: image/png');
    imagepng($dataimg);
    imagedestroy($dataimg);
    } else {
    $responya = array(
        "status"=> false,
        "message"=> "Your account has been expired"
    );
    echo json_encode($responya);
    }
}