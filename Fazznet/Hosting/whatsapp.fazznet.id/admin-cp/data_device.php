<?php include('template/header.php') ?>

<?php

if (isset($_GET['delete'])) {
    $make_by = get('delete');
    $acc = get('account');
    $delete = mysqli_query($con, "DELETE FROM device WHERE nomor = '$make_by'");
    $delete = mysqli_query($con, "DELETE FROM autoreply_button WHERE make_by = '$make_by'");
    $delete = mysqli_query($con, "DELETE FROM auto_reply WHERE nomor = '$make_by'");
    $delete = mysqli_query($con, "DELETE FROM list_button WHERE number = '$make_by'");
    $delete = mysqli_query($con, "DELETE FROM pesan WHERE sender = '$make_by'");
    $delete = mysqli_query($con, "DELETE FROM pesan_default WHERE nomor = '$make_by'");
    $update = mysqli_query($con, "UPDATE rid_account SET total_device = total_device - 1 WHERE rid_username = '$acc'");
    redirect('data_device.php');
}

if (isset($_GET['logout'])) {
    $logout = get('logout');
    $logoutin = logout_wa($logout);
    sleep(2);
    redirect('data_device.php');
}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data device</h3>
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
                Manage & List Device
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="table1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ACCOUNT</th>
                            <th><?php echo rid_lang('number');?></th>
                            <th>WEBHOOK</th>
                            <th>STATE</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cek = mysqli_query($con, "SELECT * FROM device");
                        while($row = mysqli_fetch_assoc($cek)) { ?>
                        <tr>
                            <td><?= $row['id'];?></td>
                            <td><?= $row['pemilik'];?></td>
                            <td><?= $row['nomor'];?></td>
                            <td><?= $row['link_webhook'];?></td>
                            <td><?php if ($row['state'] == 'QRCODE') { echo 'Not connected'; } else if ($row['state'] == 'STARTING') { echo 'Connecting....'; } else { echo 'Connected'; } ?></td>
                            <td>
                                <?php if ($row['state'] == 'CONNECTED') { ?>
                                <center><a href="?logout=<?= $row['nomor'];?>"><?php echo rid_lang('logout');?></a></center>
                                <?php } else { ?>
                                <center><a href="?delete=<?= $row['nomor'];?>&account=<?= $row['pemilik'];?>"><?php echo rid_lang('delete');?></a></center>
                                <?php } ?>
                                </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
</div>

<?php include("template/footer.php") ?>