<?php

/**
 * This is the model base class for the table "tbl_GanQuyen".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "GanQuyen".
 *
 * Columns in table "tbl_GanQuyen" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $nhan_vien_id
 * @property integer $quyen_id
 * @property string $bizrule
 * @property string $tham_so
 *
 */
abstract class BaseGanQuyen extends CPOSActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_GanQuyen';
	}

	public static function label($n = 1) {
        if($n <= 1 ) {
            return Yii::t('viLib', 'GanQuyen');
        } else {
		    return Yii::t('viLib', 'GanQuyens');
        }
	}

	public static function representingColumn() {
		return array(
			'nhan_vien_id',
			'quyen_id',
		);
	}

	public function rules() {
		return array(
			array('nhan_vien_id, quyen_id', 'required'),
			array('nhan_vien_id, quyen_id', 'numerical', 'integerOnly'=>true),
			array('bizrule, tham_so', 'safe'),
			array('bizrule, tham_so', 'default', 'setOnEmpty' => true, 'value' => null),
			array('nhan_vien_id, quyen_id, bizrule, tham_so', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'nhan_vien_id' => null,
			'quyen_id' => null,
			'bizrule' => Yii::t('viLib', 'Bizrule'),
			'tham_so' => Yii::t('viLib', 'Tham So'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('nhan_vien_id', $this->nhan_vien_id);
		$criteria->compare('quyen_id', $this->quyen_id);
		$criteria->compare('bizrule', $this->bizrule, true);
		$criteria->compare('tham_so', $this->tham_so, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}