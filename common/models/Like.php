<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * ActiveRecord model for table 'like'
 *
 * @property integer $id
 * @property integer $photoId
 * @property integer $userId
 */

class Like extends ActiveRecord
{

    public static function tableName()
    {
        return 'like';
    }

    public function rules()
    {
        return [
            [['photoId','userId'], 'integer'],
            [['photoId','userId'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Like ID',
            'userId' => 'User ID',
            'photoId' => 'Photo ID'
        ];
    }

}
