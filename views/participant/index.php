<?php

/** @var yii\web\View $this */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Список участников деятельности';
$this->params['breadcrumbs'][] = $this->title;
/* @var $participants */
?>
<div class="participant-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Список участников деятельности</p>
    <?= Html::a('Добавить участника деятельности', ['create'], ['class' => 'btn btn-success']); ?>
    <?=
    GridView::widget([
        'dataProvider' => $participants,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'fullFio',
                'label' => 'ФИО',
                'value' => function ($model) {
                    return $model->user->getFullFio();
                }
            ],
            [
                'attribute' => 'citizenship',
                'label' => 'Гражданство',
                'value' => function ($model) {
                    return Yii::$app->countries->getList()[$model->citizenship];
                }
            ],
            [
                'attribute' => 'disability',
                'label' => 'ОВЗ',
                'value' => function ($model) {
                    return Yii::$app->disabilities->getList()[$model->disability];
                }
            ],
            [
                'attribute' => 'school_id',
                'label' => 'Обр. учреждение',
                'value' => function ($model) {
                    return $model->school->name;
                }
            ],
            [
                'attribute' => 'class',
                'label' => 'Класс обучения',
                'value' => function ($model) {
                    return Yii::$app->classes->getList()[$model->class];
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]);
    ?>
</div>
