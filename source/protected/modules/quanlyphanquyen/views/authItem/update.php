<?php $this->breadcrumbs = array(
    Yii::t('viLib', 'Decentralization management') => array('authItem/roles'),
    Yii::t('viLib', 'Authentication item')=>array(),
    Yii::t('viLib', 'Update')=>array(),
	$model->name,
); ?>

<?php
$this->menu = array(
    array('label' => Yii::t('viLib', 'List') . ' ' . Yii::t('viLib', 'Roles'),  'url' => array('authItem/roles')),
    array('label' => Yii::t('viLib', 'List') . ' ' . Yii::t('viLib', 'Tasks'),  'url' => array('authItem/tasks')),
    array('label' => Yii::t('viLib', 'List') . ' ' . Yii::t('viLib', 'Operations'),  'url' => array('authItem/operations')),
);

?>

<h1><?php echo Rights::t('core', 'Update :name', array(
        ':name'=>$model->name,
        ':type'=>Rights::getAuthItemTypeName($model->type),
    )); ?></h1>

<div id="updatedAuthItem" class="cus-rights-content">

    <?php $this->renderPartial('_form', array('model'=>$formModel,'currentWeight'=>$currentWeight)); ?>

    <div class="relations span-11 last cus-relations-rights-mini-content">

        <div class="sub-title">
            <p><?php echo Yii::t('viLib', 'Relations item') ?></p>
        </div>

        <?php if( $model->name!==Rights::module()->superuserName ): ?>

            <div class="parents">

                <h4><?php echo Rights::t('core', 'Parents'); ?></h4>

                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'dataProvider'=>$parentDataProvider,
                    'template'=>'{items}',
                    'hideHeader'=>true,
                    'emptyText'=>Rights::t('core', 'This item has no parents.'),
                    'htmlOptions'=>array('class'=>'grid-view parent-table mini'),
                    'columns'=>array(
                        array(
                            'name'=>'name',
                            'header'=>Rights::t('core', 'Name'),
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'name-column'),
                            'value'=>'$data->getNameValueLink()',
                        ),
                        array(
                            'name'=>'type',
                            'header'=>Rights::t('core', 'Type'),
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'type-column'),
                            'value'=>'$data->getTypeText()',
                        ),
                        array(
                            'header'=>'&nbsp;',
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'actions-column'),
                            'value'=>'',
                        ),
                    )
                )); ?>

            </div>

            <div class="children">

                <h4><?php echo Rights::t('core', 'Children'); ?></h4>

                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'dataProvider'=>$childDataProvider,
                    'template'=>'{items}',
                    'hideHeader'=>true,
                    'emptyText'=>Rights::t('core', 'This item has no children.'),
                    'htmlOptions'=>array('class'=>'grid-view parent-table mini'),
                    'columns'=>array(
                        array(
                            'name'=>'name',
                            'header'=>Rights::t('core', 'Name'),
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'name-column'),
                            'value'=>'$data->getNameValueLink()',
                        ),
                        array(
                            'name'=>'type',
                            'header'=>Rights::t('core', 'Type'),
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'type-column'),
                            'value'=>'$data->getTypeText()',
                        ),
                        array(
                            'header'=>'&nbsp;',
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'actions-column'),
                            'value'=>'$data->getRemoveChildLink()',
                        ),
                    )
                )); ?>

            </div>

            <div class="addChild">

                <h5><?php echo Rights::t('core', 'Add Child'); ?></h5>

                <?php if( $childFormModel!==null ): ?>

                    <?php $this->renderPartial('_childForm', array(
                        'model'=>$childFormModel,
                        'itemnameSelectOptions'=>$childSelectOptions,
                    )); ?>

                <?php else: ?>

                <p class="info"><?php echo Rights::t('core', 'No children available to be added to this item.'); ?>

                    <?php endif; ?>

            </div>

        <?php else: ?>

            <p class="info">
                <?php echo Rights::t('core', 'No relations need to be set for the superuser role.'); ?><br />
                <?php echo Rights::t('core', 'Super users are always granted access implicitly.'); ?>
            </p>

        <?php endif; ?>

    </div>



</div>