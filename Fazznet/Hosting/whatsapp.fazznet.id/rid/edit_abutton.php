<?php
$con = $rid['sqlConnect'];
$u = $_SESSION['rid_username'];
$datadefp = $rid['dataUser'];
if ($f == 'edit_abutton') {
    if (rid_check_x($datadefp['rid_username']) !== 'expired') {
if (!empty($_FILES['media']) && $_FILES['media']['error'] == UPLOAD_ERR_OK) {
        // Be sure we're dealing with an upload
        if (is_uploaded_file($_FILES['media']['tmp_name']) === false) {
            throw new \Exception('Error on upload: Invalid file definition');
        }


        if ($size > 1000000) {
            echo '<script>alert("Maximal 1mb");</script>';
            redirect("auto_reply_button.php");
            exit;
        }
        // Rename the uploaded file
        $uploadName = $_FILES['media']['name'];
        $ext = strtolower(substr($uploadName, strripos($uploadName, '.') + 1));

        $allow = ['png', 'jpeg', 'pdf', 'jpg'];
        if (in_array($ext, $allow)) {
            if ($ext == "png") {
                $filename = round(microtime(true)) . mt_rand() . '.png';
            }

            if ($ext == "jpg") {
                $filename = round(microtime(true)) . mt_rand() . '.jpg';
            }

            if ($ext == "jpeg") {
                $filename = round(microtime(true)) . mt_rand() . '.jpeg';
            }
        } else {
            echo '<script>alert("Format png, jpg only");</script>';
            redirect("auto_reply_button.php");
            exit;
        }

        move_uploaded_file($_FILES['media']['tmp_name'], 'uploads/' . $filename);
        // Insert it into our tracking along with the original name
        $media = $base_url . "/request/uploads/" . $filename;
    } else {
        $media = null;
    }
    $media = post('media');
    $content = post('content');
    $footer = post('footer');
    $keyword = post('keyword');
    $text_button = post('text_button');
    $keyword_auto_reply = post('keyword_auto_reply');
    $external_link = post('external_link');
    $external_link_name = post('external_link_name');
    $external_telp = post('external_telp');
    $external_telp_name = post('external_telp_name');
    $keyword_auto_replytwo = post('keyword_auto_replytwo');
    $text_button_two = post('text_button_two');
    $id = post('id') ? post('id') : get('id');
    if (get('act') == 'del') {
        $update = mysqli_query($con, "DELETE FROM autoreply_button WHERE id = '$id'");
        if ($update == true) {
            $respona = array(
                "status"=> 200,
                "message"=> "Success"
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
    $insert = mysqli_query($con, "UPDATE autoreply_button SET image = '$media', content = '$content', footer = '$footer', keyword = '$keyword', text_button = '$text_button', keyword_auto_reply = '$keyword_auto_reply', external_link = '$external_link', external_link_name = '$external_link_name', external_telp = '$external_telp', external_telp_name = '$external_telp_name', keyword_auto_replytwo = '$keyword_auto_replytwo', text_button_two = '$text_button_two' WHERE id = '$id'");
    if ($insert == true) {
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
    $responya = array(
        "status"=> false,
        "message"=> "Your account has been expired"
    );
    echo json_encode($responya);
    }
}