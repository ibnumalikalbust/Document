<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><?=$nzm?></h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <small>
                        <i class="fas fa-dot-circle fa-fw" style="font-size:10px;" aria-hidden="true"></i>
                        <b>Top Up Saldo diatas jam 12 malam, akan diproses 8/10 pagi</b>
                    </small>
                    <br>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div style="position:relative;height:18rem;width:100%;">
                        <center>
                            <br>
                            <div class="text-center">
                                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 13rem;" src="https://tunnel.hostddns.us/images/white_coin_humans.svg" alt="">
                            </div>
                            <h2 class="card-title">
                                <?php
                                $saldo_user = $this->model->gd("user","saldo","id = '".$this->id_user."'","row");
                                ?>
                                <div class="text-lg font-weight-bold mb-1" id="getFunds">Rp <?= number_format($saldo_user->saldo,0,"",".") ?></div>
                            </h2>
                            <p class="text-xs mb-1">Total Saldo di Akun kamu</p>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form id="Topup" action="<?= base_url("topup_saldo") ?>" method="post">
                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-credit-card fa-fw" style="font-size:13px;" data-toggle="tooltip" data-original-title="Silahkan Pilih Jenis Pembayaran" aria-hidden="true"></i> Jenis Pembayaran : </label>
                            <select name="jenis_pembayaran" id="jenis_pembayaran" class="custom-select input-sm">
                                <option selected="selected" disabled="disable">Please Choose Payment</option>
                                <?php
                                $payment = $this->model->gd("payment_method","*","status = 'Aktif' ORDER BY payment","result");
                                if(!empty($payment)){
                                    foreach($payment as $payment){
                                        echo '<option value="'.$payment->payment.'" data-nomor-tujuan="'.$payment->nomor_payment.'" data-an="'.$payment->an.'">'.$payment->payment.'</option>';
                                    }
                                }
                                ?>
                            </select>
                            <label class="mt-2" id="info-pembayaran">
                                Silahkan lakukan pembayaran di :<br>
                                <table>
                                    <tr>
                                        <td>Nomor Tujuan</td>
                                        <td class="pl-2 pr-2 text-center">:</td>
                                        <td class="font-weight-bold" id="data-nomor-tujuan"></td>
                                    </tr>
                                    <tr>
                                        <td>A/N</td>
                                        <td class="text-center">:</td>
                                        <td class="font-weight-bold" id="data-an"></td>
                                    </tr>
                                </table>
                            </label>
                            <input type="hidden" class="form-control" name="nomor_tujuan" id="nomor_tujuan">
                            <input type="hidden" class="form-control" name="an" id="penerima">
                        </div>
                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-wallet fa-fw" style="font-size:13px;" data-toggle="tooltip" data-original-title="Masukan saldo, minimal Rp 50.000" aria-hidden="true"></i> Saldo : </label>
                            <input type="text" inputmode="numeric" class="form-control harga" name="saldo" placeholder="Masukan saldo, minimal Rp 10.000" required="">
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <div class="custom-control custom-checkbox">
                                    <input name="confirmterm" type="checkbox" class="custom-control-input" id="CheckTerm" required>
                                    <label name="confirmterm" class="custom-control-label" for="CheckTerm"> Saya setuju dan telah baca ketentuan topup.</label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="api_token" name="api_token" value="14da1df1b09409845ef7259122f8276d">
                        <div class="col-xl-12 col-sm-12 col-md-6 mb-4" id="result" role="alert"></div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-sm btn-secondary" data-dismiss="modal">
                                <i class="fas fa-undo" style="font-size:11px" aria-hidden="true"></i> Reset </button>
                            <button class="btn btn-sm btn-primary" id="action">
                                <i class="fas fa-coins" style="font-size:15px;" aria-hidden="true"></i>
                                <i class="fas fa-plus fa-fw" style="font-size:7px;" aria-hidden="true"></i> Beli </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-fw fa-history" style="font-size:15px;" aria-hidden="true"></i> Histori Pembelian
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="datatable" class="table dataTable no-footer" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%; font-size:10pt;">
                                        <thead class="thead-light">
                                            <tr role="row">
                                                <th class="text-center">No</th>
                                                <th class="text-center">Jenis Pembayaran</th>
                                                <th class="text-center">Jumlah </th>
                                                <th class="text-center">Tanggal Topup</th>
                                                <th class="text-center">Nomor Tujuan</th>
                                                <th class="text-center">A/N</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if($this->role_id == "1"){
                                                $history_topup = $this->model->gd("top_up","*","id_user != ''","result");
                                            }else{
                                                $history_topup = $this->model->gd("top_up","*","id_user = '".$this->id_user."'","result");
                                            }
                                            $load = '';
                                            if(!empty($history_topup)){
                                                $no = 1;
                                                foreach ($history_topup as $ht) {
                                                    if($ht->status == "Pending"){
                                                        $badge = "warning";
                                                        $action_btn = '<a href="'.base_url("cancel_topup/".e_nzm($ht->id)).'" class="btn btn-sm btn-danger">Batal</a>';
                                                    }else if($ht->status == "Cancel"){
                                                        $badge = "danger";
                                                        $action_btn = '<a href="javascript:void(0)" class="btn btn-sm btn-secondary">Batal</a>';
                                                    }else{
                                                        $badge = "success";
                                                        $action_btn = '<a href="javascript:void(0)" class="btn btn-sm btn-secondary">Batal</a>';
                                                    }
                                                    $load .= '
                                                    <tr>
                                                        <td class="text-center align-middle">'.$no.'</td>
                                                        <td class="text-center align-middle">'.$ht->jenis_pembayaran.'</td>
                                                        <td class="text-center align-middle">'.number_format($ht->nominal,0,"",".").'</td>
                                                        <td class="text-center align-middle">'.date("d M Y H:i:s",strtotime($ht->tanggal)).'</td>
                                                        <td class="text-center align-middle">'.$ht->nomor_tujuan.'</td>
                                                        <td class="text-center align-middle">'.$ht->an.'</td>
                                                        <td class="text-center align-middle"><span class="badge badge-'.$badge.'">'.$ht->status.'</span></td>
                                                        <td class="text-center align-middle">'.$action_btn.'</td>
                                                    </tr>';
                                                    $no++;
                                                }
                                                echo $load;
                                            }
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