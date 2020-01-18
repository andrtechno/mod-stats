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
            'attribute' => 'req',
            'header' => Yii::t('app/default', 'req'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'count',
            'header' => (($this->context->sort == "hi") ? Yii::t('stats/default', 'HITS') : Yii::t('stats/default', 'HOSTS')),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'graphic',
            'header' => Yii::t('stats/default', 'GRAPH'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'detail',
            'header' => Yii::t('app/default', 'OPTIONS'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
    ]
]);

