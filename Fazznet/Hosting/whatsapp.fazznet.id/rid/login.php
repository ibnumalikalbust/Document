<?php
if ($f == 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $errors = "Silahkan periksa semua formulir login!";
    } else {
        if (preg_match('/[^\w\s]+/u', $_POST['username'])) {
            $errors = "Invalid Karakter Username!";
        }
        if (empty($errors)) {
            $d = date('Y-m-d');
            if (rid_CreateLogin($username, $password)) {
                $responya = array(
                    "status"=> true,
                    "location"=> $rid['site_url']
                );
                $_SESSION['rid_username'] = $username;
                $session = md5($username);
                $ud = $rid['sqlConnect']->query("SELECT * FROM rid_account WHERE rid_username = '$username'")->fetch_assoc();
                $rid['sqlConnect']->query("UPDATE rid_account SET cookie = '$session' WHERE rid_username = '$username'");
                setcookie("loggedin", $session, time() + (10 * 365 * 24 * 60 * 60));
                setcookie("USERID", $ud['id'], time() + (10 * 365 * 24 * 60 * 60));
                //echo json_encode($responya);
            } else {
                $responya = array(
                    "status"=> false,
                    "errors"=> "Username atau password salah!",
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