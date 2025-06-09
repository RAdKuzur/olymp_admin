<?php

use app\models\User;
use yii\helpers\Html;

/** @var User $model */

$this->title = 'Редактировать ' . $model->getFullFio();
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="user-update">
    <div class="substrate">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
    <?= $this->render('_form',
        [
            'model' => $model
        ]
    ) ?>
</div>