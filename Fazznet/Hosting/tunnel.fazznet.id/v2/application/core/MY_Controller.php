<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->p1 = $this->uri->segment(1);
        $this->p2 = $this->uri->segment(2);
        $this->p3 = $this->uri->segment(3);
        $this->idusernzm = $this->session->userdata("id_user");
        $this->id_user = $this->session->userdata("id_user");
        $this->email = $this->session->userdata("email");
        $this->role_id = $this->session->userdata("role_id");
        $this->name = $this->session->userdata("name");
        $this->image_user = $this->session->userdata("image_user");
		$this->user_remote = $this->user_remote("user_remote");
		$this->server = $this->user_remote("server");
        $this->token_telegram = '5850968144:AAH8HE-671nVdE1BqvE5q70aHCgHzTnvBwc';
    }
	public function swal($title, $text, $icon)
	{
		$this->session->set_flashdata("swal", '
		<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.5/sweetalert2.min.js"></script>
		<script>
			var text = "' . $text . '";
			swal.fire({title:"' . $title . '",html:text,icon:"' . $icon . '"});
		</script>');
	}
    public function encryption_elbark($value)
    {
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '1234567891011121';
        $encryption_key = 'ElbarkCruises';
        $encryption = openssl_encrypt($value, $ciphering, $encryption_key, $options, $encryption_iv);
        return $encryption;
    }
    public function decryption_elbark($value)
    {
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $decryption_iv = '1234567891011121';
        $decryption_key = 'ElbarkCruises';
        $decryption = openssl_decrypt($value, $ciphering, $decryption_key, $options, $decryption_iv);
        return $decryption;
    }

    public function send_telegram($pesan)
    {
        $apiToken = $this->token_telegram;
        $chat_id = $this->model->gd("user","id,id_telegram","id_telegram IS NOT NULL AND role_id = '1'","row");
        if(!empty($chat_id->id)){
            $chat_id = $chat_id->id_telegram;
        }else{
            $chat_id = '-639123324';
        };
        $text = $pesan;
        $response = file_get_contents("https://api.telegram.org/bot".$apiToken."/sendMessage?chat_id=".$chat_id."&text=".$text);
    }

    public function router_process($proses,$data)
    {
        require_once(APPPATH."third_party/routeros_api.class.php");
        // echo APPPATH."third_party/routeros_api.class.php";
        // die();
        $id = $data["id"];
        $data_koneksi = $this->model->gd("api_routeros","*","id = '$id'","row");
        if(!empty($data_koneksi)){
            $API = new RouterosAPI();
            //$API->debug = true;
            if(!empty($data_koneksi->port)){
                $ip_address = $data_koneksi->ip_address.":".$data_koneksi->port;
            }else{
                $ip_address = $data_koneksi->ip_address;
            }
            $username = d_nzm($data_koneksi->username);
            $password = d_nzm($data_koneksi->password);
            $koneksi = $API->connect($ip_address, $username, $password);
            if ($koneksi) {
                //KONEKSI VPN
                if($proses == "koneksi"){
                    $status = 200;
                }

                //ADDITIONAL PPP SECRET
                if($proses == "ppp_secret"){
                    if(!empty($data)){
                        $API->comm('/ppp/secret/add', array(
                            'local-address' => '10.0.0.0',
                            'name' => $data["name"],
                            'password' => $data["password"],
                            'profile' => 'default',
                            'remote-address' => $data["address"],
                            'service' => 'l2tp',
                            'disabled' => 'no',
                        ));
                        $data_secret = $API->comm('/ppp/secret/print');
                        //print_r($data_secret);
                        $search_data = $this->search_array($data_secret,"name",$data["name"]);
                        if(!empty($search_data)){
                            $status = 200;
                        }else{
                            $this->send_telegram('Proses pembuatan PPP Secret Gagal, atas
Nama : '.$data["name"].'
Password : '.$data["password"]);
                            $status = 500;
                        }
                    }
                }

                //ADDITIONAL SCHEDULER
                if($proses == "scheduler"){
                    $proses = $API->comm('/system/scheduler/add', array(
                        'name' => $data["name"],
                        'on-event' => '/ppp secret set [find name='.$data["name"].'] dis=yes; /ppp active remove [find name='.$data["name"].']; /system sche remove  [find name='.$data["name"].']; /ip firewall nat disable [ find comment='.$data["name"].'];',
                        'policy' => 'ftp,reboot,read,write,policy,test,password,sniff,sensitive',
                        'start-date' => $data["start_date"],
                        'start-time' => '00:05:00',
                        'disabled' => 'no',
                        'comment' => $data["name"],
                    ));
                    $data_sheduler = $API->comm('/system/scheduler/print');
                    $search_data = $this->search_array($data_sheduler,"name",$data["name"]);
                    if(!empty($search_data)){
                        $status = 200;
                    }else{
                        $this->send_telegram('Proses pembuatan Scheduler Gagal, atas
Nama : '.$data["name"].'
Start Date : '.$data["start_date"].'
Error : '.$proses);
                        $status = 500;
                    }
                }

                //ADDITIONAL FIREWALL NAT
                if($proses == "firewall_nat"){
                    $API->write('/ip/firewall/nat/add', false);
                    $API->write('=action=dst-nat', false);
                    $API->write('=chain=dstnat',false);
                    $API->write('=comment='.$data["name"],false);
                    $API->write('=dst-address=10.20.120.187',false);
                    $API->write('=dst-port='.$data["dst_port"],false);
                    $API->write('=protocol=tcp',false);
                    $API->write('=to-addresses='.$data["address"],false);
                    $API->write('=to-ports='.$data["port"],false);
                    $API->write('=disabled=no');
                    $data_firewall = $API->comm('/ip/firewall/nat/print');
                    //print_r($data_firewall);
                    if($data_firewall){
                        $status = 200;
                    }else{
                        $this->send_telegram('Proses pembuatan Firewall Nat Gagal, atas 
Nama : '.$data["name"].'
Nomor : '.$data["nomor"].'
Port : '.$data["port"]);
                        $status = 500;
                    }
                }

                //EDIT PPP SECRET
                if($proses == "edit_ppp"){
                    $arrID = $API->comm("/ppp/secret/getall", 
                        array(
                            ".proplist"=> ".id",
                            "?name" => $data["name"],
                        ));

                    $proses_edit_ppp = $API->comm("/ppp/secret/set",
                        array(
                                ".id" => $arrID[0][".id"],
                                "password" => $data["password"]
                            )
                        );
                    if($proses_edit_ppp){
                        $status = 200;
                    }else{
                        $status = 500;
                    }
                }

                //REMOVE FIREWAL NAT
                if($proses == "remove_firewall"){
                    $API->write('/ip/firewall/nat/print', false);
                    $API->write('?comment='.$data["name"], false);
                    $API->write('=.proplist=.id');
                    $ARRAYS = $API->read();
                    
                    $API->write('/ip/firewall/nat/remove', false);
                    $API->write('=.id=' . $ARRAYS[0]['.id']);
                    $READ = $API->read();
                    if($READ){
                        $status = 200;
                    }else{
                        $status = 500;
                    }
                }

                //REMOVE PPP
                if($proses == "remove_ppp"){
                    $arrID = $API->comm("/ppp/secret/getall", 
                        array(
                            ".proplist"=> ".id",
                            "?name" => $data["name"],
                        ));

                    $proses_remove_ppp = $API->comm("/ppp/secret/remove",
                        array(
                                ".id" => $arrID[0][".id"]
                            )
                        );
                    if($proses_remove_ppp){
                        $status = 200;
                    }else{
                        $status = 500;
                    }
                }

                //REMOVE SCHEDULE
                if($proses == "remove_schedule"){
                    $arrID = $API->comm("/system/scheduler/getall", 
                        array(
                            ".proplist"=> ".id",
                            "?name" => $data["name"],
                        ));

                    $proses_remove_schedule = $API->comm("/system/scheduler/remove",
                        array(
                                ".id" => $arrID[0][".id"]
                            )
                        );
                    if($proses_remove_schedule){
                        $status = 200;
                    }else{
                        $status = 500;
                    }
                }
            }else{
                $this->send_telegram('Koneksi Routeros API tidak terhubung, mohon periksa IP Address, Port, Username, dan Password anda.');
                $status = $koneksi;
            }
            $API->disconnect();
        }else{
            $this->send_telegram('Koneksi Routeros API tidak terhubung, Sistem tidak dapat menemukan data IP Address, Username, dan Password, mohon check settingan API Routeros Anda');
            $status = 500;
        }
        return $status;
    }

    public function search_array($array,$column,$search)
    {
        $return = '';
        if(is_array($array)){
            foreach ($array as $key => $value) {
                foreach ($value as $column_name => $value_column) {
                    if($value_column == $search){
                        $return .= $value[".id"];
                    }
                }
            }
        }
        return $return;
    }

    public function user_remote($p)
    {
        $get_user = $this->model->gd("user","id,user_remote,server","role_id = '1'","row");
        if(!empty($get_user->id)){
            if($p == "user_remote"){
                $data = "@".$get_user->user_remote;
            }else if($p == "server"){
                $data = $get_user->server;
            }
        }else{
            if($p == "user_remote"){
                $data = "@Texa.net";
            }else if($p == "server"){
                $data = "Texa.my.id";
            }
        }
        return $data;
    }

    public function check_id_routeros($id_server)
    {
        $data_server = $this->model->gd("vpn_master","id_server","id = '$id_server'","row");
        if(!empty($data_server->id_server)){
            $data_routeros = $this->model->gd("api_routeros","id","id_server = '".$data_server->id_server."'","row");
            if(!empty($data_routeros->id)){
                $id_routeros = $data_routeros->id;
            }else{
                $id_routeros = 0;
            }
        }else{
            $id_routeros = 0;
        }
        return $id_routeros;
    }
}
?>