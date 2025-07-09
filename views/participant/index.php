<?php

/** @var yii\web\View $this */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Список участников деятельности';
$this->params['breadcrumbs'][] = $this->title;
/* @var $participants */
/* @var $participantsAmount */
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
                    return $model->userAPI->getFullFio();
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
                    return $model->schoolAPI->name;
                }
            ],
            [
                'attribute' => 'class',
                'label' => 'Класс обучения',
                'value' => function ($model) {
                    return $model->class . ' класс';
                }
            ],
            [
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
    <div class="pagination">
        <?php for ($i = 0 ; $i <= $participantsAmount / 10; $i++) { ?>
            <a href="<?= \yii\helpers\Url::to(['index', 'page' => $i + 1]) ?>"><?= $i + 1 ?>   </a>
        <?php }?>
    </div>
</div>
