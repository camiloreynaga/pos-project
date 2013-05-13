<?php

$this->breadcrumbs = array(
    Yii::t('viLib', 'Employee management') => array('nhanVien/danhsach'),
    Yii::t('viLib', 'Employee type') => array('loaiNhanVien/danhsach'),
    Yii::t('viLib', 'Update') => array(),
    GxHtml::valueEx($model,"ten_loai"),
);

$this->menu = array(
	array('label' => Yii::t('viLib', 'List') . ' ' . Yii::t('viLib', 'Employee type'), 'url'=>array('danhsach')),
	array('label' => Yii::t('viLib', 'Create') . ' ' . Yii::t('viLib', 'Employee type'), 'url'=>array('them')),
	array('label' => Yii::t('viLib', 'View') . ' ' . Yii::t('viLib', 'Employee type'), 'url'=>array('chitiet', 'id' => GxActiveRecord::extractPkValue($model, true))),
);
?>

<h1><?php echo Yii::t('viLib', 'Update') . ' ' . Yii::t('viLib', 'Employee type') . ' ' . GxHtml::encode(GxHtml::valueEx($model,"ten_loai")); ?></h1>

<?php
$this->renderPartial('_form', array(
		'model' => $model));
?>