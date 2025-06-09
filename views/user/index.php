<?php

/** @var yii\web\View $this */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Список пользователей';
$this->params['breadcrumbs'][] = $this->title;
/* @var $users */
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
            ],
            [
                'attribute' => 'email',
            ],
            [
                'attribute' => 'phone_number',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]);
    ?>
</div>
