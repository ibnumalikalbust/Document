<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->load->library('form_validation');
    // }
	// public function swal($title, $text, $icon)
	// {
	// 	$this->session->set_flashdata("swal", '
	// 	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.5/sweetalert2.min.js"></script>
	// 	<script>
	// 		var text = "' . $text . '";
	// 		swal.fire({title:"' . $title . '",html:text,icon:"' . $icon . '"});
	// 	</script>');
	// }
    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $data['nzm'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            // validasinya success
            $this->_login();
        }
    }


    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        // jika usernya ada
        if ($user) {
            //jika usernya aktif
            if ($user['is_active'] == 1) {
                // cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'id_user' => $user['id'],
                        'email' => $user['email'],
                        'role_id' => $user['role_id'],
                        'name' => $user['name'],
                        'image_user' => base_url('assets/img/profile/'.$user['image']),
                    ];
                    $this->session->set_userdata($data);
                    $last_login = [
                        "last_login" => date("Y-m-d H:i:s"),
                    ];
                    $this->model->update("user","id = '".$user['id']."'",$last_login);
                    redirect('admin');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">passwordnya salah sobat</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">email belum di Aktivasi</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun Belum Terdaftar</div>');
            redirect('auth');
        }
    }

    public function registration()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'waduuuh.... email sudah terdaftar sobat'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'waduuuh...password tidak sama',
            'min_length' => 'password min 3 huruf/angka ya sobat...'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['nzm'] = $this->server.' Registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'saldo' => 0,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);

            $this->load->config('email');
            $this->load->library('email');
            
            $from = $this->config->item('smtp_user');
            $to = $this->input->post('email', true);
            $subject = "Activation Account ".$this->server." ".$this->input->post('name', true);
            $message = '
            Terimakasih anda telah mendaftar di '.$this->server.',<br>
            Mohon untuk bisa klik link di bawah ini agar akun anda segera di aktifkan<br><br>
            Link Aktivasi : '.base_url("activation/".e_nzm($this->db->insert_id())).'<br><br>
            Mohon abaikan pesan ini jika akun anda sudah di aktivasi.<br>
            Terimakasih dan semoga hari anda menyenangkan.';

            $this->email->set_newline("\r\n");
            $this->email->from($from);
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);

            if ($this->email->send()) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Proses regitrasi selesai, Mohon untuk check email anda dan klik link aktivasi nya.</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.show_error($this->email->print_debugger()).'<br><br>Mohon hubungi admin untuk proses aktivasi, klik tombol di bawan ini<br><br><a href="https://wa.me/+6285290189491?text=Dear%20Admin%2C%0ASaya%20telah%20melakukan%20registrasi%20namun%20pengiriman%20link%20aktivasi%20gagal.%0AMohon%20untuk%20bisa%20di%20bantu%20proses%20aktivasi%20atas%20%3A%0ANama%20%3A%20'.urlencode($this->input->post('name', true)).'%0AEmail%20%3A%20'.urlencode($this->input->post('email', true)).'%0A%0ATerimakasih" class="btn btn-sm btn-success"><i class="fab fa-whatsapp mr-2"></i>0852-9018-9491</a></div>');
            }
            redirect('auth');
        }
    }

    public function activation($p)
    {
        $id_user = d_nzm($p);
        $data = [
            "is_active" => 1,
        ];
        $update = $this->model->update("user","id = '$id_user'",$data);
        if(!$update){
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Proses aktivasi selesai, Sekarang anda bisa melakukan login.</div>');
        }else{
            $user = $this->model->gd("user","*","id = '$id_user'","row");
            if(!empty($user->id)){
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Proses aktivasi gagal, Mohon hubungi admin untuk proses aktivasi, klik tombol di bawah ini<br><br><a href="https://wa.me/+6285290189491?text=Dear%20Admin%2C%0ASaya%20telah%20melakukan%20registrasi%20namun%20pengiriman%20link%20aktivasi%20gagal.%0AMohon%20untuk%20bisa%20di%20bantu%20proses%20aktivasi%20atas%20%3A%0ANama%20%3A%20'.urlencode($user->name).'%0AEmail%20%3A%20'.urlencode($user->email).'%0A%0ATerimakasih" class="btn btn-sm btn-success"><i class="fab fa-whatsapp mr-2"></i>0852-9018-9491</a>.</div>');
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Proses aktivasi gagal, Mohon hubungi admin untuk proses aktivasi, klik tombol di bawah ini<br><br><a href="https://wa.me/+6285290189491" class="btn btn-sm btn-success"><i class="fab fa-whatsapp mr-2"></i>0852-9018-9491</a>.</div>');
            }
        }
        redirect('auth');
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        if(!empty($this->id_user)){
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sobat sudah Berhasil Keluar</div>');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Sesi login terakhir anda telah berakhir</div>');
        }
        redirect('auth');
    }

    public function forget_password()
    {
        $data['nzm'] = 'Forget Password';
        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/forget_password');
        $this->load->view('templates/auth_footer');
    }

    public function fpass()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|xss_clean');
        if($this->form_validation->run() === TRUE){
            $email = $this->input->post("email");
            $check_email = $this->model->gd("user","id","email = '$email'","row");
            if(!empty($check_email->id)){
                $new_pass1 = rand(111111,999999);
                $new_pass = password_hash($new_pass1,PASSWORD_BCRYPT);
                $data_password = [
                    "password" => $new_pass,
                ];
                $action = $this->model->update("user","id = '".$check_email->id."'",$data_password);
                if(!$action){
                    $this->load->config('email');
                    $this->load->library('email');
                    
                    $from = $this->config->item('smtp_user');
                    $to = $email;
                    $subject = "Forget Password ".$this->server;
                    $message = '
                    <h2 style="margin-bottom:0px;">'.$this->server.'</h2>,<br>
                    Berikut adalah password baru anda<br><br>
                    <div style="width:100%;" align="center"><h1 style="margin-bottom:0px;">'.$new_pass1.'</h1></div><br><br>
                    Silahkan login menggunakan password di atas, setelah itu mohon langsung mengganti password anda, supaya lebih mudah dalam di ingat.<br>
                    Terimakasih dan semoga hari anda menyenangkan.';

                    $this->email->set_newline("\r\n");
                    $this->email->from($from);
                    $this->email->to($to);
                    $this->email->subject($subject);
                    $this->email->message($message);

                    if ($this->email->send()) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password baru anda sudah kami kirim melalui email, silahkan check email anda.</div>');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal mengirimkan email untuk password baru anda.<br><br>Mohon untuk bisa hubungi admin, klik button di bawah ini<br><a href="https://wa.me/+6285290189491" class="btn btn-sm btn-success"><i class="fab fa-whatsapp mr-2"></i>0852-9018-9491</a></div>');
                    }
                }else{
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal membuat password baru, cobalah beberapa saat lagi </div>');
                }
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Alamat email tidak terdaftar</div>');
            }
            redirect('auth');
        }
    }
}
