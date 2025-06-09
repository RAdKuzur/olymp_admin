<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/** @var User $model */
?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('Email(username)'); ?>
<?= $form->field($model, 'password_hash')->textInput(['maxlength' => true])->label('Пароль(Хэш)'); ?>
<?= $form->field($model, 'surname')->textInput(['maxlength' => true])->label('Фамилия'); ?>
<?= $form->field($model, 'firstname')->textInput(['maxlength' => true])->label('Имя'); ?>
<?= $form->field($model, 'patronymic')->textInput(['maxlength' => true])->label('Отчество'); ?>

<?= $form->field($model, 'phone_number')->widget(\yii\widgets\MaskedInput::className(), [
    'mask' => '+7 (999) 999-99-99',
])->label('Телефон'); ?>

<?= $form->field($model, 'gender')->dropDownList(
    Yii::$app->genders->getList()
)->label('Пол'); ?>
<?= $form->field($model, 'role')->dropDownList(
    Yii::$app->roles->getList()
)->label('Роль'); ?>
<?= $form->field($model, 'birthdate')->widget(DatePicker::class, [
    'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
    'options' => ['class' => 'form-control'],
    'clientOptions' => [
        'changeYear' => true,
        'changeMonth' => true,
        'yearRange' => '1900:' . date('Y'),
    ]
])->label('Дата рождения'); ?>

<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>