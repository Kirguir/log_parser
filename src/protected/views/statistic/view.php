<?php
$this->breadcrumbs = array(
    'Statistics' => array('index'),
    $model->id,
);
?>

<h1>View Statistic #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'remote_host',
        'remote_user',
        'time',
        'method',
        'request',
        'protocol',
        'status',
        'bytes',
        'referer',
        'user_agent',
    ),
)); ?>
