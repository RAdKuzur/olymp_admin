<?php
/** @var yii\web\View $this */
/** @var \app\models\School $model */

use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Просмотр образовательного учреждения '  . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Список обр. учреждений', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить эту олимпиаду?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'name',
                'label' => 'Название образовательного учреждения'
            ],
            [
                'attribute' => 'region',
                'label' => 'Регион',
                'value' => function($model){
                    return Yii::$app->regions->getList()[$model->region];
                }
            ]
        ],
        'options' => ['class' => 'table table-striped table-bordered detail-view'],
    ]) ?>

</div>