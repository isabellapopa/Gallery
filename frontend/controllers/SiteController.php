<?php
namespace frontend\controllers;

use Yii;



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
                        'actions' => ['logout'],
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
    public function actionAbout()
    {
        return $this->render('about');
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
            $model->assignRole('freeUser');
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
    public function actionPremium(){


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
            '4'=> 'April',
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
        for(; $currYear <= 2025; $currYear++) {
            $years[$currYear] = $currYear;
        }

        if (isset($_POST['Premium'])) {
            $model->cardType= $_POST['Premium']['cardType'];
            $model->monthAccountDisable = $_POST['Premium']['monthAccountDisable'];
            $model->yearAccountDisable = $_POST['Premium']['yearAccountDisable'];
            $model->userId=Yii::$app->user->identity->getId();
            $model->accountType = 'premium';
            if ($model->save()) {
                $model->assignRole('premiumUser');
                $this->redirect(['index']);
            } else {
                VarDumper::dump($model->getErrors(), 10, true); exit;
            }
        }
        return $this->render('premium',[
            'model' => $model,
            'cardType' => $type,
            'years' => $years,
            'month' =>$month,
        ]);
    }
    public function actionUpload()
    {
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

    public function actionPhoto()
    {
        $model = new Photo();
        $fileName = '';
        $uploadPath = 'frontend/images';

        if (isset($_FILES[$fileName])) {
            $file = \yii\web\UploadedFile::getInstanceByName($fileName);

            if ($file->saveAs($uploadPath . '/' . $file->name)) {
                    $model->photoName = $fileName;
                    echo \yii\helpers\Json::encode($file);
                VarDumper::dump($model->getErrors(), 10, true); exit;
            }


        }

        return $this->render('photo',[
            'model' => $model
    ]);

    }

    public function actionCreateAlbum()
    {
        $model = new Albums();
        if (isset($_POST['Albums'])) {
            $model->name = $_POST['Albums']['name'];
            $model->description = $_POST['Albums']['description'];
            $model->tag = $_POST['Albums']['tag'];
            $model->userId = Yii::$app->user->getId();
            if ($model->save() ) {
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



}
