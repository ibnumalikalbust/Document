<?php
$con = $rid['sqlConnect'];
$u = $_SESSION['rid_username'];
$datadefp = $rid['dataUser'];
if ($f == 'del_ccr') {
    $u = $_SESSION['rid_username'];
    $id = $_GET['id'];
    $cek = mysqli_query($con, "SELECT * FROM custom_code_reply WHERE id = '$id' AND username = '$u'");
    if (mysqli_num_rows($cek) == '0') {
        $responya = array(
            "status"=> false,
            "message"=> "Not found in database"
        );
        echo json_encode($responya);
    } else {
        $datanya = mysqli_fetch_assoc($cek);
        $fname = $datanya['file_name'];
        $mynumb = $datanya['mynumb'];
        if (unlink("custom_code_reply/$fname-$mynumb.js")) {
            $update = mysqli_query($con, "DELETE FROM custom_code_reply WHERE id = '$id'");
            //restart('6281572885606');
            $ceknumb = mysqli_query($con, "SELECT * FROM device");
            while($rowx = mysqli_fetch_assoc($ceknumb)) {
                $start = start($rowx['nomor']);
            }
            $responya = array(
                "status"=> 200,
                "message"=> "Succesfully"
            );
            echo json_encode($responya);
        } else {
            $responya = array(
                "status"=> false,
                "message"=> "Failed delete file"
            );
            echo json_encode($responya);
        }
    }
    
}