<?php

$this->breadcrumbs = array(
    Yii::t('viLib','Branch management')=>array('chiNhanh/danhsach'),
    Yii::t('viLib','Branch')=>array('chiNhanh/danhsach'),
	Yii::t('viLib', 'Create'),
);

$this->menu = array(
	array('label'=>Yii::t('viLib', 'List') . ' ' . $model->label(2), 'url' => array('danhsach')),
	array('label'=>Yii::t('viLib', 'Create') . ' ' . Yii::t('viLib','Area'), 'url' => array('khuVuc/them')),
);
?>

<h1><?php echo Yii::t('viLib', 'Create') . ' ' . GxHtml::encode($model->label()); ?></h1>

<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create'));
?>