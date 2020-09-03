<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruangan_model extends CI_Model {

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
                        us.nama as diajukan_oleh');
        $this->db->from($this->table);
        $this->db->join('ruangan as r', 'r.id = pr.id_ruangan');
        $this->db->join('users as us', 'us.id = pr.id_users');
        // $this->db->join('makan_siang as ms', 'ms.id = pr.id_makan_siang', 'left');
        // $this->db->join('snack as s', 's.id = pr.id_snack', 'left');
        $this->db->where('pr.id', $id);
        return $this->db->get()->row();
        // $this->db->get(); echo $this->db->last_query(); die;
    }

    // update data
    function update_data_peminjaman_ruangan($data_peminjaman_ruangan, $id)
    {
        return $this->db->where('id', $id, true)->update('peminjaman_ruangan', $data_peminjaman_ruangan);
    }

    function get_data_absensi_ruangan($id)
    {
        $sql = "select pr.*, date(pr.tgl_start) as tanggal_mulai,
                time(pr.tgl_start) as time_mulai,
                concat_ws(' - ', r.kode, r.nama) as ruangan, 
                us.nama as diajukan_oleh,
                ms.nama as makan_siang
                from peminjaman_ruangan as pr
                join ruangan as r on (r.id = pr.id_ruangan) 
                join users as us on (us.id = pr.id_users) 
                left join makan_siang as ms on (ms.id = pr.id_makan_siang) 
                where pr.id = " . $id;
        
         $sql_ = "select dh.*, us.nama, us.email, us.telp_wa, d.nama as divisi
                 from daftar_hadir as dh
                 join users as us on (us.id = dh.id_users) 
                 join divisi as d on (d.id = us.id_divisi) 
                 where dh.id_peminjaman_ruangan = ". $id;       

        $data['booking'] = $this->db->query($sql)->row();
        $data['absensi'] = $this->db->query($sql_)->result();

        return $data;
    }

    function ubah_status_ruangan($data)
    {
        $result = $this->db->where('id', $data['id'])->update('peminjaman_ruangan', $data);
        $result = $this->db->where('id_peminjaman_ruangan', $data['id'])->update('peminjaman_ruangan_persetujuan', $data);

        return $result;
    }

}
