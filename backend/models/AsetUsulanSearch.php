<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PeminjamanBarang;

/**
 * AsetUsulanSearch represents the model behind the search form about `common\models\PeminjamanBarang`.
 */
class AsetUsulanSearch extends PeminjamanBarang
{
    public $cari;
    public $rowdata;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_barang', 'id_user', 'id_verifikator', 'jumlah'], 'integer'],
            [['cepat_kode_unit', 'nama_barang', 'tanggal_pinjam', 'tanggal_kembali', 'keterangan', 'status'], 'safe'],
            [['cari','rowdata'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $this->load($params);
        $query = PeminjamanBarang::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => (!empty($this->rowdata)) ? $this->rowdata : 10,
            ],
        ]);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $cari_angka = '';
        if(is_numeric($this->cari)){
            $cari_angka = $this->cari;
        }

        $query->andFilterWhere(['or',
            ['id' => $cari_angka],
            ['id_barang' => $cari_angka],
            ['id_user' => $cari_angka],
            ['id_verifikator' => $cari_angka],
            ['jumlah' => $cari_angka],
            ['tanggal_pinjam' => $cari_angka],
            ['tanggal_kembali' => $cari_angka],
            ['like', 'cepat_kode_unit', $this->cari],
            ['like', 'nama_barang', $this->cari],
            ['like', 'keterangan', $this->cari],
            ['like', 'status', $this->cari],
        ]);
        // $query->andFilterWhere(['like', '', $this->cari]);
        return $dataProvider;
    }
}
