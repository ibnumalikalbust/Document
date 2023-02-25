<?php
$con = $rid['sqlConnect'];
if ($f == 'lool') {
    $last_sync = get("lastsync");
    $last_sync = strtotime($last_sync);
    $q = mysqli_query($con, "SELECT * FROM pesan ORDER BY id DESC");
    $final = [];
    while($row = mysqli_fetch_assoc($q)){
            $r['id'] = $row['id'];
            $r['status'] = $row['status'];
            $final[] = $r;
    }
    echo json_encode($final);

}