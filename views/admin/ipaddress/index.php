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
            'attribute' => 'ip',
            'header' => Yii::t('app/default', 'ip'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'val',
            'header' => Yii::t('app/default', 'hits'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'progressbar',
            'header' => Yii::t('app/default', 'progressbar'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'detail',
            'header' => Yii::t('app/default', 'detail'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],



            ]
        ]);





?>


