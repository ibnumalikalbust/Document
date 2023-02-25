<?php
$con = $rid['sqlConnect'];
$u = $_SESSION['rid_username'];
$datadefp = $rid['dataUser'];
if ($f == 'add_listbutton') {
    if (rid_check_x($datadefp['rid_username']) !== 'expired') {
    $u = $_SESSION['rid_username'];
    $keyword = post('keyword');
    $text_small = post('text_small');
    $footer = post('footer');
    $title_message = post('title_message');
    $buttontext = post('buttontext');
    $title_section = post('title_section');
    $title_list_1 = post('title_list_1');
    $title_list_keyword_1 = post('title_list_keyword_1');
    $title_list_desc_1 = post('title_list_desc_1');
    $title_list_2 = post('title_list_2');
    $title_list_keyword_2 = post('title_list_keyword_2');
    $title_list_desc_2 = post('title_list_desc_2');
    $title_list_3 = post('title_list_3');
    $title_list_keyword_3 = post('title_list_keyword_3');
    $title_list_desc_3 = post('title_list_desc_3');
    $sender = post('sender');
    $cek = mysqli_query($con, "SELECT * FROM list_button WHERE nomor = '$sender' AND keyword = '$keyword'");
    if (mysqli_num_rows($cek) > 0) {
        $respona = array(
            "status"=> false,
            "message"=> rid_lang('numb_with_key_already')
        );
        echo json_encode($respona);
    } else {
        if ($datadefp['send_button'] == '1') {
        $q = mysqli_query($con, "INSERT INTO list_button VALUES (
            null,
            '$keyword',
            '$text_small',
            '$footer',
            '$title_message',
            '$buttontext',
            '$title_section',
            '$title_list_1',
            '$title_list_keyword_1',
            '$title_list_desc_1',
            '$title_list_2',
            '$title_list_keyword_2',
            '$title_list_desc_2',
            '$title_list_3',
            '$title_list_keyword_3',
            '$title_list_desc_3',
            '$sender',
            '$u')");
        if ($q == true) {
            $respona = array(
                "status"=> 200,
                "message"=> rid_lang('success_added')
            );
            echo json_encode($respona);
        } else {
            $respona = array(
                "status"=> false,
                "message"=> rid_lang('system_error')
            );
            echo json_encode($respona);
        }
        } else {
            $respona = array(
                "status"=> false,
                "message"=> "Your can't access this feature"
            );
            echo json_encode($respona);
        }
    }
    
    } else {
    $responya = array(
        "status"=> false,
        "message"=> "Your account has been expired"
    );
    echo json_encode($responya);
    }
}