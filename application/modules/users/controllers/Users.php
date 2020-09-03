<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Users extends SM_Controller
{
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('id'))) :
            redirect('auth');
        endif;
        
        $this->template->set_layout('templates/backend/index');
        $this->load->model('M_users', 'm_users');
        $this->load->model('auto/M_auto', 'm_auto');
        $this->datetime = date('Y-m-d H:i:s');
    }

    function index()
    {
        $this->template->add_title_segment('Users');

        $data = array(
            'active'     => 'users',
            'breadcrumb' => 'Users',
            'modal'      => array('users/modal'),
            'kelamin'    => $this->m_auto->get_kelamin(),
        );
        $this->template->render('index', $data);
    }

    function ajax_list()
    {
        $data  = array();
        $sort  = isset($_POST['columns'][$_POST['order'][0]['column']]['data']) ? strval($_POST['columns'][$_POST['order'][0]['column']]['data']) : 'nama';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
        $no    = $this->input->post('start', true);

        $list  = $this->m_users->get_datatables($sort, $order);
        foreach ($list as $l) :
            $no++;
            $l->no   = $no;
            $l->nama = $l->nama;
            $l->aksi = '<div class="right">
                    <button type="button" onclick="ubah_data(' . $l->id . ')" title="Ubah Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-edit"></i></button>
                    <button type="button" onclick="hapus_data(' . $l->id . ')" title="Hapus Data" class="btn btn-shadow btn-light btn-xs"><i class="fas fa-trash"></i></button>
                </div>';

            $data[] = $l;
        endforeach;

        $output = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->m_users->count_all($sort, $order),
            "recordsFiltered"   => $this->m_users->count_filtered($sort, $order),
            "data"              => $data,
        );
        echo json_encode($output);
    }

    function ajax_data_id()
    {
        $id = $this->input->get('id', true);
        $data = $this->m_users->get_data_by_id($id);
        echo json_encode($data);
    }

    private function _validasi()
    {
        $this->load->library('form_validation');
        $this->config->set_item('language', 'indonesia');

        $this->form_validation->set_rules('nama', 'nama', 'required');
        // $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('re_password', 'konfirmasi password', 'required|matches[password]');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email');
        $this->form_validation->set_rules('telp_wa', 'no handphone (whatsapp)', 'required|is_numeric');
        $this->form_validation->set_rules('divisi', 'divisi', 'required');

        if ($this->form_validation->run()) return TRUE;

        $data                = $error                = array();
        $data['error_class'] = $data['error_string'] = array();
        $data['status']      = TRUE;

        if (form_error('nama')) $error[] = 'nama';
        // if (form_error('username')) $error[] = 'username';
        if (form_error('password')) $error[] = 'password';
        if (form_error('re_password')) $error[] = 're_password';
        if (form_error('email')) $error[] = 'email';
        if (form_error('telp_wa')) $error[] = 'telp_wa';
        if (form_error('divisi')) $error[] = 'divisi';

        if ($error) :
            foreach ($error as $row) :
                $data['error_class'][$row]  = 'is-invalid';
                $data['error_string'][$row] = form_error($row);
            endforeach;

            $data['validasi'] = FALSE;
            echo json_encode($data);
            exit();
        endif;
    }

    function ajax_post() 
    {
        $this->_validasi();

        $request = array(
            'id_divisi'    => $this->input->post('divisi', true),
            'telp_atasan'  => $this->input->post('telpon_atasan', true),
            'username'     => $this->input->post('username', true),
            'password'     => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
            'nik'          => $this->input->post('nik', true),
            'nama'         => $this->input->post('nama', true),
            'kelamin'      => $this->input->post('kelamin', true),
            'email'        => $this->input->post('email', true),
            'telp_wa'      => $this->input->post('telp_wa', true),
            'telp'         => $this->input->post('telp', true),
            'foto'         => $this->input->post('nama_foto', true),
            'status'       => $this->input->post('status', true),
            'created_date' => $this->datetime,
            
        );
        
        // echo json_encode($request); die;
        $data = $this->m_users->simpan_data($request);
        if ($data) :
            echo json_encode(array(
                'status' => $data,
                'message' => 'Berhasil menyimpan data'
            ));
        else :
            echo json_encode(array(
                'status' => $data,
                'message' => 'Gagal menyimpan data'
            ));
        endif;
    }

    function ajax_put()
    {
        $request = array(
            'id'            => $this->input->post('id', true),
            'id_divisi'     => $this->input->post('divisi', true),
            'telp_atasan'   => $this->input->post('telpon_atasan', true),
            'nik'           => $this->input->post('nik', true),
            'nama'          => $this->input->post('nama', true),
            'kelamin'       => $this->input->post('kelamin', true),
            'email'         => $this->input->post('email', true),
            'telp_wa'       => $this->input->post('telp_wa', true),
            'telp'          => $this->input->post('telp', true),
            'foto'          => $this->input->post('nama_foto', true),
            'status'        => $this->input->post('status', true),
            'modified_date' => $this->datetime,
        );

        $data = $this->m_users->update_data($request);
        if ($data) :
            echo json_encode(array(
                'status' => $data,
                'message' => 'Berhasil mengubah data'
            ));
        else :
            echo json_encode(array(
                'status' => $data,
                'message' => 'Gagal mengubah data'
            ));
        endif;
    }

    function ajax_delete()
    {
        $id = $this->input->get('id', true);
        $data = $this->m_users->hapus_data($id);
        if ($data) :
            echo json_encode(array(
                'status' => $data
            ));
        endif;
    }

    function ajax_upload()
    {
        if (!empty($_FILES['foto']['name'])) :
            $config['upload_path']          = 'assets/upload/';
            $config['allowed_types']        = 'jpg|png|jpeg';
            $config['max_size']             = 1024; //set max size allowed in Kilobyte
            $config['overwrite']            = TRUE;
            // $config['encrypt_name']         = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('foto')) :
                $data['error'] = 'Terjadi Kesalahan | ' . $this->upload->display_errors();
                $data['status'] = false;

                die(json_encode($data));
            else :
                $data['status'] = true;
                $data['file_name'] = $this->upload->data('file_name');
                $data['success'] = 'Proses Upload Telah Berhasil';
                die(json_encode($data));
            endif;
        else :
            die(json_encode(['status' => false]));
        endif;
    }

    function ajax_delete_image_old()
    {
        if (($_POST['file_tmp'] !== NULL) && ($_POST['file_tmp'] !== "")) {
            $file = 'assets/upload/' . $_POST['file_tmp'];
            unlink($file);
            echo json_encode(array('status' => TRUE));
        } else {
            echo json_encode(array('status' => FALSE));
        }
    }

    function username_similarity_check()
    {
        $username = $this->input->post('username', true);

        if ($username !== '') {
            $similar =  $this->m_users->username_check($username);
        } else {
            $similar = false;
        }

        $response = array(
            'similar' => $similar
        );
        
        echo json_encode($response);
    }

    // ganti password
    function change_password()
    {
        $this->template->add_title_segment('Change Password');

        $data = array(
            'active'     => '',
            'breadcrumb' => 'Change Password',
        );
        $this->template->render('change_password/index', $data);
    }

    function check_password()
    {
        $account = filter_input(INPUT_POST, 'username');
        $key = filter_input(INPUT_POST, 'password');
        $data = $this->m_users->check_my_account($account)->row();
        if (isset($data->id)) {
            if (password_verify($key, $data->password)) {
                die(json_encode(array('status' => TRUE)));
            } else {
                die(json_encode(array('status' => FALSE)));
            }
        } else {
            die(json_encode(array('status' => FALSE)));
        }
    }

    function simpan_password()
    {
        $data = array(
            'password' => password_hash($this->input->post('new_password', true), PASSWORD_DEFAULT),
        );

        $this->db->where('id', $this->session->userdata("id"))->update('users', $data);

        die(json_encode(array('status' => true)));
    }

    // users profil
    function profil()
    {
        $this->template->add_title_segment('Profil');

        $data = array(
            'active'     => '',
            'breadcrumb' => 'Profil',
            'modal'      => array('users/modal'),
            'kelamin'    => $this->m_auto->get_kelamin(),
            'users'      => $this->m_users->get_data_by_id($this->session->userdata('id'))
        );
        $this->template->render('profil/index', $data);
    }

}
