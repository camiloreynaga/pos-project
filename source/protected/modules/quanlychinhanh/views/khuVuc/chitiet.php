<?php if (Yii::app()->user->hasFlash('info-board')) { ?>
    <div class="response-msg error ui-corner-all info-board">
        <?php echo Yii::app()->user->getFlash('info-board'); ?>
    </div>
<?php } ?>


<?php

$this->breadcrumbs = array(
    Yii::t('viLib', 'Branch management') => array('chiNhanh/danhsach'),
    Yii::t('viLib', 'Area') => array('khuVuc/danhsach'),
    Yii::t('viLib', 'Detail') => array(),
    GxHtml::valueEx($model, "ten_khu_vuc"),
);

$this->menu = array(
    array('label' => Yii::t('viLib', 'List') . ' ' . Yii::t('viLib', 'Area'), 'url' => array('danhsach'), 'visible' => Yii::app()->user->checkAccess('Quanlychinhanh.KhuVuc.DanhSach')),
    array('label' => Yii::t('viLib', 'Add') . ' ' . Yii::t('viLib', 'Area'), 'url' => array('them'), 'visible' => Yii::app()->user->checkAccess('Quanlychinhanh.KhuVuc.Them')),
    array('label' => Yii::t('viLib', 'Update') . ' ' . Yii::t('viLib', 'Area'), 'url' => array('capnhat', 'id' => $model->id), 'visible' => Yii::app()->user->checkAccess('Quanlychinhanh.KhuVuc.CapNhat')),
    array('label' => Yii::t('viLib', 'Delete') . ' ' . Yii::t('viLib', 'Area'), 'url' => '#', 'linkOptions' => array('submit' => array('xoa', 'id' => $model->id), 'confirm' => Yii::t('viLib', 'Are you sure you want to delete this item?'), 'visible' => Yii::app()->user->checkAccess('Quanlychinhanh.KhuVuc.Xoa'))),
);
?>


    <h1><?php echo Yii::t('viLib', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model, "ten_khu_vuc")); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'ma_khu_vuc',
        'ten_khu_vuc',
        'mo_ta',
    ),
)); ?>

    <!--<h2><?php /*echo GxHtml::encode($model->getRelationLabel('chiNhanhs')); */?></h2>
--><?php
/*	echo GxHtml::openTag('ul');
	foreach($model->chiNhanhs as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('chiNhanh/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
*/
?>