<?php
$this->breadcrumbs = array(
    'Statistics',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('statistic-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Statistics</h1>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
        'model' => $model,
    )); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'statistic-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        array(
            'name' => 'remote_host',
            'type' => 'raw',
            'value' => 'long2ip($data->remote_host)',
        ),
        'time',
        'method',
        'status',
        'bytes',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view}',
            /*'buttons' => array(
                'update' => array(
                    'url' => 'Yii::app()->createUrl("/banner/allocation/update", array("id"=>$data->id))',
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/banner/allocation/delete", array("id"=>$data->id))',
                ),
                'restore' => array(
                    'url' => 'Yii::app()->createUrl("/banner/allocation/restore", array("id"=>$data->id))',
                ),
            ),*/
        ),
    ),
)); ?>
