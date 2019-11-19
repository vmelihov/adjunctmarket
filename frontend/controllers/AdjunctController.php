<?php

namespace frontend\controllers;

use common\models\Adjunct;
use common\models\User;
use common\src\helpers\FileHelper;
use common\src\helpers\Helper;
use frontend\forms\AdjunctProfileForm;
use frontend\models\AdjunctSearch;
use frontend\models\profile\strategy\AdjunctProfile;
use Throwable;
use Yii;
use yii\base\Exception;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper as YiiFileHelper;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;
use yii\web\UploadedFile;

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
                        'allow' => !self::isInstitution(),
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
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
        if (!$user = Helper::getUserIdentity()) {
            $this->goHome();
        }

        $params = Yii::$app->request->getQueryParams();
        $page = Yii::$app->request->post('page', 0);
        $searchModel = new AdjunctSearch();

        $dataProvider = $searchModel->search($params, $page);

        $string = '';
        if (Yii::$app->request->isAjax) {
            foreach ($dataProvider->getModels() as $adjunct) {
                $string .= $this->renderPartial('_one', [
                    'adjunct' => $adjunct,
                    'user' => $user,
                ]);
            }

            return $string;
        }

        $favorites = $user->profile->getFavoriteAdjuncts();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'favorites' => $favorites,
        ]);
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionView(int $id): string
    {
        $user = Helper::getUserIdentity();
        $adjunct = Adjunct::findOne($id);

        return $this->render('view', [
            'adjunct' => $adjunct,
            'user' => $user,
        ]);
    }

    /**
     * @return string|Response
     * @throws Exception
     * @throws UserException
     */
    public function actionProfile()
    {
        $user = Helper::getUserIdentity();

        if ($user && $post = Yii::$app->request->post()) {

            /** @var AdjunctProfileForm $model */
            $model = (new AdjunctProfile($user))->getForm();
            $model->teaching_experience = $post['teaching_experience'] ?? 0;
            $model->uploadedFile = UploadedFile::getInstance($model, 'image_file');

            if ($model->load($post) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Profile is saved success');
            }

            Yii::$app->session->setFlash('error', $model->getErrors());

            return $this->render('profile', [
                'model' => $model,
                'user' => $user,
            ]);
        }

        return $this->goHome();
    }

    /**
     * @param string $fileName
     * @return Response
     * @throws Exception
     */
    public function actionUnlink(string $fileName)
    {
        if (!$user = Helper::getUserIdentity()) {
            $this->goHome();
        }

        /** @var Adjunct $profile */
        $profile = $user->profile;
        $documents = $profile->getDocumentsArray();

        $key = array_search($fileName, $documents, false);

        if ($key !== false) {
            $folder = FileHelper::getDocumentFolder($user->getId());
            $path = $folder . '/' . $fileName;
            YiiFileHelper::unlink($path);

            unset($documents[$key]);
            $profile->documents = json_encode($documents);
            $profile->save();
        }

        return $this->redirect(['site/profile']);
    }
}