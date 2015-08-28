<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Albums extends ActiveRecord
{

    public static function tableName()
    {
        return 'album';
    }

    public function rules()
    {
        return [
            [['name','description','tag'], 'string'],
            [['numberPhotos'], 'integer'],
            [['numberPhotos','name','description'], 'safe'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Album ID',
            'userId' => 'User ID',
            'name' => 'Album Name',
            'description' => 'Description Album',
            'numberPhotos' => 'Number Photos'
        ];
    }

}
