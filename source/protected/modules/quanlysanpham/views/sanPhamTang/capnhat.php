<?php

$this->breadcrumbs = array(
    Yii::t('viLib', 'Product management')=>array('sanPham/danhsach'),
    Yii::t('viLib','Gift product')=>array('sanPhamTang/danhsach'),
    Yii::t('viLib', 'Update')=>array(),
    GxHtml::valueEx($model,"ten_san_pham")
);

$this->menu = array(
	array('label' => Yii::t('viLib', 'List') . ' ' . Yii::t('viLib','Gift Product'), 'url'=>array('danhsach'),'visible'=>Yii::app()->user->checkAccess('Quanlysanpham.SanPhamTang.DanhSach')),
	array('label' => Yii::t('viLib', 'Create') . ' ' . Yii::t('viLib','Gift Product'), 'url'=>array('them'),'visible'=>Yii::app()->user->checkAccess('Quanlysanpham.SanPhamTang.Them')),
	array('label' => Yii::t('viLib', 'View') . ' ' . Yii::t('viLib','Gift Product'), 'url'=>array('chitiet', 'id' => GxActiveRecord::extractPkValue($model, true)),'visible'=>Yii::app()->user->checkAccess('Quanlysanpham.SanPhamTang.ChiTiet')),

);
?>

<h1><?php echo Yii::t('viLib', 'Update') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model,"ten_san_pham")); ?></h1>

<?php
$this->renderPartial('_form', array(
		'model' => $model));
?>