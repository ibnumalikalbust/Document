<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$nzm?></h1>
    <div class="card">
        <div class="card-header p-1" align="right"><a href="<?=base_url("routeros/0")?>" class="btn btn-sm btn-info">Create Winbox</a></div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-horvered" id="datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th class="p-1 text-center">No</th>
                                    <th class="p-1 text-center">ID Server</th>
                                    <th class="p-1 text-center">Nama Server</th>
                                    <th class="p-1 text-center">IP Address</th>
                                    <th class="p-1 text-center">Port</th>
                                    <th class="p-1 text-center">Username</th>
                                    <th class="p-1 text-center">Password</th>
                                    <th class="p-1 text-center">Location</th>
                                    <th class="p-1 text-center">Total VPN</th>
                                    <th class="p-1 text-center">Status</th>
                                    <th class="p-1 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $data = $this->model->gd("api_routeros","*","id != ''","result");
                                $load = '';
                                if(!empty($data)){
                                    $no = 1;
                                    foreach ($data as $data) {
                                        if($data->is_active == "1"){
                                            $status = '<span class="badge badge-success">Aktif</span>';
                                        }else{
                                            $status = '<span class="badge badge-danger">Non Aktif</span>';
                                        }
                                        if(!empty($data->port)){
                                            $port = $data->port;
                                        }else{
                                            $port = "";
                                        }
                                        $total_vpn = $this->model->gd("vpn_master","COUNT(id) as count","id_server = '".$data->id_server."'","row");
                                        $id_enc = "'".e_nzm($data->id)."'";
                                        $load .= '
                                        <tr>
                                            <td class="text-center">'.$no.'</td>
                                            <td class="text-center">'.$data->id_server.'</td>
                                            <td class="text-center">'.$data->nama_server.'</td>
                                            <td class="text-center">'.$data->ip_address.'</td>
                                            <td class="text-center">'.$port.'</td>
                                            <td class="text-center">'.d_nzm($data->username).'</td>
                                            <td class="text-center">'.d_nzm($data->password).'</td>
                                            <td class="text-center">'.$data->country.'</td>
                                            <td class="text-center">'.$total_vpn->count.'</td>
                                            <td class="text-center">'.$status.'</td>
                                            <td class="text-center">
                                                <a href="'.base_url("routeros/".e_nzm($data->id)).'" class="btn btn-sm btn-info" title="Rubah"><i class="fas fa-pencil-alt"></i></a>
                                                <a href="javascript:void(0)" onclick="test('.$id_enc.')" class="btn btn-sm btn-success" title="Test Connection"><i class="fa-solid fa-wifi"></i></a>
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