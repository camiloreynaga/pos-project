<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('ma_vach')); ?>:
	<?php echo GxHtml::encode($data->ma_vach); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('ten_san_pham')); ?>:
	<?php echo GxHtml::encode($data->ten_san_pham); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('mo_ta')); ?>:
	<?php echo GxHtml::encode($data->mo_ta); ?>
	<br />

</div>