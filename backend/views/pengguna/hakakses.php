<?php
use yii\helpers\Url;
use yii\helpers\Html;



/* @var $this yii\web\View */
/* @var $searchModel verifikasi\models\UsulanBarangNilaiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hak Akses';
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'template' => "<li class='breadcrumb-item active'>{link}</li>\n"
];

// $this->registerJsFile(
//     '@web/js/hak_akses1.js',
//     ['depends' => [\yii\web\JqueryAsset::className()]]
// );

//pembentukan button berdasarkan hak akses
$no=0;
$btns=[];
$keys = [];
foreach ($AuthItem as $data):
    $no++;

    $akses = $data->cekAkses($user_id);

    if ($akses) {
        $btn = "btn-success";
    }
    else{
        $btn = "btn-danger";
    }
    if($data->name == 'Site'){
        $nama = 'Pengaturan Profil';
    }else{
        $nama = $data->name;
    }
    // $btn = "btn-success";
    array_push($keys,$data->name);
    $btns[$data->name] = '
        <div class="col-md-4">
        <button
        role="button"
        class="btn btn-success '. $btn .' btn_akses col-md-12"
        style="color:white"
        data-ajaxload = '.Url::to(['ubah-akses', 'id'=>$user_id, 'auth'=>$data->name]).'
        data-ajaxtarget = "#target'.$no.'"
        data-ajaxdata = "'.$nama.'"
        id = "target'. $no .'">
        '.
        $nama
        .'
        </button>
        </div>
    ';
    // echo $btns[$data->name];
endforeach;
// echo '<pre>'.print_r($keys).'</pre>';
// exit();
?>
<style>
    .badge-success{
        background-color: #67b847;

    }
    .rounded-circle{
        border-radius:100%;
    }
    .badge-danger{
        background-color: #c56d6d ;
    }
    .btn{
        margin-bottom:5px;
    }
</style>
<div class="row" style="margin-top:-25px;">
    <div class="col-md-12 " >
        <h6> Keterangan </h6> <hr>
        <h6> <span class="badge badge-success rounded-circle" style="color:white"> &nbsp&nbsp&nbsp</span> : Aktif</h6>
        <h6> <span class="badge  badge-danger rounded-circle" style="color:white"> &nbsp&nbsp&nbsp</span> : Non Aktif</h6>
    </div>

    <div class="col-md-12">
        <div class="row">
            <?php
                for ($i=0;$i<count($keys);$i++){
                    $value = $keys[$i];
                    echo $btns[$value];
                }
            ?>
        </div>
    </div>
    <hr/>
</div>


<script >
$('button').click(function(){
    var url = $(this).data('ajaxload');
    var data = $(this).data('ajaxdata');
    var target = $(this).data('ajaxtarget');

    $(target).html("Proses");

    $.ajax({
        type: "POST",
        url:url,
        data:{},
        success: function(isi){
            $(target).html(data);
            if(isi == 1){
                $(target).attr("class", "btn btn-success btn_akses col-md-12");
            }else{
                $(target).attr("class", "btn btn-danger btn_akses col-md-12");
            }

        },
        error: function(){
          console.log("Gagal Ambil Data");
        }
    })
});

</script>