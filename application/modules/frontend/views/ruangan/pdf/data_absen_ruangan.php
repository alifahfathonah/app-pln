<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Hadir Ruangan</title>
    <link rel="stylesheet" href="<?= base_url() . 'assets/css/print-A4.css' ?>">
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
        }

        table#table-header {
            border-collapse: collapse;
        }

        table#table-peserta {
            border-collapse: collapse;
        }

        table#table-header  td {
            padding: 3px;
            border: 1px solid black;
        }

        table#table-peserta th, table#table-peserta td {
            padding: 3px;
            border: 1px solid black;
        }

        table#table-no-border thead, tbody, th, td{
            border: 0;
        }

        table#data td, td {
            border-bottom: 1px;
        }

        .center {
            text-align: center;
        }

        #text-sub-banner {
            font-size: 10pt;
        }
    </style>
</head>
<body>
    <div class="page">
        <table width="100%" id="table-header">
            <tr>
                <td width="10%" rowspan="3"><img src="assets/images/logo-pln-2.jpg" width="80"></td>
                <td width="33%" rowspan="3">
                    <span id="text-banner"><b>PLT PLN (PERSERO)<br>UNIT INDUK DISTRIBUSI<br>BANTEN</span></b><br>
                    <span id="text-sub-banner">Jl. Jendral Sudirman No. 1 Sukasari Kota Tangerang, Banten 15118<br>Telp : (021) 5526716</span>
                </td>
                <td class="center" width="14%" rowspan="3"><b>FORMULIR</b></td>
                <td class="center" width="23%">NO. DOKUMEN</td>
                <td width="25%">HAL : <b>1 - 2</b></td>
            </tr>
            <tr>
                <td class="center" rowspan="2"><b>FR-DBTN-W-7-01</b></b></td>
                <td>TGL : <?= date('d-m-Y'); ?></td>
            </tr>
            <tr>
                <td>REV : 3</td>
            </tr>
            <tr>
                <td class="center" colspan="5"><b>DAFTAR HADIR</b></td>
            </tr>
        </table>
        <br><br>
        <table width="100%" id="table-data">
            <tr>
                <td width="20%"><b>Unit/Tempat</b></td>
                <td width="1%">:</td>
                <td style="border-bottom: 1px solid black" wdith="79%"><?= $booking->ruangan ?></td>
            </tr>
            <tr>
                <td><b>Tgl/Pukul</b></td>
                <td>:</td>
                <td style="border-bottom: 1px solid black" ><b><?= tanggal_indo($booking->tanggal_mulai) ?> / <?= $booking->time_mulai ?></b></td>
            </tr>
            <tr>
                <td><b>Pemimpin</b></td>
                <td>:</td>
                <td style="border-bottom: 1px solid black" ><?= $booking->diajukan_oleh ?></td>
            </tr>
            <tr>
                <td><b>Topik</b></td>
                <td>:</td>
                <td style="border-bottom: 1px solid black" ><b><?= $booking->nama_kegiatan ?></b></td>
            </tr>
            <tr>
                <td><b>Peserta</b></td>
                <td>:</td>
                <td style="border-bottom: 1px solid black" >-</td>
            </tr>
            <tr>
                <td><b>Lampiran</b></td>
                <td>:</td>
                <td style="border-bottom: 1px solid black" ><?= $booking->keterangan; ?></td>
            </tr>
        </table>
        <br><br>
        <table width="100%" id="table-peserta">
            <tr style="background-color:lightblue">
                <th>NO.</th>
                <th>NAMA</th>
                <th>UNIT/BAGIAN/BIDANG</th>
                <th>EMAIL</th>
                <th>NO. HP</th>
                <th>TANDA TANGAN</th>
            </tr>
            <?php $no = 1; foreach($absensi as $row): ?>
                <tr>
                    <td class="center "><?= $no++ ?></td>
                    <td><?= $row->nama ?></td>
                    <td><?= $row->divisi ?></td>
                    <td><?= $row->email ?></td>
                    <td><?= $row->telp_wa ?></td>
                    <td class="center">Hadir</td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</body>
</html>