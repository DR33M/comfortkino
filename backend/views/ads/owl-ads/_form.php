<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\ImagesAsset;

ImagesAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\ads\OwlAds */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="owl-ads-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($file, 'imageFiles')->fileInput(['class' => 'view-img-after-dwn', 'data-image-name' => 'model-owl-backgrounds']) ?>
    <?php if (isset($model['background_image_name'])): ?>
        <img class="model-owl-backgrounds" src="<?= Yii::getAlias('@frontend_link') . Yii::getAlias('@owl-backgrounds') . $model['background_image_name']; ?>" alt="image" />
    <?php endif; ?>

    <?= $form->field($model, 'button_text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'movie_theaters_id')->textInput() ?>

    <?= $form->field($model, 'end_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
