<?php
if (!empty($this->p2)) {
    $data = $this->model->gd("api_routeros", "*", "id = '" . $id . "'", "row");
    if (!empty($data->id)) {
        $id_server_disable = "readonly";
        $id_server = $data->id_server;
        $nama_server = $data->nama_server;
        $ip_address = $data->ip_address;
        $port = $data->port;
        $country = $data->country;
        if($data->is_active == "1"){
            $is_active = "checked";
        }else{
            $is_active = "";
        }
        if (!empty($port)) {
            $port = $port;
        } else {
            $port = "";
        }
        $username = d_nzm($data->username);
        $password = d_nzm($data->password);
    } else {
        $this->session->set_flashdata("swal", '
		<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.5/sweetalert2.min.js"></script>
		<script>
			var text = "ID Tidak Ditemukan";
			swal.fire({title:"Error",html:text,icon:"error"});
		</script>');
        redirect("admin");
    }
} else {
    $id_server_disable = "";
    $id_server = "";
    $nama_server = "";
    $ip_address = "";
    $port = "";
    $username = "";
    $password = "";
    $country = "";
    $is_active = "checked";
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $nzm; ?></h1>
    <form action="<?= base_url("save_routeros/" . $this->p2) ?>" method="post">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">ID Server <span class="text-danger">*</span></p>
                                <input type="text" name="id_server" id="id_server" class="form-control" placeholder="Masukkan ID Server, Contoh : id-27" value="<?= $id_server ?>" <?= $id_server_disable; ?> maxlength="10" required>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">Nama Server <span class="text-danger">*</span></p>
                                <input type="text" name="nama_server" id="nama_server" class="form-control" placeholder="Masukkan Nama Server" value="<?= $nama_server ?>" required>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">Location <span class="text-danger">*</span></p>
                                <input type="text" name="country" id="country" class="form-control" placeholder="Contoh : Indonesia" value="<?= $country ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">IP Address <span class="text-danger">*</span></p>
                                <input type="text" name="ip_address" id="ip_address" class="form-control" placeholder="Masukkan IP Address" value="<?= $ip_address ?>" required>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">Port (Optional)</p>
                                <input type="number" name="port" id="port" class="form-control" placeholder="Masukkan Port" value="<?= $port ?>">
                            </div>
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">Username <span class="text-danger">*</span></p>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan Username" value="<?= $username ?>" required>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">Password (Optional)</p>
                                <input type="text" name="password" id="password" class="form-control" placeholder="Masukkan Password" value="<?= $password ?>">
                            </div>
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">Status</p>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="Aktif" onchange="change_status()" <?=$is_active?>>
                                    <label class="custom-control-label" for="is_active">Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2" align="right">
                        <a href="<?= base_url("routeros/list") ?>" class="btn btn-sm btn-danger">Kembali</a>
                        <button type="submit" class="btn btn-sm btn-info">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->