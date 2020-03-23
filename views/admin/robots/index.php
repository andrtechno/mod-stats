<?php
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;

?>
<div class="row">
    <div class="col-md-6 col-lg-8 col-xl-9 order-md-1 order-2">
        <?php

        Pjax::begin();
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
                    'attribute' => 'bot',
                    'header' => Yii::t('app/default', 'Поисковый робот'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-left'],
                ],

                [
                    'attribute' => 'visit',
                    'header' => Yii::t('stats/default', 'Последний визит'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'attribute' => 'count',
                    'header' => Yii::t('stats/default', 'Кол-во страниц'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'attribute' => 'progressbar',
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
        Pjax::end();
        ?>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3 order-md-2 order-1"><?= $this->context->timefilter(false); ?></div>
</div>
