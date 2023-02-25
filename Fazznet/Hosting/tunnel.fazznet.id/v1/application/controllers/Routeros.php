<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Routeros extends MY_Controller
{
    public function save()
    {
        $this->form_validation->set_rules("ip_address","IP Address","required|xss_clean|trim");
        $this->form_validation->set_rules("port","Port","required|xss_clean|trim|integer");
        $this->form_validation->set_rules("username","Username","required|xss_clean|trim");
        $this->form_validation->set_rules("password","Password","required|xss_clean|trim");
        if($this->form_validation->run() === TRUE){
            $data = [
                'ip_address' => $this->input->post("ip_address"),
                'port' => $this->input->post("port"),
                'username' => e_nzm($this->input->post("username")),
                'password' => e_nzm($this->input->post("password")),
            ];
            $action = $this->model->update("api_routeros","id = '1'",$data);
            if(!$action){
                $this->swal("Sukses","API Routeros Berhasil Di Rubah","success");
            }else{
                $this->swal("Gagal","API Routeros Gagal Di Rubah","error");
            }
        }else{
            $this->swal("Peringatan",str_replace("\n","",validation_errors()),"warning");
        }
        redirect("routeros/set");
    }
}
