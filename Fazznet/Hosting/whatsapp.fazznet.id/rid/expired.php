<?php
$con = $rid['sqlConnect'];
if ($f == 'expired') {
    $cek = mysqli_query($con, "SELECT * FROM rid_account");
    while($row = mysqli_fetch_assoc($cek)) {
        if (date('Y-m-d') < $row['rid_expired']) {
            $f = false;
            echo 'Nothing <br>';
        } else {
            $u = $row['rid_username'];
            $cekk = mysqli_query($con, "SELECT * FROM device WHERE pemilik = '$u'");
            while($raw = mysqli_fetch_assoc($cekk)) {
                logout_wa($raw['nomor']);
                echo $u."<br>";
            }
        }
    }
}