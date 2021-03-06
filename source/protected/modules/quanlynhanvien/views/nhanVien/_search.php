<div class="wide search-box-form">

    <?php $form = $this->beginWidget('GxActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>

    <div class="row cus-row">
        <?php echo $form->label($model, 'ma_nhan_vien'); ?>
        <?php echo $form->textField($model, 'ma_nhan_vien', array('maxlength' => 10)); ?>
    </div>

    <div class="row cus-row">
        <?php echo $form->label($model, 'ho_ten'); ?>
        <?php echo $form->textField($model, 'ho_ten', array('maxlength' => 200)); ?>
    </div>

    <div class="row cus-row">
        <?php echo $form->label($model, 'gioi_tinh'); ?>
        <div class="radio-list">
            <?php echo $form->radioButtonList($model, 'gioi_tinh', NhanVien::layDanhSachGioiTinh()); ?>
        </div>
    </div>

    <div class="row cus-row">
        <?php echo $form->label($model, 'trang_thai'); ?>
        <div class="radio-list">
            <?php echo $form->radioButtonList($model, 'trang_thai', $model->layDanhSachTrangThai()); ?>
        </div>
    </div>

    <div class="row cus-row">
        <?php echo $form->label($model, 'loai_nhan_vien_id'); ?>
        <?php echo $form->dropDownList($model, 'loai_nhan_vien_id', GxHtml::listDataEx(LoaiNhanVien::model()->findAll(),null,"ten_loai"), array('prompt' => Yii::t('viLib', 'All'))); ?>
    </div>

    <div class="row cus-row">
        <?php echo $form->label($model, 'chi_nhanh_id'); ?>
        <?php echo $form->dropDownList($model, 'chi_nhanh_id', GxHtml::listDataEx(ChiNhanh::layDanhSachChiNhanhKichHoatTrongHeThongTheoNguoiDung(),null,"ten_chi_nhanh"), array('prompt' => Yii::t('viLib', 'All'))); ?>
    </div>

    <div class="row buttons btn-search">
        <?php echo GxHtml::submitButton(Yii::t('viLib', 'Search')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
