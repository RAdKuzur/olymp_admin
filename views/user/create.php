<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \app\models\User $model */

$this->title = 'Создание пользователя';
$this->params['breadcrumbs'][] = 'Создание';
?>
<div class="user-create">
    <div class="substrate">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
    <?= $this->render('_form',
        [
            'model' => $model,
        ]
    ) ?>
</div>
