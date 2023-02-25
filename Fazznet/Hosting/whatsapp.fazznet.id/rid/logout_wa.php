<?php
if ($f == 'logout_wa') {
    $s = $_GET['sender'];
    $o = logout_wa($s);
    $d = json_decode($o, true);
    if ($d['Status']['message'] == 'sesi terputus') {
        $responya = array(
            "Status"=> [
                "message"=> "sesi terputus"
            ]
        );
        echo json_encode($responya);
    } else {
        $responya = array (
            "Status"=> [
                "message"=> "sadasdasd"
            ]
        );
        echo json_encode($responya);
    }
}