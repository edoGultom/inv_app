<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * PenggunaSearch represents the model behind the search form about `common\models\User`.
 */
class PenggunaSearch extends User
{
    public $cari;
    public $rowdata;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'id_unit', 'verification_token'], 'safe'],
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
        $query = User::find();

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
            ['status' => $cari_angka],
            ['created_at' => $cari_angka],
            ['updated_at' => $cari_angka],
            ['like', 'username', $this->cari],
            ['like', 'auth_key', $this->cari],
            ['like', 'password_hash', $this->cari],
            ['like', 'password_reset_token', $this->cari],
            ['like', 'email', $this->cari],
            ['like', 'id_unit', $this->cari],
            ['like', 'verification_token', $this->cari],
        ]);
        // $query->andFilterWhere(['like', '', $this->cari]);
        return $dataProvider;
    }
}
