<!-- Begin Page Content -->
<?php
$data = $this->model->join3table("data_order a","user b","vpn_master c","a.id_user = b.id","a.id_server = c.id","a.status_debit,a.id,c.harga,b.name,b.email,a.nomor_order,c.id_server,a.username,a.password,a.port,a.tanggal_order,a.berlangganan,a.expired_date,a.remote_address,a.status","a.deleted_date IS NULL AND a.id = '".$id_order."'","row");
if(!empty($data)){
    if($data->status == "Aktif"){
        $status = '<p class="badge badge-success">Aktif</p>';
    }else{
        $status = '<p class="badge badge-danger">Non Aktif</p>';
    }

    if($data->status_debit == "1"){
        $checked = "checked";
        $status_debit = "Aktif";
    }else{
        $checked = "";
        $status_debit = "Non Aktif";
    }
}else{
    $this->session->set_flashdata("swal", '
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.5/sweetalert2.min.js"></script>
    <script>
        var text = "Data tidak ditemukan";
        swal.fire({title:"Error",html:text,icon:"error"});
    </script>');
    redirect("list_order_vpn");
}
?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$nzm?></h1>
    <div class="row">
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div style="position:relative;height:16rem;width:100%;">
                        <center>
                            <div class="text-center">
                                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 11rem;" src="https://tunnel.hostddns.us/images/undraw_server_cluster_jwwq.svg" alt="">
                            </div>
                            <h4 class="card-title">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">VPN Remote Access</div>
                            </h4>
                            <p class="badge badge-success">Active</p>
                            <p class="text-xs mb-1"><?= $data->username; ?></p>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header ">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="m-0 font-weight-bold text-primary nav-item nav-link active" id="nav-config" data-toggle="tab" href="#configuration" role="tab" aria-controls="nav-config" aria-selected="false">
                                <i class="fas fa-fw fa-cogs" style="font-size:13px;" aria-hidden="true"></i> Configuration </a>
                        </li>
                        <li class="nav-item">
                            <a class="m-0 font-weight-bold text-primary nav-item nav-link" id="nav-control" data-toggle="tab" href="#control" role="tab" aria-controls="nav-control" aria-selected="true">
                                <i class="fas fa-fw fa-cash-register" style="font-size:13px;" aria-hidden="true"></i> Control </a>
                        </li>
                    </ul>
                </div>
                <div class="collapse show" id="voucher">
                    <div class="card-body">
                        <div style="position:relative;min-height:12.5rem;width:100%;">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="configuration" role="tabpanel" aria-labelledby="nav-config">
                                    <p class="mb-4">
                                        <b>MikroTik</b>
                                        <br>
                                        <small>Silahkan copy script ke terminal.</small>
                                    </p>
                                    <code id="code_pelanggan">/interface l2tp-client add connect-to=sg1.fazznet.id name=<?= $data->username; ?> password=<?= $data->password; ?> user=<?= $data->username; ?> disabled=no comment=vpn.nzmwifi.my.id:<?= ip_number($data->nomor_order-1); ?><-><?= $data->port; ?>*exp-<?= strtolower(date("M/d/Y",strtotime($data->expired_date))); ?></code>
                                    <div class="mt-2 w-100" align="right"><a href="javascript:void(0)" onclick="copyDivToClipboard()" class="btn btn-sm btn-white" title="Copy to Clipboard"><i class="fa-regular fa-copy"></i></a></div>
                                </div>
                                <div class="tab-pane fade" id="control" role="tabpanel" aria-labelledby="nav-control">
                                    <br>
                                    <center>
                                        <p class="mb-4">
                                            <b>Control Center</b>
                                            <br>
                                            <small>Silahkan klik tombol dibawah ini jika ingin menghapus atau memperpanjang vpn</small>
                                        </p>
                                        <a href="#" data-toggle="modal" data-target="#DeleteVPN" class="btn btn-danger btn-sm">
                                            <i class="fas fa-times-circle fa-fw" style="font-size:13px" aria-hidden="true"></i> Delete Akun VPN </a>
                                    </center>
                                </div>
                                <div class="modal fade" id="DeleteVPN" tabindex="1" role="dialog" aria-labelledby="Destroy" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="DeleteVPN">
                                                    <i class="fas fa-exclamation-triangle fa-fw" aria-hidden="true"></i> Warning
                                                </h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="modal-body">Perhatikan Sebelum Menghapus : <br>
                                                    <br> 1. System mendeteksi pengembalian saldo berdasarkan tanggal. Jika tanggal pembuatan dan tanggal penghapusan sama, maka akan direfund. <br> 2. Jika tanggal pembuatan dengan tanggal penghapusan beda, maka saldo tidak akan direfund <br> 3. Segala kesalahan user dalam melakukan tindakan ini bukan tanggung jawab kami ! <br>
                                                    <br> Tekan <b>"Ya, Hapus Akun Ini"</b> Untuk Konfirmasi. <br>
                                                    <br>
                                                    <div class="alert alert-danger" role="alert">
                                                        <small>Anda tidak dapat membatalkan aksi ini jika kamu telah menekan tombol.</small>
                                                    </div>
                                                </div>
                                                <div data-id="error"></div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                    <a href="<?= base_url("delvpn/".$this->p3); ?>" class="btn btn-sm btn-danger btn-icon-split" data-id="delete">
                                                        <span class="icon text-white">
                                                            <i class="fas fa-thumbs-up fa-fw" style="font-size:13px" aria-hidden="true"></i>
                                                        </span>
                                                        <span class="text"> Ya, Hapus Akun Ini</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="PerpanjangVPN" tabindex="1" role="dialog" aria-labelledby="Destroy" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="PerpanjangVPN">
                                                    <i class="fas fa-exclamation-triangle fa-fw" aria-hidden="true"></i> Warning
                                                </h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form data-id="PerpanjangVPN197253" method="post">
                                                    <div class="modal-body">Perhatikan Sebelum Memperpanjang akun : <br>
                                                        <br> 1. Saldo anda akan dipotong sebesar harga server. <br> 2. Pastikan saldo anda cukup untuk melakukan perpanjang <br>
                                                        <br>
                                                        <br> Tekan <b>"Ya, Perpanjang Akun Ini"</b> Untuk Konfirmasi. <br>
                                                        <br>
                                                        <div class="alert alert-danger" role="alert">
                                                            <small>Anda tidak dapat membatalkan aksi ini jika kamu telah menekan tombol.</small>
                                                        </div>
                                                    </div>
                                                    <div data-id="error"></div>
                                                    <input type="hidden" name="name" value="YldGc2FXc3hOa0J0ZVhSMWJtNWxiQzVwWkE9PQ==">
                                                    <input type="hidden" name="port" value="TWpRd013PT0=">
                                                    <input type="hidden" id="api_token" name="api_token" value="40256e0c228abec12b24e360eedc0cfa">
                                                    <div class="modal-footer">
                                                        <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-sm btn-success btn-icon-split" data-id="perpanjang">
                                                            <span class="icon text-white">
                                                                <i class="fas fa-sync fa-fw" style="font-size:13px" aria-hidden="true"></i>
                                                            </span>
                                                            <span class="text"> Ya, Perpanjang Akun Ini</span>
                                                        </button>
                                                    </div>
                                                </form>
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
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header ">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="m-0 font-weight-bold text-primary nav-item nav-link active" id="nav-informasi" data-toggle="tab" href="#informasi" role="tab" aria-controls="nav-home" aria-selected="true">
                                <i class="fas fa-fw fa-users-cog" style="font-size:13px;" aria-hidden="true"></i> Information </a>
                        </li>
                        <li class="nav-item">
                            <a class="m-0 font-weight-bold text-primary nav-item nav-link" id="nav-changepass" data-toggle="tab" href="#changepass" role="tab" aria-controls="nav-profile" aria-selected="false">
                                <i class="fas fa-fw fa-user-edit" style="font-size:13px;" aria-hidden="true"></i> Edit VPN </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="informasi" role="tabpanel" aria-labelledby="nav-informasi">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="text">
                                        <i class="fas fa-user fa-fw" style="font-size:13px;" data-toggle="tooltip" data-original-title="Username VPN" aria-hidden="true"></i> Username VPN : </label>
                                    <div class="col-sm-12 mb-3 mb-sm-0"> <?= $data->username; ?> </div>
                                </div>
                                <div class="col-sm-6 ">
                                    <label for="text">
                                        <i class="fas fa-user-lock fa-fw" style="font-size:13px;" data-toggle="tooltip" data-original-title="Password VPN" aria-hidden="true"></i> Password VPN : </label>
                                    <div class="col-sm-12 mb-3 mb-sm-0"> <?= $data->password; ?> </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="text">
                                        <i class="fas fa-server fa-fw" style="font-size:13px;" data-toggle="tooltip" data-original-title="Server" aria-hidden="true"></i> IP Server : </label>
                                    <div class="col-sm-12 mb-3 mb-sm-0"> <?= $data->id_server; ?> </div>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="text">
                                        <i class="fas fa-server fa-fw" style="font-size:13px;" data-toggle="tooltip" data-original-title="Server" aria-hidden="true"></i> IP Local : </label>
                                    <div class="col-sm-12 mb-3 mb-sm-0"> <?= $data->remote_address; ?> </div>
                                </div>
                            </div>
                            <div class="form-group row">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="text">
                                        <i class="fas fa-clock fa-fw" style="font-size:13px;" data-toggle="tooltip" data-original-title="Created Date" aria-hidden="true"></i> Created Date : </label>
                                    <div class="col-sm-12 mb-3 mb-sm-0"> <?= date("d M Y",strtotime($data->tanggal_order)); ?> </div>
                                </div>
                                <div class="col-sm-6 ">
                                    <label for="text">
                                        <i class="fas fa-history fa-fw" style="font-size:13px;" data-toggle="tooltip" data-original-title="Expired Date" aria-hidden="true"></i> Expired Date : </label>
                                    <div class="col-sm-12 mb-3 mb-sm-0"> <?= date("d M Y",strtotime($data->expired_date)); ?> </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="text">
                                        <i class="fas fa-laptop-house fa-fw" style="font-size:13px;" data-toggle="tooltip" data-original-title="URL REMOTE" aria-hidden="true"></i> URL Remote : </label>
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <?php
                                        $address_ip = ip_number($data->nomor_order-1);
                                        ?>
                                        <span class="badge badge-info" data-toggle="tooltip" data-original-title="URL Remote"><?= $data->id_server.".".$this->server.":".$address_ip; ?></span>
                                        <i class="fas fa-arrows-alt-h" aria-hidden="true"></i>
                                        <span class="badge badge-success" data-toggle="tooltip" data-original-title="Port Yang diremote"><?=$data->port;?></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="text">
                                        <i class="fas fa-history fa-fw" style="font-size:13px;" data-toggle="tooltip" data-original-title="Perpanjang Otomatis" aria-hidden="true"></i> Perpanjang Otomatis : </label>
                                    <div class="col-sm-12 mb-3 mb-sm-0"> <?= $status_debit; ?> </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="changepass" role="tabpanel" aria-labelledby="nav-changepass">
                            <form id="EditVPN" action="<?= base_url("edit_vpn/".$this->p3) ?>" method="post">
                                <p class="mb-4">
                                    <b>Ubah akun VPN Remote Anda.</b>
                                </p>
                                <div class="alert alert-primary" role="alert">
                                    <small>Anda dapat mengubah port yang mau diremote, dan mengubah option billing kapan pun anda mau. Perlu diketahui bahwa dalam mengubah Port, anda diberikan batasan 5 Kali untuk mengubah dalam waktu 1 bulan.</small>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="email">
                                            <i class="fas fa-user fa-fw" style="font-size:13px;" data-toggle="tooltip" data-original-title="Username VPN" aria-hidden="true"></i> Username : </label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <input type="text" class="form-control" name="vpn_username" placeholder="Username VPN" value="<?= $data->username; ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 ">
                                        <label for="email">
                                            <i class="fas fa-ethernet fa-fw" style="font-size:13px;" data-toggle="tooltip" data-original-title="Port yang ingin diremote" aria-hidden="true"></i> Port For Remote : </label>
                                        <input type="number" class="form-control" name="port" placeholder="Contoh : 8291 (Port Yang ingin diremote" value="<?= $data->port; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">
                                        <i class="fas fa-fingerprint fa-fw" style="font-size:13px;" data-toggle="tooltip" data-original-title="Password VPN" aria-hidden="true"></i> Password : </label>
                                    <input type="text" class="form-control" name="password" placeholder="Contoh : XXXXXXXXX" value="<?= $data->password; ?>">
                                </div>
                                <div class="alert alert-danger" role="alert">
                                    <small>Fitur ini berguna untuk membuat agar vpn anda diperpanjang otomatis nantinya. Jika ini tidak kamu aktifkan, maka sistem akan mendeteksi bahwa akun ini tidak akan diperpanjang dan akan dihapus oleh sistem.</small>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input name="status_debit" value="0" type="hidden" class="custom-control-input">
                                        <input name="status_debit" value="1" type="checkbox" class="custom-control-input" id="customCheck" <?= $checked; ?>>
                                        <label name="remember" class="custom-control-label" for="customCheck" data-toggle="tooltip" data-original-title="Opsi auto Perpanjang">Perpanjang Otomatis <small>(Auto Debit)</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-sm-12 col-md-6 mb-4" id="result" role="alert"></div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-sm btn-secondary" data-dismiss="modal">
                                        <i class="fas fa-undo" style="font-size:13px" aria-hidden="true"></i> Reset </button>
                                    <button class="btn btn-sm btn-primary" id="action">
                                        <i class="fas fa-paper-plane" style="font-size:13px" aria-hidden="true"></i> Edit </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>