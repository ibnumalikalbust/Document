<?php include("template/header.php")?>

<?php
$id = get('id');
if (empty($id)) {
    redirect('index.php');
} else {
    $cek = mysqli_query($con, "SELECT * FROM rid_account WHERE id = '$id'");
    if (mysqli_num_rows($cek) > 0) {
        $data = mysqli_fetch_assoc($cek);
        $user = $data['rid_username'];
        $datvice = mysqli_query($con, "SELECT * FROM device WHERE pemilik = '$user'");
        $totalvice = mysqli_num_rows($datvice);
    } else {
        redirect('index.php');
    }
}

if (isset($_POST['level'])) {
    $level = post('level');
    $newpass = post('newpass');
    if (!empty($newpass)) {
        $newpass = sha1($newpass);
        $update = mysqli_query($con, "UPDATE rid_account SET rid_password = '$newpass', rid_level = '$level' WHERE id = '$id'");
    } else {
        $update = mysqli_query($con, "UPDATE rid_account SET rid_level = '$level' WHERE id = '$id'");
    }
    $ridfo = 'Updated';
$can_sendmsg = post('can_sendmsg');
$can_sendbutton = post('can_sendbutton');
$can_datanumber = post('can_datanumber');
$can_def_msg = post('can_def_msg');
$can_restapi = post('can_restapi');
$limit_device = post('limit_device');
$rid_start = date('Y-m-d');
$rid_expired = post('expired');
$cookie = post('cookie');
$updatepermision = mysqli_query($con, "
UPDATE rid_account SET send_msg = '$can_sendmsg',
send_button = '$can_sendbutton',
datanumber = '$can_datanumber',
def_msg = '$can_def_msg',
rest_api = '$can_restapi',
limit_device = '$limit_device',
rid_start = '$rid_start',
rid_expired = '$rid_expired',
cookie = '$cookie' WHERE id = '$id'");
    redirect('edituser.php?id='.$id);
}

// deleting all data and session
if (isset($_GET['delete'])) {
    $username = get('delete');
    $delete_button = mysqli_query($con, "DELETE FROM autoreply_button WHERE username = '$username'");
    $deleteautoreply = mysqli_query($con, "DELETE FROM auto_reply WHERE make_by = '$username'");
    if ($totalvice > 0) {
        $datvice = mysqli_query($con, "SELECT * FROM device WHERE pemilik = '$username'");
        while($sesvice = mysqli_fetch_assoc($datvice)) {
            $nomor = $sesvice['nomor'];
            $file = './../session/ridped-md-' . $nomor . '.json';
            $cekfile = file_exists($file);
            if ($cekfile == true) {
                $logout = logout_wa($nomor);
            }
        }
        $deletedevice = mysqli_query($con, "DELETE FROM device WHERE pemilik = '$username'");
        $deletenomor = mysqli_query($con, "DELETE FROM nomor WHERE make_by = '$username'");
        $deletepesan = mysqli_query($con, "DELETE FROM pesan WHERE make_by = '$username'");
        $deletepesan_def = mysqli_query($con, "DELETE FROM pesan_default WHERE make_by = '$username'");
    }
    $deleteaccount = mysqli_query($con, "DELETE FROM rid_account WHERE rid_username = '$username'");
    
    redirect('index.php');
}
?>
<!-- Body -->       
    <div class="page-title">        
            <div class="row">       
                <div class="col-12 col-md-6 order-md-1 order-last">     
                    <h3>DETAIL USER</h3>      
                    <p class="text-subtitle text-muted">WAY - Admin Panel </p>      
                </div>      
                <div class="col-12 col-md-6 order-md-2 order-first">        
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">        
                    </nav>      
                </div>      
            </div>      
    </div>      
    <div class="card">      
        <div class="card-body py-4 px-5">       
            <div class="d-flex align-items-center">     
                <div class="avatar avatar-xl">      
                    <img src="assets/images/faces/1.jpg" alt="Face 1">      
                </div>      
                <div class="ms-3 name">     
                    <h5 class="font-bold"><?= $data['rid_username'];?><span class="badge bg-light-primary"><?php if ($data['rid_level'] == '1') { echo 'Admin'; } else { echo 'Member'; } ?> </span></h5>        
                    <h6 class="text-muted mb-0">Total device : <?= $totalvice;?></h6>     
                </div>      
            </div>      
        </div>      
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Fitur User</h4>
            </div>
            
            <form method="POST">
            <div class="card-body">
                <label class="card-title"><b>User Information</b></label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="disabledInput">Username</label>
                            <input type="text" class="form-control" id="readonlyInput" readonly="readonly" value="<?= $user;?>">
                        </div>
                    </div>
                    <fieldset class="form-group">
                        <label for="disabledInput">Select level</label>
                        <select class="form-select" name="level">
                            <option value="<?php echo $data['rid_level'];?>" selected><?php if ($data['rid_level'] == '1') { echo 'Admin (current)'; } else { echo 'member (current)'; }?></option>
                            <option value="1">As Admin</option>
                            <option value="2">As member</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput">Can user send message?</label>
                        <select class="form-select" name="can_sendmsg">
                            <option value="<?php echo $data['send_msg'];?>" selected><?php if ($data['send_msg'] == '1') { echo 'Enable (current)'; } else { echo 'Disable (current)'; }?></option>
                            <option value="1">Enable</option>
                            <option value="2">Disable</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput">Can user send button?</label>
                        <select class="form-select" name="can_sendbutton">
                            <option value="<?php echo $data['send_button'];?>" selected><?php if ($data['send_button'] == '1') { echo 'Enable (current)'; } else { echo 'Disable (current)'; }?></option>
                            <option value="1">Enable</option>
                            <option value="2">Disable</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput">Can user add data number?</label>
                        <select class="form-select" name="can_datanumber">
                            <option value="<?php echo $data['datanumber'];?>" selected><?php if ($data['datanumber'] == '1') { echo 'Enable (current)'; } else { echo 'Disable (current)'; }?></option>
                            <option value="1">Enable</option>
                            <option value="2">Disable</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput">Can user add default message?</label>
                        <select class="form-select" name="can_def_msg">
                            <option value="<?php echo $data['def_msg'];?>" selected><?php if ($data['def_msg'] == '1') { echo 'Enable (current)'; } else { echo 'Disable (current)'; }?></option>
                            <option value="1">Enable</option>
                            <option value="2">Disable</option>
                            </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="disabledInput">Can user access REST API?</label>
                        <select class="form-select" name="can_restapi">
                            <option value="<?php echo $data['rest_api'];?>" selected><?php if ($data['rest_api'] == '1') { echo 'Enable (current)'; } else { echo 'Disable (current)'; }?></option>
                            <option value="1">Enable</option>
                            <option value="2">Disable</option>
                            </select>
                    </fieldset>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="disabledInput">New pass</label>
                            <input type="password" class="form-control" name="newpass">
                        </div>
                        <div class="form-group">
                            <label for="disabledInput">COOKIE</label>
                            <input type="text" class="form-control" name="cookie" readonly value="<?php echo $data['cookie'];?>">
                        </div>
                        <div class="form-group">
                            <label for="disabledInput">API Key</label>
                            <input type="text" class="form-control" id="readonlyInput" readonly="readonly" value="<?php echo $data['api_key'];?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="disabledInput">Limit device</label>
                            <input type="text" class="form-control" name="limit_device" value="<?= $data['limit_device'];?>">
                        </div>
                        <small>*Set unlimited for unlimited</small>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="disabledInput">Account Expired</label>
                            <input type="date" class="form-control" name="expired" value="<?= $data['rid_expired'];?>">
                        </div>
                        <small>*Jika anda mengubah ini, ini akan berubah pula Tanggal Start nya menjadi tanggal pada hari ini <?php echo date('Y-m-d');?>.</small>
                    </div>
                </div>
            </div>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-primary"><i class="iconly-boldEdit-Square"></i> Update</button>
                </div>
                </form>
                <br>
                <br>
                <label class="card-title"><b>Important : Semua data user akan di hapus</b></label>
                <a href="?id=<?php echo $data['id'];?>&delete=<?php echo $user;?>" class="btn btn-warning" name="delete"><i class="iconly-boldDelete"></i> Delete</a>
        </div>
        
                            
        </div>
    </section>


<?php include("template/footer.php")?>      