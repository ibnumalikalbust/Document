<?php
require('assetnya/require.php');
$con = $rid['sqlConnect'];
if (checksession == false) {
    redirect(url_wa());
}
$ungser = $_SESSION['rid_username'];
$getid = $_GET['id'];
$cekicrot = mysqli_query($con, "SELECT * FROM custom_code_reply WHERE id = '$getid' AND username = '$ungser'");
if (mysqli_num_rows($cekicrot) == 0) {
    redirect(url_wa());
} else {
    $datanya = mysqli_fetch_assoc($cekicrot);
    $file_name = $datanya['file_name'];
    $mynumb = $datanya['mynumb'];
    $code = file_get_contents("custom_code_reply/$file_name-$mynumb.js");
}

if (isset($_POST['edit'])) {
    $kode = $_POST['kode'];
    if (empty($kode)) {
        $error = 'Nothing kode';
    } else {
        file_put_contents("custom_code_reply/$file_name-$mynumb.js", $kode);
        restart($mynumb);
        $ceknumb = mysqli_query($con, "SELECT * FROM device");
        while($rowx = mysqli_fetch_assoc($ceknumb)) {
            $start = start($rowx['nomor']);
        }
        redirect("edit_ccr.php?id=$getid");
    }
}
?>

<html>
    <head>
        <title>Simple code</title>
    </head>
    <body>
        <center>
            <h1 style="color: Tomato;"><?php echo $error;?></h1>
            <form method="POST" action="">
                <p style="color: Tomato;">File <?php echo $file_name.'-'.$mynumb.'.js';?></p>
                <label for="kode">Enter your own kode here</label><br>
                <textarea name="kode" style="height: 250px; width: 450px;"><?php echo $code;?></textarea>
                <br>
                <button type="submit" name="edit">Save</button>
            </form>
        </center>
    </body>
</html>