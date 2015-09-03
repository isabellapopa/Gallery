<?php
namespace frontend\controllers;

use common\models\Comment;
use Yii;


use yii\data\ActiveDataProvider;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\Premium;
use common\models\Profile;
use common\models\Upload;
use yii\web\UploadedFile;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use common\models\Albums;
use common\models\Photo;
use common\models\Like;
use yii\web\HttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'like'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],

        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */

    // Photos Gallery for all users
    public function actionGallery()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Albums::find()->with('photos'),
        ]);

        return $this->render('gallery', [
            'listDataProvider' => $dataProvider,
        ]);
    }

    public function actionSaveComment()
    {
        /**
         * @var Comment $model
         */
        if (Yii::$app->request->isPost) {
            if (isset($_POST['photoId']) && isset($_POST['Comment']) && isset($_POST['Comment']['commentText'])) {
                $model = new Comment();
                $model->userId = Yii::$app->user->id;
                $model->photoId = $_POST['photoId'];
                $model->commentText = $_POST['Comment']['commentText'];
                $model->save();
            }
        }

    }

    /**
     * Save a like for a photo
     * @params integer $_REQUEST['photoId']
     * @return string
     */
    public function actionLike()
    {
        /**
         * @var Like $model
         */
        if (isset($_REQUEST['photoId']) && $_REQUEST['photoId']) {
            $photo = Photo::findOne($_REQUEST['photoId']);

            if ($photo && !$photo->likedAlready()) {
                $model = new Like();
                $model->photoId = $photo->id;
                $model->userId = Yii::$app->user->id;
                if ($model->save()) {
                    echo json_encode(['message' => 'liked']);
                    Yii::$app->end();
                }
            }
        }
        echo json_encode(['message' => 'not liked']);
        Yii::$app->end();
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }


        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


    public function actionPremium()
    {

        /**
         * @var Premium $model
         */

        $model = new Premium();
        $type = [
            'visa' => 'Visa',
            'maestro' => 'Maestro',
            'mastercard' => 'MasterCard'
        ];
        $month = [
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];
        $years = [];
        $currYear = intval(date('Y'));
        for (; $currYear <= 2025; $currYear++) {
            $years[$currYear] = $currYear;
        }

        if (isset($_POST['Premium'])) {
            $model->cardType = $_POST['Premium']['cardType'];
            $model->monthAccountDisable = $_POST['Premium']['monthAccountDisable'];
            $model->yearAccountDisable = $_POST['Premium']['yearAccountDisable'];
            $model->userId = Yii::$app->user->identity->getId();
            $model->accountType = 'premium';
            if ($model->save()) {
                $model->assignRole('premiumUser');// when users makes a premium account they can have nelimited  albums and photoa
                $this->redirect(['index']);
            } else {
                VarDumper::dump($model->getErrors(), 10, true);
                exit;
            }
        }
        return $this->render('premium', [
            'model' => $model,
            'cardType' => $type,
            'years' => $years,
            'month' => $month,
        ]);
    }


    //Upload for profile picture
    public function actionUpload()
    {


        /**
         * @var Upload $model
         */
        $modelUpload = new Upload();
        if (!empty($_FILES)) {
            if (Yii::$app->request->isPost) {
                $modelUpload->userId = Yii::$app->user->getId();
                $modelUpload->imageFile = UploadedFile::getInstance($modelUpload, 'imageFile');
                if ($modelUpload->upload()) {
                    echo '<img src="/images/profilePicture/' . $modelUpload->imageFile->baseName . '.' . $modelUpload->imageFile->extension . '"/>';
                    return $this->redirect('index');
                }
            }
        }
        return $this->render('upload', [
            'modelUpload' => $modelUpload,
        ]);
    }

    //Upload for albums photos
    public function actionPhoto($albumId)
    {

        /**
         * @var Photo $model
         */
        $model = new Photo();
        $fileName = 'file';
        $uploadPath = dirname(dirname(__FILE__)) . '/images';
        $counter = 0;
        if (isset($_FILES['file'])) {
            $file = \yii\web\UploadedFile::getInstanceByName($fileName);

            if ($file->saveAs($uploadPath . '/' . $file->name)) {
                $counter++;
                $model->photoName = $file->name;
                $model->albumId = $albumId;
                $model->userId = Yii::$app->user->getId();
                if (Yii::$app->user->hasRole('freeUser')) {
                    if ($counter == 10) $this->redirect(['premium']);
                    else {
                        if ($model->save() && $counter < 10) {
                            echo json_encode($file);

                        } else {
                            VarDumper::dump($model->getErrors(), 10, true);
                            exit;
                        }
                    }
                }else{
                    if ($model->save()) {
                        echo json_encode($file);

                    } else {
                        VarDumper::dump($model->getErrors(), 10, true);
                        exit;
                    }

                }
            }
        }


            return $this->render('photo', [
                'model' => $model,
                'albumId' => $albumId
            ]);
        }

    // Delete albums photos
    public function actionDeletePhoto($id)
    {
        $model = Photo::find()->where(['id' => $id])->one();
        if ($model && $model->delete())
            $this->redirect(['photos']);

    }

    // Create new album
    public function actionCreateAlbum()
    {

        /**
         * @var Albums $model
         */
        $model = new Albums();
        $counter=0;
            if (isset($_POST['Albums'])) {
                $model->name = $_POST['Albums']['name'];
                $model->description = $_POST['Albums']['description'];
                $model->tag = $_POST['Albums']['tag'];
                $model->userId = Yii::$app->user->getId();
                if ($counter < 1) {
                    if (Yii::$app->user->hasRole('freeUser')) $counter++;
                    else $counter = 0;
                }
                if ($model->save() && $counter == 0) {

                    $this->redirect(['albums']);
                }


            }

        return $this->render('createAlbum', [
            'model' => $model,
        ]);
    }

    public function actionAlbums()
    {
        $albums = Albums::find()->all();
        return $this->render('albums', [
            'albums' => $albums,
        ]);
    }

    //view each user photos
    public function actionViewPhotos()
    {
        $photos = Photo::find()->all();
        $albums = Albums::find()->all();
        return $this->render('viewPhotos', [
            'photos' => $photos,
            'albums' => $albums,
        ]);
    }

    //edit user profile
    public function actionProfile()
    {

        return $this->render('profile');
    }

    protected function findModel($id)
    {
        if (($model = Albums::findOne($id)) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }

}
