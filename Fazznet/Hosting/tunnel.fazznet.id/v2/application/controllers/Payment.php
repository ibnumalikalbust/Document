<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Payment extends MY_Controller
{
    public function save_payment($p)
    {
        if(!empty($this->idusernzm)){
            $this->form_validation->set_rules("payment","Nama Payment","required|trim|xss_clean");
            $this->form_validation->set_rules("nomor_payment","Nomor Payment","required|trim|xss_clean");
            $this->form_validation->set_rules("an","A/N","required|trim|xss_clean");
            if($this->form_validation->run() === TRUE){
                if(empty($this->input->post("status"))){
                    $status = "Non Aktif";
                }else{
                    $status = "Aktif";
                }
                $data_input = [
                    "payment" => $this->input->post("payment"),
                    "nomor_payment" => $this->input->post("nomor_payment"),
                    "an" => $this->input->post("an"),
                    "status" => $status,
                ];
                if(empty($p)){//Tambah Data
                    $action = $this->model->insert("payment_method",$data_input);
                    $redirect = "list_payment/form_payment/".$p;
                    $pesan = "Tambah";
                }else{//Edit Data
                    $action = $this->model->update("payment_method","id = '$p'",$data_input);
                    $redirect = "list_payment";
                    $pesan = "Rubah";
                }
                if(!$action){
                    $this->swal("Sukses","Data Berhasil Di ".$pesan,"success");
                }else{
                    $this->swal("Gagal","Data Gagal Di ".$pesan,"error");
                }
            }else{
                $this->swal("Peringatan",str_replace("\n","",validation_errors()),"warning");
                $redirect = "list_payment/form_payment/".$p;
            }
            redirect($redirect);
        }
    }
}