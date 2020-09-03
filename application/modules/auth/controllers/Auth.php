<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends SM_Controller {

    
    function __construct()
    {
        parent::__construct();
        $this->template->set_layout('templates/auth/index');
        $this->load->model('M_auth', 'm_auth');    
        $this->datetime = date('Y-m-d H:i:s');
    }
    
    function index()
    {
        if ($this->session->userdata('id') == '1') :
            redirect(base_url());
        endif;

        $this->template->add_title_segment('Login');

        $data = array(
            'captcha' => $this->create_captcha()
        );

        $this->template->render('index', $data);
    }

    function login () {
        $username = $this->input->post('account', true);
        $password = $this->input->post('password', true);

        $users = $this->m_auth->verifikasi_user($username);
        if ($users) :
            if ($users->is_allow_login == 1) :
                if ($users->status == 1) :
                    if ($users->username === $username || $users->email === $username) :
                        if (password_verify($password, $users->password)) :
                            if ($this->input->post('captcha') == $this->session->userdata('captchaword')) :
                                $data_session = array(
                                    'id'                 => $users->id,
                                    'nama'               => $users->nama,
                                    'username'           => $users->username,
                                    'email'              => $users->email,
                                    'foto'               => $users->foto,
                                    'id_atasan'          => $users->id_atasan,
                                    'id_kategori_divisi' => $users->id_kategori_divisi,
                                    'is_need_approval'   => $users->is_need_approval,
                                    'atasan'             => $users->atasan,
                                    'id_divisi'          => $users->id_divisi,
                                    'divisi'             => $users->divisi,
                                    'kategori_divisi'    => $users->kategori_divisi,
                                );
                                
                                $this->session->set_userdata($data_session);
                                $this->db->where('id', $users->id)->update('users', array('last_login' => $this->datetime));
                                
                                $url_absen = false;
                                if ($this->session->userdata('url_absen')) :
                                    $url_absen = $this->session->userdata('url_absen');
                                endif;

                                $return = array(
                                    'status' => true,
                                    'url_absen'   => $url_absen,
                                    'message' => 'Mohon tunggu sebentar...'
                                );
                            else :
                                $return = array(
                                    'status' => false,
                                    'message' => 'Captcha tidak sesuai'
                                );
                            endif;
                        else :
                            $return = array(
                                'status' => false,
                                'message' => 'Password yang anda masukkan salah'
                            );
                        endif;
                    else :
                        $return = array(
                            'status' => false,
                            'message' => 'Username / email tidak terdaftar'
                        );
                    endif;
                else :
                    $return = array(
                        'status' => false,
                        'message' => 'Account anda sudah tidak aktif',
                    );
                endif;
            else :
                $return = array(
                    'status' => false,
                    'message' => 'Account anda tidak diizinkan login / silahkan hubungi administrator'
                );
            endif;
        else :
            $return = array(
                'status' => false,
                'message' => 'Data account tidak ditemukan'
            );
        endif;

        echo json_encode($return);
    }

    function logout() {
        $data_session = array(
            'id',
            'nama',
            'username',
            'email',
            'foto',
            'id_atasan',
            'id_kategori_divisi',
            'is_need_approval',
            'atasan',
            'divisi',
            'kategori_divisi',
        );

        $this->session->unset_userdata($data_session);
        $this->session->sess_destroy();
        redirect('/');
    }

    function create_captcha()
    {
        $random_number = substr(number_format(time() * rand(),0,'',''),0,4);

        $option = array(
            'word'       => $random_number,
            'img_path'   => 'assets/captcha/',
            'img_url'    => base_url('assets/captcha'),
            'font_path'  => FCPATH . 'assets/captcha/fonts/roboto-bold.ttf',
            'img_width'  => '200',
            'img_height' => '50',
            'font_size'  => 20,
            'expiration' => 7200,
        );

        $cap = create_captcha($option);
        $image = $cap['image'];
        $this->session->set_userdata('captchaword', $cap['word']);
        return $image;
    }
}

/* End of file Auth.php */
