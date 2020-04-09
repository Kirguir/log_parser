<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
)); ?>

<?php echo $form->textFieldRow($model, 'remote_host', array(
    'class' => 'span5',
    'name' => 'remote_host',
    'pattern' => '\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}',
    'placeholder' => '192.168.0.1',
)); ?>

<?php $form->error($model, 'remote_host'); ?>

<div class="control-group">
    <label class="control-label">Period</label>
    <div class="controls controls-row">
        <div class="input-prepend">
            <span class="add-on">from</span>
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'time_from',
                'options' => array(
                    'dateFormat' => 'dd.mm.yy',
                    'changeYear' => 'true',
                    'yearRange' => date('Y', strtotime('-2 year')) . ':' . date('Y', strtotime('+2 year')),
                    'showButtonPanel' => 'true',
                ),
                'htmlOptions' => array(
                    'class' => 'input-small',
                    'name' => 'time_from'
                ),
            ));
            ?>
        </div>
        <div class="input-prepend">
            <span class="add-on">to</span>
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'time_to',
                'options' => array(
                    'dateFormat' => 'dd.mm.yy',
                    'changeYear' => 'true',
                    'yearRange' => date('Y', strtotime('-2 year')) . ':' . date('Y', strtotime('+2 year')),
                    'showButtonPanel' => 'true',
                ),
                'htmlOptions' => array(
                    'class' => 'input-small',
                    'name' => 'time_to'
                ),
            ));
            ?>
        </div>
        <?= $form->error($model, 'time_from'); ?>
        <?= $form->error($model, 'time_to'); ?>
    </div>
</div>

<?php echo $form->dropDownListRow($model, 'method',
    array('' => 'All', 'get' => 'GET', 'post' => 'POST'),
    array('class' => 'span5', 'name' => 'method', 'maxlength' => 255));
?>

<?php echo $form->textFieldRow($model, 'status',
    array('class' => 'span5', 'name' => 'status'));
?>

<?php echo $form->checkBoxListRow($model, 'group_by',
    array(
        'remote_host' => 'By host',
        'method' => 'By method',
        'status' => 'By status'
    ),
    array('name' => 'group_by'));
?>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Search',
    )); ?>
</div>

<?php $this->endWidget(); ?>
