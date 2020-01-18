<?php

use panix\engine\grid\GridView;

echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'refer',
            'header' => Yii::t('app/default', 'refer'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'ip',
            'header' => Yii::t('app/default', 'ip'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'host',
            'header' => Yii::t('app/default', 'host'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],

        [
            'attribute' => 'user_agent',
            'header' => Yii::t('app/default', 'user_agent'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'timelink',
            'header' => Yii::t('app/default', 'timelink'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
    ]
]);




