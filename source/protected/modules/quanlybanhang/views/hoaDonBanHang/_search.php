<div class="wide search-box-form">

    <?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

                    <div class="row cus-row">
            <?php echo $form->label($model, 'id'); ?>
            <?php echo $form->dropDownList($model, 'id', GxHtml::listDataEx(ChungTu::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
        </div>

                    <div class="row cus-row">
            <?php echo $form->label($model, 'chiet_khau'); ?>
            <?php echo $form->textField($model, 'chiet_khau'); ?>
        </div>

                    <div class="row cus-row">
            <?php echo $form->label($model, 'khach_hang_id'); ?>
            <?php echo $form->textField($model, 'khach_hang_id'); ?>
        </div>

        <div class="row buttons btn-search">
        <?php echo GxHtml::submitButton(Yii::t('viLib', 'Search')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->