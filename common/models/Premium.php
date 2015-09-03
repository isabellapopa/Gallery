<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;



/**
 * Premium model
 *
 * @property integer $id
 * @property string $cardType
 * @property string $yearAccountDisable
 * @property integer $monthAccountDisable
 * @property integer $userId
 */
class Premium extends ActiveRecord
{
    public static function tableName()
    {
        return 'account';
    }

    public function rules()
    {
        return [
            [['cardType', 'yearAccountDisable', 'accountType'], 'string'],
            [['userId', 'monthAccountDisable'], 'integer'],
            [['cardType'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Cont ID',
            'userId' => 'User ID',
            'cardType' => 'Card Type',
            'monthAccountDisable' => 'Month Account Disable',
            'yearAccountDisable' => 'Year Account Disable',
            'accountType' => 'Account Type'

        ];
    }

    public function assignRole($role){

        $auth = Yii::$app->authManager;
        $roleClass = $auth->getRole($role);
        $auth->assign($roleClass, $this->userId);
    }

}


