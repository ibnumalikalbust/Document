<?php
require('assetnya/require.php');
$con = $rid['sqlConnect'];
if (checksession == false) {
    redirect(url_wa());
}
$ungser = $_SESSION['rid_username'];
if (isset($_POST['add'])) {
    $kode = $_POST['kode'];
    $fname = $_POST['fname'];
    $fname = str_replace(" ", "", $fname);
    $sender = $_POST['sender'];
    if (empty($kode)) {
        $error = 'Nothing kode';
    } else if (empty($sender)) {
        $error = 'Nothing sender!';  
    } else {
        $cek = mysqli_query($con, "SELECT * FROM custom_code_reply WHERE username = '$ungser' AND file_name = '$fname'");
        if (mysqli_num_rows($cek) == 0) {
            $insert = mysqli_query($con, "INSERT INTO custom_code_reply VALUES (null, '$fname', '$sender', '$ungser')");
            file_put_contents("custom_code_reply/$fname-$sender.js", $kode);
            restart($sender);
            $ceknumb = mysqli_query($con, "SELECT * FROM device");
            while($rowx = mysqli_fetch_assoc($ceknumb)) {
                $start = start($rowx['nomor']);
            }
            header("location: " . $rid['site_url'] . "/index.php?link1=ccr");
        } else {
            $error = 'File already exists';
        }
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
            <p style="color: Tomato;">Note : Edit the code in any code editor, then paste it here.</p>
            <form method="POST" action="">
                <label for="sender">Choose sender</label><br>
                <select class="form-control show-tick" id="sender" name="sender">
                <?php
                $q = mysqli_query($con, "SELECT * FROM device WHERE pemilik='$ungser' AND state = 'CONNECTED'");
                while ($row = mysqli_fetch_assoc($q)) {
                    echo '<option value="' . $row['nomor'] . '">' . $row['nomor'] . ' (active)</option>';
                }
                ?>
                </select>
                <br>
                <label for="kode">Enter your own kode here</label><br>
                <textarea name="kode" style="height: 250px; width: 450px;"> // By : Ridah
module.exports = async function(body, args, arg, client, pushname, from, m, SessionName) {
    // write your code reply here hereeee, Don't delete above. example :
    const fetch = require('node-fetch')
    var apiKey = 'Yourkey' // change with your key self.
    var urlApi = 'https://www.api.ridped.com/api'
    var body = body.toLowerCase()
    if (body == 'halow') {
        // send message text
        return await client.sendMessage(from, { text: `Haloo ${pushname}`})
        // If reply mode then add { quoted: m }) so : return await client.sendMessage(from, { text: `Haloo ${pushname}`}, { quoted: m })
    }
    
    // auto reply with sesi
    if (body == 'kenalan') {
        client.kenalan = client.kenalan ? client.kenalan : {}
        if (from in client.kenalan) {
            return await client.sendMessage(from, { text: `The session isn't over yet, you haven't said your name`}, { quoted: m })
        }
        return client.kenalan[from] = [
            await client.sendMessage(from, { text: `Whats your name?` }, { quoted: m }),
            from
        ]
    }
    
    try {
        if (from in client.kenalan) {
            var name = m.message.conversation
            var noUser = client.kenalan[from][1]
            await client.sendMessage(noUser, { text: `Ohh hellow ${name}`}, { quoted: m })
            // if you want, you can insert to database value name & number.
            // delete sesi with this number
            return delete client.kenalan[noUser]
        }
    } catch (e) {}
}
                </textarea>
                <br>
                <label for="fname">Enter name file</label>
                <input type="text" name="fname" placeholder="Ex : myautoreply" required>
                <br>
                <button type="submit" name="add">Add</button>
            </form>
        </center>
    </body>
</html>