<?php header("X-Frame-Options: sameorigin");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
function decode($encoded) {
    $encoded = base64_decode($encoded);
    $decoded = "";
    for ($i = 0;$i < strlen($encoded);$i++) {
        $b = ord($encoded[$i]);
        $a = $b ^ 10;
        $decoded.= chr($a);
    }
    return base64_decode(base64_decode($decoded));
}
function randN($length) {
    $chars = "23456789";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1;$i <= $length;$i++) {
        $randChar = rand(0, $charCount - 1);
        $result.= $charArray[$randChar];
    }
    return $result;
}
function randUC($length) {
    $chars = "ABCDEFGHJKLMNPRSTUVWXYZ";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1;$i <= $length;$i++) {
        $randChar = rand(0, $charCount - 1);
        $result.= $charArray[$randChar];
    }
    return $result;
}
function randLC($length) {
    $chars = "abcdefghijkmnprstuvwxyz";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1;$i <= $length;$i++) {
        $randChar = rand(0, $charCount - 1);
        $result.= $charArray[$randChar];
    }
    return $result;
}
function randULC($length) {
    $chars = "ABCDEFGHJKLMNPRSTUVWXYZabcdefghijkmnprstuvwxyz";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1;$i <= $length;$i++) {
        $randChar = rand(0, $charCount - 1);
        $result.= $charArray[$randChar];
    }
    return $result;
}
function randNLC($length) {
    $chars = "23456789abcdefghijkmnprstuvwxyz";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1;$i <= $length;$i++) {
        $randChar = rand(0, $charCount - 1);
        $result.= $charArray[$randChar];
    }
    return $result;
}
function randNUC($length) {
    $chars = "23456789ABCDEFGHJKLMNPRSTUVWXYZ";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1;$i <= $length;$i++) {
        $randChar = rand(0, $charCount - 1);
        $result.= $charArray[$randChar];
    }
    return $result;
}
function randNULC($length) {
    $chars = "23456789ABCDEFGHJKLMNPRSTUVWXYZabcdefghijkmnprstuvwxyz";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1;$i <= $length;$i++) {
        $randChar = rand(0, $charCount - 1);
        $result.= $charArray[$randChar];
    }
    return $result;
}
$host = explode(":", $_SERVER['HTTP_HOST']) [0];
if (filter_var($host, FILTER_VALIDATE_IP) || $host == "mikhmon.fazznet.id") {
} else {
    e403("<h1>Sorry Mikhmon doesn't work on <b>" . $host . "</b>, please open it at localhost or IP address.</h1>");
}
function forbPHP() {
    $get_self = explode("/", $_SERVER['PHP_SELF']);
    $self[] = $get_self[count($get_self) - 1];
    if ($self[0] !== "index.php" && $self[0] !== "") {
        e403();
    }
}
function e404() {
    header('HTTP/1.0 404 Not Found', true, 404);
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Not Found</title>
    <link rel="icon" href="../../assets/img/favicon.png" />
    
    <style>
    *{-webkit-box-sizing:border-box;box-sizing:border-box}body{padding:10;margin:0}#error{position:relative;height:70vh}#error .error{position:absolute;left:50%;top:50%;-webkit-transform:translate(-50%, -50%);-ms-transform:translate(-50%, -50%);transform:translate(-50%, -50%)}.error{max-width:520px;width:100%;line-height:1.4}.error .error-num{position:absolute;left:0;top:0;height:150px;width:200px;z-index:-1}.error .error-num h1{font-family:sans-serif;font-size:238px;font-weight:700;margin:0;color:#e3e3e3;text-transform:uppercase;letter-spacing:7px;position:absolute;left:50%;top:50%;-webkit-transform:translate(-50% , -50%);-ms-transform:translate(-50% , -50%);transform:translate(-50% , -50%)}.error h2{font-family:sans-serif;font-size:28px;font-weight:400;text-transform:uppercase;color:#222;margin-top:12px;margin-bottom:15px}@media only screen and (max-width: 767px){.error .error-num{height:110px;line-height:110px}.error .error-num h1{font-size:170px}.error h2{font-size:24px;margin-left:20px}}@media only screen and (max-width: 480px){.error .error-num{left:40px}.error .error-num h1{font-size:120px}.error h2{font-size:18px;margin-left:20px}}
    </style>
    
    </head>
    <body>
    <div id="error">
    <div class="error">
    <div class="error-num">
    <h1>404</h1>
    </div>
    <h2>Page not found!</h2>
    </div>
    </div>
    </body>
    </html>
    ';
    die();
}
function e403($mess = "") {
    header('HTTP/1.0 403 Forbidden', true, 403);
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 Forbidden </title>
    <link rel="icon" href="../../assets/img/favicon.png" />
    
    <style>
    *{-webkit-box-sizing:border-box;box-sizing:border-box}body{padding:10;margin:0}#error{position:relative;height:70vh}#error .error{position:absolute;left:50%;top:50%;-webkit-transform:translate(-50%, -50%);-ms-transform:translate(-50%, -50%);transform:translate(-50%, -50%)}.error{max-width:520px;width:100%;line-height:1.4}.error .error-num{position:absolute;left:0;top:0;height:150px;width:200px;z-index:-1}.error .error-num h1{font-family:sans-serif;font-size:238px;font-weight:700;margin:0;color:#e3e3e3;text-transform:uppercase;letter-spacing:7px;position:absolute;left:50%;top:50%;-webkit-transform:translate(-50% , -50%);-ms-transform:translate(-50% , -50%);transform:translate(-50% , -50%)}.error h2{font-family:sans-serif;font-size:28px;font-weight:400;text-transform:uppercase;color:#222;margin-top:12px;margin-bottom:15px}@media only screen and (max-width: 767px){.error .error-num{height:110px;line-height:110px}.error .error-num h1{font-size:170px}.error h2{font-size:24px;margin-left:20px}}@media only screen and (max-width: 480px){.error .error-num{left:40px}.error .error-num h1{font-size:120px}.error h2{font-size:18px;margin-left:20px}}h1{font-family:sans-serif;font-size:24px;font-weight:400;}
    </style>
    
    </head>
    <body>
    <div id="error">
    <div class="error">
    <div class="error-num">
    <h1>403</h1>
    </div>
    <h2>Forbidden!</h2>
    ' . $mess . '
    </div>
    </div>
    </body>
    </html>
    ';
    die();
};
