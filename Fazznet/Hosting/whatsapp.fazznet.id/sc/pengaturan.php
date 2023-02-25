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
if ($rid['loggedin'] !== true){
    header("Location: " . $rid['site_url'] . "/index.php?link1=login");
    exit();
}
$rid['title']       = 'Settings';
$rid['is_setting']  = true;
$rid['content']     = rid_LoadPage('home/pengaturan');