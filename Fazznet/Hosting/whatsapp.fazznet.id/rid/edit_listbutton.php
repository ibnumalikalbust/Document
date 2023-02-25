<?php
$con = $rid['sqlConnect'];
$u = $_SESSION['rid_username'];
$datadefp = $rid['dataUser'];
if ($f == 'edit_listbutton') {
    if (rid_check_x($datadefp['rid_username']) !== 'expired') {
    $u = $_SESSION['rid_username'];
    $keyword = post('keyword');
    $text_small = $_POST['text_small'];
    $footer = $_POST['footer'];
    $title_message = $_POST['title_message'];
    $buttontext = $_POST['buttontext'];
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
    $id = post('id') ? post('id') : get('id');
    $cek = mysqli_query($con, "SELECT * FROM list_button WHERE id = '$id'");
    if (mysqli_num_rows($cek) > 0) {
        if (get('act') == 'del') {
            $update = mysqli_query($con, "DELETE FROM list_button WHERE id = '$id'");
            if ($update == true) {
                $respona = array(
                    "status"=> 200,
                    "message"=> "Succes"
                );
                echo json_encode($respona);
            } else {
                $respona = array(
                    "status"=> false,
                    "message"=> rid_lang('system_error')
                );
                echo json_encode($respona);
            }
        }
        $update = mysqli_query($con, "UPDATE list_button SET keyword = '$keyword',
        text_small = '$text_small',
        footer = '$footer',
        title_message = '$title_message',
        buttontext = '$buttontext',
        title_section = '$title_section',
        title_list_1 = '$title_list_1',
        title_list_keyword_1 = '$title_list_keyword_1',
        title_list_desc_1 = '$title_list_desc_1',
        title_list_2 = '$title_list_2',
        title_list_keyword_2 = '$title_list_keyword_2',
        title_list_desc_2 = '$title_list_desc_2',
        title_list_3 = '$title_list_3',
        title_list_keyword_3 = '$title_list_keyword_3',
        title_list_desc_3 = '$title_list_desc_3' WHERE id = '$id'");
        if ($update == true) {
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
            "message"=> "Nothing $response"
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