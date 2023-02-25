<?php
$con = $rid['sqlConnect'];
$u = $_SESSION['rid_username'];
if ($f == 'delete_number') {
    $nomor = get("nomor");
    $file = '../session/ridped-md-' . $nomor . '.json';
    $cekfile = file_exists($file);
    $cekready = mysqli_query($con, "SELECT * FROM device WHERE nomor = '$nomor'");

    if ($cekfile == true) {
         echo "<script>alert('Please logout wa first before deleting the number from the database');</script>";
    } else {
        if (mysqli_num_rows($cekready) > 0) { 
            mysqli_query($con, "DELETE FROM device WHERE nomor='$nomor'");
            mysqli_query($con, "DELETE FROM autoreply_button WHERE make_by = '$nomor'");
            mysqli_query($con, "DELETE FROM auto_reply WHERE nomor = '$nomor'");
            mysqli_query($con, "DELETE FROM list_button WHERE number = '$nomor'");
            mysqli_query($con, "DELETE FROM pesan WHERE sender = '$nomor'");
            mysqli_query($con, "DELETE FROM pesan_default WHERE nomor = '$nomor'");
            mysqli_query($con, "UPDATE rid_account SET total_device = total_device - 1 WHERE rid_username = '$u'");
            echo "oke";
        } else {
            echo "nothing";
        }
    }
}
