function validation(element, error_string, data)
{
    if (data.error_string[error_string]) {
        $(element).addClass('is-invalid');
        $(element).next().html(data.error_string[error_string]);
    }
}

function validation_live(element, message)
{
    if (message) {
        $(element).addClass('is-invalid');
        $(element).next().html(message);
    }
}
function validation_select_live(element, message)
{
    if (message) {
        $(element).addClass('is-invalid');
        $(element).after('<div class="error mt-1" style="font-weight: normal; color: #DC3545; font-size: 12.8px;"><i>' + message + '</i></div>').closest('.form-control, .custom-select').removeClass('has-success').addClass('has-error is-invalid');
    }
}

function validation_select(element, error_string, data)
{
    if (data.error_string[error_string]) {
        $(element).addClass('is-invalid');
        $(element).after('<div class="error mt-1" style="font-weight: normal; color: #DC3545; font-size: 12.8px;"><i>' + data.error_string[error_string] + '</i></div>').closest('.form-control, .custom-select').removeClass('has-success').addClass('has-error is-invalid');
    }
}

function validation_select2(element, error_string, data) {
    if (data.error_string[error_string]) {
        $(element).next().remove();
        $(element).next().after('<div class="error mt-1" style="font-weight: normal; color: #DC3545; font-size: 12.8px;"><i>' + data.error_string[error_string] + '</i></div>').closest('.form-control, .custom-select').removeClass('has-success').addClass('has-error is-invalid');
    }
}

function validation_remove(element) {
    $(element).removeClass('is-invalid');
}

function validation_remove_select2(element) {
    $(element).next().remove();
    $(element).closest('.form-control, .custom-select').removeClass('has-error is-invalid');
}

function validation_remove_select(element) {
    // $(element).next().remove();
    $(element).closest('.form-control, .custom-select, select2').removeClass('has-error is-invalid');
}

function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function datetimefmysql(waktu, status) {
    if (status === undefined) {
        if ((waktu !== undefined) & (waktu !== null) & (waktu !== '')) {
            var el = waktu.split(' ');
            var tgl= datefmysql(el[0]);
            var tm = el[1].split(':');
            return tgl+' '+tm[0]+':'+tm[1];
        } else {
            return '-';
        }
    } else {
        if ((waktu !== undefined) & (waktu !== null) & (waktu !== '')) {
            var el = waktu.split(' ');
            var tgl= datefmysql(el[0]);
            var tm = el[1].split(':');
            return tgl;
        } else {
            return '-';
        }
    }
    
}

function datefmysql(tanggal) {
    if (tanggal !== undefined && tanggal !== null && tanggal !== 'null') {
        var elem = tanggal.split('-');
        var tahun = elem[0];
        var bulan = elem[1];
        var hari  = elem[2];
        return hari+'/'+bulan+'/'+tahun;
    } else {
        return '';
    }
}