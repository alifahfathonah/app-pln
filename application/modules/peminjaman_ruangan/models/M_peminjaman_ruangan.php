<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_peminjaman_ruangan extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->table = 'peminjaman_ruangan as pr';
    }

    private function _get_datatables_query($sort = null, $order = null)
    {
        $this->db->select('pr.*, concat_ws(" - ", r.kode, r.nama) as ruangan, us.nama as diajukan_oleh');
        $this->db->from($this->table);
        $this->db->join('ruangan as r', 'r.id = pr.id_ruangan');
        $this->db->join('users as us', 'us.id = pr.id_users');

        if ($_POST['order'][0]['column'] == 1) :
            $this->db->order_by('pr.no_dokumen', $order);
        else :
            $this->db->order_by($sort, $order);
        endif;

        $filter   = $_POST['filter'];
        if (@$filter['no_dokumen']) $this->db->like('pr.no_dokumen', $filter['no_dokumen'], 'after');
        if (@$filter['nama_kegiatan']) $this->db->like('pr.nama_kegiatan', $filter['nama_kegiatan']);
        if (@$filter['status_dokumen']) $this->db->like('pr.status_dokumen', $filter['status_dokumen']);
    }

    function get_datatables($sort = null, $order = null)
    {
        $this->_get_datatables_query($sort, $order);

        if ($_POST['length'] != -1) :
            $this->db->limit($_POST['length'], $_POST['start']);
        endif;

        // $this->db->get(); echo $this->db->last_query(); die;
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

    // simpan data
    function simpan_data_peminjaman_ruangan($data_peminjaman_ruangan)
    {
        $this->db->insert('peminjaman_ruangan', $data_peminjaman_ruangan, true);
        return $this->db->insert_id();
    }

    function save_batch_data_persetujuan_peminjaman_ruangan($request)
    {
        return $this->db->insert_batch('peminjaman_ruangan_persetujuan', $request);
    }

    // hapus data
    function hapus_data($id)
    {
        return $this->db->where('id', $id, true)->delete('peminjaman_ruangan');
    }

    // get data by id
    function get_data_by_id($id)
    {
        $this->db->select('pr.*, 
                        concat_ws(" - ", r.kode, r.nama) as ruangan, 
                        us.nama as diajukan_oleh,
                        ms.nama as makan_siang, 
                        s.nama as snack');
        $this->db->from($this->table);
        $this->db->join('ruangan as r', 'r.id = pr.id_ruangan');
        $this->db->join('users as us', 'us.id = pr.id_users');
        $this->db->join('makan_siang as ms', 'ms.id = pr.id_makan_siang', 'left');
        $this->db->join('snack as s', 's.id = pr.id_snack', 'left');
        $this->db->where('pr.id', $id);
        return $this->db->get()->row();
        // $this->db->get(); echo $this->db->last_query(); die;
    }

    // update data
    function update_data_peminjaman_ruangan($data_peminjaman_ruangan, $id)
    {
        return $this->db->where('id', $id, true)->update('peminjaman_ruangan', $data_peminjaman_ruangan);
    }

}
