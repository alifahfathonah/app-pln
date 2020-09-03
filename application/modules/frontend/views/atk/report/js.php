<script>
    $(function() {
        $("#tanggal-awal, #tanggal-akhir").datepicker({
            format: 'dd/mm/yyyy',
            endDate: new Date()
        }).on('changeDate', function() {
            $(this).datepicker('hide');
        });
    });

    function cetak_laporan() {
        window.open(
            '<?= base_url("frontend/report_atk/print_pdf") ?>?' + $('#form-report-atk').serialize(),
            '_blank' // <- This is what makes it open in a new window.
        );
    }
</script>