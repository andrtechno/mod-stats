<?php
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;

Pjax::begin([]);
echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'date',
            'header' => Yii::t('stats/default', 'TIMEVISIT'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],

        [
            'attribute' => 'refer',
            'header' => Yii::t('stats/default', 'REFER'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'user_agent',
            'header' => Yii::t('stats/default', 'USER_AGENT'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'page',
            'header' => Yii::t('stats/default', 'PAGE'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
    ]
]);
Pjax::end();