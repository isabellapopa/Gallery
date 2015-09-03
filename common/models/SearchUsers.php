<?php

namespace common\models;

use Yii;

use yii\data\ActiveDataProvider;

/**
 * SearchProfile model
 *
 * @property integer $id
 * @property string $lastName
 * @property string $firstName
 * @property string $phone
 * @property string $address
 * @property integer $skypeId
 * @property integer $userId
 */
class SearchUsers extends Profile
{

    public function rules()
    {
        return [
            [['id','userId', 'skypeId',], 'integer'],
            [['firstName','lastName','phone','address'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = Profile::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'userId' => $this->userId,
            'skypeId' => $this->skypeId,
        ]);

        $query->andFilterWhere(['like', 'firstName', $this->firstName])
            ->andFilterWhere(['like', 'lastName', $this->lastName])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
