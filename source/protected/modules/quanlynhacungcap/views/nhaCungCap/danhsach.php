<?php

$this->breadcrumbs = array(
    Yii::t('viLib', 'Supplier management') => array('nhaCungCap/danhsach'),
    Yii::t('viLib', 'Supplier') => array('nhaCungCap/danhsach'),
    Yii::t('viLib', 'List') . ' ' . Yii::t('viLib', 'Supplier')
);

if (RightsWeight::getRoleWeight(Yii::app()->user->id) == 999) {
    $this->menu = array(
        array('label' => Yii::t('viLib', 'Create') . ' ' . Yii::t('viLib', 'Supplier'), 'url' => array('them'),'visible' => Yii::app()->user->checkAccess('Quanlynhacungcap.NhaCungCap.Them')),
        array('label' => Yii::t('viLib', 'Export') . ' ' . Yii::t('viLib', 'Supplier'), 'url' => array('xuat'),'visible' => Yii::app()->user->checkAccess('Quanlynhacungcap.NhaCungCap.Xuat')),
    );
}

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('grid', {
data: $(this).serialize()
});
return false;
});
");
?>

    <h1><?php echo Yii::t('viLib', 'List') . ' ' . Yii::t('viLib', 'Supplier'); ?></h1>


    <div class="search-form">
        <?php $this->renderPartial('_search', array(
            'model' => $model,
        )); ?>
    </div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        'ma_nha_cung_cap',
        'ten_nha_cung_cap',
        'fax',
        'dien_thoai',
        'email',
        array(
            'name' => 'trang_thai',
            'value' => '$data->layTenTrangThai()'
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