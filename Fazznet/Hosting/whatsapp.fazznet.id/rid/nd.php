<?php
$con = $rid['sqlConnect'];
$checksession = $_SESSION['rid_username'];
if ($f == 'nd') {
    $mode = req('mode');
    $update = mysqli_query($con, "UPDATE rid_account SET nd = '$mode' WHERE rid_username = '$checksession'");
}