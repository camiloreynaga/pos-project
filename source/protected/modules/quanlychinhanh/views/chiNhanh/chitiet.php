
<?php if (Yii::app()->user->hasFlash('info-board')) { ?>
    <div class="response-msg error ui-corner-all info-board">
        <?php echo Yii::app()->user->getFlash('info-board'); ?>
    </div>
<?php } ?>



<?php

$this->breadcrumbs = array(
    Yii::t('viLib', 'Branch management') => array('chiNhanh/danhsach'),
    Yii::t('viLib', 'Branch') => array('chiNhanh/danhsach'),
    Yii::t('viLib', 'Detail') => array(),
    GxHtml::valueEx($model,"ten_chi_nhanh"),
);

$this->menu = array(
    array('label' => Yii::t('viLib', 'List') . ' ' . Yii::t('viLib','Branch'), 'url' => array('danhsach'),'visible'=>Yii::app()->user->checkAccess('Quanlychinhanh.ChiNhanh.DanhSach')),
    array('label' => Yii::t('viLib', 'Add') . ' ' . Yii::t('viLib','Branch'), 'url' => array('them'),'visible'=>Yii::app()->user->checkAccess('Quanlychinhanh.ChiNhanh.Them')),
    array('label' => Yii::t('viLib', 'Update') . ' ' . Yii::t('viLib','Branch'), 'url' => array('capnhat', 'id' => $model->id),'visible'=>Yii::app()->user->checkAccess('Quanlychinhanh.ChiNhanh.CapNhat')),
    array('label' => Yii::t('viLib', 'Delete') . ' ' . Yii::t('viLib','Branch'), 'url' => '#', 'linkOptions' => array('submit' => array('xoa', 'id' => $model->id), 'confirm' => Yii::t('viLib', 'Are you sure you want to delete this item?')),'visible'=>Yii::app()->user->checkAccess('Quanlychinhanh.ChiNhanh.Xoa')),
);
?>


    <h1><?php echo Yii::t('viLib', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model,"ten_chi_nhanh")); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'ma_chi_nhanh',
        'ten_chi_nhanh',
        'dia_chi',
        'dien_thoai',
        'fax',
        'mo_ta',
        array(
            'name' => 'trang_thai',
            'value' => $model->layTenTrangThai(),
        ),
        array(
            'name' => 'trucThuoc',
            'type' => 'raw',
            'value' => $model->trucThuoc !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->trucThuoc)), array('chiNhanh/view', 'id' => GxActiveRecord::extractPkValue($model->trucThuoc, true))) : null,
        ),
        array(
            'name' => 'khuVuc',
            'type' => 'raw',
            'value' => $model->khuVuc->ten_khu_vuc ,
        ),
        array(
            'name' => 'loaiChiNhanh',
            'type' => 'raw',
            'value' => $model->loaiChiNhanh->ten_loai_chi_nhanh,
        ),
    ),
)); ?>

    <?php
/*	echo GxHtml::openTag('ul');
	foreach($model->chiNhanhs as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('chiNhanh/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
*/?><!--<h2><?php /*echo GxHtml::encode($model->getRelationLabel('chungTus')); */?></h2>
<?php
/*	echo GxHtml::openTag('ul');
	foreach($model->chungTus as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('chungTu/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
*/?><h2><?php /*echo GxHtml::encode($model->getRelationLabel('khuyenMais')); */?></h2>
<?php
/*	echo GxHtml::openTag('ul');
	foreach($model->khuyenMais as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('khuyenMai/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
*/?><h2><?php /*echo GxHtml::encode($model->getRelationLabel('tblKhuyenMais')); */?></h2>
<?php
/*	echo GxHtml::openTag('ul');
	foreach($model->tblKhuyenMais as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('khuyenMai/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
*/?><h2><?php /*echo GxHtml::encode($model->getRelationLabel('mocGias')); */?></h2>
<?php
/*	echo GxHtml::openTag('ul');
	foreach($model->mocGias as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('mocGia/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
*/?><h2><?php /*echo GxHtml::encode($model->getRelationLabel('nhanViens')); */?></h2>
<?php
/*	echo GxHtml::openTag('ul');
	foreach($model->nhanViens as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('nhanVien/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
*/?><h2><?php /*echo GxHtml::encode($model->getRelationLabel('phieuNhaps')); */?></h2>
<?php
/*	echo GxHtml::openTag('ul');
	foreach($model->phieuNhaps as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('phieuNhap/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
*/?><h2><?php /*echo GxHtml::encode($model->getRelationLabel('phieuXuats')); */?></h2>
<?php
/*	echo GxHtml::openTag('ul');
	foreach($model->phieuXuats as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('phieuXuat/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
*/?><h2><?php /*echo GxHtml::encode($model->getRelationLabel('tblSanPhams')); */?></h2>
<?php
/*	echo GxHtml::openTag('ul');
	foreach($model->tblSanPhams as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('sanPham/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
*/?><h2><?php /*echo GxHtml::encode($model->getRelationLabel('tblSanPhamTangs')); */?></h2>
--><?php
/*	echo GxHtml::openTag('ul');
	foreach($model->tblSanPhamTangs as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('sanPhamTang/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
*/
?>