<?php
if ($f == 'ucapan') {
    $ucapan = ucapan();
    $respona = array(
        "status"=> 200,
        "message"=> $ucapan
    );
    echo json_encode($respona);
}