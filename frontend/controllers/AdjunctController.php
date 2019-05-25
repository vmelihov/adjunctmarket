<?php

namespace frontend\controllers;

use common\models\Adjunct;
use common\models\User;
use common\src\helpers\Helper;
use frontend\forms\AdjunctProfileForm;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

class AdjunctController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['profile', 'index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => self::isInstitution(),
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'profile' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return bool
     */
    public static function isInstitution(): bool
    {
        try {
            /** @var User $user */
            $user = Helper::getUserIdentity();
            return $user->isInstitution();
        } catch (Throwable $e) {
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $adjuncts = Adjunct::find()
            ->joinWith('user', false)
            ->where(['=', 'user.user_type', User::TYPE_ADJUNCT])
            ->andWhere(['=', 'user.status', User::STATUS_ACTIVE])
            ->all();

        return $this->render('index', ['adjuncts' => $adjuncts]);
    }

    /**
     * @return string|Response
     */
    public function actionProfile()
    {
        $model = new AdjunctProfileForm();

        if ($post = Yii::$app->request->post()) {
            if ($model->load($post) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Profile is saved success');

                return $this->redirect(['site/profile']);
            }

            Yii::$app->session->setFlash('error', $model->getErrors());
        }

        return $this->goHome();
    }
}