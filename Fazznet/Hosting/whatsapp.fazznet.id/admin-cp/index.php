<?php include('template/header.php') ?>

<?php
if (isset($_POST['add_user'])) {
	$username = post('username');
	$password = sha1($_POST['password']);
	$api_key = sha1(date("Y-m-d H:i:s") . rand(100000, 999999));
	$ridlevel = post('level'); // member
	$nd = post('nd'); // 1 mode night, 2 mode day
	$can_sendmsg = post('can_sendmsg');
	$can_sendbutton = post('can_sendbutton');
	$can_datanumber = post('can_datanumber');
	$can_def_msg = post('can_def_msg');
	$can_restapi = post('can_restapi');
	$total_device = '0';
	$limit_device = post('limit_device') ? post('limit_device') : '1';
	$rid_start = date('Y-m-d');
	$rid_expired = post('expired');
	$ridfo = '';
	$ridcheck = mysqli_query($con, "SELECT * FROM rid_account WHERE rid_username = '$username'");
	if (mysqli_num_rows($ridcheck) < 1) {
		$ridinsert = mysqli_query($con, "INSERT INTO rid_account VALUES (null, '$username', '$password', '$ridlevel', '$api_key', '$nd', '$can_sendmsg', '$can_sendbutton', '$can_datanumber', '$can_def_msg', '$can_restapi', '$total_device', '$limit_device', '$rid_start', '$rid_expired')");
		if ($ridinsert == true) {
			$ridfo = true;
			$ridmsg = rid_lang('succes_register');
			echo $ridmsg;
		} else {
			$ridfo = false;
			$ridmsg = rid_lang('system_error');
			echo $ridmsg;
		}
	} else {
		$ridfo = false;
		$ridmsg = rid_lang('username_registered');
		echo $ridmsg;
	}
}

if (isset($_GET['force_logout'])) {
    $id = $_GET['force_logout'];
    $con->query("UPDATE rid_account SET cookie = '' WHERE id = '$id'");
    echo '<script>alert("Succesfully");</script>';
}
?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>DASHBOARD</h3>
                <p class="text-subtitle text-muted">WAY - Admin Panel</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon green">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Total users</h6>
                                    <h6 class="font-extrabold mb-0"><?php echo totaluser();?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon green">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Total device active</h6>
                                    <h6 class="font-extrabold mb-0"><?php echo totaldevactive();?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon green">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Total device not active</h6>
                                    <h6 class="font-extrabold mb-0"><?php echo totaldevnotactive();?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section class="section">
        <div class="card">
            <div class="card-header">
                Manage & List User
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="table1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>USERNAME</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cek = mysqli_query($con, "SELECT * FROM rid_account");
                        while($row = mysqli_fetch_assoc($cek)) { ?>
                        <tr>
                            <td><?= $row['id'];?></td>
                            <td><?= $row['rid_username'];?></td>
                            <td>
                                <center><a href="edituser.php?id=<?= $row['id'];?>">Edit</a></center>
                                <?php if (strlen($row['cookie']) > 1) { ?>
                                <center><a href="index.php?force_logout=<?= $row['id'];?>">Force logout</a></center>
                                <?php } else { ?>
                                <center><a href="#">Not loggedin</a></center>
                                <?php } ?>
                                </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Add users
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="">
                                            <div class="form-group">
                                                <label for="disabledInput">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="disabledInput">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                            </div>
                                            <fieldset class="form-group">
                                                <label for="disabledInput">Select role/level</label>
                                                <select class="form-select" name="level">
                                                    <option value="2" selected="">member (current)</option>
                                                    <option value="1">As Admin</option>
                                                    <option value="2">As member</option>
                                                </select>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="disabledInput">Mode night/day</label>
                                                <select class="form-select" name="nd">
                                                    <option value="1" selected="">Night (current)</option>
                                                    <option value="1">As Night</option>
                                                    <option value="2">As Day</option>
                                                </select>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="disabledInput">Can user send message?</label>
                                                <select class="form-select" name="can_sendmsg">
                                                    <option value="1" selected="">Enable (current)</option>
                                                    <option value="1">Enable</option>
                                                    <option value="2">Disable</option>
                                                </select>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="disabledInput">Can user send button?</label>
                                                <select class="form-select" name="can_sendbutton">
                                                    <option value="1" selected="">Enable (current)</option>
                                                    <option value="1">Enable</option>
                                                    <option value="2">Disable</option>
                                                </select>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label for="disabledInput">Can user add data number?</label>
                                                <select class="form-select" name="can_datanumber">
                                                    <option value="1" selected="">Enable (current)</option>
                                                    <option value="1">Enable</option>
                                                    <option value="2">Disable</option>
                                                </select>
                                            </fieldset> 
                                            <fieldset class="form-group">
                                                <label for="disabledInput">Can user add default message?</label>
                                                <select class="form-select" name="can_def_msg">
                                                    <option value="1" selected="">Enable (current)</option>
                                                    <option value="1">Enable</option>
                                                    <option value="2">Disable</option>
                                                </select>
                                            </fieldset>  
                                            <fieldset class="form-group">
                                                <label for="disabledInput">Can user access REST API?</label>
                                                <select class="form-select" name="can_restapi">
                                                    <option value="1" selected="">Enable (current)</option>
                                                    <option value="1">Enable</option>
                                                    <option value="2">Disable</option>
                                                </select>
                                            </fieldset> 
                                            <div class="form-group">
                                                <label for="disabledInput">Limit Device</label>
                                                <input type="text" class="form-control" id="limit_device" name="limit_device" required>
                                                <small>*Set to unlimited for unli</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="disabledInput">Account expired</label>
                                                <input type="date" class="form-control" id="limit_device" name="expired" required>
                                                <small>*Tanggal Hari ini <?php echo date('Y-m-d');?>, Pilih tanggal kapan akun akan expired dari mulai hari ini.</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="add_user" class="btn btn-primary ml-1">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Create</span>
                                            </button>
                                            </form>
                                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Close</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
<?php include("template/footer.php") ?>
