<?php
$con = $rid['sqlConnect'];
$u = $_SESSION['rid_username'];
$datadefp = $rid['dataUser'];
if($f == 'quote_maker') {
    if (rid_check_x($datadefp['rid_username']) !== 'expired') {
    $txt = urlencode($_POST['text'] ? $_POST['text'] : "Before you quit, remember why you started");
    $wm = urlencode($_POST['wm'] ? $_POST['wm'] : "Ridah");
    $bg = urlencode($_POST['bg'] ? $_POST['bg'] : "https://ridped.com/way/mypp2.png");
    $responya = array(
        "status"=> 200,
        "message"=> "https://www.api.ridped.com/api?feature=quotemaker&text=$txt&wm=$wm&bg=$bg&apikey=$apiKey",
        "wm"=> $wm
    );
    echo json_encode($responya);
    } else {
    $responya = array(
        "status"=> false,
        "message"=> "Your account has been expired"
    );
    echo json_encode($responya);
    }
}