<?php
$con = $rid['sqlConnect'];
$u = $_SESSION['rid_username'];
$datadefp = $rid['dataUser'];
if ($f == 'add_button') {
    if (rid_check_x($datadefp['rid_username']) !== 'expired') {
    $u = $_SESSION['rid_username'];
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
    $media = post("media");
    $content = post('content');
    $footer = post('footer');
    $make_by = post('make_by');
    $keyword = post('keyword');
    $text_button = post('text_button');
    $keyword_auto_reply = post('keyword_auto_reply');
    $username = $u;
    $external_link = post('external_link');
    $external_link_name = post('external_link_name');
    $external_telp = post('external_telp');
    $external_telp_name = post('external_telp_name');
    $keyword_auto_replytwo = post('keyword_auto_replytwo');
    $text_button_two = post('text_button_two');
    $cek = mysqli_query($con, "SELECT * FROM autoreply_button WHERE make_by = '$make_by' AND keyword = '$keyword'");
    if (mysqli_num_rows($cek) > 0) {
        $respona = array(
            "status"=> false,
            "message"=> rid_lang('numb_with_key_already')
        );
        echo json_encode($respona);
    } else {
        $insert = mysqli_query($con, "INSERT INTO autoreply_button VALUES (null, '$media', '$content', '$footer', '$make_by', '$keyword', '$text_button', '$keyword_auto_reply', '$username', '$external_link', '$external_link_name', '$external_telp', '$external_telp_name', '$keyword_auto_replytwo', '$text_button_two')");
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
    }
    } else {
    $responya = array(
        "status"=> false,
        "message"=> "Your account has been expired"
    );
    echo json_encode($responya);
    }
}