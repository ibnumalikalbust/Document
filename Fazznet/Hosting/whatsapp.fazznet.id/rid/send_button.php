<?php
$con = $rid['sqlConnect'];
$u = $_SESSION['rid_username'];
$datadefp = $rid['dataUser'];
if ($f == 'send_button') {
    if (rid_check_x($datadefp['rid_username']) !== 'expired') {
    $u = $_SESSION['rid_username'];
    $sender = post('sender');
    $nomor = post('nomor');
    $image = post('image');
    $content = $_POST['content'];
    $footer = post('footer');
    $external_link = post('external_link');
    $external_link_name = post('external_link_name');
    $external_telp = post('external_telp');
    $external_telp_name = post('external_telp_name');
    $keyword_auto_reply = post('keyword_auto_reply');
    $text_button = post('text_button');
    $keyword_auto_replytwo = post('keyword_auto_replytwo');
    $text_button_two = post('text_button_two');
    $noo = explode(',', $nomor);
    if (!empty($sender) || !empty($content) || !empty($footer) && $datadefp['send_button'] == '1') {
        foreach($noo as $ky) {
            sleep(1);
            $send = sendButton($sender, $ky, $image, $content, $footer, $external_link, $external_link_name, $external_telp, $external_telp_name, $keyword_auto_reply, $text_button, $keyword_auto_replytwo, $text_button_two);
        }
        if ($send['Status']['status'] == 200) {
            $respona = array(
                "status"=> 200,
                "message"=> 'Succesfully'
            );
            echo json_encode($respona);
        } else {
            $respona = array(
                "status"=> false,
                "message"=> $send['Status']['message']
            );
            echo json_encode($respona);
        }
    } else if ($datadefp['send_msg'] == '2') {
        $respona = array(
            "status"=> false,
            "message"=> "Your can't access this feature"
        );
        echo json_encode($respona);
    } else {
        $respona = array(
            "status"=> false,
            "message"=> "Please fill in the required fields"
        );
        echo json_encode($respona);
    }
    
    } else {
    $responya = array(
        "status"=> false,
        "message"=> "Your account has been expired"
    );
    echo json_encode($responya);
    }
}
