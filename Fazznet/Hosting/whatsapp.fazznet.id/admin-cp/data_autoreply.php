<?php include('template/header.php') ?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Auto reply</h3>
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
                                    <h6 class="text-muted font-semibold">Total autoreply</h6>
                                    <h6 class="font-extrabold mb-0"><?php echo totalautoreply();?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section class="section">
        <div class="card">
            <div class="card-header">
                Manage & List Auto reply
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="table1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>KEYWORD</th>
                            <th>RESPONSE</th>
                            <th><?php echo rid_lang('number');?></th>
                            <th>Account</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cek = mysqli_query($con, "SELECT * FROM auto_reply");
                        while($row = mysqli_fetch_assoc($cek)) { ?>
                        <tr>
                            <td><?= $row['id'];?></td>
                            <td><?= $row['keyword'];?></td>
                            <td><?= $row['response'];?></td>
                            <td><?= $row['nomor'];?></td>
                            <td><?= $row['make_by'];?></td>
                            <td>
                                <center><a href="editautoreply.php?id=<?= $row['id'];?>">Edit</a></center>
                                </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
</div>

<?php include("template/footer.php") ?>