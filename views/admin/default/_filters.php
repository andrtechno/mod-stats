<?php

use panix\engine\jui\DatePicker;
use panix\engine\Html;
use yii\bootstrap4\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'filter-form',
]);

?>
<div class="card">
    <div class="card-header">
        <h5>Фильтр</h5>
    </div>
    <div class="card-body p-0">
        <div class="col-12">
            <div class="form-group row">


                <?= Html::label('с', 'sss',['class'=>'col-form-label col-sm-2']); ?>
                <?php

                echo DatePicker::widget([
                    'name' => 's_date',
                    'value' => $this->context->sdate,
                    'dateFormat' => 'yyyy-MM-dd',
                    'clientOptions' => [],
                    'options'=>['class'=>'form-control col-sm-4']
                ]);
                ?>

                <?= Html::label('до', 'sss',['class'=>'col-form-label col-sm-2']); ?>
                <?php

                echo DatePicker::widget([
                    'name' => 'f_date',
                    'value' => $this->context->fdate,
                    'dateFormat' => 'yyyy-MM-dd',
                    'clientOptions' => ['maxDate' => '+1D'],
                    'options'=>['class'=>'form-control col-sm-4']
                ]);
                ?>
            </div>


            <?php if (!isset($_GET['domen'])) { ?>

            <div class="form-group row">
                <?php
                if ($sort) {
                    echo Html::label('sort', 'sss',['class'=>'col-form-label col-sm-4']);
                    echo Html::dropDownList('sort', $this->context->sort, ['ho' => Yii::t('stats/default', 'HOSTS'), 'hi' => Yii::t('stats/default', 'HITS')], ['class' => 'form-control col-sm-8']);
                    /*  $this->widget('ext.bootstrap.selectinput.SelectInput', array(
                      'name' => 'sort',
                      'data' => array('ho' => Yii::t('stats/default', 'HOSTS'), 'hi' => Yii::t('stats/default', 'HITS')),
                      'value' => $this->context->sort
                      )); */
                }?>
            </div>
                <?php
            }
            ?>
            <?php if (Yii::$app->request->get('engin')) echo "<input name='engin' value=" . Yii::$app->request->get('engin') . " type='hidden'>"; ?>
            <?php if (Yii::$app->request->get('domen')) echo "<input name='domen' value=" . Yii::$app->request->get('domen') . " type='hidden'>"; ?>
            <?php if (Yii::$app->request->get('brw')) echo "<input name='brw' value='" . Yii::$app->request->get('brw') . "' type='hidden'>"; ?>
            <?php if (Yii::$app->request->get('qq')) echo "<input name='qq' value='" . Yii::$app->request->get('qq') . "' type='hidden'>"; ?>
            <?php if (Yii::$app->request->get('domen') || !Yii::$app->request->get('engin')) { ?>
                <div class="form-group row">
                    <?= Html::label('строка', 'sss',['class'=>'col-form-label col-sm-4']); ?>
                    <?= Html::textInput('str_f', Yii::$app->request->get('str_f'), ['class' => 'form-control col-sm-8']); ?>
                </div>

            <?php } ?>
        </div>
    </div>
    <div class="card-footer text-center">
        <input class="btn btn-success" type=submit value="Показать!">
    </div>

</div>
<?php ActiveForm::end() ?>

