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
                                    <th class="p-1 text-center">Date Order</th>
                                    <th class="p-1 text-center">Username</th>
                                    <th class="p-1 text-center">Password</th>
                                    <th class="p-1 text-center">URL Remote</th>
                                    <th class="p-1 text-center">Berlangganan</th>
                                    <th class="p-1 text-center">Auto Debit</th>
                                    <th class="p-1 text-center">Expired</th>
                                    <th class="p-1 text-center">Status</th>
                                    <th class="p-1 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($this->role_id == "1"){
                                    $data = $this->model->join3table("data_order a","user b","vpn_master c","a.id_user = b.id","a.id_server = c.id","a.status_debit,a.id,c.harga,b.name,b.email,a.nomor_order,c.id_server,a.username,a.password,a.port,a.tanggal_order,a.berlangganan,a.expired_date,a.status","a.deleted_date IS NULL AND a.id != ''","result");
                                }else{
                                    $data = $this->model->join3table("data_order a","user b","vpn_master c","a.id_user = b.id","a.id_server = c.id","a.status_debit,a.id,c.harga,b.name,b.email,a.nomor_order,c.id_server,a.username,a.password,a.port,a.tanggal_order,a.berlangganan,a.expired_date,a.status","a.deleted_date IS NULL AND a.id_user = '".$this->id_user."'","result");
                                }
                                $load = '';
                                if(!empty($data)){
                                    $no = 1;
                                    foreach ($data as $data) {
                                        if($data->status == "Aktif"){
                                            $status = '<span class="badge badge-success">Aktif</span>';
                                        }else{
                                            $status = '<span class="badge badge-danger">Non Aktif</span>';
                                        }
                                        if($data->status_debit == "1"){
                                            $status_debit = '<span class="badge badge-success">Aktif</span>';
                                        }else{
                                            $status_debit = '<span class="badge badge-danger">Non Aktif</span>';
                                        }

                                        $address_ip = ip_number($data->nomor_order-1);
                                        $load .= '
                                        <tr>
                                            <td class="text-center align-middle">'.$no.'</td>
                                            <td class="text-center align-middle">'.date("d-M-Y",strtotime($data->tanggal_order)).'</td>
                                            <td class="text-center align-middle">'.$data->username.'</td>
                                            <td class="text-center align-middle">'.$data->password.'</td>
                                            <td class="text-center align-middle"><span class="badge badge-danger">'.$data->id_server.'.'.$this->server.':'.$address_ip.'</span><i class="fa-solid fa-arrows-left-right ml-1 mr-1"></i><span class="badge badge-success">'.$data->port.'</span></td>
                                            <td class="text-center align-middle">'.$data->berlangganan.' Bulan<br><span class="badge badge-success">Rp. '.number_format($data->harga*$data->berlangganan,0,"",",").'</span></td>
                                            <td class="text-center align-middle">'.$status_debit.'</td>
                                            <td class="text-center align-middle">'.date("d-M-Y",strtotime($data->expired_date)).'</td>
                                            <td class="text-center align-middle">'.$status.'</td>
                                            <td class="text-center align-middle">
                                                <a href="'.base_url("list_order_vpn/manage_vpn/".e_nzm($data->id)).'" class="btn btn-sm p-1 btn-info" title="Rubah">Manage</a>
                                            </td>
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