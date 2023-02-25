<?php
$con = $rid['sqlConnect'];
$u = $_SESSION['rid_username'];
$datadefp = $rid['dataUser'];
if ($f == 'refreshall') {
    $ceknumb = mysqli_query($con, "SELECT * FROM device"); 
    while($rowx = mysqli_fetch_assoc($ceknumb)) {
        $start = start($rowx['nomor']);
    }
    echo 'done';
}