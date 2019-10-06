<?php

namespace frontend\controllers;

use frontend\forms\InstitutionProfileForm;
use \Exception;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\log\Logger;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;
use yii\web\UploadedFile;

class InstitutionController extends Controller
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
        $model = new InstitutionProfileForm();

        if ($post = Yii::$app->request->post()) {
            try {
                if ($model->load($post)) {

                    $model->uploadedFile = UploadedFile::getInstance($model, 'image_file');

                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Profile is saved success');
                    } else {
                        Yii::$app->session->setFlash('error', 'Error saving profile');
                    }

                } else {
                    Yii::$app->session->setFlash('error', 'Error saving profile');
                }
            } catch (Exception $e) {
                Yii::$app->session->setFlash('error', 'Error saving profile');
                Yii::getLogger()->log('Error creating profile. ' . $e->getMessage(), Logger::LEVEL_ERROR);
            }

            return $this->render('@frontend/views/site/institution', [
                'model' => $model,
            ]);
        }

        return $this->goHome();
    }
}