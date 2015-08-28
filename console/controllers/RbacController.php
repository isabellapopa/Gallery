<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * Creates the roles
     */
    public function actionInit()
    {

        $auth = Yii::$app->authManager;
        $createAlbum = $auth->createPermission('createAlbum');
        $createAlbum->description = 'Create more than 1 album';
        $auth->add($createAlbum);
        $createPhoto = $auth->createPermission('createPhoto');
        $createAlbum->description = 'Upload max 10 photos';
        $auth->add($createAlbum);
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $freeUser = $auth->createRole('freeUser');
        $auth->add($freeUser);
        $premiumUser = $auth->createRole('premiumUser');
        $auth->add($premiumUser);
        $auth->addChild($premiumUser, $createAlbum);
    }

    public function actionAssign($role, $userId = 0)
    {
        if($userId == 0) $userId = 1;
        /* @var \yii\rbac\DbManager $auth */
        $auth = Yii::$app->authManager;
        $roleClass = $auth->getRole($role);
        $auth->assign($roleClass, $userId);
        echo "Ok"."\n";
    }
    public function actionRevoke($role, $userId = 0) {
        if($userId == 0) $userId = 1;
        /* @var \yii\rbac\DbManager $auth */
        $auth = Yii::$app->authManager;
        $roleClass = $auth->getRole($role);
        $auth->revoke($roleClass, $userId);
        echo "Ok"."\n";
    }
}
