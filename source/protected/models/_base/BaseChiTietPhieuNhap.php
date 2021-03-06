<?php

/**
 * This is the model base class for the table "tbl_ChiTietPhieuNhap".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ChiTietPhieuNhap".
 *
 * Columns in table "tbl_ChiTietPhieuNhap" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $san_pham_id
 * @property integer $phieu_nhap_id
 * @property integer $so_luong
 * @property double $gia_nhap
 *
 */
abstract class BaseChiTietPhieuNhap extends CPOSActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_ChiTietPhieuNhap';
	}

	public static function label($n = 1) {
        if($n <= 1 ) {
            return Yii::t('viLib', 'ChiTietPhieuNhap');
        } else {
		    return Yii::t('viLib', 'ChiTietPhieuNhaps');
        }
	}

	public static function representingColumn() {
		return array(
			'san_pham_id',
			'phieu_nhap_id',
		);
	}

	public function rules() {
		return array(
			array('san_pham_id, phieu_nhap_id,so_luong,gia_nhap', 'required'),
			array('san_pham_id, phieu_nhap_id, so_luong', 'numerical', 'integerOnly'=>true),
			array('gia_nhap', 'numerical'),
			array('san_pham_id, phieu_nhap_id, so_luong, gia_nhap', 'safe', 'on'=>'search'),
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
			'san_pham_id' => null,
			'phieu_nhap_id' => null,
			'so_luong' => Yii::t('viLib', 'So Luong'),
			'gia_nhap' => Yii::t('viLib', 'Gia Nhap'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('san_pham_id', $this->san_pham_id);
		$criteria->compare('phieu_nhap_id', $this->phieu_nhap_id);
		$criteria->compare('so_luong', $this->so_luong);
		$criteria->compare('gia_nhap', $this->gia_nhap);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}