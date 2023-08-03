$(document).on("click", ".btn-akses", function (e) {
    e.preventDefault();
    var url = $(this).data('ajaxload');
    var target = $(this).data('ajaxtarget');

    $(target).html("Proses");
    $.ajax({
        type: "POST",
        url: url,
        data: {},
        success: function (status) {
            if (status == 0) {
                $.pjax.reload({container: '#crud-datatable-pjax', async: false});
                $(target).html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-1 align-middle"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Pilih');
                $(target).attr("class", "btn btn-info btn-block btn-akses");
            } else {
                $.pjax.reload({container: '#crud-datatable-pjax', async: false});
                $(target).html('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle me-1 align-middle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> Terpilih');
                $(target).attr("class", "btn btn-success btn-block btn-akses");
            }

        },
        error: function () {
            console.log("Gagal Ambil Data");
        }
    })
});

function func(id){
    // alert(id);
    $("#form-akses"+id).submit();
}

function func2(id){
    // alert(id);
    $("#form-akses2"+id).submit();
}

