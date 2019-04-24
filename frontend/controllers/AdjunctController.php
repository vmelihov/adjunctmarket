<?php

namespace frontend\controllers;

use frontend\forms\AdjunctForm;
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
                'only' => ['profile'],
                'rules' => [
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
     * @return string|Response
     */
    public function actionProfile()
    {
        $model = new AdjunctForm();

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