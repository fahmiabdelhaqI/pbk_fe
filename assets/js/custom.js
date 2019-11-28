function cariProvinsi(provinsi) {
    let provinsi1 = provinsi;

    if(provinsi === 'ACEH') {
        provinsi1 = 'Nanggroe Aceh Darussalam (NAD)';
    }
    else if(provinsi === 'BALI') {
        provinsi1 = 'Bali';
    }
    else if(provinsi === 'BANTEN') {
        provinsi1 = 'Banten';
    }
    else if(provinsi === 'BENGKULU') {
        provinsi1 = 'Bengkulu';
    }
    else if(provinsi === 'DI YOGYAKARTA') {
        provinsi1 = 'DI Yogyakarta';
    }
    else if(provinsi === 'DKI JAKARTA') {
        provinsi1 = 'DKI Jakarta';
    }
    else if(provinsi === 'GORONTALO') {
        provinsi1 = 'Gorontalo';
    }
    else if(provinsi === 'JAMBI') {
        provinsi1 = 'Jambi';
    }
    else if(provinsi === 'JAWA BARAT') {
        provinsi1 = 'Jawa Barat';
    }
    else if(provinsi === 'JAWA TENGAH') {
        provinsi1 = 'Jawa Tengah';
    }
    else if(provinsi === 'JAWA TIMUR') {
        provinsi1 = 'Jawa Timur';
    }
    else if(provinsi === 'KALIMANTAN BARAT') {
        provinsi1 = 'Kalimantan Barat';
    }
    else if(provinsi === 'KALIMANTAN SELATAN') {
        provinsi1 = 'Kalimantan Selatan';
    }
    else if(provinsi === 'KALIMANTAN TENGAH') {
        provinsi1 = 'Kalimantan Tengah';
    }
    else if(provinsi === 'KALIMANTAN TIMUR') {
        provinsi1 = 'Kalimantan Timur';
    }
    else if(provinsi === 'KALIMANTAN UTARA') {
        provinsi1 = 'Kalimantan Utara';
    }
    else if(provinsi === 'KEP. BANGKA BELITUNG') {
        provinsi1 = 'Bangka Belitung';
    }
    else if(provinsi === 'KEP. RIAU') {
        provinsi1 = 'Kepulauan Riau';
    }
    else if(provinsi === 'LAMPUNG') {
        provinsi1 = 'Lampung'
    }
    else if(provinsi === 'MALUKU UTARA') {
        provinsi1 = 'Maluku Utara';
    }
    else if(provinsi === 'MALUKU') {
        provinsi1 = 'Maluku';
    }
    else if(provinsi === 'NUSA TENGGARA BARAT') {
        provinsi1 = 'Nusa Tenggara Barat (NTB)';
    }
    else if(provinsi === 'NUSA TENGGARA TIMUR') {
        provinsi1 = 'Nusa Tenggara Timur (NTT)';
    }
    else if(provinsi === 'PAPUA') {
        provinsi1 = 'Papua';
    }
    else {
        provinsi1 = 'Papua Barat';
    }

    return provinsi1;
}

$(document).on("change", "#provinsi", function (e) {
    e.preventDefault();
    let provinsi = "";
    $.each($("#provinsi option:selected"), function () {
        provinsi = $(this).val();
    });

    //Ajax
    $.ajax({
        type: 'POST',
        url: '../api/fetch_kodepos_kota.php',
        data: 'provinsi='+cariProvinsi(provinsi),
        dataType: 'json',
        success: function (response_kota) {
            if(provinsi === '' || provinsi === null) {
                $('#kota').empty();
                $("#kota").attr('disabled', true);
            }
            else {
                $('#kota').empty();
                $('#kota').attr('disabled', false);

                for(var i = 0; i < response_kota.length; i++) {
                    $('#kota').append('<option value="'+response_kota[i].kota+'">'+response_kota[i].kota+'</option>')
                }
            }
        }
    });
});

$(document).on("change", "#kota", function (e) {
    e.preventDefault();
    let kota = "";
    $.each($("#kota option:selected"), function () {
        kota = $(this).val();
    });

    //Ajax
    $.ajax({
        type: 'POST',
        url: '../api/fetch_kodepos_kecamatan.php',
        data: 'kota='+kota,
        dataType: 'json',
        success: function (response_kecamatan) {
            if(kota === '' || kota === null) {
                $('#kecamatan').empty();
                $("#kecamatan").attr('disabled', true);
            }
            else {
                $('#kecamatan').empty();
                $('#kecamatan').attr('disabled', false);

                for(var i = 0; i < response_kecamatan.length; i++) {
                    $('#kecamatan').append('<option value="'+response_kecamatan[i].kecamatan+'">'+response_kecamatan[i].kecamatan+'</option>')
                }
            }
        }
    });
});

