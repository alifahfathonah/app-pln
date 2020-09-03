<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auto extends CI_Model {

    
    function __construct()
    {
        parent::__construct();
        
    }
    
    function get_kelamin() 
    {
        return array(
            'L' => 'Laki - laki',
            'P' => 'Perempuan',
        );
    }

    function get_status_dokumen()
    {
        return array(
            ''           => '- Filter Status -',
            'Menunggu'   => 'Menunggu',
            'Disetujui'  => 'Disetujui',
            'Ditolak'    => 'Ditolak',
            'Selesai'    => 'Selesai',
            'Kadaluarsa' => 'Kadaluarsa',
            'Pending'    => 'Pending',
            'Batal'      => 'Batal' 
        );
    }

    function get_atasan()
    {
        $query = $this->db->get('atasan')->result();
        $data =  array();
        $data[''] = '- Pilih -';
        foreach ($query as $key => $value) :
            $data[$value->id] = $value->nama;
        endforeach;

        return $data;
    }

    function get_atasan_select()
    {
        $sql = "select us.id, us.nama, us.id_divisi, d.nama as divisi 
                from users as us 
                join divisi as d on (d.id = us.id_divisi)";
        
        $query = $this->db->query($sql)->result();
        $data =  array();
        $data[''] = '- Pilih -';
        foreach ($query as $key => $value) :
            $data[$value->divisi][] = array(
                'id' => $value->id,
                'nama' => $value->nama,
            );
        endforeach;

        return $data;
    }

    function get_petugas_select()
    {
        $sql = "select us.id, us.nama, us.id_divisi, d.nama as divisi 
                from users as us 
                join divisi as d on (d.id = us.id_divisi)
                where us.id_divisi = 9";
        
        $query = $this->db->query($sql)->result();
        $data =  array();
        $data[''] = '- Pilih -';
        foreach ($query as $key => $value) :
            $data[$value->divisi][] = array(
                'id' => $value->id,
                'nama' => $value->nama,
            );
        endforeach;

        return $data;
    }

    function get_driver_select()
    {
        $sql = "select us.id, us.nama, us.id_divisi, d.nama as divisi 
                from users as us 
                join divisi as d on (d.id = us.id_divisi)
                where us.id_divisi = 33";
        
        $query = $this->db->query($sql)->result();
        $data =  array();
        $data[''] = '- Pilih -';
        foreach ($query as $key => $value) :
            $data[$value->divisi][] = array(
                'id' => $value->id,
                'nama' => $value->nama,
            );
        endforeach;

        return $data;
    }

    function get_snack_select()
    {
        $query = $this->db->get('snack')->result();
        $data =  array();
        $data[''] = '- Pilih -';
        foreach ($query as $key => $value) :
            $data[$value->id] = $value->nama;
        endforeach;

        return $data;
    }

    function get_makan_siang_select()
    {
        $query = $this->db->get('makan_siang')->result();
        $data =  array();
        $data[''] = '- Pilih -';
        foreach ($query as $key => $value) :
            $data[$value->id] = $value->nama;
        endforeach;

        return $data;
    }

    function get_kategori_divisi()
    {
        $query = $this->db->get('kategori_divisi')->result();
        $data =  array();
        $data[''] = '- Pilih -';
        foreach ($query as $key => $value) :
            $data[$value->id] = $value->nama;
        endforeach;

        return $data;
    }

    function get_divisi_select()
    {
        $query = $this->db->get('divisi')->result();
        $data =  array();
        $data[''] = '- Pilih Divisi -';
        foreach ($query as $key => $value) :
            $data[$value->id] = $value->nama;
        endforeach;

        return $data;
    }

    function get_kendaraan_select()
    {
        $query = $this->db->get('kendaraan')->result();
        $data =  array();
        $data[''] = '- Pilih -';
        foreach ($query as $key => $value) :
            $data[$value->id] = $value->nopol . ' - ' . $value->nama;
        endforeach;

        return $data;
    }

    function get_jenis_kendaraan()
    {
        $query = $this->db->get('jenis_kendaraan')->result();
        $data =  array();
        $data[''] = '- Pilih -';
        foreach ($query as $key => $value) :
            $data[$value->id] = $value->nama;
        endforeach;

        return $data;
    }

    function get_ruangan()
    {
        $query = $this->db->get('ruangan')->result();
        $data =  array();
        $data[''] = '- Pilih -';
        foreach ($query as $key => $value) :
            $data[$value->id] = $value->kode . ' - ' . $value->nama;
        endforeach;

        return $data;
    }

    function get_auto_divisi($q, $start, $limit)
    {
        $limit = " limit " . $limit . " offset " . $start;
        $sql = "select d.*, kd.nama as kategori_divisi
                from divisi as d
                join kategori_divisi as kd on (kd.id = d.id_kategori_divisi)
                where d.nama like ('%$q%') order by d.nama";
        $data['data'] = $this->db->query($sql . $limit)->result();
        $data['total'] = $this->db->query($sql)->num_rows();
        return $data;
    }

    function get_auto_kendaraan($q, $start, $limit)
    {
        $limit = " limit " . $limit . " offset " . $start;
        $sql = "select k.*, jk.nama as jenis_kendaraan,
                us.nama as created_by
                from kendaraan as k
                join jenis_kendaraan as jk on ( jk.id = k.id_jenis_kendaraan )
                join users as us on ( us.id = k.id_users )
                where k.nama like ('%$q%') or k.nopol like ('%$q') order by k.nama";
        $data['data'] = $this->db->query($sql . $limit)->result();
        $data['total'] = $this->db->query($sql)->num_rows();
        return $data;
    }

    function get_auto_driver($q, $start, $limit)
    {
        $limit = " limit " . $limit . " offset " . $start;
        $sql = "select us.*, d.nama as divisi
                from users as us
                join divisi as d on (d.id = us.id_divisi)
                where us.nama like ('%$q%') and d.id = '33' order by us.nama";
        $data['data'] = $this->db->query($sql . $limit)->result();
        $data['total'] = $this->db->query($sql)->num_rows();
        return $data;
    }

    function get_auto_atasan($q, $start, $limit)
    {
        $limit = " limit " . $limit . " offset " . $start;
        $sql = "select us.*, d.nama as divisi
                from users as us
                left join divisi as d on (d.id = us.id_divisi)
                where us.nama like ('%$q%') and us.username != 'Admin' order by d.nama";
        $data['data'] = $this->db->query($sql . $limit)->result();
        $data['total'] = $this->db->query($sql)->num_rows();
        return $data;
    }

    function get_auto_snack($q, $start, $limit)
    {
        $limit = " limit " . $limit . " offset " . $start;
        $sql = "select *
                from snack
                where nama like ('%$q%') order by nama";
        $data['data'] = $this->db->query($sql . $limit)->result();
        $data['total'] = $this->db->query($sql)->num_rows();
        return $data;
    }

    function get_auto_makan_siang($q, $start, $limit)
    {
        $limit = " limit " . $limit . " offset " . $start;
        $sql = "select *
                from makan_siang
                where nama like ('%$q%') order by nama";
        $data['data'] = $this->db->query($sql . $limit)->result();
        $data['total'] = $this->db->query($sql)->num_rows();
        return $data;
    }

    function cek_no_dokumen()
    {
        $query = $this->db->query("SELECT MAX(no_dokumen) as no_dokumen from peminjaman_kendaraan");
        $hasil = $query->row();
        return $hasil->no_dokumen;
    }

    function cek_no_dokumen_ruangan()
    {
        $query = $this->db->query("SELECT MAX(no_dokumen) as no_dokumen from peminjaman_ruangan");
        $hasil = $query->row();
        return $hasil->no_dokumen;
    }

    function get_barang()
    {
        $query = $this->db->get('barang')->result();
        return $query;
    }

    function get_barang_by_id($id)
    {
        $query = $this->db->select('*')->from('barang')->where('id', $id)->get()->row();
        return $query;
    }
}