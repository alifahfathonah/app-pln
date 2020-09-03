<?php 

function datetime2mysql($dt)
{
    $var = explode(" ", $dt);
    $var1 = explode("/", $var[0]);
    $var2 = (string) $var1[2] . "-" . $var1[1] . "-" . $var1[0];
    return $var2 . " " . $var[1];
}

function date2mysql($tgl)
{
    $new = NULL;
    $tgl = explode("/", $tgl);
    if (empty($tgl[2])) {
        return "";
    }
    $new = (string) $tgl[2] . "-" . $tgl[1] . "-" . $tgl[0];
    return $new;
}

function tanggal_indo($tanggal, $cetak_hari = false,$singkat_hari = false, $singkat_bulan = false){
    if ($singkat_hari) {
        $hari = array ( 1 => 'Sen','Sel','Rab','Kam','Jum','Sab','Min');
    }else{
        $hari = array ( 1 => 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu');
    }
    
    if ($singkat_bulan) {
        $bulan = array (1 => 'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des');
    }else{
        $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    }
            
    $split    = explode('-', $tanggal);
    $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
    
    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num] . ', ' . $tgl_indo;
    }
    return $tgl_indo;
}