<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \app\models\Participant $model */
/** @var \app\models\User $users */
/** @var \app\models\School $schools */
?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<?= $form->field($model, 'user_id')->dropDownList(\yii\helpers\ArrayHelper::map($users, 'id', 'fullFio'))->label('Пользователь'); ?>
<?= $form->field($model, 'disability')->dropDownList(Yii::$app->disabilities->getList())->label('Ограничения по здоровью'); ?>
<?= $form->field($model, 'class')->dropDownList(Yii::$app->classes->getList())->label('Класс обучения'); ?>
<?= $form->field($model, 'citizenship')->dropDownList(Yii::$app->countries->getList())->label('Гражданство'); ?>
<?= $form->field($model, 'school_id')->dropDownList(\yii\helpers\ArrayHelper::map($schools, 'id', 'name'))->label('Школа'); ?>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
