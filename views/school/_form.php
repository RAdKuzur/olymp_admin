<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \app\models\User $model */
?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название образовательного учреждения'); ?>
<?= $form->field($model, 'region')->dropDownList(Yii::$app->regions->getList())->label('Регион'); ?>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
