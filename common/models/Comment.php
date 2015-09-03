<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class Comment
 * @package common\models
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $photoId
 * @property string  $commentText
 */

class Comment extends ActiveRecord
{

    public static function tableName()
    {
        return 'comment';
    }

    public function rules()
    {
        return [
            [['photoId','userId'], 'integer'],
            [['commentText'], 'string'],
            [['photoId','userId','commentText'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Like ID',
            'userId' => 'User ID',
            'photoId' => 'Photo ID',
            'commentText' => 'Comment'
        ];
    }

}
