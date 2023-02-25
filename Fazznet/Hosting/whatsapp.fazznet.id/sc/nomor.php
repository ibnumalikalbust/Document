<?php
/* 
// +------------------------------------------------------------------------+
// | @author RIDPEDIA
// | @author_url 1: http://www.ridped.com
// | @author_email: ridahh23@gmail.com
// +------------------------------------------------------------------------+
*/
if ($rid['loggedin'] !== true){
    header("Location: " . $rid['site_url'] . "/index.php?link1=login");
    exit();
}
$rid['title']       = 'Number contact';
$rid['is_numbercontact']    = true;
$rid['content']     = rid_LoadPage('home/nomor');