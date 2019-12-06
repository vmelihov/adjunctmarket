<?php
namespace frontend\controllers;

use common\models\User;
use common\src\helpers\Helper;
use frontend\forms\PasswordResetRequestForm;
use frontend\forms\SignupForm;
use frontend\forms\VerifyEmailForm;
use frontend\models\profile\ProfileBuilder;
use frontend\src\MyLinkedIn;
use Throwable;
use Yii;
use yii\authclient\ClientInterface;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @param ClientInterface $client
     * @return mixed|Response
     * @throws Exception
     * @throws \yii\db\Exception
     */
    public function onAuthSuccess(ClientInterface $client)
    {
        if ($client->getName() === MyLinkedIn::DEFAULT_NAME) {
            $attributes = $client->getUserAttributes();

            $email = $attributes['email'];

            $user = User::findByEmail($email);

            if ($user) {
                // log in
                Yii::$app->user->login($user);
            } else {
                // registration
                $password = Yii::$app->security->generateRandomString(8);
                $user = new User([
                    'first_name' => $attributes['firstName'],
                    'last_name' => $attributes['lastName'],
                    'email' => $attributes['email'],
                    'password' => $password,
                    'user_type' => User::TYPE_ADJUNCT,
                    'status' => User::STATUS_ACTIVE,
                ]);
                $user->generateAuthKey();
                $user->generatePasswordResetToken();

                if ($user->save()) {

                    $profile = ProfileBuilder::build($user);
                    $profile->getForm()->save();

                    Yii::$app->user->login($user);

                    return $this->actionProfile();
                }

                Yii::$app->session->setFlash('error', 'Sorry');
            }
        }

        return $this->goHome();
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
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
        return $this->render('index', [
            'popup' => Yii::$app->session->getFlash('popup'),
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     * @throws \yii\db\Exception
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $user = Helper::getUserIdentity();

            if ($user && !$user->profile) {
                return $this->actionProfile();
            }

            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
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
     * Signs user up.
     *
     * @return mixed
     * @throws Exception
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ActiveForm::validate($model, ['email']);
            }

            if ($model->signup()) {
                Yii::$app->session->setFlash('popup', [
                    'text' => 'We have sent an email with a confirmation link to your email address',
                    'class' => 'm-mail',
                ]);

                return $this->goHome();
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
     * @throws Exception
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                $text = 'If an account exists for <a href="">' . $model->email . '</a>, you will get an email with instructions on resetting your password. If it doesn\'t arrive, be sure to check your spam folder.';
                Yii::$app->session->setFlash('popup', ['text' => $text, 'class' => 'm-restore']);

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
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
     * @throws Exception
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @return Response
     * @throws Exception
     * @throws BadRequestHttpException
     * @throws Throwable
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {

            $profile = ProfileBuilder::build($user);
            $profile->getForm()->save();

            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->actionProfile();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    /**
     * @return mixed
     * @throws \yii\db\Exception
     */
    public function actionProfile()
    {
        $user = Helper::getUserIdentity();

        if ($user) {
            $profile = ProfileBuilder::build($user);

            return $this->render($profile->getViewName(), [
                'model' => $profile->getForm(),
                'user' => $user,
            ]);
        }

        Yii::$app->session->setFlash('error', 'User undefined');

        return $this->goHome();
    }
}
