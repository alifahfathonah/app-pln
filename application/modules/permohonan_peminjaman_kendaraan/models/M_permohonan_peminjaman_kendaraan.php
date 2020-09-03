<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_permohonan_peminjaman_kendaraan extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = 
        $this->users = $this->session->userdata('id');
    }

    private function _get_datatables_query($sort = null, $order = null)
    {
        $this->db->select('pkp.*, pk.id as id_peminjaman_kendaraan, 
                            pk.id_kendaraan, pk.voucher, pk.is_use_driver, 
                            pk.id_driver, pk.tujuan, pk.keterangan, pk.tgl_start_peminjaman,
                            pk.tgl_end_peminjaman, pk.no_dokumen, pk.id_atasan, 
                            pk.dokumen_status, k.nopol, k.nama as kendaraan, us.nama as diajukan_oleh, 
                            usr.nama as driver');
        $this->db->from('peminjaman_kendaraan_persetujuan as pkp');
        $this->db->join('peminjaman_kendaraan as pk', 'pk.id = pkp.id_peminjaman_kendaraan');
        $this->db->join('kendaraan as k', 'k.id = pk.id_kendaraan', 'left');
        $this->db->join('users as us', 'us.id = pk.id_atasan', 'left');
        $this->db->join('users as usr', 'usr.id = pk.id_driver', 'left');

        if ($_POST['order'][0]['column'] == 1) :
            $this->db->order_by('k.nama', $order);
        else :
            $this->db->order_by($sort, $order);
        endif;

        $this->db->group_by('pk.id');

        $filter   = $_POST['filter'];
        if (@$filter['nama']) $this->db->like('k.nama', $filter['nama']);
        if (@$filter['status_dokumen']) $this->db->or_like('pkp.status_dokumen', $filter['status_dokumen']);
    }

    function get_datatables($sort = null, $order = null)
    {
        $this->_get_datatables_query($sort, $order);
        $this->db->where('pkp.id_users', $this->users, true);
        // $this->db->where('pkp.status_dokumen', 'Menunggu', true);

        if ($_POST['length'] != -1) :
            $this->db->limit($_POST['length'], $_POST['start']);
        endif;

        return $this->db->get()->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->db->get()->num_rows();
    }

    function count_all()
    {
        $this->_get_datatables_query();
        $db_results = $this->db->get();
        $results    = $db_results->result();
        $num_rows   = $db_results->num_rows();
        return $num_rows;
    }

    // get data by id
    function get_data_by_id($id)
    {
        $this->db->select('pk.*, pkp.status_dokumen as status_dokumen_persetujuan, 
                            pkp.keterangan as keterangan_persetujuan, 
                            pkp.signature,
                            k.nopol, d.nama as divisi, usr.id_divisi, usr.nama, 
                            usr.telp_wa as telp, k.nama as kendaraan, 
                            us.nama as diajukan_oleh, usr.nama as driver,
                            k.foto as foto_kendaraan, jk.nama as jenis_kendaraan, k.kapasitas, 
                            k.created_date as tgl_dibuat_kendaraan, usrr.nama as dibuat_oleh_kendaraan');
        $this->db->from('peminjaman_kendaraan as pk');
        $this->db->join('kendaraan as k', 'k.id = pk.id_kendaraan', 'left');
        $this->db->join('jenis_kendaraan as jk', 'jk.id = k.id_jenis_kendaraan', 'left');
        $this->db->join('users as us', 'us.id = pk.id_atasan', 'left');
        $this->db->join('users as usr', 'usr.id = pk.id_driver', 'left');
        $this->db->join('users as usrr', 'usrr.id = k.id_users', 'left');
        $this->db->join('divisi as d', 'd.id = usr.id_divisi', 'left');
        $this->db->join('peminjaman_kendaraan_persetujuan as pkp', 'pkp.id_peminjaman_kendaraan = pk.id');
        $this->db->where('pk.id', $id);
        $this->db->where('pkp.id_users', $this->session->userdata('id'));
        return $this->db->get()->row();
        // $this->db->get(); echo $this->db->last_query(); die;
    }

    function get_data_personil($id_peminjaman_kendaraan)
    {
        $this->db->select('*')->from('peminjaman_kendaraan_personil')->where('id_peminjaman_kendaraan', $id_peminjaman_kendaraan);
        return $this->db->get()->result();
    }


    // update data
    function update_data_permohonan_peminjaman_kendaraan($data_peminjaman_kendaraan, $id)
    {
        $this->db->where('id', $id, true)->update('peminjaman_kendaraan', $data_peminjaman_kendaraan);
        return $id; 
    }

    // hapus data
    function hapus_data($id)
    {
        return $this->db->where('id', $id, true)->delete($this->table);
    }

    function get_data_pemohon_by_id($id)
    {
        return $this->db->select('us.nama as nama_driver, us.telp_wa, us.telp_atasan, 
                                  concat_ws(" - ", k.nopol, k.nama) as kendaraan,
                                  usr.telp_wa as telp_pemohon
                                ')
                        ->from('peminjaman_kendaraan as pk')
                        ->join('users as us', 'us.id = pk.id_driver', 'left')
                        ->join('kendaraan as k', 'k.id = pk.id_kendaraan', 'left')
                        ->join('users as usr', 'usr.id = pk.id_atasan', 'left')
                        ->where('pk.id', $id)
                        ->get()
                        ->row();
    }

    function get_data_traveladmin_by_id()
    {
        return $this->db->select('telp_wa')->from('users')->where('id', '394')->get()->row();
    }

    function get_data_driver_by_id($id)
    {
        return $this->db->select('us.nama as nama_driver, us.telp_wa')
                        ->from('peminjaman_kendaraan as pk')
                        ->join('users as us', 'us.id = pk.id_driver', 'left')
                        ->where('pk.id', $id)
                        ->get()
                        ->row();
    }
}
