<?php

use panix\engine\grid\GridView;
?>
<div class="row">
    <div class="col-md-6 col-lg-8 col-xl-9 order-md-1 order-2">

        <?php
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
                    'header' => Yii::t('stats/default', 'GRAPH'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'attribute' => 'detail',
                    'header' => Yii::t('stats/default', 'DETAIL'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],


            ]
        ]);

        ?>

    </div>
    <div class="col-md-6 col-lg-4 col-xl-3 order-md-2 order-1"><?= $this->context->timefilter(); ?></div>
</div>
<?php





