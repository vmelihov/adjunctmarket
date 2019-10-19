<?php

namespace frontend\controllers;

use common\models\User;
use common\src\helpers\FileHelper;
use common\src\helpers\Helper;
use frontend\forms\ProposalForm;
use Throwable;
use Yii;
use common\models\Proposal;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\FileHelper as YiiFileHelper;
use yii\web\Response;

class ProposalController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'edit', 'update', 'delete', 'publish', 'unpublish'],
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create', 'edit', 'update', 'delete', 'publish', 'unpublish'],
                        'allow' => self::isAdjunct(),
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['POST'],
                    'update' => ['POST'],
                ]
            ],
        ];
    }

    /**
     * @return bool
     */
    public static function isAdjunct(): bool
    {
        try {
            /** @var User $user */
            $user = Helper::getUserIdentity();
            return $user->isAdjunct();
        } catch (Throwable $e) {
        }

        return false;
    }

    /**
     * Lists all Proposal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Proposal::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Proposal model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Proposal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new ProposalForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['vacancy/view', 'id' => $model->vacancy_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws Exception
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEdit($id)
    {
        $proposal = $this->findModel($id);
        $model = ProposalForm::createByProposal($proposal);

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionUpdate()
    {
        $model = new ProposalForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['vacancy/view', 'id' => $model->vacancy_id]);
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Proposal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id)
    {
        $proposal = $this->findModel($id);
        $user = Helper::getUserIdentity();
        $vacancyId = $proposal->vacancy_id;

        if ($user) {
            $folder = FileHelper::getVacancyFolder($user->getId(), $vacancyId);
            YiiFileHelper::removeDirectory($folder);
        }

        $proposal->delete();

        return $this->redirect(['vacancy/view', 'id' => $vacancyId]);
    }

    /**
     * @param int $proposalId
     * @param string $fileName
     * @return Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUnlink(int $proposalId, string $fileName)
    {
        $proposal = $this->findModel($proposalId);
        $user = Helper::getUserIdentity();

        $attaches = $proposal->getAttachesArray();
        $key = array_search($fileName, $attaches, false);

        if ($user && $key !== false) {
            $folder = FileHelper::getVacancyFolder($user->getId(), $proposal->vacancy_id);
            $path = $folder . '/' . $fileName;
            YiiFileHelper::unlink($path);

            unset($attaches[$key]);
            $proposal->attaches = json_encode($attaches);
            $proposal->save();
        }

        return $this->redirect(['edit', 'id' => $proposalId]);
    }

    /**
     * Finds the Proposal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Proposal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Proposal::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
