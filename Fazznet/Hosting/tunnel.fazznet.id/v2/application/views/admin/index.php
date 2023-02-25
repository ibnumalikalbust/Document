<?php
if ($this->role_id == "1") {
    $vpn_aktif = $this->model->gd("data_order", "COUNT(id) as count", "deleted_date IS NULL AND expired_date >= '" . date("Y-m-d") . "'", "row");
    $vpn_non_aktif = $this->model->gd("data_order", "COUNT(id) as count", "deleted_date IS NULL AND expired_date < '" . date("Y-m-d") . "'", "row");
    $jumlah_user = $this->model->gd("user", "COUNT(id) as count", "role_id = '2'", "row");
    $topup_pending = $this->model->gd("top_up", "COUNT(id) as count", "status = 'Pending'", "row");
?>
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Hai, <?= $this->name; ?> ✨</h1>
            <a href="<?= base_url("saldo/isi_saldo") ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow">
                <i class="fas fa-coins" data-toggle="tooltip" data-original-title="Aksi cepat untuk melakukan pembelian saldo" aria-hidden="true"></i>
                <i class="fas fa-plus" style="font-size:7px;" aria-hidden="true"></i> Isi Saldo
            </a>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold  text-uppercase mb-1">VPN Remote Aktif</div>
                                <div class="h5 mb-0 font-weight-bold " id="countVPN"><?= $vpn_aktif->count; ?></div>
                            </div>
                            <div class="col-auto" data-toggle="tooltip" data-original-title="VPN Remote Aktif">
                                <i class="fas fa-laptop-house fa-2x" style="color:#026aeb" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold  text-uppercase mb-1">VPN Remote Non Aktif</div>
                                <div class="h5 mb-0 font-weight-bold " id="getFunds"><?= $vpn_non_aktif->count; ?></div>
                            </div>
                            <div class="col-auto" data-toggle="tooltip" data-original-title="VPN Remote Non Aktif">
                                <i class="fas fa-plane-slash fa-2x " style="color:#C70039" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold  text-uppercase mb-1">User</div>
                                <div class="h5 mb-0 font-weight-bold " id="getFunds"><?= $jumlah_user->count; ?></div>
                            </div>
                            <div class="col-auto" data-toggle="tooltip" data-original-title="Saldo">
                                <i class="fas fa-users fa-2x " style="color:#33BEFF" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold  text-uppercase mb-1">Top Up Pending</div>
                                <div class="h5 mb-0 font-weight-bold " id="getFunds"><?= $topup_pending->count; ?></div>
                            </div>
                            <div class="col-auto" data-toggle="tooltip" data-original-title="Saldo">
                                <i class="fas fa-coins fa-2x " style="color:#0FA59B" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card  mb-4">
                    <div class="collapse show" id="systemlog">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div id="DataLog_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table dataTable no-footer" id="datatable" width="100%" cellspacing="0" role="grid" aria-describedby="DataLog_info" style="width: 100%; font-size:10pt;">
                                                <thead class="thead-light">
                                                    <tr role="row">
                                                        <th class="text-center align-middle">No</th>
                                                        <th class="text-center align-middle">Email</th>
                                                        <th class="text-center align-middle">Date / Time</th>
                                                        <th class="text-center align-middle">Log Activity </th>
                                                        <th class="text-center align-middle">Category</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $log_activity = $this->model->gd("log_activity_user", "*,(SELECT email FROM user WHERE id = id_user) as email", "id !=", "result");
                                                    $load = '';
                                                    if (!empty($log_activity)) {
                                                        $no = 1;
                                                        foreach ($log_activity as $log_activity) {
                                                            if ($log_activity->category == "Create") {
                                                                $category = '<span class="badge badge-info"><i class="fas fa-plus fa-sm fa-fw" aria-hidden="true"></i> ' . $log_activity->category . '</span>';
                                                            } else if ($log_activity->category == "Update") {
                                                                $category = '<span class="badge badge-warning"><i class="fas fa-pencil-alt fa-sm fa-fw" aria-hidden="true"></i> ' . $log_activity->category . '</span>';
                                                            } else if ($log_activity->category == "Delete") {
                                                                $category = '<span class="badge badge-danger"><i class="fas fa-trash-alt fa-sm fa-fw" aria-hidden="true"></i> ' . $log_activity->category . '</span>';
                                                            } else {
                                                                $category = '';
                                                            }
                                                            $load .= '
                                                            <tr role="row" class="odd">
                                                                <td class="text-center align-middle">' . $no . '</td>
                                                                <td class="text-center align-middle">' . $log_activity->email . '</td>
                                                                <td class="text-center align-middle">' . date("d F Y H:i:s", strtotime($log_activity->tanggal)) . '</td>
                                                                <td class="text-center align-middle">' . $log_activity->logs . '</td>
                                                                <td class="text-center align-middle">' . $category . '</td>
                                                            </tr>';
                                                            $no++;
                                                        }
                                                    }
                                                    echo $load;
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
    $vpn_aktif = $this->model->gd("data_order", "COUNT(id) as count", "deleted_date IS NULL AND expired_date >= '" . date("Y-m-d") . "' AND id_user = '" . $this->id_user . "'", "row");
    $vpn_non_aktif = $this->model->gd("data_order", "COUNT(id) as count", "deleted_date IS NULL AND expired_date < '" . date("Y-m-d") . "' AND id_user = '" . $this->id_user . "'", "row");
    $saldo = $this->model->gd("user", "saldo", "id = '" . $this->id_user . "'", "row");
?>
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Hai, <?= $this->name; ?> ✨</h1>
            <a href="<?=base_url("saldo/isi_saldo")?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow">
                <i class="fas fa-coins" data-toggle="tooltip" data-original-title="Aksi cepat untuk melakukan pembelian saldo" aria-hidden="true"></i>
                <i class="fas fa-plus" style="font-size:7px;" aria-hidden="true"></i> Isi Saldo
            </a>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold  text-uppercase mb-1">VPN Remote Aktif</div>
                                <div class="h5 mb-0 font-weight-bold " id="countVPN"><?= $vpn_aktif->count; ?></div>
                            </div>
                            <div class="col-auto" data-toggle="tooltip" data-original-title="VPN Remote Aktif">
                                <i class="fas fa-laptop-house fa-2x" style="color:#026aeb" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold  text-uppercase mb-1">VPN Remote Non Aktif</div>
                                <div class="h5 mb-0 font-weight-bold " id="getFunds"><?= $vpn_non_aktif->count; ?></div>
                            </div>
                            <div class="col-auto" data-toggle="tooltip" data-original-title="VPN Remote Non Aktif">
                                <i class="fas fa-plane-slash fa-2x " style="color:#C70039" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold  text-uppercase mb-1">Saldo</div>
                                <div class="h5 mb-0 font-weight-bold " id="getFunds"><?= number_format($saldo->saldo,0,"","."); ?></div>
                            </div>
                            <div class="col-auto" data-toggle="tooltip" data-original-title="Saldo">
                                <i class="fas fa-coins fa-2x " style="color:#0FA59B" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12">
                <div class=" card mb-4  shadow">
                    <div class="card-body">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item  active">
                                    <div id="content2" class="row row-grid align-items-center">
                                        <div class="col-lg-8">
                                            <div class="media align-items-center">
                                                <a href="https://docs.hostddns.us/docs/f-a-q/apakah-vpn-remote-freeddns-aman/" class=" rounded-circle mr-3">
                                                    <img width="65" src="<?= base_url("assets/img/device.png") ?>">
                                                </a>
                                                <div class="media-body">
                                                    <h5 class=" mb-0">F.A.Q &amp; Tips</h5>
                                                    <div>
                                                        <small class="">Tips mengamankan mikrotik dari serangan bruteforce. </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto flex-fill mt-4 mt-sm-0 text-sm-right">
                                            <a href="https://wa.me/+6285290189491" target="_blank" class="btn btn-sm btn-success  btn-icon shadow">
                                                <span class="btn-inner--icon"><i class="fab fa-whatsapp fa-fw" aria-hidden="true"></i></span>
                                                <span class="btn-inner--text">Contact</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card  mb-4">

                    <div class="collapse show" id="systemlog">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div id="DataLog_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table dataTable no-footer" id="datatable" width="100%" cellspacing="0" role="grid" aria-describedby="DataLog_info" style="width: 100%; font-size:10pt;">
                                                <thead class="thead-light">
                                                    <tr role="row">
                                                        <th class="text-center align-middle">No</th>
                                                        <th class="text-center align-middle">Email</th>
                                                        <th class="text-center align-middle">Date / Time</th>
                                                        <th class="text-center align-middle">Log Activity </th>
                                                        <th class="text-center align-middle">Category</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $log_activity = $this->model->gd("log_activity_user", "*,(SELECT email FROM user WHERE id = id_user) as email", "id_user = '" . $this->id_user . "'", "result");
                                                    $load = '';
                                                    if (!empty($log_activity)) {
                                                        $no = 1;
                                                        foreach ($log_activity as $log_activity) {
                                                            if ($log_activity->category == "Create") {
                                                                $category = '<span class="badge badge-info"><i class="fas fa-plus fa-sm fa-fw" aria-hidden="true"></i> ' . $log_activity->category . '</span>';
                                                            } else if ($log_activity->category == "Update") {
                                                                $category = '<span class="badge badge-warning"><i class="fas fa-pencil-alt fa-sm fa-fw" aria-hidden="true"></i> ' . $log_activity->category . '</span>';
                                                            } else if ($log_activity->category == "Delete") {
                                                                $category = '<span class="badge badge-danger"><i class="fas fa-trash-alt fa-sm fa-fw" aria-hidden="true"></i> ' . $log_activity->category . '</span>';
                                                            } else {
                                                                $category = '';
                                                            }
                                                            $load .= '
                                                            <tr role="row" class="odd">
                                                                <td class="text-center align-middle">' . $no . '</td>
                                                                <td class="text-center align-middle">' . $log_activity->email . '</td>
                                                                <td class="text-center align-middle">' . date("d F Y H:i:s", strtotime($log_activity->tanggal)) . '</td>
                                                                <td class="text-center align-middle">' . $log_activity->logs . '</td>
                                                                <td class="text-center align-middle">' . $category . '</td>
                                                            </tr>';
                                                            $no++;
                                                        }
                                                    }
                                                    echo $load;
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>