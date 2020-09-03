<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_atk_model extends CI_Model {

    // function get_data_atk($search)
    // {
    //     // Data ATK
    //     $this->db->select('a.*, us.nama as users, b.nama as barang, b.satuan, da.qty_request, da.qty_approval');
    //     $this->db->from('atk a');
    //     $this->db->join('users us', 'us.id = a.id_user');
    //     $this->db->join('detail_atk da', 'da.id_atk = a.id');
    //     $this->db->join('barang b', 'b.id = da.id_barang');
        
    //     if ($search['no_notadinas']) :
    //         $this->db->where('a.no_notadinas', $search['no_notadinas']);
    //     endif;

    //     if (($search['tanggal_awal'] !== '') & ($search['tanggal_akhir'] !== '')) :
    //         $this->db->where("a.tanggal BETWEEN '" . date2mysql($search['tanggal_awal']) . " 00:00:00' AND '" . date2mysql($search['tanggal_akhir']) . " 23:59:59'");
    //     endif;

    //     if ($search['divisi']) :
    //         $this->db->where('us.id_divisi', $search['divisi']);
    //     endif;

    //     // $this->db->get(); echo $this->db->last_query(); die;
    //     $data['atk'] = $this->db->get()->result_array();
    
    //     $result = array();

    //     foreach ($data['atk'] as $row) :
    //         $result[$row['no_notadinas']][] = [
    //             'barang' =>
    //         ];
    //     endforeach;
    //     return $result;
    // }

    function get_data_atk($search){
        $this->db->select('a.*,us.nama as users , b.nama as barang, b.satuan, da.qty_request, da.qty_approval');
        $this->db->from('detail_atk da');
        $this->db->join('atk a', 'a.id = da.id_atk');
        $this->db->join('barang b', 'b.id = da.id_barang');
        $this->db->join('users us', 'us.id = a.id_user');
    
        if ($search['no_notadinas']) :
            $this->db->where('a.no_notadinas', $search['no_notadinas']);
        endif;
    
        if (($search['tanggal_awal'] !== '') & ($search['tanggal_akhir'] !== '')) :
            $this->db->where("a.tanggal BETWEEN '" . date2mysql($search['tanggal_awal']) . " 00:00:00' AND '" . date2mysql($search['tanggal_akhir']) . " 23:59:59'");
        endif;
    
        if ($search['divisi']) :
            $this->db->where('us.id_divisi', $search['divisi']);
        endif;
    
        $data = $this->db->get()->result();
    
        $i=0;
        $indexIdAtk = -1;
        $dt = array();
        $temp["id_atk"] = -1;
        foreach ($data as $row) {
    
            if($temp["id_atk"]==$row->id){
                $detail_atk = $this->_detail_atk($row);
                $dt[$indexIdAtk]["detail_atk"][$i]  = $detail_atk;
            } else {
                $i = 0; //reset variable
                $indexIdAtk++;
                $dt[$indexIdAtk]["id"] = $row->id;
                $dt[$indexIdAtk]["tanggal"] = $row->tanggal;
                $dt[$indexIdAtk]["id_user"] = $row->id_user;
                $dt[$indexIdAtk]["user"] = $row->users;
                $dt[$indexIdAtk]["no_notadinas"] = $row->no_notadinas;
    
                $detail_atk = $this->_detail_atk($row);
                $dt[$indexIdAtk]["detail_atk"][$i]  = $detail_atk;
    
                $temp["id_atk"] = $row->id;
            }
            $i++;
        }
    
        return $dt;
    }
    
    function _detail_atk($row){
        $dt = array('id_atk' => $row->id,
                    'barang' => $row->barang,
                    'satuan' => $row->satuan,
                    'qty_request' => $row->qty_request,
                    'qty_approval' => $row->qty_approval,
              );
    
        return $dt;
    }

}

/* End of file Report_atk_model.php */
