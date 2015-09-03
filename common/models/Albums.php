<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Album model
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $tag
 * @property integer $numberPhotos
 * @property integer $userId
 */

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
    public function getId(){
        return $this->id;
    }
    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['albumId' => 'id']);
    }

}
