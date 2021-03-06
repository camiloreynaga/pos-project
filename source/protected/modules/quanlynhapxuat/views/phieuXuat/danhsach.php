<?php
$this->breadcrumbs = array(
    Yii::t('viLib', 'Import/Export management') => array('chiNhanh/danhsach'),
    Yii::t('viLib', 'List') . ' ' . Yii::t('viLib', 'Export form'),
);

$this->menu = array(
    array('label' => Yii::t('viLib', 'Create') . ' ' . Yii::t('viLib', 'Export form'), 'url' => array('them'),'visible'=>Yii::app()->user->checkAccess('Quanlynhapxuat.PhieuXuat.Them')),
    array('label' => Yii::t('viLib', 'Create') . ' ' . Yii::t('viLib', 'Export gift product'), 'url' => array('phieuXuat/xuatsanphamtang'),'visible'=>Yii::app()->user->checkAccess('Quanlynhapxuat.PhieuXuat.XuatSanPhamTang')),

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

    <h1><?php echo Yii::t('viLib', 'List') . ' ' . Yii::t('viLib', 'Export form'); ?></h1>


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
        array(
            'name' => 'id',
            'value' => 'GxHtml::valueEx($data->chungTu)',
            'filter' => GxHtml::listDataEx(ChungTu::model()->findAllAttributes(null, true)),
        ),
        array(
            'name' => Yii::t('viLib','Created date'),
            'value' => 'date("d-m-Y",strtotime($data->getBaseModel()->ngay_lap))'
        ),

        array(
            'name' => Yii::t('viLib','Export type'),
            'value' => '$data->loaiNhapXuat->ten_loai_nhap_xuat',
        ),

        array(
            'name' => 'chi_nhanh_nhap_id',
            'value' => '$data->chiNhanhNhap->ten_chi_nhanh',
            'filter' => GxHtml::listDataEx(ChiNhanh::model()->findAllAttributes(null, true)),
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'buttons' => array(
                'view' => array(
                    'url' => 'Helpers::urlRouting(Yii::app()->controller,"","chitiet",array("id"=>$data->id))',
                    'label' => Yii::t('viLib', 'View'),
                ),

            ),
        ),
    ),
)); ?>