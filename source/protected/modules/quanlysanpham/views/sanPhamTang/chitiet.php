<?php
$this->breadcrumbs = array(
    Yii::t('viLib', 'Product management') => array('sanPham/danhsach'),
    Yii::t('viLib', 'Gift product') => array('sanPhamTang/danhsach'),
    Yii::t('viLib', 'Detail') => array(),
    GxHtml::valueEx($model, "ten_san_pham"),
);

$this->menu = array(
    array('label' => Yii::t('viLib', 'List') . ' ' . Yii::t('viLib', 'Gift Product'), 'url' => array('danhsach'), 'visible' => Yii::app()->user->checkAccess('Quanlysanpham.SanPhamTang.DanhSach')),
    array('label' => Yii::t('viLib', 'Add') . ' ' . Yii::t('viLib', 'Gift Product'), 'url' => array('them'), 'visible' => Yii::app()->user->checkAccess('Quanlysanpham.SanPhamTang.Them')),
    array('label' => Yii::t('viLib', 'Update') . ' ' . Yii::t('viLib', 'Gift Product'), 'url' => array('capnhat', 'id' => $model->id), 'visible' => Yii::app()->user->checkAccess('Quanlysanpham.SanPhamTang.CapNhat')),
    array('label' => Yii::t('viLib', 'Delete') . ' ' . Yii::t('viLib', 'Gift Product'), 'url' => '#', 'linkOptions' => array('submit' => array('xoa', 'id' => $model->id), 'confirm' => Yii::t('viLib', 'Are you sure you want to delete this item?')), 'visible' => Yii::app()->user->checkAccess('Quanlysanpham.SanPhamTang.Xoa')),
);
?>


    <h1><?php echo Yii::t('viLib', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model, "ten_san_pham")); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'ma_vach',
        'ten_san_pham',
        'gia_tang',
        array('name' => 'thoi_gian_bat_dau',
            'value' => $model->formatDate('thoi_gian_bat_dau')
        ),
        array('name' => 'thoi_gian_ket_thuc',
            'value' => $model->formatDate('thoi_gian_ket_thuc')
        ),
        'mo_ta',
        array('name' => 'trang_thai',
            'value' => $model->layTenTrangThai()),
    ),));

?>

<?php // Cua hang chua san pham ?>
    <div class="sub-title">
        <p><?php echo Yii::t('viLib', 'Stored at branch') ?></p>
    </div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'chi-nhanh-grid',
    'dataProvider' => $model->layDanhSachChiNhanh(),
    'columns' => array(
        'ma_chi_nhanh',
        'ten_chi_nhanh',
        array('name' => Yii::t('viLib', 'Instock'),
            'value' => '$data->laySoLuongTonSanPhamTang()'),

    ),

));
?>

<?php
echo GxHtml::encode(Yii::t('viLib','Total quantity') .' : '.  $model->layTongSoLuongTon());
?>

<?php
/*echo GxHtml::openTag('ul');
foreach($model->tblChiNhanhs as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('chiNhanh/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
    echo GxHtml::closeTag('li');
}
echo GxHtml::closeTag('ul');*/
?>