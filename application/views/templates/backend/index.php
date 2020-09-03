<!doctype html>
<html lang="en">

<?php $this->load->view('templates/backend/header') ?>

<body>
    <div class="app-container app-theme-white fixed-sidebar fixed-header body-tabs-shadow">
        <!-- Header -->
        <?php $this->load->view('templates/backend/navbar') ?>
        <!-- End Header -->

        <div class="app-main">
            <!-- Menu -->
            <?php $this->load->view('templates/backend/menu') ?>
            <!-- End Menu -->

            <div class="app-main__outer">
                <div class="app-main__inner">
                    <!-- Content -->
                    <div id="content">
                        <?php echo $content; ?>
                    </div>
                    <!-- End Content -->
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?= base_url() ?>assets/datatables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/datatables/datatables.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/admin/assets/scripts/main.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/sweetalert2/sweetalert2.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/syam.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/relcopy.jquery.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script>
        $(function() {
            requestAnimationFrame(clock);
        });

        function clock() {
            var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];

            var date = new Date();
            var day = date.getDate();
            var month = date.getMonth();
            var thisDay = date.getDay(),
                thisDay = myDays[thisDay];

            var yy = date.getYear();

            var year = (yy < 1000) ? yy + 1900 : yy;

            var Hari = '<i class="fas fa-calendar-alt"></i>  ' + thisDay + ', ' + day + ' ' + months[month] + ' ' + year;
            //document.write();

            var now = new Date();
            var secs = ('0' + now.getSeconds()).slice(-2);
            var mins = ('0' + now.getMinutes()).slice(-2);
            var hr = ('0' + now.getHours()).slice(-2);
            var Time = " - <i class='fas fa-clock'></i> : " + hr + " : " + mins + " : " + secs + " WIB";
            document.getElementById("jam").innerHTML = Hari + Time;
            requestAnimationFrame(clock);
        }
    </script>
</body>

</html>

<?php
    if (isset($modal)) : 
        foreach ($modal as $mod) : $this->load->view($mod); endforeach; 
    endif;
?>