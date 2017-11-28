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
            'attribute' => 'time',
            'header' => Yii::t('app', 'time'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        
         [
            'attribute' => 'val',
            'header' => (($this->context->sort == "hi") ? Yii::t('stats/default', 'HITS') : Yii::t('stats/default', 'HOSTS')),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],

        [
            'attribute' => 'progressbar',
            'header' => Yii::t('stats/default', 'GRAPH'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],


            ]
        ]);
                
        




/*
$this->Widget('ext.highcharts.HighchartsWidget', array(
    'scripts' => array(
        'highcharts-more',
        // 'columnrange', // enables supplementary chart types (gauge, arearange, columnrange, etc.)
        'modules/exporting', // adds Exporting button/menu to chart
    ),
    'options' => array(
        'chart' => array(
            // 'width'=> '100%',

            'defaultSeriesType' => 'areaspline',
            'type' => 'column',
            'plotBackgroundColor' => null,
            'plotBorderWidth' => null,
            'plotShadow' => false,
            'backgroundColor' => 'rgba(255, 255, 255, 0)'
        ),
        'credits' => array(
            'enabled' => false
        ),
        'exporting' => array(
            'buttons' => array(
                'contextButton' => array(
                    'menuItems' => array(array(
                            'text' => 'Export to PNG (small)',
                            'onclick' => 'js:function () {
                            this.exportChart({
                                width: 250
                            });
                        }'
                        ), array(
                            'text' => 'Export to PNG (large)',
                            'onclick' => 'js:function () {
                            this.exportChart();
                        }',
                            'separator' => false
                        ))
                )
            )
        ),
        'title' => array('text' => 'Время посещение'),
        'subtitle' => array(
            'text' => 'График времени посещения с ' . date('Y-m-d', strtotime($this->sdate)) . ' по ' . date('Y-m-d', strtotime($this->fdate)) . ''
        ),
        'xAxis' => array(
            'categories' => $times
        ),
        'yAxis' => array(
            'title' => array('text' => null),
            'visible' => false
        ),
        'plotOptions' => array(
            'column' => array(
                'dataLabels' => array(
                    'enabled' => true,
                ),
            ),
            'series' => array(
                'cursor' => 'pointer',
                'point' => array(
                    'events' => array(
                        'click' => "js:function (e) {
                            console.log(this.options);
                            location.href = this.options.url;
                        }"
                    )
                ),
                'marker' => array(
                    'lineWidth' => 1,
                    'enabled' => false
                )
            )
        ),
        'series' => array(
            array('name' => (($this->sort == "hi") ? Yii::t('StatsModule.default', 'HITS') : Yii::t('StatsModule.default', 'HOSTS')), 'data' => $visits),
        )
    )
));


*/
?>
