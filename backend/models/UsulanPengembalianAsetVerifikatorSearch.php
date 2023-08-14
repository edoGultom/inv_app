<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PengembalianBarang;

/**
 * UsulanPengembalianAsetVerifikatorSearch represents the model behind the search form about `common\models\PengembalianBarang`.
 */
class UsulanPengembalianAsetVerifikatorSearch extends PengembalianBarang
{
    public $cari;
    public $rowdata;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_peminjaman_barang', 'jumlah', 'terlambat', 'jumlah_denda'], 'integer'],
            [['tanggal_pinjam', 'tanggal_kembali'], 'safe'],
            [['cari', 'rowdata'], 'safe'],
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
        $query = PengembalianBarang::find();

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
        if (is_numeric($this->cari)) {
            $cari_angka = $this->cari;
        }

        $query->andFilterWhere([
            'or',
            ['id' => $cari_angka],
            ['id_peminjaman_barang' => $cari_angka],
            ['jumlah' => $cari_angka],
            ['tanggal_pinjam' => $cari_angka],
            ['tanggal_kembali' => $cari_angka],
            ['terlambat' => $cari_angka],
            ['jumlah_denda' => $cari_angka],

        ]);
        // $query->andFilterWhere(['like', '', $this->cari]);
        return $dataProvider;
    }
}
