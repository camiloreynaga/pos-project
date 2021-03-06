<?php

/**
 * This is the model base class for the table "tbl_ThongTinCongTy".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ThongTinCongTy".
 *
 * Columns in table "tbl_ThongTinCongTy" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $ten_cong_ty
 * @property string $dia_chi
 * @property string $dien_thoai
 * @property string $fax
 * @property string $email
 * @property string $website
 *
 */
abstract class BaseThongTinCongTy extends CPOSActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tbl_ThongTinCongTy';
	}

	public static function label($n = 1) {
        if($n <= 1 ) {
            return Yii::t('viLib', 'ThongTinCongTy');
        } else {
		    return Yii::t('viLib', 'ThongTinCongTies');
        }
	}

	public static function representingColumn() {
		return 'ten_cong_ty';
	}

	public function rules() {
		return array(
			array('ten_cong_ty, dia_chi, email, website', 'length', 'max'=>100),
			array('dien_thoai, fax', 'length', 'max'=>15),
			array('ten_cong_ty, dia_chi, dien_thoai, fax, email, website', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, ten_cong_ty, dia_chi, dien_thoai, fax, email, website', 'safe', 'on'=>'search'),
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
			'id' => Yii::t('app', 'ID'),
			'ten_cong_ty' => Yii::t('app', 'Ten Cong Ty'),
			'dia_chi' => Yii::t('app', 'Dia Chi'),
			'dien_thoai' => Yii::t('app', 'Dien Thoai'),
			'fax' => Yii::t('app', 'Fax'),
			'email' => Yii::t('app', 'Email'),
			'website' => Yii::t('app', 'Website'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('ten_cong_ty', $this->ten_cong_ty, true);
		$criteria->compare('dia_chi', $this->dia_chi, true);
		$criteria->compare('dien_thoai', $this->dien_thoai, true);
		$criteria->compare('fax', $this->fax, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('website', $this->website, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}