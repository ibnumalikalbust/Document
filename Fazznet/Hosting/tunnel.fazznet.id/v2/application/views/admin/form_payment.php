<?php
if(!empty($this->p3)){
    $data = $this->model->gd("payment_method","*","id = '".$this->p3."'","row");
    if(!empty($data->id)){
        $payment = $data->payment;
        $nomor_payment = $data->nomor_payment;
        $an = $data->an;
        if($data->status == "Aktif"){
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
        redirect("list_vpn");
    }
}else{
    $payment = "";
    $nomor_payment = "";
    $an = "";
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
                    <form action="<?=base_url("save_payment/".$this->p3)?>" method="post">
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">Nama Payment</p>
                                <input type="text" name="payment" id="payment" class="form-control" placeholder="Masukkan Nama Payment, Contoh : OVO" value="<?=$payment?>" required>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">Nomor Payment</p>
                                <input type="text" name="nomor_payment" id="nomor_payment" class="form-control" placeholder="Masukkan No Rek / No Payment Kamu" value="<?=$nomor_payment?>" required>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">A/N</p>
                                <input type="text" name="an" id="an" class="form-control" placeholder="Masukkan Nama Tujuan Payment" value="<?=$an?>" required>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <p class="mb-1">Status</p>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="status" name="status" value="Aktif" onchange="change_status()" <?=$status?>>
                                    <label class="custom-control-label" for="status">Aktif</label>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-2" align="right">
                                <a href="<?=base_url("list_payment")?>" class="btn btn-sm btn-danger">Kembali</a>
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