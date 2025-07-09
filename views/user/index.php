<?php

/** @var yii\web\View $this */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Список пользователей';
$this->params['breadcrumbs'][] = $this->title;
/* @var $users */
/* @var $usersAmount */
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Список пользователей</p>
    <?= Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-success']); ?>
    <?=
    GridView::widget([
        'dataProvider' => $users,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'fullFio',
                'label' => 'ФИО'
            ],
            [
                'attribute' => 'email',
                'label' => 'Эл.почта'
            ],
            [
                'attribute' => 'phone_number',
                'label' => 'Номер телефона'
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
            ],
        ],
    ]);
    ?>
    <div class="pagination">
        <?php for ($i = 0 ; $i <= $usersAmount / 10; $i++) { ?>
            <a href="<?= \yii\helpers\Url::to(['index', 'page' => $i + 1]) ?>"><?= $i + 1 ?>   </a>
        <?php }?>
    </div>
</div>