$(document).on("change", "#kecamatan", function (e) {
    e.preventDefault();
    let kecamatan = "";
    $.each($("#kecamatan option:selected"), function () {
        kecamatan = $(this).val();
    });

    //Ajax
    $.ajax({
        type: 'POST',
        url: '../api/fetch_kodepos_kelurahan.php',
        data: 'kecamatan='+kecamatan,
        dataType: 'json',
        success: function (response_kelurahan) {
            if(kecamatan === '' || kecamatan === null) {
                $('#kelurahan').empty();
                $("#kelurahan").attr('disabled', true);
            }
            else {
                $('#kelurahan').empty();
                $('#kelurahan').attr('disabled', false);

                for(var i = 0; i < response_kelurahan.length; i++) {
                    $('#kelurahan').append('<option value="'+response_kelurahan[i].kelurahan+'">'+response_kelurahan[i].kelurahan+'</option>')
                }
            }
        }
    });
});

$(document).on("change", "#kelurahan", function (e) {
    e.preventDefault();
    let kelurahan = "";
    $.each($("#kelurahan option:selected"), function () {
        kelurahan = $(this).val();
    });

    //Ajax
    $.ajax({
        type: 'POST',
        url: '../api/fetch_kodepos.php',
        data: 'kelurahan='+kelurahan,
        dataType: 'json',
        success: function (response_kodepos) {
            if(kelurahan === null || kelurahan === '') {
                document.getElementById('kode_pos').value = '';
            }
            for(var i = 0; i < response_kodepos.length; i++) {
                document.getElementById('kode_pos').value = response_kodepos[i].kode_pos;
            }
        }
    });
});


/*** Smartwizard ***/
    // Toolbar extra buttons
var btnFinish = $('<button></button>').text('Finish')
        .addClass('btn btn-info')
        .on('click', function(){
            if( !$(this).hasClass('disabled')){
                var elmForm = $("#myForm");
                if(elmForm){
                    elmForm.validator('validate');
                    var elmErr = elmForm.find('.with-error');
                    if(elmErr && elmErr.length > 0){
                        alert('Oops we still have error in the form');
                        return false;
                    }else{
                        alert('Great! we are ready to submit form');
                        elmForm.submit();
                        return false;
                    }
                }
            }
        });
var btnCancel = $('<button></button>').text('Cancel')
    .addClass('btn btn-danger')
    .on('click', function(){
        $('#smartwizard').smartWizard("reset");
        $('#myForm').find("input, textarea").val("");
    });

var btnSubmit = $('<input type="submit" value="SUBMIT" class="btn btn-success"/>').on('click', function () {
    confirm('Yakin data sudah lengkap?');
});

// Smart Wizard
$('#smartwizard').smartWizard({
    selected: 0,
    keyNavigation: false,
    theme: 'arrows',
    transitionEffect:'fade',
    toolbarSettings: {
        toolbarPosition: 'bottom',
        toolbarExtraButtons: [btnSubmit, btnCancel]
    },
    anchorSettings: {
        markDoneStep: true, // add done css
        markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
        removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
        enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
    }
});

$("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
    var elmForm = $("#form-step-" + stepNumber);
    // stepDirection === 'forward' :- this condition allows to do the form validation
    // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
    if(stepDirection === 'forward' && elmForm){
        elmForm.validator('validate');
        var elmErr = elmForm.children('.has-error');
        if(elmErr && elmErr.length > 0){
            // Form validation failed
            return false;
        }
    }
    return true;
});

$("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
    // Enable finish button only on last step
    if(stepNumber == 3){
        $('.btn-finish').removeClass('disabled');
    }else{
        $('.btn-finish').addClass('disabled');
    }
});

/*** End of Smartwizard ***/


//Date Picker
$('#tanggal_lahir').datepicker({
    format: 'yyyy-mm-dd',
    // startDate: '-3d'
});

$('#pendapatan_tahunan, #project_amount, #hrgotr, #dpkons, #angs, #taksasi').keyup(function (event) {
    // skip for arrow keys
    if(event.which >= 37 && event.which <= 40) return;

    // format number
    $(this).val(function(index, value) {
        return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            ;
    });
});

$('#bidang_pekerjaan, #provinsi').select2({
    placeholder: '--- Pilih salah satu ---',
    allowClear: true
});

$('#pekerjaan').select2({
    placeholder: '--- Pilih Bidang Pekerjaan terlebih dahulu ---',
    allowClear: true
});

$('#kota').select2({
    placeholder: '--- Pilih Provinsi terlebih dahulu ---',
    allowClear: true
});

$('#kecamatan').select2({
    placeholder: '--- Pilih Kota/Kabupaten terlebih dahulu ---',
    allowClear: true
});

$('#kelurahan').select2({
    placeholder: '--- Pilih Kecamatan terlebih dahulu ---',
    allowClear: true
});

if(localStorage.getItem('nik')) {
    document.getElementById('nik').value = localStorage.getItem('nik');
}