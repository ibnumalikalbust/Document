<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$nzm?></h1>
    <div class="card">
        <div class="card-header p-1" align="right"><a href="<?=base_url("list_vpn/form_vpn/0")?>" class="btn btn-sm btn-info">Create VPN</a></div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-horvered" id="datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th class="p-1 text-center">No</th>
                                    <th class="p-1 text-center">ID Server</th>
                                    <th class="p-1 text-center">Nama</th>
                                    <th class="p-1 text-center">Harga</th>
                                    <th class="p-1 text-center">Lokasi</th>
                                    <th class="p-1 text-center">Status</th>
                                    <th class="p-1 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $data = $this->model->gd("vpn_master","*","id !=","result");
                                $load = '';
                                if(!empty($data)){
                                    $no = 1;
                                    foreach ($data as $data) {
                                        if($data->status == "Aktif"){
                                            $status = '<span class="badge badge-success">Aktif</span>';
                                        }else{
                                            $status = '<span class="badge badge-danger">Non Aktif</span>';
                                        }
                                        $load .= '
                                        <tr>
                                            <td class="text-center">'.$no.'</td>
                                            <td class="text-center">'.$data->id_server.'</td>
                                            <td class="text-center">'.$data->nama.'</td>
                                            <td class="text-center">Rp. '.number_format($data->harga,0,"",",").'</td>
                                            <td class="text-center">'.$data->lokasi.'</td>
                                            <td class="text-center">'.$status.'</td>
                                            <td class="text-center">
                                                <a href="'.base_url("list_vpn/form_vpn/".$data->id).'" class="btn btn-sm btn-info" title="Rubah"><i class="fas fa-pencil-alt"></i></a>
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