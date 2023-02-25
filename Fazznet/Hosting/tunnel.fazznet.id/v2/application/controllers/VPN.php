<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class VPN extends MY_Controller
{
    public function save_vpn_master($p)
    {
        if(!empty($this->idusernzm)){
            $this->form_validation->set_rules("id_server","ID Server","required|trim|xss_clean");
            $this->form_validation->set_rules("nama","Nama Server","required|trim|xss_clean");
            $this->form_validation->set_rules("harga","Harga","required|trim|xss_clean");
            $this->form_validation->set_rules("lokasi","Lokasi","required|trim|xss_clean");
            if($this->form_validation->run() === TRUE){
                if(empty($this->input->post("status"))){
                    $status = "Non Aktif";
                }else{
                    $status = "Aktif";
                }
                $data_input = [
                    "id_server" => $this->input->post("id_server"),
                    "nama" => $this->input->post("nama"),
                    "harga" => str_replace(".","",$this->input->post("harga")),
                    "lokasi" => $this->input->post("lokasi"),
                    "status" => $status,
                ];
                if(empty($p)){//Tambah Data
                    $action = $this->model->insert("vpn_master",$data_input);
                    $redirect = "list_vpn/form_vpn/".$p;
                    $pesan = "Tambah";
                }else{//Edit Data
                    $action = $this->model->update("vpn_master","id = '$p'",$data_input);
                    $redirect = "list_vpn";
                    $pesan = "Rubah";
                }
                if(!$action){
                    $this->swal("Sukses","Data Berhasil Di ".$pesan,"success");
                }else{
                    $this->swal("Gagal","Data Gagal Di ".$pesan,"error");
                }
            }else{
                $this->swal("Peringatan",str_replace("\n","",validation_errors()),"warning");
                $redirect = "list_vpn/form_vpn/".$p;
            }
            redirect($redirect);
        }
    }

    public function simpan_order_vpn()
    {
        $id_server = $this->input->post("id_server");
        if(!empty($id_server)){
            $id_routeros = $this->check_id_routeros($id_server);
            if(!empty($id_routeros)){
                $data_vpn_server = [
                    "id" => $id_routeros,
                ];
                $koneksi_router = $this->router_process("koneksi",$data_vpn_server);
                if($koneksi_router == "200"){
                    if(!empty($this->idusernzm)){
                        $this->form_validation->set_rules("id_server","Server","required|trim|xss_clean|integer");
                        $this->form_validation->set_rules("username","Username","required|trim|xss_clean");
                        $this->form_validation->set_rules("password","Password","required|trim|xss_clean");
                        $this->form_validation->set_rules("port","Port","required|trim|xss_clean|integer");
                        $this->form_validation->set_rules("berlangganan","Berlangganan","required|trim|xss_clean|integer");
                        $this->form_validation->set_rules("status_debit","Status Debit","required|trim|xss_clean|integer");
                        if($this->form_validation->run() === TRUE){
                            $check_user = $this->model->gd("data_order","id","username = '".$this->input->post("username").$this->user_remote."' AND status = 'Aktif'","row");
                            if(empty($check_user->id)){
                                $nomor_order = $this->model->gd("data_order","COUNT(id) as jumlah_order","id !=","row");
                                $harga_vpn = $this->model->gd("vpn_master","harga","id = '".$this->input->post("id_server")."'","row");
                                $address = addressip($nomor_order->jumlah_order);
                                $dst_port = ip_number($nomor_order->jumlah_order);
            
                                $data = [
                                    "id_user" => $this->id_user,
                                    "nomor_order" => $nomor_order->jumlah_order+1,
                                    "id_server" => $this->input->post("id_server"),
                                    "username" => $this->input->post("username").$this->user_remote,
                                    "password" => $this->input->post("password"),
                                    "port" => $this->input->post("port"),
                                    "tanggal_order" => date("Y-m-d"),
                                    "berlangganan" => $this->input->post("berlangganan"),
                                    // MENGATUR MASA BERLANGGANAN (START)
                                    "expired_date" => date("Y-m-d",strtotime("+".$this->input->post("berlangganan")." day")), 
                                    // MENGATUR MASA BERLANGGANAN (END)
                                    "status" => "Aktif",
                                    "harga_beli" => $harga_vpn->harga*$this->input->post("berlangganan"),
                                    "status_debit" => $this->input->post("status_debit"),
                                    "remote_address" => $address,
                                ];
                                $saldo_now = $this->model->gd("user","saldo","id = '".$this->id_user."'","row");
                                $saldo_akhir = $saldo_now->saldo - $data["harga_beli"];
                                if($saldo_akhir < 0){
                                    $this->swal("Gagal","Maaf saldo tidak cukup","error");
                                }else{
                                    $data_input_vpn = [
                                        "id" => $id_routeros,
                                        "name" => $data["username"],
                                        "password" => $data["password"],
                                        "start_date" => strtolower(date('M/d/Y',strtotime($data["expired_date"]))),
                                        "nomor" => $data["nomor_order"],
                                        "port" => $data["port"],
                                        "address" => $address,
                                        "dst_port" => $dst_port,
                                    ];
                                    $action = $this->model->insert("data_order",$data);
                                    if(!$action){
                                        $data_log = [
                                            "id_user" => $this->id_user,
                                            "tanggal" => date("Y-m-d H:i:s"),
                                            "logs" => "Membuat VPN Remote Baru ".$this->input->post("username").$this->user_remote,
                                            "category" => "Create",
                                        ];
                                        $logs = $this->model->insert("log_activity_user",$data_log);
                                        $saldo_user = [
                                            "saldo" => $saldo_akhir,
                                        ];
                                        $update_saldo = $this->model->update("user","id = '".$this->id_user."'",$saldo_user);    
                                        $this->swal("Sukses","VPN Berhasil di Order","success");
                                        $this->router_process("scheduler",$data_input_vpn);
                                        $this->router_process("ppp_secret",$data_input_vpn);
                                        $this->router_process("firewall_nat",$data_input_vpn);
                                    }else{
                                        $this->swal("Gagal","VPN Gagal di Order","error");
                                    }
                                }
                            }else{
                                $this->swal("Gagal","Username sudah terdaftar<br>Mohon buat username seunik mungkin.","error");
                            }
                        }else{
                            $this->swal("Warning",str_replace("\n","",validation_errors()),"warning");
                        }
                    }
                }else{
                    $this->swal("Gagal","VPN Gagal di Order, Router API tidak terhubung","error");
                }
            }else{
                $this->swal("Gagal","Server Tidak Ditemukan, Silahkan Hubungi Admin","error");
            }
        }else{
            $this->swal("Gagal","VPN Server Belum Dipilih","error");
        }
        redirect("order_vpn");
    }

    public function edit_vpn($p)
    {
        if(!empty($this->idusernzm)){
            $this->form_validation->set_rules("port","Port","required|trim|xss_clean|integer");
            $this->form_validation->set_rules("password","Password","required|trim|xss_clean");
            if($this->form_validation->run() === TRUE){
                $id = d_nzm($p);
                $data = [
                    "password" => $this->input->post("password"),
                    "port" => $this->input->post("port"),
                    "status_debit" => $this->input->post("status_debit"),
                ];
                $action = $this->model->update("data_order","id = '$id'",$data);
                if(!$action){
                    $data_log = [
                        "id_user" => $this->id_user,
                        "tanggal" => date("Y-m-d H:i:s"),
                        "logs" => "Edit VPN Remote ".$this->input->post("vpn_username"),
                        "category" => "Update",
                    ];
                    $logs = $this->model->insert("log_activity_user",$data_log);
                    $data_user = $this->model->gd("data_order","username,nomor_order,port,password,id_server","id = '$id'","row");
                    if(!empty($data_user)){
                        $id_routeros = $this->check_id_routeros($data_user->id_server);
                        $address = addressip($data_user->nomor_order-1);
                        $dst_port = ip_number($data_user->nomor_order-1);
                        $data_edit = [
                            "id" => $id_routeros,
                            "name" => $data_user->username,
                            "password" => $data_user->password,
                            "port" => $data_user->port,
                            "nomor" => $data_user->nomor_order,
                            "address" => $address,
                            "dst_port" => $dst_port,
                        ];
                        $this->router_process("edit_ppp",$data_edit);
                        $this->router_process("remove_firewall",$data_edit);
                        $this->router_process("firewall_nat",$data_edit);
                    }
                    $this->swal("Sukses","VPN Berhasil di Rubah","success");
                }else{
                    $this->swal("Gagal","VPN Gagal di Rubah","error");
                }
            }else{
                $this->swal("Warning",str_replace("\n","",validation_errors()),"warning");
            }
            redirect("list_order_vpn/manage_vpn/".$p);
        }
    }

    public function delete_vpn($p)
    {
        if(!empty($this->idusernzm)){
            $id = d_nzm($p);
            $data_vpn = $this->model->gd("data_order","harga_beli,tanggal_order,username","id = '$id'","row");
            $saldo_awal = $this->model->gd("user","saldo","id = '".$this->id_user."'","row");
            if($data_vpn->tanggal_order == date("Y-m-d")){
                $data_saldo = [
                    "saldo" => $data_vpn->harga_beli + $saldo_awal->saldo,
                ];
                $action = $this->model->update("user","id = '".$this->id_user."'",$data_saldo);
                if(!$action){
                    $delete_proses = "OK";
                }else{
                    $delete_proses = "NOK";
                }
            }else{
                $delete_proses = "OK";
            }
            if($delete_proses == "OK"){
                $data_del = [
                    "deleted_date" => date("Y-m-d"),
                ];
                $action_del = $this->model->update("data_order","id = '$id'",$data_del);
                if(!$action_del){
                    $data_order = $this->model->gd("data_order","username,id_server","id = '$id'","row");
                    $id_routeros = $this->check_id_routeros($data_order->id_server);
                    $data_log = [
                        "id_user" => $this->id_user,
                        "tanggal" => date("Y-m-d H:i:s"),
                        "logs" => "Delete VPN Remote ".$data_order->username.$this->user_remote,
                        "category" => "Delete",
                    ];
                    $logs = $this->model->insert("log_activity_user",$data_log);
                    $this->swal("Sukses","VPN Berhasil Di Hapus","success");

                    $data = [
                        "id" => $id_routeros,
                        "name" => $data_vpn->username,
                    ];
                    $this->router_process("remove_firewall",$data);
                    $this->router_process("remove_ppp",$data);
                    $this->router_process("remove_schedule",$data);
                }else{
                    $data_saldo = [
                        "saldo" => $saldo_awal->saldo,
                    ];
                    $action = $this->model->update("user","id = '".$this->id_user."'",$data_saldo);
                    $this->swal("Gagal","Gagal Hapus VPN, Mohon coba kembali","error");
                }
            }else{
                $this->swal("Gagal","Gagal Hapus VPN, Mohon coba kembali","error");
            }
            // die();
            redirect("list_order_vpn");
        }
    }

    public function check_status_vpn()
    {
        $data_server = $this->model->gd("api_routeros","id","is_active = '1'","result");
        foreach ($data_server as $data_server) {
            $data_vpn_server = [
                "id" => $data_server->id,
            ];
            $koneksi_router = $this->router_process("koneksi",$data_vpn_server);
            if($koneksi_router == "200"){
                //STATUS DEEBIT NOT OK
                $data = [
                    "status" => "Non Aktif",
                ];
                $update_no_debit = $this->model->update("data_order","expired_date < '".date("Y-m-d")."' AND status = 'Aktif' AND status_debit = '0'",$data);
                $get_no_debit = $this->model->gd("data_order a","*,(SELECT email FROM user b WHERE b.id = a.id_user) as email","expired_date < '".date("Y-m-d")."' AND status = 'Aktif' AND status_debit = '0'","result");
                if(!empty($get_no_debit)){
                    foreach ($get_no_debit as $gnd) {
                        $from = $this->config->item('smtp_user');
                        $to = $gnd->email;
                        $subject = "VPN Remote Non Active (".$gnd->username.")";
                        $message = '
                        <font style="font-size:16pt">Pemberitahuan</font><br><br>
                        Untuk akun VPN atas :<br>
                        Username : '.$gnd->username.'<br>
                        Password : '.$gnd->password.'<br><br>
                        Sudah tidak aktif sejak '.date("d-M-Y",strtotime($gnd->expired_date));
    
                        $this->email->set_newline("\r\n");
                        $this->email->from($from);
                        $this->email->to($to);
                        $this->email->subject($subject);
                        $this->email->message($message);
                    }
                }
    
                //STATUS DEBIT OK
                $get_data = $this->model->gd("data_order a","*,((SELECT saldo FROM user b WHERE b.id = a.id_user) - (SELECT harga c FROM vpn_master c WHERE c.id = a.id_server)*berlangganan) as sisa_saldo","a.expired_date < '".date("Y-m-d")."' AND a.status = 'Aktif' AND a.status_debit = '1'","result");
                if(!empty($get_data)){
                    foreach ($get_data as $get_data) {
                        if($get_data->sisa_saldo < 0){
                            $update_debit = $this->model->update("data_order","id = '".$get_data->id."'",$data);
                            $from = $this->config->item('smtp_user');
                            $to = $get_data->email;
                            $subject = "VPN Remote Non Active (".$get_data->username.")";
                            $message = '
                            <font style="font-size:16pt">Pemberitahuan</font><br><br>
                            Untuk akun VPN atas :<br>
                            Username : '.$get_data->username.'<br>
                            Password : '.$get_data->password.'<br><br>
                            Sudah tidak aktif sejak '.date("d-M-Y",strtotime($get_data->expired_date)).', Dikarenakan saldo anda kurang';
        
                            $this->email->set_newline("\r\n");
                            $this->email->from($from);
                            $this->email->to($to);
                            $this->email->subject($subject);
                            $this->email->message($message);
                        }else{
                            $data_saldo = [
                                "saldo" => $get_data->sisa_saldo,
                            ];
                            $update_saldo = $this->model->update("user","id = '".$get_data->id_user."'",$data_saldo);
                            
                            $data_debit = [
                                "status" => "Aktif",
                                "expired_date" => date("Y-m-d",strtotime("+".$get_data->berlangganan." month -1 days")),
                            ];
                            $data = [
                                "id" => $data_server->id,
                                "name" => $get_data->username,
                                "password" => $get_data->password,
                                "start_date" => strtolower(date('M/d/Y',strtotime($data_debit["expired_date"]))),
                                "nomor" => $get_data->nomor_order,
                                "port" => $get_data->port,
                            ];
                            $update_debit = $this->model->update("data_order","id = '".$get_data->id."'",$data_debit);
                            if(!$update_debit){
                                $this->router_process("ppp_secret",$data);
                                $this->router_process("scheduler",$data);
                                $this->router_process("firewall_nat",$data);
    
                                $from = $this->config->item('smtp_user');
                                $to = $get_data->email;
                                $subject = "VPN Remote Re-Active Auto Debit (".$get_data->username.")";
                                $message = '
                                <font style="font-size:16pt">Pemberitahuan</font><br><br>
                                Untuk akun VPN atas :<br>
                                Username : '.$get_data->username.'<br>
                                Password : '.$get_data->password.'<br><br>
                                Berhasil untuk di lakukan perpanjangan secara otomatis.<br>
                                Sehingga untuk expired date nya menjadi '.date("d-M-Y",strtotime($get_data->expired_date));
            
                                $this->email->set_newline("\r\n");
                                $this->email->from($from);
                                $this->email->to($to);
                                $this->email->subject($subject);
                                $this->email->message($message);
                            }
                        }
                    }
                }
            }
        }
        die();
    }
}