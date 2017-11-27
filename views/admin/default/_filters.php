<?php
Yii::app()->tpl->openWidget(array(
    'title' => 'Фильтр',
));
?>

<table class="table table-bordered">
    <tr>
        <td><form action="" method="get" class="form-inline">
                <div class="input-group">
                    <span class="input-group-addon">с</span> 
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 's_date',
                        'value' => $this->sdate,
                        // additional javascript options for the date picker plugin
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'defaultdate' => '12.02.2012'
                        ),
                        'htmlOptions' => array(
                            'class' => 'form-control'
                        ),
                    ));
                    ?>
          
                    <span class="input-group-addon">до</span>  

                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 'f_date',
                        'value' => $this->fdate,
                        // additional javascript options for the date picker plugin
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                        //   'maxDate'=> '+1D', 
                        ),
                        'htmlOptions' => array(
                            'class' => 'form-control'
                        ),
                    ));
                    ?>
                </div>



                   <?php if (!isset($_GET['domen'])) { ?>

                    &nbsp;<span style="vertical-align: middle;"></span> 
                    <?php
                    if ($sort) {
                        $this->widget('ext.bootstrap.selectinput.SelectInput', array(
                            'name' => 'sort',
                            'data' => array('ho' => Yii::t('StatsModule.default', 'HOSTS'), 'hi' => Yii::t('StatsModule.default', 'HITS')),
                            'value' => $this->sort
                        ));
                    }
                }
                ?>
                <?php if ($_GET['engin']) echo "<input name='engin' value=" . $_GET['engin'] . " type='hidden'>"; ?>
                <?php if ($_GET['domen']) echo "<input name='domen' value=" . $_GET['domen'] . " type='hidden'>"; ?>
                <?php if ($_GET['brw']) echo "<input name='brw' value='" . $_GET['brw'] . "' type='hidden'>"; ?>
                <?php if ($_GET['qq']) echo "<input name='qq' value='" . $_GET['qq'] . "' type='hidden'>"; ?>
                <?php if (isset($_GET['domen']) or ! empty($_GET['engin'])) { ?>
                    &nbsp;<span>строка</span> <input type=text name="str_f"  value="<?php if ($_GET['str_f']) echo $_GET['str_f']; ?>">
                <?php } ?>
                <input class="btn btn-success" type=submit value="Показать!">
            </form></td>
    </tr>
</table>
<?php Yii::app()->tpl->closeWidget(); ?>
