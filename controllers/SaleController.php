<?php

namespace app\controllers;

use Yii;
use app\models\Sale;
use app\models\SaleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * SaleController implements the CRUD actions for Sale model.
 */
class SaleController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                // 🔒 Access control
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['create', 'update', 'delete'],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'], // logged-in users only
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Sale models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SaleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sale model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Sale model.
     * Only logged-in users can create.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Sale();

        if ($model->load(Yii::$app->request->post())) {
            $model->uploaded_by = Yii::$app->user->id; // 🔒 assign uploader
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->upload() && $model->save(false)) {
                Yii::$app->session->setFlash('success', 'Sale added successfully!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Sale model.
     * Only the owner (uploaded_by) can update.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // 🔒 Ensure current user owns this sale
        if ($model->uploaded_by !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('You don’t have permission to update this sale.');
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile && $model->upload()) {
                $model->save(false);
            } else {
                $model->save();
            }
            Yii::$app->session->setFlash('success', 'Sale updated successfully!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Sale model.
     * Only the owner (uploaded_by) can delete.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // 🔒 Ensure current user owns this sale
        if ($model->uploaded_by !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('You don’t have permission to delete this sale.');
        }

        $model->delete();
        Yii::$app->session->setFlash('success', 'Sale deleted successfully!');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Sale model based on its primary key value.
     * If not found, throws 404.
     * @param int $id
     * @return Sale
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Sale::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested sale does not exist.');
    }
}
