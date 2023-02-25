<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$nzm?></h1>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-horvered" id="datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th class="p-1 text-center">No</th>
                                    <th class="p-1 text-center">Tanggal Buat</th>
                                    <th class="p-1 text-center">Nama</th>
                                    <th class="p-1 text-center">Email</th>
                                    <th class="p-1 text-center">Saldo</th>
                                    <th class="p-1 text-center">Status</th>
                                    <th class="p-1 text-center">Login Terakhir</th>
                                    <th class="p-1 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $data = $this->model->gd("user","*","id != '' AND role_id != '1'","result");
                                $load = '';
                                if(!empty($data)){
                                    $no = 1;
                                    foreach ($data as $data) {
                                        if($data->is_active == "1"){
                                            $status = '<span class="badge badge-success">Aktif</span>';
                                        }else{
                                            $status = '<span class="badge badge-danger">Non Aktif</span>';
                                        }
                                        $load .= '
                                        <tr>
                                            <td class="text-center">'.$no.'</td>
                                            <td class="text-center">'.date("d-M-Y H:i:s",$data->date_created).'</td>
                                            <td class="text-center">'.$data->name.'</td>
                                            <td class="text-center">'.$data->email.'</td>
                                            <td class="text-center">'.number_format($data->saldo,0,"",",").'</td>
                                            <td class="text-center">'.$status.'</td>
                                            <td class="text-center">'.date("d-M-Y H:i:s",strtotime($data->last_login)).'</td>
                                            <td class="text-center">
                                                <a href="'.base_url("user/edit/".e_nzm($data->id)).'" class="btn btn-sm btn-info" title="Rubah"><i class="fas fa-pencil-alt"></i></a>
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