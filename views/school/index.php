<?php

/** @var yii\web\View $this */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Список школ';
$this->params['breadcrumbs'][] = $this->title;
/* @var $schools */
?>
<div class="school-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Список школ</p>
    <?= Html::a('Добавить обр. учреждение', ['create'], ['class' => 'btn btn-success']); ?>
    <?=
    GridView::widget([
        'dataProvider' => $schools,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'label' => 'Название образовательного учреждения'
            ],
            [
                'attribute' => 'region',
                'label' => 'Регион',
                'value' => function ($model) {
                    return Yii::$app->regions->getList()[$model->region];
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]);
    ?>
</div>
