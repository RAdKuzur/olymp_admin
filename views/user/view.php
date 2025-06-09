<?php
/** @var yii\web\View $this */
/** @var \app\models\User $model */

use app\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Просмотр пользователя ' . $model->getFullFio();
$this->params['breadcrumbs'][] = ['label' => 'Список пользователей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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
            ],
            [
                'attribute' => 'email',
                'label' => 'Email',
            ],
            [
                'attribute' => 'phone_number',
                'label' => 'Номер телефона',
            ],
            [
                'attribute' => 'birthdate',
                'label' => 'Дата рождения',
            ],
            [
                'attribute' => 'birthdate',
                'label' => 'Роль',
                'value' => function (User $model) {
                    return Yii::$app->roles->getList()[$model->role];
                }
            ],
            [
                'attribute' => 'gender',
                'label' => 'Пол',
                'value' => function (User $model) {
                    return Yii::$app->genders->getList()[$model->gender];
                }
            ],
            [
                'attribute' => 'birthdate',
                'label' => 'Дата рождения',
            ],
        ],
        'options' => ['class' => 'table table-striped table-bordered detail-view'],
    ]) ?>

</div>