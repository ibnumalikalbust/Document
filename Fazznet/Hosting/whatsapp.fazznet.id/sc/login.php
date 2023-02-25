<?php
/* 
// +------------------------------------------------------------------------+
// | @author RIDPEDIA
// | @author2 M ASRAN
// | @author_url 1: http://www.ridped.com
// | @author_url 2: http://nufa.co.id
// | @author_email: ridahh23@gmail.com
// +------------------------------------------------------------------------+
*/
if ($rid['loggedin'] == true){
    header("Location: " . $rid['site_url'] . "/index.php?link1=home");
    exit();
}
$rid['title']       = 'Login';
$rid['is_login']    = true;
$rid['content']     = rid_LoadPage('login/main');