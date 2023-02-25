<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Account extends MY_Controller
{
    public function editing_account()
    {
        $this->form_validation->set_rules("name","Nama","required|xss_clean|trim");
        if($this->role_id == "1"){
            $this->form_validation->set_rules("id_telegram","ID Telegram","required|integer|xss_clean|trim");
        }
        if(!empty($this->input->post("password"))){
            $this->form_validation->set_rules("password","Password","xss_clean|trim");
            $this->form_validation->set_rules("conf_password","Konfirmasi Password","xss_clean|trim|matches[password]");
        }
        if($this->form_validation->run() === TRUE){
            $data = [
                'name' => htmlentities($this->input->post("name")),
            ];
            if(!empty($this->input->post("password"))){
                $data["password"] = password_hash(htmlentities($this->input->post("password")),PASSWORD_BCRYPT);
            }
            if(!empty($this->input->post("id_telegram"))){
                $data["id_telegram"] = $this->input->post("id_telegram");
            }
            if(!empty($this->input->post("user_remote"))){
                $data["user_remote"] = $this->input->post("user_remote");
            }
            if(!empty($this->input->post("server"))){
                $data["server"] = $this->input->post("server");
            }
            $action = $this->model->update("user","id = '".$this->id_user."'",$data);
            if(!$action){
                $this->swal("Sukses","Data Berhasil Di Rubah","success");
            }else{
                $this->swal("Gagal","Data Gagal Di Rubah","error");
            }
        }else{
            $this->swal("Peringatan",str_replace("\n","",validation_errors()),"warning");
        }
        redirect("account");
    }
}
