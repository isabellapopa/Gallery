<?php

namespace common\models;

use Yii;

use yii\data\ActiveDataProvider;
/**
 * SearchAlbum model
 *
 * @property integer $id
 *  @property integer $userId
 * @property string $name
 * @property string $description
 * @property string $tag
 * @property integer $numberPhotos
 */
class SearchAlbums extends Profile
{

    public function rules()
    {
        return [
            [['id','userId', 'numberPhotos'], 'integer'],
            [['name','description','tag'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = Albums::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'userId' => $this->userId,
            'numberPhotos' => $this->numberPhotos,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'tag', $this->tag]);

        return $dataProvider;
    }
}
