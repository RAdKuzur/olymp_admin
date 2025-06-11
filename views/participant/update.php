<?php


use yii\helpers\Html;

/** @var \app\models\Participant $model */
/** @var \app\models\School $schools */
/** @var \app\models\User $users */

$this->title = 'Редактировать ' . $model->user->getFullFio();
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="participant-update">
    <div class="substrate">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
    <?= $this->render('_form',
        [
            'model' => $model,
            'users' => $users,
            'schools' => $schools
        ]
    ) ?>
</div>