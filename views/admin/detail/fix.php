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
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'ip',
            'header' => Yii::t('stats/default', 'IP_ADDRESS'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'host',
            'header' => Yii::t('stats/default', 'HOSTS'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'user_agent',
            'header' => Yii::t('stats/default', 'USER_AGENT'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'req',
            'header' => Yii::t('app/default', 'req'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
    ]
]);

echo "<div>";
foreach ($count as $k => $v)
    echo "<b>Всего хитов <font color='#DE3163'>" . str_replace(" :", "", $k) . "</font></b> : $v<br>";
echo "</div>";
