<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Users;

/**
 * UsersRegisterSearch represents the model behind the search form about `backend\models\Users`.
 */
class UsersRegisterSearch extends Users
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'partner_id'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'type', 'partner_id'], 'safe'],
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
        if(Yii::$app->user->identity->type=='admin') {
            $query = Users::find();
        }else if(Yii::$app->user->identity->type=='partner'){
            $query = Users::find()->where([
                'partner_id' => Yii::$app->user->identity->id,
                'status' => 10
            ])->orWhere([
                'id' => Yii::$app->user->identity->id,
                'status' => 10
            ]);
        }else if(Yii::$app->user->identity->type=='client'){
            $query = Users::find()->where([
                'id' => Yii::$app->user->identity->id,
                'status' => 10
            ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'updated_at' => SORT_DESC,
                    'name' => SORT_ASC,
                ]
            ],
        ]);

        if ($this->load($params) && !$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'partner_id' => $this->partner_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'partner_id', $this->partner_id])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
