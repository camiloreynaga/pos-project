<?php
/**
 * User: ${Cristazn}
 * Date: 5/14/13
 * Time: 10:19 AM
 * Email: crist.azn@gmail.com | Phone : 0963-500-980
 */

$this->breadcrumbs = array(
    Yii::t('viLib', 'Report management') => array('baoCao/index'),
    Yii::t('viLib', 'Report') => array('baoCao/index'),
    Yii::t('viLib', 'Import and Export Report'),
);

$this->menu = array(
    array('label' => Yii::t('viLib', 'Import Export Report'), 'url' => array('baoCao/nhapxuatton')),
    array('label' => Yii::t('viLib', 'General Report'), 'url' => array('baoCao/baocaotonghop')),
    array('label' => Yii::t('viLib', 'Sales Report'), 'url' => array('baoCao/banhang')),
);

?>



<h1><?php echo Yii::t('viLib', 'Import and Export Report') ?></h1>
<?php

if (!isset($chiNhanh) && !isset($model)) {
    ?>
    <div class="report-intro">
        <p><?php echo Yii::t('viLib', 'Choose a branch to view Import & Export Status') ?></p>
        <img src="<?php echo Yii::app()->theme->baseUrl . '/images/stock.png' ?>">
    </div>

<?php
}


if (isset($chiNhanh)) {
    $this->widget('ext.custom-widgets.DetailView4Col', array(
        'id' => 'report-branch-detail',
        'data' => $chiNhanh,
        'attributes' => array(
            'ma_chi_nhanh',
            'ten_chi_nhanh',
            array(
                'name' => 'trang_thai',
                'value' => $chiNhanh->layTenTrangThai(),
            ),
            array(
                'name' => 'truc_thuoc_id',
                'value' => $chiNhanh->layTenTrucThuoc(),
            ),
            array(
                'name' => 'loai_chi_nhanh_id',
                'value' => $chiNhanh->layTenLoaiChiNhanh(),
            ),
            array(
                'name' => 'khu_vuc_id',
                'value' => $chiNhanh->layTenKhuVuc(),
            ),
        ),
    ));

    if (!empty($thoi_gian_bat_dau) && !empty($thoi_gian_ket_thuc)) {
        echo '<div class="sub-title">';
        echo '<p>' . Yii::t('viLib', 'Time period') . ' : ' . $thoi_gian_bat_dau . ' --> ' . $thoi_gian_ket_thuc . '</p>';
        echo '</div>';
    }
    ?>
    <?php if (Yii::app()->user->hasFlash('info-board')) { ?>
        <div
            class="response-msg error ui-corner-all info-board">
        <?php echo Yii::app()->user->getFlash('info-board'); ?>
        </div><?php } ?>

    <?php
    if (isset($model)) {

        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'grid',
            'dataProvider' => $model,
            'columns' => array(
                'ma_vach',
                'ten_san_pham',
                array(
                    'name' => Yii::t('viLib', 'Current price'),
                    'value' => '$data->layGiaHienTai()',
                ),
                array(
                    'name' => Yii::t('viLib', 'Beginning instock'),
                    'value' => '$data->ton_dau_ky',
                ),
                array(
                    'name' => Yii::t('viLib', 'Import quantity'),
                    'value' => '$data->so_luong_nhap',
                ),
                array(
                    'name' => Yii::t('viLib', 'Export quantity'),
                    'value' => '$data->so_luong_xuat',
                ),
                array(
                    'name' => Yii::t('viLib', 'Sale quantity'),
                    'value' => '$data->so_luong_ban',
                ),
                array(
                    'name' => Yii::t('viLib', 'Real instock'),
                    'value' => '$data->so_luong_thuc_ton',
                ),

            )
        ));
    }
}
?>