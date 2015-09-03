<?php

namespace common\models;

use Yii;

use yii\data\ActiveDataProvider;
/**
 * SearchPhoto model
 *
 * @property integer $id
 * @property string $photoName
 * @property integer $albumId
 * @property integer $userId
 */

class SearchPhotos extends Profile
{

    public function rules()
    {
        return [
            [['id','userId', 'albumId'], 'integer'],
            [['photoName'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = Photo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'userId' => $this->userId,
            'albumId' => $this->albumId,
        ]);

        $query->andFilterWhere(['like', 'photoName', $this->photoName]);

        return $dataProvider;
    }
}
