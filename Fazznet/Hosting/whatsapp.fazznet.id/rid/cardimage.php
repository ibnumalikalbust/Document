<?php
$con = $rid['sqlConnect'];
$u = $_SESSION['rid_username'];
$datadefp = $rid['dataUser'];
if($f == 'cardimage') {
    if (rid_check_x($datadefp['rid_username']) !== 'expired') {
    $title = urlencode($_POST['title'] ? $_POST['title'] : 'RIDPEDIA');
    $msgcenter = urlencode($_POST['msgcenter'] ? $_POST['msgcenter'] : 'By : Ridped');
    $msgfooter = urlencode($_POST['msgfooter'] ? $_POST['msgfooter'] : 'Msg footer');
    $userimage = urlencode($_POST['userimage'] ? $_POST['userimage'] : 'https://ridped.com/way/mypp2.png');
    $background = urlencode($_POST['background'] ? $_POST['background'] : 'https://y.ridped.com/themes/simple-aja/img/logo.png');
    $responya = array(
        "status"=> 200,
        "message"=> "https://www.api.ridped.com/api?feature=card-welcome&title=$title&msgcenter=$msgcenter&msgfooter=$msgfooter&userimage=$userimage&background=$background&apikey=".rid_key()
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