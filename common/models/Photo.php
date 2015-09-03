<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Photo model
 *
 * @property integer $id
 * @property string $photoName
 * @property integer $albumId
 * @property integer $userId
 */

class Photo extends ActiveRecord
{

    public static function tableName()
    {
        return 'photo';
    }

    public function rules()
    {
        return [
            [['photoName'], 'string'],
            [['id','albumId','userId'], 'integer'],
            [['albumId','photoName'], 'safe'],
            [['photoName'], 'string', 'max' => 50],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     *
     */


    public function getAlbums()
    {
        return $this->hasOne(Albums::className(), ['id' => 'albumId']);
    }

    /**
     * Check if the photo has already been liked
     * @return bool
     */
    public function likedAlready(){
        return (!Like::findOne(['photoId' => $this->id, 'userId' => Yii::$app->user->id])) ? false : true;
    }

}