<?php
require('../require/f.php');
set_time_limit(0);
restart('6281572885606');
$ceknumb = mysqli_query($con, "SELECT * FROM device"); 
while($rowx = mysqli_fetch_assoc($ceknumb)) {
    $start = start($rowx['nomor']);
}
$done = 'done';
echo 'done';
?>