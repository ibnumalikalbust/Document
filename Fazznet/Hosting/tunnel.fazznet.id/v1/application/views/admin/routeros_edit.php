<?php
if(!empty($this->p2)){
    $data = $this->model->gd("api_routeros","*","id = '1'","row");
    if(!empty($data->id)){
        $ip_address = $data->ip_address;
        $port = $data->port;
        $username = d_nzm($data->username);
        $password = d_nzm($data->password);
    }else{
		$this->session->set_flashdata("swal", '
		<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.5/sweetalert2.min.js"></script>
		<script>
			var text = "ID Tidak Ditemukan";
			swal.fire({title:"Error",html:text,icon:"error"});
		</script>');
        redirect("admin");
    }
}else{
    $ip_address = "";
    $port = "";
    $username = "";
    $password = "";
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $nzm; ?></h1>
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <form action="<?=base_url("save_routeros")?>" method="post">
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">IP Address</p>
                                <input type="text" name="ip_address" id="ip_address" class="form-control" placeholder="Masukkan IP Address" value="<?=$ip_address?>" required>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">Port</p>
                                <input type="number" name="port" id="port" class="form-control" placeholder="Masukkan Port" value="<?=$port?>" required>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">Username</p>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan IP Address" value="<?=$username?>" required>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">Password</p>
                                <input type="text" name="password" id="password" class="form-control" placeholder="Masukkan IP Address" value="<?=$password?>" required>
                            </div>
                            <div class="col-lg-12 mb-2" align="right">
                                <button type="submit" class="btn btn-sm btn-info">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->