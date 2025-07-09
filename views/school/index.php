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
            ],[
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}', // задаем порядок и наличие кнопок
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $url = \yii\helpers\Url::to(['view', 'id' => $model->id]);
                        return Html::a('Просмотр', $url, ['class' => 'btn btn-sm btn-primary']);
                    },
                    'update' => function ($url, $model, $key) {
                        $url = \yii\helpers\Url::to(['update', 'id' => $model->id]);
                        return Html::a('Редактировать', $url, ['class' => 'btn btn-sm btn-warning']);
                    },
                    'delete' => function ($url, $model, $key) {
                        $url = \yii\helpers\Url::to(['delete', 'id' => $model->id]);
                        return Html::a('Удалить', $url, [
                            'class' => 'btn btn-sm btn-danger',
                            'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                            'data-method' => 'post',
                        ]);
                    },
                ],
            ]
        ],
    ]);
    ?>
</div>
