<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{
    public function save_user($p)
    {
        $this->form_validation->set_rules("name","Nama","required|xss_clean|trim");
        $this->form_validation->set_rules("email","Email","valid_email|required|xss_clean|trim");
        $this->form_validation->set_rules("saldo","Saldo","required|xss_clean|trim");
        $this->form_validation->set_rules("is_active","Status","integer|xss_clean|trim");
        if($this->form_validation->run() === TRUE){
            $id_user = d_nzm($p);
            if(!empty($this->input->post("is_active"))){
                $is_active = 1;
            }else{
                $is_active = 0;
            }
            $data = [
                "name" => htmlentities($this->input->post("name")),
                "email" => htmlentities($this->input->post("email")),
                "saldo" => htmlentities(str_replace(".","",$this->input->post("saldo"))),
                "is_active" => $is_active,
            ];
            $action = $this->model->update("user","id = '$id_user'",$data);
            if(!$action){
                $this->swal("Sukses","User Berhasil Di Rubah","success");
            }else{
                $this->swal("Gagal","User Gagal Di Rubah","error");
            }
        }else{
            $this->swal("Warning",str_replace("\n","",validation_errors()),"warning");
        }
        redirect("user/list");
    }
}
