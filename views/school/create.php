<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
/** @var \app\models\School $model */


$this->title = 'Создание обр. учреждений';
$this->params['breadcrumbs'][] = 'Создание';
?>
<div class="school-create">
    <div class="substrate">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
    <?= $this->render('_form',
        [
            'model' => $model,
        ]
    ) ?>
</div>
