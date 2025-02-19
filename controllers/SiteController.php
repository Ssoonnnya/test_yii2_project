<?php
namespace app\controllers;

use app\models\SignupForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    const LOGIN_ATTEMPTS_FILE = '@runtime/login_attempts.txt';
    const MAX_ATTEMPTS = 3;
    const BLOCK_TIME = 300;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'profile'],
                'rules' => [
                    [
                        'actions' => ['logout', 'profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Registration successful.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['profile']);
        }

        $model = new LoginForm();

        $attemptsData = $this->getLoginAttempts();
        $remainingTime = self::BLOCK_TIME - (time() - $attemptsData['last_attempt_time']);

        if ($attemptsData['attempts'] >= self::MAX_ATTEMPTS && $remainingTime > 0) {
            Yii::$app->session->setFlash('error', "Try again in {$remainingTime} seconds.");
            return $this->render('login', ['model' => $model]);
        }

        if ($model->load(Yii::$app->request->post())) {
            $user = User::findOne(['username' => $model->username]);

            if ($user && Yii::$app->security->validatePassword($model->password, $user->password_hash)) {
                Yii::$app->user->login($user, 3600);
                $this->resetLoginAttempts();
                return $this->redirect(['profile']);
            } else {
                $model->addError('password', 'Wrong credentials');
                $this->incrementLoginAttempts();
            }
        }


        return $this->render('login', ['model' => $model]);
    }

    private function resetLoginAttempts()
    {
        file_put_contents(Yii::getAlias(self::LOGIN_ATTEMPTS_FILE), json_encode([
            'attempts' => 0,
            'last_attempt_time' => 0
        ]));
    }

    private function incrementLoginAttempts()
    {
        $attemptsData = $this->getLoginAttempts();
        $attemptsData['attempts']++;
        $attemptsData['last_attempt_time'] = time();
        file_put_contents(Yii::getAlias(self::LOGIN_ATTEMPTS_FILE), json_encode($attemptsData));
    }

    private function getLoginAttempts()
    {
        if (file_exists(Yii::getAlias(self::LOGIN_ATTEMPTS_FILE))) {
            $data = json_decode(file_get_contents(Yii::getAlias(self::LOGIN_ATTEMPTS_FILE)), true);
            return $data ?: ['attempts' => 0, 'last_attempt_time' => 0];
        }
        return ['attempts' => 0, 'last_attempt_time' => 0];
    }

    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }

        return $this->render('profile', [
            'username' => Yii::$app->user->identity->username,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
