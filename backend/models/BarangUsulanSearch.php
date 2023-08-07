<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PengusulanBarang;

/**
 * BarangUsulanSearch represents the model behind the search form about `common\models\PengusulanBarang`.
 */
class BarangUsulanSearch extends PengusulanBarang
{
    public $cari;
    public $rowdata;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_barang', 'id_user', 'jumlah', 'status'], 'integer'],
            [['cepat_kode_unit', 'nama_barang', 'tanggal', 'keterangan'], 'safe'],
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
        $query = PengusulanBarang::find();

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
            ['jumlah' => $cari_angka],
            ['tanggal' => $cari_angka],
            ['like', 'lower(nama_barang)', strtolower($this->cari)],
            ['like', 'lower(keterangan)', strtolower($this->cari)],
        ]);
        // $query->andFilterWhere(['like', '', $this->cari]);
        return $dataProvider;
    }
}
