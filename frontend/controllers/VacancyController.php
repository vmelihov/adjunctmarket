<?php

namespace frontend\controllers;

use common\models\User;
use common\src\helpers\Helper;
use frontend\models\VacancySearch;
use Throwable;
use Yii;
use common\models\Vacancy;
use yii\base\InvalidConfigException;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VacancyController implements the CRUD actions for Vacancy model.
 */
class VacancyController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['view', 'create', 'update', 'delete', 'publish', 'unpublish'],
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create', 'update', 'delete', 'publish', 'unpublish'],
                        'allow' => self::isInstitution(),
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'create' => ['POST'],
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
        } catch (Throwable $e) {}

        return false;
    }

    /**
     * Lists all Vacancy models.
     * @return mixed
     * @throws InvalidConfigException
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->getQueryParams();
        $page = Yii::$app->request->post('page', 0);
        $user = Helper::getUserIdentity();
        $searchModel = new VacancySearch();

        // todo разнести всю эту срань по стратегиям
        if ($user) {
            $view = $user->isInstitution() ? 'index_institution' : 'index_adjunct';
            $oneView = $user->isInstitution() ? '_one_institution' : '_one_adjunct';
            if ($user->isInstitution()) {
                $params[$searchModel->formName()]['institution_user_id'] = $user->getId();
            } else {
                $params[$searchModel->formName()]['deleted'] = 0;
            }
        } else {
            $view = 'index';
            $oneView = '_one';
            $params[$searchModel->formName()]['deleted'] = 0;
        }

        if (isset($params['ff'])) {
            $searchModel->fastFilter = $params['ff'];
        }

        $dataProvider = $searchModel->search($params, $page);

        $string = '';
        if (Yii::$app->request->isAjax) {
            foreach ($dataProvider->getModels() as $vacancy) {
                if ($user && $user->isAdjunct()) {
                    $viewParams = ['model' => $vacancy, 'adjunct' => $user->profile];
                } else {
                    $viewParams = ['model' => $vacancy];
                }
                $string .= $this->renderPartial($oneView, $viewParams);
            }

            return $string;
        }

        return $this->render($view, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vacancy model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        /** @var User $user */
        $user = Helper::getUserIdentity();

        if ($user->isAdjunct()) {
            Vacancy::incrementView($id);
            $view = 'view_adjunct';
        } else {
            $view = 'view_institution';
        }

        return $this->render($view, [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Vacancy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vacancy();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Vacancy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionPublish($id)
    {
        $model = $this->findModel($id);
        $model->deleted = 0;
        $model->save();

        return $this->redirect('index');
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUnpublish($id)
    {
        $model = $this->findModel($id);
        $model->deleted = 1;
        $model->save();

        return $this->redirect('index');
    }

    /**
     * Deletes an existing Vacancy model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @return int
     * @throws NotFoundHttpException
     */
    public function actionProposal(): int
    {
        if (Yii::$app->request->isAjax) {
            $params = Yii::$app->request->post();

            if (!$params['action'] || !$params['proposalId'] || !$params['vacancyId']) {
                return 0;
            }

            $vacancy = $this->findModel($params['vacancyId']);

            if (!$vacancy) {
                return 0;
            }

            if ($params['action'] === 'save') {
                $vacancy->addSavedProposal($params['proposalId']);
            } elseif ($params['action'] === 'remove') {
                $vacancy->removeSavedProposal($params['proposalId']);
            }

            return 1;
        }

        return 0;
    }

    /**
     * Finds the Vacancy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vacancy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vacancy::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
