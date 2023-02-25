<?php
if(!empty($this->p3)){
    $data = $this->model->gd("user","*","id = '".d_nzm($this->p3)."'","row");
    if(!empty($data->id)){
        $name = $data->name;
        $email = $data->email;
        $saldo = number_format($data->saldo,0,"",".");
        if($data->is_active == "1"){
            $status = "checked";
        }else{
            $status = "";
        }
    }else{
		$this->session->set_flashdata("swal", '
		<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.5/sweetalert2.min.js"></script>
		<script>
			var text = "ID Tidak Ditemukan";
			swal.fire({title:"Error",html:text,icon:"error"});
		</script>');
        redirect("user/list");
    }
}else{
    $name = "";
    $email = "";
    $harga = "";
    $lokasi = "";
    $status = "checked";
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
                    <form action="<?=base_url("save_user/".$this->p3)?>" method="post">
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">Name</p>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama" value="<?=$name?>" required>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">Email</p>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Contoh : VPN Remote ID27" value="<?=$email?>" required>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">Saldo</p>
                                <input type="text" inputmode="numeric" name="saldo" id="saldo" class="form-control harga" placeholder="Masukkan Harga disini" value="<?=$saldo?>" required>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">Status</p>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" onchange="change_status()" <?=$status?>>
                                    <label class="custom-control-label" for="is_active">Aktif</label>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-2" align="right">
                                <a href="<?=base_url("user/list")?>" class="btn btn-sm btn-danger">Kembali</a>
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