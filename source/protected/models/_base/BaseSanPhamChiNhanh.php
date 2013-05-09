<?php

/**
 * This is the model base class for the table "tbl_SanPhamChiNhanh".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "SanPhamChiNhanh".
 *
 * Columns in table "tbl_SanPhamChiNhanh" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $chi_nhanh_id
 * @property integer $san_pham_id
 * @property integer $so_ton
 * @property integer $trang_thai
 *
 */
abstract class BaseSanPhamChiNhanh extends CPOSActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_SanPhamChiNhanh';
	}

	public static function label($n = 1) {
        if($n <= 1 ) {
            return Yii::t('viLib', 'SanPhamChiNhanh');
        } else {
		    return Yii::t('viLib', 'SanPhamChiNhanhs');
        }
	}

	public static function representingColumn() {
		return array(
			'chi_nhanh_id',
			'san_pham_id',
		);
	}

	public function rules() {
		return array(
			array('chi_nhanh_id, san_pham_id, khuyen_mai_id, so_ton, trang_thai', 'numerical', 'integerOnly'=>true),
			array('chi_nhanh_id, san_pham_id, khuyen_mai_id, so_ton, trang_thai', 'default', 'setOnEmpty' => true, 'value' => null),
			array('chi_nhanh_id, san_pham_id, khuyen_mai_id, so_ton, trang_thai', 'safe', 'on'=>'search'),
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
			'chi_nhanh_id' => null,
			'san_pham_id' => null,
			'khuyen_mai_id' => null,
			'so_ton' => Yii::t('viLib', 'So Ton'),
			'trang_thai' => Yii::t('viLib', 'Trang Thai'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('chi_nhanh_id', $this->chi_nhanh_id);
		$criteria->compare('san_pham_id', $this->san_pham_id);
		$criteria->compare('khuyen_mai_id', $this->khuyen_mai_id);
		$criteria->compare('so_ton', $this->so_ton);
		$criteria->compare('trang_thai', $this->trang_thai);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}