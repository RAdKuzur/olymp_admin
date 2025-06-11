<?php
/** @var yii\web\View $this */
/** @var \app\models\Participant $model */

use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Просмотр участника деятельности ' . $model->user->getFullFio();
$this->params['breadcrumbs'][] = ['label' => 'Список участников деятельности', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participant-view">

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
            ]
        ],
        'options' => ['class' => 'table table-striped table-bordered detail-view'],
    ]) ?>

</div>