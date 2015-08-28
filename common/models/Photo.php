<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Photo extends ActiveRecord
{

    public static function tableName()
    {
        return 'photo';
    }

    public function rules()
    {
        return [
            [['photoName','description','tag'], 'string'],
            [['albumId','userId'], 'integer'],
            [['albumId','photoName','description'], 'safe'],
            [['photoName'], 'string', 'max' => 50],
        ];
    }




    public function getAlbum()
    {
        return $this->hasOne(Album::className(), ['id' => 'albumId']);
    }


}
