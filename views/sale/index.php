<?php

use app\models\Sale;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SaleSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Sales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Sale', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'uploaded_by',
                'label' => 'Uploaded By',
                'value' => function ($model) {
                    return $model->uploader ? $model->uploader->username : 'Unknown';
                },
            ],
            'price',
            'description:ntext',
            //'contact',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
                'label' => 'Created At',
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
                'label' => 'Updated At',
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Sale $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

</div>
