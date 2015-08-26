<?php
namespace common\models;

use Yii;

use yii\db\ActiveRecord;

class Premium extends ActiveRecord
{
    public static function tableName()
    {
        return 'account';
    }

    public function rules()
    {
        return [
            [['cardName' , 'accountType'], 'string'],
            [['userId', 'activeAccount'], 'integer'],
            [['cardName'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Cont ID',
            'userId' => 'User ID',
            'cardName' => 'Card Name',
            'activeAccount' => 'Active Account',
        ];
    }

}


