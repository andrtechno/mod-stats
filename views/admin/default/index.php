<?php
use panix\engine\Html;
use panix\engine\grid\GridView;
?>
<div class="row">
    <div class="col-sm-6 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">Статистика по месяцам</div>
            </div>
            <div class="panel-body">
                <?php
                
                echo panix\engine\widgets\highcharts\Highcharts::widget([
'options' => array(
                        'chart' => array(
                            'height' => 250,
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
                        'exporting' => false,
                        'title' => array('text' => null),
                        'subtitle' => array(
                            //'text' => "Monitoring: " . date('F', mktime(0, 0, 0, substr($m_dt[0], 0, 2), 1, 0)) . " " . $m_gd[0] . " - " . date('F', mktime(0, 0, 0, substr($m_dt[count($m_dt) - 1], 0, 2), 1, 0)) . " " . $m_gd[count($m_gd) - 1],
                        ),
                        'xAxis' => false,
                        'yAxis' => array(
                            'title' => array('text' => null),
                            'visible' => false
                        ),
                        'plotOptions' => array(
                            'column' => array(
                                'dataLabels' => array(
                                    'enabled' => false,
                                ),
                            ),
                            'series' => array(
                                'cursor' => 'pointer',
                                'point' => array(
                                    'events' => array(
                                        'click' => "js:function (e) {
//location.href = this.options.url;
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
                            array('name' => 'Скоро', 'data' => array(0)),
                        )
                    )
                ]);
                
                
                
                /*$this->Widget('ext.highcharts.HighchartsWidget', array(
                    'scripts' => array(
                        'highcharts-more',
                        // 'columnrange', // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                        'modules/exporting', // adds Exporting button/menu to chart
                    ),
                    'options' => array(
                        'chart' => array(
                            'height' => 250,
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
                        'exporting' => false,
                        'title' => array('text' => null),
                        'subtitle' => array(
                            'text' => "Monitoring: " . date('F', mktime(0, 0, 0, substr($m_dt[0], 0, 2), 1, 0)) . " " . $m_gd[0] . " - " . date('F', mktime(0, 0, 0, substr($m_dt[count($m_dt) - 1], 0, 2), 1, 0)) . " " . $m_gd[count($m_gd) - 1],
                        ),
                        'xAxis' => false,
                        'yAxis' => array(
                            'title' => array('text' => null),
                            'visible' => false
                        ),
                        'plotOptions' => array(
                            'column' => array(
                                'dataLabels' => array(
                                    'enabled' => false,
                                ),
                            ),
                            'series' => array(
                                'cursor' => 'pointer',
                                'point' => array(
                                    'events' => array(
                                        'click' => "js:function (e) {
//location.href = this.options.url;
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
                            array('name' => 'Скоро', 'data' => array(0)),
                        )
                    )
                ));*/
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">Статистика по дням</div>
            </div>
            <div class="panel-body">
                <?php
                /*$this->widget('ext.highcharts.HighchartsWidget', array(
                    'options' => array(
                        'chart' => array(
                            'height' => 250,
                            // 'zoomType'=> 'xy',
                            'defaultSeriesType' => 'areaspline',
                            'type' => 'line',
                            'plotBackgroundColor' => null,
                            'plotBorderWidth' => null,
                            'plotShadow' => false,
                            'backgroundColor' => 'rgba(255, 255, 255, 0)'
                        ),
                        'exporting' => false,
                        'credits' => array(
                            'enabled' => false
                        ),
                        'title' => array('text' => null),
                        'subtitle' => array(
                            'text' => "Monitoring: " . $m_date[count($m_date) - 1] . " - " . $m_date[0],
                        ),
                        'xAxis' => array(
                            'categories' => $weekResult['cats']
                        ),
                        'yAxis' => array(
                            'title' => array('text' => null),
                            'visible' => false
                        ),
                        'plotOptions' => array(
                            'line' => array(
                                'dataLabels' => array(
                                    'enabled' => true
                                ),
                                'enableMouseTracking' => false
                            )
                        ),
                        'series' => array(
                            array('type' => 'line', 'name' => Yii::t('StatsModule.default', 'HITS'), 'data' => $weekResult['hits']),
                            array('type' => 'line', 'name' => Yii::t('StatsModule.default', 'HOSTS'), 'data' => $weekResult['hosts']),
                        )
                    )
                ));*/
                ?>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-sm-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td><b>Всего хостов:</b></td>
                        <td class="text-center"><span class="badge"><?= $all_uniqs; ?></span></td>
                    </tr>
                    <tr>
                        <td><b>Всего хитов:</b></td>
                        <td class="text-center"><span class="badge"><?= $total_hits; ?></span></td>
                    </tr>
                    <tr>
                        <td><b>Всего с поиска:</b></td>
                        <td class="text-center"><span class="badge"><?= $total_search; ?></span></td>
                    </tr>
                    <tr>
                        <td><b>Всего с др. сайтов:</b></td>
                        <td class="text-center"><span class="badge"><?= $total_other; ?></span></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?= Html::a('Последние 100 запроса', ['/admin/stats/default/last', 'query' => 100]) ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?= Html::a('Последние 100 других сайта', ['/admin/stats/default/last', 'site' => 100]) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <?php
   
        
        
        
echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'date',
            'header' => Yii::t('app', 'date'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'graphic',
            'header' => Yii::t('app', 'graphic'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'hosts',
            'header' => Yii::t('app', 'hosts'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'hits',
            'header' => Yii::t('app', 'hits'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'search',
            'header' => Yii::t('app', 'search'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'sites',
            'header' => Yii::t('app', 'sites'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'fix',
            'header' => Yii::t('app', 'fix'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],

            ]
        ]);
                
        ?>
    </div>
</div>


