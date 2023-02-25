<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends MY_Controller
{

    public function index()
    {
        $data['nzm'] = 'Admin NZM';
        $data["js_add"] = "index";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function list_vpn()
    {
        $data['nzm'] = 'List VPN';
		$data["js_add"] = "list_vpn";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/list_vpn', $data);
        $this->load->view('templates/footer',$data);
    }

    public function list_payment()
    {
        $data['nzm'] = 'Payment Method';
		$data["js_add"] = "list_payment";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/list_payment', $data);
        $this->load->view('templates/footer',$data);
    }

    public function list_user()
    {
        $data['nzm'] = 'Data User';
		$data["js_add"] = "list_user";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/list_user', $data);
        $this->load->view('templates/footer',$data);
    }

    public function user_edit($p)
    {
        if(!empty($p)){
            $data['nzm'] = 'Edit User';
            $data["js_add"] = "edit_user";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('admin/edit_user', $data);
            $this->load->view('templates/footer', $data);
        }else{
            // redirect("user/list");
            echo "user/list";
        }
    }

    public function list_order_vpn()
    {
        $data['nzm'] = 'List Order VPN';
		$data["js_add"] = "list_order_vpn";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/list_order_vpn', $data);
        $this->load->view('templates/footer',$data);
    }

    public function manage_vpn($p)
    {
        $data['nzm'] = 'List Order VPN';
		$data["js_add"] = "manage_vpn";
		$data["id_order"] = d_nzm($p);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/manage_vpn', $data);
        $this->load->view('templates/footer',$data);
    }

    public function order_vpn()
    {
        $data['nzm'] = 'Order Remote VPN';
		$data["js_add"] = "order_vpn";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/order_vpn', $data);
        $this->load->view('templates/footer',$data);
    }

    public function form_vpn($p)
    {
        if(!empty($p)){
            $data['nzm'] = 'Edit VPN Master';
        }else{
            $data['nzm'] = 'Create VPN Master';
        }
		$data["js_add"] = "form_vpn";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/form_vpn', $data);
        $this->load->view('templates/footer', $data);
    }

    public function form_payment($p)
    {
        if(!empty($p)){
            $data['nzm'] = 'Edit Payment';
        }else{
            $data['nzm'] = 'Create Payment';
        }
		$data["js_add"] = "form_payment";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/form_payment', $data);
        $this->load->view('templates/footer', $data);
    }

    public function account_setting()
    {
        $data['nzm'] = 'Akun';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/account_setting', $data);
        $this->load->view('templates/footer');
    }

    public function isi_saldo()
    {
        $data['nzm'] = 'Saldo';
		$data["js_add"] = "isi_saldo";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/isi_saldo', $data);
        $this->load->view('templates/footer');
    }

    public function list_topup($p)
    {
        if($p == "pending"){
            $data_list = $this->model->gd("top_up","*,(SELECT email FROM user WHERE id = id_user) as email","status = 'Pending'","result");
            $status = '<span class="badge badge-warning">Pending</span>';
            $data['nzm'] = 'List Top Up Pending';
        }else if($p == "success"){
            $data_list = $this->model->gd("top_up","*,(SELECT email FROM user WHERE id = id_user) as email","status = 'Sukses'","result");
            $status = '<span class="badge badge-success">Success</span>';
            $data['nzm'] = 'List Top Up Sukses';
        }else if($p == "cancel"){
            $data_list = $this->model->gd("top_up","*,(SELECT email FROM user WHERE id = id_user) as email","status = 'Cancel'","result");
            $status = '<span class="badge badge-danger">Cancel</span>';
            $data['nzm'] = 'List Top Up Cancel';
        }else{
            $data_list = "Parameter Not Registered";
        }
        if($data_list != "Parameter Not Registered"){
            $data["js_add"] = "list_topup";
            $data["data"] = $data_list;
            $data["status"] = $status;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('admin/list_topup', $data);
            $this->load->view('templates/footer');
        }else{
            redirect("auth/logout");
        }
    }

    public function routeros($p)
    {
        if($p == "list"){
            $data['nzm'] = 'List Mikrotik';
            $data["js_add"] = "list_routeros";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('admin/list_routeros', $data);
            $this->load->view('templates/footer', $data);
        }else{
            if($p == "0"){
                $data['nzm'] = 'Add Mikrotik';
                $data["js_add"] = "routeros_edit";
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar');
                $this->load->view('templates/topbar');
                $this->load->view('admin/routeros_edit', $data);
                $this->load->view('templates/footer', $data);
            }else{
                $data['nzm'] = 'Edit Mikrotik';
                $data["js_add"] = "routeros_edit";
                $data["id"] = d_nzm($p);
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar');
                $this->load->view('templates/topbar');
                $this->load->view('admin/routeros_edit', $data);
                $this->load->view('templates/footer', $data);
            }
        }
    }

    public function konfirmasi_saldo()
    {
        $data['nzm'] = 'Konfirmasi Top Up';
        $this->load->view('templates/auth_header', $data);
        $this->load->view('admin/konfirmasi_saldo');
        $this->load->view('templates/auth_footer');
    }
}
