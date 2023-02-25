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
$rid['title']       = 'Auto reply button';
$rid['is_autoreply_button'] = true;
$rid['content']     = rid_LoadPage('home/auto_reply_button');