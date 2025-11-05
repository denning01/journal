<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\widgets\ActiveForm $form */
/** @var app\models\Sale $model */
?>

<div class="sale-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'] // 🔥 Required for file upload
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <?php if ($model->image): ?>
    <p>Current image:</p>
    <img src="<?= Yii::getAlias('@web/' . $model->image) ?>" width="150">
<?php endif; ?>


    <div class="form-group mt-3">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
