<?php
use panix\engine\grid\GridView;
$this->context->timefilter();


echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'num',
            'header' => Yii::t('app/default', 'num'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'engine',
            'header' => Yii::t('app/default', 'Поисковый запрос'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'val',
            'header' => (($this->context->sort == "hi") ? Yii::t('stats/default', 'HITS') : Yii::t('stats/default', 'HOSTS')),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'progressbar',
            'header' => Yii::t('stats/default', 'GRAPH'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],

    ]
]);

