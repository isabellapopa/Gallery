<?php
namespace common\models;

use Yii;

use yii\db\ActiveRecord;


/**
 * Profile model
 *
 * @property integer $id
 * @property string $lastName
 * @property string $firstName
 * @property string $phone
 * @property string $address
 * @property integer $skypeId
 * @property integer $userId
 */

class Profile extends ActiveRecord
{
    public static function tableName()
    {
        return 'users';
    }
    public function rules()
    {
        return [
            [['lastName', 'firstName', 'phone', 'profilePicture', 'address'], 'string'],
            [['skypeId','userId'], 'integer'],
            [['firstName'], 'string', 'max' => 50],
            [['lastName'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 10]
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'Profile ID',
            'userId' => 'User ID',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'username' => 'Username',
            'phone' => 'Phone',
            'address' => 'Address',
            'profilePicture' => 'Profile Picture',
        ];
    }
    /**
     * @return User
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

}
