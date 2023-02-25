<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Saldo extends MY_Controller
{
    public function topup_saldo()
    {
        $this->form_validation->set_rules("jenis_pembayaran","Jenis Pembayaran","required|xss_clean|trim");
        $this->form_validation->set_rules("saldo","Saldo","required|xss_clean|trim");
        if($this->form_validation->run() === TRUE){
            if(str_replace(".","",$this->input->post("saldo")) < 10000){
                $this->swal("Gagal","Top up gagal, Minimal pengisian saldo 50.000","error");
                redirect("saldo/isi_saldo");
            }
            $data = [
                'tanggal' => date("Y-m-d H:i:s"),
                'id_user' => $this->id_user,
                'nominal' => htmlentities(str_replace(".","",$this->input->post("saldo"))),
                "jenis_pembayaran" => htmlentities($this->input->post("jenis_pembayaran")),
                "nomor_tujuan" => htmlentities($this->input->post("nomor_tujuan")),
                "an" => htmlentities($this->input->post("an")),
            ];
            $action = $this->model->insert("top_up",$data);
            $id_top_up = $this->db->insert_id();
            if(!$action){
                $this->swal("Sukses","Top up berhasil, mohon tunggu konfirmasi dari admin kami","success");
                $apiToken = $this->token_telegram;
                $chat_id = $this->model->gd("user","id,id_telegram","id_telegram IS NOT NULL AND role_id = '1'","row");
                if(!empty($chat_id->id)){
                    $chat_id = $chat_id->id_telegram;
                }else{
                    $chat_id = '-639123324';
                };

                $get_user = $this->model->gd("top_up","*,(SELECT name FROM user WHERE id = id_user) as name,(SELECT email FROM user WHERE id = id_user) as email","id = '".$id_top_up."'","row");
                if(!empty($get_user->id_user)){
                    $nama = $get_user->name;
                    $email = $get_user->email;
                    $link_konfirmasi = base_url("konfirmasi_saldo/".e_nzm($id_top_up)."/".e_nzm($get_user->id_user)."/".e_nzm($get_user->nominal));
                    $text = '
Pengisian saldo atas :
Nama : '.$nama.'
Email : '.$email.'
Saldo : '.number_format($get_user->nominal,0,"",".").'
Jenis Pembayaran : '.$get_user->jenis_pembayaran.'

Klik Konfirmasi dibawah ini, jika user benar-benar sudah melakukan pembayaran';
                    $keyboard = [
                        'inline_keyboard' => [
                            [
                                [
                                    'text' => 'Konfirmasi Disini', 
                                    'url' => $link_konfirmasi,
                                ]
                            ]
                        ]
                    ];
                    $encodedKeyboard = json_encode($keyboard);
                    $url='https://api.telegram.org/bot'.$apiToken.'/sendMessage';
                    $data= array(
                        'chat_id'=>$chat_id,
                        'text'=> $text,
                        'parse_mode'=>'markdown',
                        'reply_markup' => $encodedKeyboard,
                    );
                    $options=array('http'=>array('method'=>'POST','header'=>"Content-Type:application/x-www-form-urlencoded\r\n",'content'=>http_build_query($data),),);
                    $context=stream_context_create($options);
                    $response=file_get_contents($url,false,$context);
                    print_r($response);
                }else{
                    $delete_topup = $this->model->delete("top_up","id = '$id_top_up'");
                }
            }else{
                $this->swal("Gagal","Top up gagal, mohon coba kembali","error");
            }
        }else{
            $this->swal("Peringatan",str_replace("\n","",validation_errors()),"warning");
        }
        redirect("saldo/isi_saldo");
        // die();
    }

    public function cancel_topup($p)
    {
        $id = d_nzm($p);
        $data =  [
            "status" => "Cancel",
        ];
        $action = $this->model->update("top_up","id = '$id'",$data);
        if(!$action){
            $data_topup = $this->model->gd("top_up","tanggal,id_user,nominal","id = '$id'","row");
            if(!empty($data_topup->tanggal)){
                $tanggal_topup = $data_topup->tanggal;
            }else{
                $tanggal_topup = date("Y-m-d H:i:s");
            }
            
            if(!empty($data_topup->id_user)){
                $id_user = $data_topup->id_user;
            }else{
                $id_user = 0;
            }
            
            if(!empty($data_topup->nominal)){
                $nominal = $data_topup->nominal;
            }else{
                $nominal = 0;
            }
            $data_log = [
                "id_user" => $id_user,
                "tanggal" => $tanggal_topup,
                "logs" => "Cancel Top Up Saldo ".number_format($nominal,0,"","."),
                "category" => "Create",
            ];
            $logs = $this->model->insert("log_activity_user",$data_log);
            $this->swal("Sukses","Proses cancel berhasil","success");
        }else{
            $this->swal("Gagal","Proses cancel gagal","error");
        }
        redirect("saldo/isi_saldo");
    }

    public function konfirmasi_saldo($id_topup,$id_user,$saldo)
    {
        $r = $this->input->get("r");
        $id_topup = d_nzm($id_topup);
        $id_user = d_nzm($id_user);
        $dsaldo = d_nzm($saldo);
        $saldo_sekarang = $this->model->gd("user","id,saldo,email,name","id = '$id_user'","row");
        if(!empty($saldo_sekarang->id)){
            $get_konfirmasi = $this->model->gd("top_up","id","id = '$id_topup' AND status = 'Pending'","row");
            if(!empty($get_konfirmasi->id)){
                $status_topup = [
                    "status" => "Sukses",
                ];
                $action = $this->model->update("top_up","id = '$id_topup' AND status = 'Pending'",$status_topup);
                if(!$action){
                    //UPDATE SALDO DI USER
                    $saldo_akhir = $saldo_sekarang->saldo + $dsaldo;
                    $data =  [
                        "saldo" => $saldo_akhir,
                    ];
                    $action = $this->model->update("user","id = '$id_user'",$data);

                    //LOG ACTIVIT
                    $tanggal_topup = $this->model->gd("top_up","tanggal","id = '$id_topup'","row");
                    if(!empty($tanggal_topup)){
                        $tanggal_topup = $tanggal_topup->tanggal;
                    }else{
                        $tanggal_topup = date("Y-m-d H:i:s");
                    }
                    $data_log = [
                        "id_user" => $id_user,
                        "tanggal" => $tanggal_topup,
                        "logs" => "Isi Saldo ".number_format($dsaldo,0,"","."),
                        "category" => "Create",
                    ];
                    $logs = $this->model->insert("log_activity_user",$data_log);

                    if(!empty($r)){
                        $this->swal("Sukses","Konfirmasi top up sukses","success");
                    }else{
                        $this->session->set_flashdata('message', '<div class="alert alert-success mb-0 text-center" role="alert">Konfirmasi Top Up '.$saldo_sekarang->name.' SUKSES</div>');
                    }
                }else{
                    if(!empty($r)){
                        $this->swal("Gagal","Konfirmasi top up gagal","error");
                    }else{
                        $this->session->set_flashdata('message', '<div class="alert alert-danger mb-0 text-center" role="alert">Konfirmasi Top Up '.$saldo_sekarang->name.' GAGAL</div>');
                    }
                }
            }else{
                if(!empty($r)){
                    $this->swal("Gagal","Konfirmasi top up hanya bisa di lakukan 1x saja","error");
                }else{
                    $this->session->set_flashdata('message', '<div class="alert alert-warning mb-0 text-center" role="alert">Konfirmasi Top Up ini sudah pernah dilakukan.<br>Hanya bisa melakukan 1x konfirmasi saja</div>');
                }
            }
        }else{
            if(!empty($r)){
                $this->swal("Gagal","Error data user tidak ditemukan","error");
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger mb-0 text-center" role="alert">Error data user tidak ditemukan</div>');
            }
        }
        if(!empty($r)){
            redirect("saldo/".$r);
        }else{
            redirect("saldo/konfirmasi");
        }
        die();
    }
}
