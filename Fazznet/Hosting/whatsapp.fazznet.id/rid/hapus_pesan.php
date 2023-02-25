<?php
$con = $rid['sqlConnect'];
if ($f == 'hapus_pesan') {
    $id = get("id");

    $q = mysqli_query($con, "DELETE FROM pesan WHERE id='$id'");
    header("location: " . $rid['site_url'] . "/index.php?link1=pesan_s_m");
}