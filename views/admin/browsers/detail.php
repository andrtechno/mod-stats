<?php

use panix\engine\grid\GridView;

echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'date',
            'header' => Yii::t('app/default', 'date'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'time',
            'header' => Yii::t('app/default', 'time'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'refer',
            'header' => Yii::t('app/default', 'refer'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'ip',
            'header' => Yii::t('app/default', 'ip'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'host',
            'header' => Yii::t('stats/default', 'host'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'user_agent',
            'header' => Yii::t('stats/default', 'host'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'page',
            'header' => Yii::t('stats/default', 'host'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
    ]
]);

