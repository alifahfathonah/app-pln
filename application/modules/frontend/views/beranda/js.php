<script>
    $(function () {
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

            var Hari = thisDay + ', ' + day + ' ' + months[month] + ' ' + year;
            //document.write();

            var now = new Date();
            var secs = ('0' + now.getSeconds()).slice(-2);
            var mins = ('0' + now.getMinutes()).slice(-2);
            var hr = ('0' + now.getHours()).slice(-2);
            var Time = " - " + hr + " : " + mins + " : " + secs + " WIB";
            document.getElementById("jam").innerHTML = Hari + Time;
            requestAnimationFrame(clock);
        }
</script>