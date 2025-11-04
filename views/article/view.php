<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Article $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <p class="text-muted">
        <small> 
            <b> Created At: <?php echo Yii::$app->formatter->asRelativeTime($model ->created_at) ?></b>
        <br>
            <b> By: <?php echo $model->createdBy->username ?></b>

        </small>

    </p>

    <?php if(!Yii::$app->user->isGuest):?>


    <p>
        <?= Html::a('Update', ['update', 'slug' => $model->slug], ['class' => 'btn btn-primary']) ?>

        <?= Html::a('Delete', ['delete', 'slug' => $model->slug], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php endif?>


    <div>
        <?php echo $model->getEncodedBody();?>
    </div>

</div>
