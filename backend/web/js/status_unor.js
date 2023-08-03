function setStatusOpd(id_bkn) {
    $.ajax({
        type: "POST",
        url: "/adminkinerja/unor/set-status-opd?id_bkn="+id_bkn,
        data: {},
        success: function (status) {
            // alert(status);
            $.pjax.reload({container: '#unor-pjax', async: false});
            if (status == 1) {
                $(this).attr('checked','checked');
                $('#target-'+id_bkn).text('Aktif');
            } else {
                $(this).removeAttr('checked');
                $('#target-'+id_bkn).text('Tidak Aktif');
            }

        },
        error: function () {
            console.log("Gagal Ambil Data");
        }
    })
}

function setStatusUkm(id_bkn, diatasan_id) {
    $.ajax({
        type: "POST",
        url: "/adminkinerja/unor/set-status-ukm?id_bkn="+id_bkn,
        data: {},
        success: function (status) {
            $.pjax.reload({container: '#unor-pjax', async: false});
            if (status == 1) {
                datas = JSON.parse(localStorage.getItem(diatasan_id));
                datas.forEach(item => {
                   if(item['anak_id_bkn'] == id_bkn) {
                        item['anak_status_ukm'] = '1';
                   }
                });
                
                localStorage.setItem(diatasan_id, JSON.stringify(datas));

                $(this).attr('checked','checked');
                $('#target-ukm'+id_bkn).text('Aktif');
            } else {
                datas = JSON.parse(localStorage.getItem(diatasan_id));
                datas.forEach(item => {
                   if(item['anak_id_bkn'] == id_bkn) {
                        item['anak_status_ukm'] = '0';
                   }
                });
                
                localStorage.setItem(diatasan_id, JSON.stringify(datas));

                $(this).removeAttr('checked');
                $('#target-ukm'+id_bkn).text('Tidak Aktif');
            }

        },
        error: function () {
            console.log("Gagal Ambil Data");
        }
    })
}