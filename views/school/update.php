<?php


use yii\helpers\Html;

/** @var \app\models\School $model */

$this->title = 'Редактировать ' . $model->name;
$this->params['breadcrumbs'][] = 'Редактирование';
?>
    <div class="school-update">
    <div class="substrate">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
<?= $this->render('_form',
    [
        'model' => $model,
    ]
) ?>
</div>