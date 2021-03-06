<?php

$this->breadcrumbs = array(
    Yii::t('viLib', 'Product management') => array('sanPham/danhsach'),
    Yii::t('viLib', 'Product') => array('sanPham/danhsach'),
    Yii::t('viLib', 'List') . ' ' . Yii::t('viLib', 'Product'),
);


$this->menu = array(
    array('label' => Yii::t('viLib', 'List') . ' ' . Yii::t('viLib', 'Gift product'), 'url' => array('sanPhamTang/danhsach'), 'visible' => Yii::app()->user->checkAccess('Quanlysanpham.SanPhamTang.DanhSach')),
    array('label' => Yii::t('viLib', 'List') . ' ' . Yii::t('viLib', 'Product type'), 'url' => array('loaiSanPham/danhsach'), 'visible' => Yii::app()->user->checkAccess('Quanlysanpham.SanPham.DanhSach')),
    array('label' => Yii::t('viLib', 'Create') . ' ' . Yii::t('viLib', 'Product'), 'url' => array('them'), 'visible' => Yii::app()->user->checkAccess('Quanlysanpham.SanPham.Them')),
    array('label' => Yii::t('viLib', 'Create') . ' ' . Yii::t('viLib', 'Gift product'), 'url' => array('sanPhamTang/them'), 'visible' => Yii::app()->user->checkAccess('Quanlysanpham.SanPhamTang.Them')),
    array('label' => Yii::t('viLib', 'Create') . ' ' . Yii::t('viLib', 'Product type'), 'url' => array('loaiSanPham/them'), 'visible' => Yii::app()->user->checkAccess('Quanlysanpham.LoaiSanPham.Them')),
    array('label' => Yii::t('viLib', 'Export') . ' ' . Yii::t('viLib', 'File Excel'), 'url' => array('xuat'), 'visible' => Yii::app()->user->checkAccess('Quanlysanpham.SanPham.Xuat')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1><?php echo Yii::t('viLib', 'List') . ' ' . Yii::t('viLib', 'Product'); ?></h1>


<div class="search-form">
    <?php $this->renderPartial('_search', array(
        'model' => $model,
    )); ?>
</div><!-- search-form -->

<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        'ma_vach',
        'ten_san_pham',
        'don_vi_tinh',
        array(
            'name' => 'nha_cung_cap_id',
            'value' => '$data->nhaCungCap->ten_nha_cung_cap'
        ),

        array('name' => Yii::t('viLib', 'Base price'),
            'type' => 'raw',
            'value' => 'number_format(floatval($data->gia_goc),0,".",",")',
        ),

        array('name' => Yii::t('viLib', 'Current price'),
            'type' => 'raw',
            'value' => 'is_numeric($data->layGiaHienTai())?number_format(floatval($data->layGiaHienTai()),0,".",","):$data->layGiaHienTai()',
        ),

        array('name' => Yii::t('viLib', 'Promotion'),
            'type' => 'raw',
            'value' => '($data->khuyen_mai_id!=null)?(CHtml::image(Yii::app()->theme->baseUrl . "/images/promo.png") ."  ".$data->khuyenMai->ten_chuong_trinh):null',
        ),

        array(
            'name' => Yii::t('viLib', 'Total instock'),
            'value' => 'number_format(floatval($data->layTongSoLuongTon()),0,".",",")',
        ),
        array(
            'name' => 'trang_thai',
            'value' => '$data->layTenTrangThai()',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{update}{delete}',
            'buttons' => array(
                'view' => array(
                    'url' => 'Helpers::urlRouting(Yii::app()->controller,"","chitiet",array("id"=>$data->id))',
                    'label' => Yii::t('viLib', 'View'),
                ),
                'update' => array(
                    'url' => 'Helpers::urlRouting(Yii::app()->controller,"","capnhat",array("id"=>$data->id))',
                    'label' => Yii::t('viLib', 'Update'),
                ),
                'delete' => array(
                    'url' => 'Helpers::urlRouting(Yii::app()->controller,"","xoagrid",array("id"=>$data->id))',
                    'label' => Yii::t('viLib', 'Delete'),
                    'click' => Helpers::deleteButtonClick(),
                ),

            ),
        ),
    ),
)); ?>



