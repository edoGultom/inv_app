function func(id_bkn) {
    var induk = $('#' + id_bkn);
    var iconStyle = $("#icon" + id_bkn);

    if (induk.hasClass('show' + id_bkn)) {
        $(".anakTingkat2" + id_bkn).hide();
        induk.removeClass('show' + id_bkn);
        iconStyle.text('add_circle');
        iconStyle.css("color", "#34A1DA");
    } else {
        if (localStorage.getItem(id_bkn)) {
            if (document.querySelector('.anakTingkat2' + id_bkn) != null) {
                $(".anakTingkat2" + id_bkn).show();
            } else {
                datas = JSON.parse(localStorage.getItem(id_bkn));
                datas.forEach(item => {
                    // cek status ukm dan plt //
                    if(item['anak_status_ukm'] == '1'){
                        isBadgeUkm = '<span class="badge badge-info-custom d-flex align-items-center me-2">UNIT KERJA MANDIRI</span>';
                    } else {
                        isBadgeUkm = '';
                    } 

                    if(item['anak_plt_pns_id']){
                        isBadgePlt = '<span class="badge badge-warning-custom d-flex align-items-center">PIMPINAN PLT</span>';
                    } else {
                        isBadgePlt = '';
                    } 
                    
                    // cek status end //
                    if (item['anak_icon'] == true) {
                        induk.append(`
                                        <li class="anakTingkat2` + id_bkn + `" style="list-style-type: none;">
                                            <a href="javascript: void(0);" class="d-flex align-items-center">
                                                <span class="material-symbols-outlined align-middle me-1" 
                                                      style="color: #34A1DA;" 
                                                      id="icon`+ item['anak_id_bkn'] + `" 
                                                      onclick="func(`+ `'${item['anak_id_bkn']}'` + `)">add_circle
                                                </span>
                                                <object>
                                                    <a href="view?id=`+ item['anak_id'] + `" role="modal-remote" class="linkTingkatAnak">` + item['anak_nama_unor'] + `</a>
                                                </object>
                                                `
                                                + isBadgeUkm + isBadgePlt +
                                                `
                                            </a>
                                            <ul id="` + item['anak_id_bkn'] + `" style="padding-left: 42px;"></ul></li>
                                     `);
                    } else {
                        induk.append(`
                                        <li class="anakTingkat2` + id_bkn + `" style="list-style-type: none;">
                                            <a href="javascript: void(0);" class="d-flex align-items-center">
                                                <object>
                                                    <a href="view?id=`+ item['anak_id'] + `" role="modal-remote" class="linkTingkatAnak">` + item['anak_nama_unor'] + `</a>
                                                </object>
                                                `
                                                + isBadgeUkm + isBadgePlt +
                                                `
                                            </a>
                                            <ul id="` + item['anak_id_bkn'] + `" style="padding-left: 42px;"></ul></li>
                                     `);
                    }

                })
            }
            induk.addClass('show' + id_bkn);
            iconStyle.text('remove_circle');
            iconStyle.css("color", "#DC3545");
        } else {
            $.ajax({
                type: "GET",
                url: "/adminkinerja/ajax-load/data-unor-tree",
                data: { id_bkn: id_bkn },
                success: function (data) {
                    if (data != "") {
                        arr = [];
                        data.forEach(item => {
                            // cek status ukm dan plt //
                            if(item['status_ukm'] == '1'){
                                isBadgeUkm = '<span class="badge badge-info-custom d-flex align-items-center me-2">UNIT KERJA MANDIRI</span>';
                            } else {
                                isBadgeUkm = '';
                            } 

                            if(item['plt_pns_id']){
                                isBadgePlt = '<span class="badge badge-warning-custom d-flex align-items-center">PIMPINAN PLT</span>';
                            } else {
                                isBadgePlt = '';
                            } 
                            
                            // cek status end //

                            if (item['isIcon'] == true) {

                                induk.append(`
                                            <li class="anakTingkat2` + id_bkn + `" style="list-style-type: none;">
                                                <a href="javascript: void(0);" class="d-flex">
                                                    <span class="material-symbols-outlined align-middle me-1" 
                                                        style="color: #34A1DA;" 
                                                        id="icon`+ item['id_bkn'] + `" 
                                                        onclick="func(`+ `'${item['id_bkn']}'` + `)">add_circle
                                                    </span>
                                                    <object>
                                                        <a href="view?id=`+ item['id'] + `" role="modal-remote" class="linkTingkatAnak">` + item['nama_unor'] + `</a>
                                                    </object>
                                                    `
                                                    + isBadgeUkm + isBadgePlt +
                                                    `
                                                </a>
                                                <ul id="` + item['id_bkn'] + `" style="padding-left: 42px;">
                                                    
                                            `);
                            } else {
                                induk.append(`
                                            <li class="anakTingkat2` + id_bkn + `" style="list-style-type: none;">
                                                <a href="javascript: void(0);" class="d-flex">
                                                    <object>
                                                        <a href="view?id=`+ item['id'] + `" role="modal-remote" class="linkTingkatAnak">` + item['nama_unor'] + `</a>
                                                    </object>
                                                    `
                                                    + isBadgeUkm + isBadgePlt +
                                                    `
                                                </a>
                                                <ul id="` + item['id_bkn'] + `" style="padding-left: 42px;">
                                            `);
                            }

                            const myObject = {
                                indukId: id_bkn,
                                anak_id: item['id'],
                                anak_id_bkn: item['id_bkn'],
                                anak_nama_unor: item['nama_unor'],
                                anak_icon: item['isIcon'],
                                anak_status_ukm: item['status_ukm'],
                                anak_diatasan_id: item['diatasan_id'],
                                anak_cepat_kode: item['cepat_kode'],
                                anak_eselon: item['eselon'],
                                anak_pemimpin_pns_id: item['pemimpin_pns_id'],
                                anak_pemimpin_non_pns_id: item['pemimpin_non_pns_id'],
                                anak_plt_pns_id: item['plt_pns_id'],
                            }
                            arr.push(myObject);
                        });
                        localStorage.setItem(id_bkn, JSON.stringify(arr));
                        induk.addClass('show' + id_bkn);
                        iconStyle.text('remove_circle');
                        iconStyle.css("color", "#DC3545");
                    }
                },
                error: function () {
                    console.log("Gagal Ambil Data");
                }
            })
        }

    }
}
