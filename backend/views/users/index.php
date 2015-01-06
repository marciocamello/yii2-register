<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UsersRegisterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Users',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'username',
            'type',
            [
                'attribute' => 'partner_id',
                'value' => function($model){
                    return $model->partnerLabel;
                }
            ],
            'email:email',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->statusLabel;
                }
            ],
            [
                'class' => '\yii\grid\ActionColumn',
                'template' => '{view} {update} {update-password} {delete}',
                'options' => [
                    'class' => 'col-md-2',
                ],
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'View'),
                            'class' => 'col-md-2'
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'Update'),
                            'class' => 'col-md-2'
                        ]);
                    },
                    'update-password' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-lock"></span>', $url, [
                            'title' => Yii::t('app', 'Update'),
                            'class' => 'col-md-2'
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, [
                            'title' => Yii::t('app', 'Delete'),
                            'class' => 'col-md-2',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure to delete this item?'),
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
