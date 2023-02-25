<?php
if ($f == 'register') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nowa = $_POST['nowa'];
    if (empty($_POST['email']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['fullName']) || empty($_POST['nowa'])) {
        $errors = "Silahkan periksa semua formulir register!";
    } else {
        if (preg_match('/[^\w\s]+/u', $_POST['fullName'])) {
            $errors = "Invalid Karakter Full Name!";
        }
        if (preg_match('/[^\w\s]+/u', $_POST['username'])) {
            $errors = "Invalid Karakter Username!!";
        }
        if (rid_username($_POST['username'])) {
            $errors = "Username telah di gunakan";
        }
        if (strlen($_POST['username']) < 5 OR strlen($_POST['username']) > 32) {
            $errors = "Username harus lebih dari 5 karakter!";
        }
        if (strlen($_POST['password']) < 5) {
            $errors = "Password terlalu pendek!";
        }
        if (nowa_exists($_POST['nowa'])) {
            $errors = "Nomor sudah di gunakan!";
        }
        if (email_exists($_POST['email'])) {
            $errors = "Email sudah di gunakan!";
        }
        if (empty($errors)) {
            $d = date('Y-m-d');
            $dataa = array(
                "username"=> str_replace(' ', '', $username),
                "fullName"=> $fullName,
                "email"=> $email,
                "password"=> $password,
                "c_wa"=> $nowa
            );
            $dataa = json_encode($dataa);
            if (rid_Register($dataa)) {
                $responya = array(
                    "status"=> true,
                    "location"=> $rid['site_url']
                );
                $_SESSION['rid_username'] = $username;
                $session = md5($username);
                $uid = $rid['sqlConnect']->query("SELECT * FROM rid_account WHERE rid_username = '$username'")->fetch_assoc();
                $rid['sqlConnect']->query("UPDATE rid_account SET cookie = '$session' WHERE rid_username = '$username'");
                setcookie("loggedin", $session, time() + (10 * 365 * 24 * 60 * 60));
                setcookie("USERID", $uid['id'], time() + (10 * 365 * 24 * 60 * 60));
                //echo json_encode($responya);
            } else {
                $responya = array(
                    "status"=> false,
                    "errors"=> "Silahkan periksa semua formulir register!",
                );
                 die(json_encode($responya));
            } 
        }
        if (isset($errors))  {
            $responya = array(
                "status"=> false,
                "errors"=> $errors
            );
            echo json_encode($responya);
        } else {
            $responya = array(
                "status"=> true,
                "location"=> $rid['site_url']
            );
            echo json_encode($responya);
        }
    }
    exit();
}