<?php

?>

<table class="table table-bordered">
    <tr>
        <td><form action="" method="get" class="form-inline">
                <div class="input-group">
                    <span class="input-group-addon">с</span> 
                    <?php
                   /* $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 's_date',
                        'value' => $this->context->sdate,
                        // additional javascript options for the date picker plugin
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'defaultdate' => '12.02.2012'
                        ),
                        'htmlOptions' => array(
                            'class' => 'form-control'
                        ),
                    ));*/
                    ?>
          
                    <span class="input-group-addon">до</span>  

                    <?php
                    /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 'f_date',
                        'value' => $this->context->fdate,
                        // additional javascript options for the date picker plugin
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                        //   'maxDate'=> '+1D', 
                        ),
                        'htmlOptions' => array(
                            'class' => 'form-control'
                        ),
                    ));*/
                    ?>
                </div>



                   <?php if (!isset($_GET['domen'])) { ?>

                    &nbsp;<span style="vertical-align: middle;"></span> 
                    <?php
                    if ($sort) {
                      /*  $this->widget('ext.bootstrap.selectinput.SelectInput', array(
                            'name' => 'sort',
                            'data' => array('ho' => Yii::t('stats/default', 'HOSTS'), 'hi' => Yii::t('stats/default', 'HITS')),
                            'value' => $this->context->sort
                        ));*/
                    }
                }
                ?>
                <?php if (Yii::$app->request->get('engin')) echo "<input name='engin' value=" . Yii::$app->request->get('engin') . " type='hidden'>"; ?>
                <?php if (Yii::$app->request->get('domen')) echo "<input name='domen' value=" . Yii::$app->request->get('domen') . " type='hidden'>"; ?>
                <?php if (Yii::$app->request->get('brw')) echo "<input name='brw' value='" . Yii::$app->request->get('brw') . "' type='hidden'>"; ?>
                <?php if (Yii::$app->request->get('qq')) echo "<input name='qq' value='" . Yii::$app->request->get('qq') . "' type='hidden'>"; ?>
                <?php if (Yii::$app->request->get('domen') || !Yii::$app->request->get('engin')) { ?>
                    &nbsp;<span>строка</span> <input type=text name="str_f"  value="<?php if (Yii::$app->request->get('str_f')) echo Yii::$app->request->get('str_f'); ?>">
                <?php } ?>
                <input class="btn btn-success" type=submit value="Показать!">
            </form></td>
    </tr>
</table>

