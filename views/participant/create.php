<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
/** @var \app\models\User $users */
/** @var \app\models\Participant $model */
/** @var \app\models\School $schools */

$this->title = 'Создание участника деятельности';
$this->params['breadcrumbs'][] = 'Создание';
?>
<div class="participant-create">
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
