<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$nzm?></h1>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-horvered" id="datatable" style="font-size: 10pt;">
                            <thead class="thead-light">
                                <tr>
                                    <th class="p-1 text-center">No</th>
                                    <th class="p-1 text-center">Tanggal Order</th>
                                    <th class="p-1 text-center">Email</th>
                                    <th class="p-1 text-center">Nominal</th>
                                    <th class="p-1 text-center">Jenis Pembayaran</th>
                                    <th class="p-1 text-center">Status</th>
                                    <?php
                                    if($this->p2 == "pending"){
                                        echo '<th class="p-1 text-center">Action</th>';
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $load = '';
                                if(!empty($data)){
                                    $no = 1;
                                    foreach ($data as $data) {
                                        if($data->status == "Pending"){
                                            $action = '
                                            <td class="text-center align-middle">
                                                <a href="'.base_url("konfirmasi_saldo/".e_nzm($data->id)."/".e_nzm($data->id_user)."/".e_nzm($data->nominal)).'?r=pending" class="btn btn-sm p-1 btn-info" title="Rubah" style="font-size:8pt;">Sudah Bayar</a>
                                            </td>';
                                        }else{
                                            $action = '';
                                        }
                                        $load .= '
                                        <tr>
                                            <td class="text-center align-middle">'.$no.'</td>
                                            <td class="text-center align-middle">'.date("d-M-Y H:i:s",strtotime($data->tanggal)).'</td>
                                            <td class="text-center align-middle">'.$data->email.'</td>
                                            <td class="text-center align-middle">'.number_format($data->nominal,0,"",".").'</td>
                                            <td class="text-center align-middle">'.strtoupper($data->jenis_pembayaran).'</td>
                                            <td class="text-center align-middle">'.$status.'</td>
                                            '.$action.'
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
<!-- End of Main Content -->