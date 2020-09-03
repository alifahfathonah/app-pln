<link rel="stylesheet" href="<?= base_url() . 'assets/css/print-A4.css' ?>">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan ATK</title>

    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        table.table {
            border-collapse: collapse;
        }

        table.table, thead, tbody, th, td {
            padding: 5px;
            border: 1px solid black;
        }

        table#table-no-border thead, tbody, th, td{
            padding: 5px;
            border: 0;
        }

        .center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="page">
        <?php foreach($atk as $a): ?>
            <br>
            <table width="100%" id="table-no-border">
                <tr>
                    <td width="20%">No. Nota Dinas</td>
                    <td width="1%">:</td>
                    <td width="79%"><?= $a['no_notadinas']; ?></td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td><?= $a['tanggal']; ?></td>
                </tr>
                <tr>
                    <td>User</td>
                    <td>:</td>
                    <td><?= $a['user']; ?></td>
                </tr>
            </table>
            <table width="100%" class="table">
                <thead style="background-color: #F1F1F1">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Request QTY</th>
                        <th>Satuan</th>
                        <th>Approval QTY</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <?php foreach($a['detail_atk'] as $da): ?>
                    <tbody>
                        <tr>
                            <td><?= $da['barang']; ?></td>
                            <td class="center"><?= $da['qty_request']; ?></td>
                            <td class="center"><?= $da['satuan']; ?></td>
                            <td class="center"><?= $da['qty_approval']; ?></td>
                            <td class="center"><?= $da['satuan']; ?></td>
                        </tr>
                    </tbody>
                <?php endforeach ?>
            </table>
        <?php endforeach ?>
    </div>
</body>
</html>