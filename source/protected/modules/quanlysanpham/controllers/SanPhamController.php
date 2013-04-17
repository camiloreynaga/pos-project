<?php

class SanPhamController extends GxController {


	public function actionChiTiet($id) {

        $model = $this->loadModel($id, 'SanPham');
        //lay danh sach cac moc gia cua san pham nay
        $danhSachMocGia = $model->layDanhSachMocGia();
        $giaHienTai = $model->layGiaHienTai();
        $this->render('chitiet', array(
			'model' => $model,
            'danhSachMocGia'=>$danhSachMocGia,
            'giaHienTai'=>$giaHienTai,
		));
	}

	public function actionThem() {
		$model = new SanPham;

		if (isset($_POST['SanPham'])) {
            $result = $model->them($_POST['SanPham']);
            switch($result) {
                case 'ok': {
                    if (Yii::app()->getRequest()->getIsAjaxRequest())
                        Yii::app()->end();
                    else
                        $this->redirect(array('chitiet', 'id' => $model->id));
                    break;
                }
            case 'dup-error': {
                    Yii::app()->user->setFlash('info-board',Yii::t('viLib','Data existed in sytem. Please try another one!'));
                    break;
            }
            case 'fail': {
                    // co the lam them canh bao cho nguoi dung
                    break;
                    }
            }
		}
		$this->render('them', array( 'model' => $model));
	}

	public function actionCapNhat($id) {
		$model = $this->loadModel($id, 'SanPham');


		if (isset($_POST['SanPham'])) {
            $result = $model->capNhat($_POST['SanPham']);
            switch($result) {
                case 'ok': {
                    $this->redirect(array('chitiet', 'id' => $id));
                    break;
                }
                case 'dup-error': {
                    Yii::app()->user->setFlash('info-board',Yii::t('viLib','Data existed in sytem. Please try another one!'));
                    break;
                }
                case 'fail': {
                    // co the lam them canh bao cho nguoi dung
                    break;
                }
            }
		}
		$this->render('capnhat', array( 'model' => $model));
	}

    public function actionXoaGrid($id) {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $delModel = $this->loadModel($id, 'SanPham');
            $result = $delModel->xoa();
            switch($result) {
                case 'ok': {
                    break;
                }
                case 'rel-error': {
                    echo Yii::t('viLib','Can not delete this item because it contains relative data');
                    break;
                }
                case 'fail': {
                    echo Yii::t('viLib','Some errors occur in delete process. Please check your DBMS!');
                    break;
                }
            }
            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('danhsach'));
        } else
        throw new CHttpException(400, Yii::t('viLib', 'Your request is invalid.'));
    }

	public function actionXoa($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
            $delModel = $this->loadModel($id, 'SanPham');
            $message = '';
            $canDelete = true;
            $result = $delModel->xoa();
                switch($result) {
                    case 'ok': {
                        break;
                    }
                    case 'rel-error': {
                        $message =  Yii::t('viLib','Can not delete this item because it contains relative data');
                        $canDelete = false;
                        break;
                    }
                    case 'fail': {
                        $message = Yii::t('viLib','Some errors occur in delete process. Please check your DBMS!');
                        $canDelete = false;
                        break;
                    }
                }
            if($canDelete) {
                if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('danhsach'));
            } else  {
                Yii::app()->user->setFlash('info-board',$message);
                $this->redirect(array('chitiet', 'id' => $id));
            }
			/*if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('danhsach'));*/
		} else
			throw new CHttpException(400, Yii::t('viLib', 'Your request is invalid.'));
	}

	public function actionDanhSach() {

        $model = new SanPham('search');
        $model->unsetAttributes();
        if(isset($_GET['SanPham'])) {
            $model->setAttributes($_GET['SanPham']);
            $model->ma_chi_nhanh = $_GET['SanPham']['tblChiNhanhs'];
        }

        $this->render('danhsach',array('model'=>$model));
	}

	public function actionAdmin() {
		$model = new SanPham('search');
		$model->unsetAttributes();

		if (isset($_GET['SanPham']))
			$model->setAttributes($_GET['SanPham']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

    public function  actionXuat() {

        $model = new SanPham('search');
        $model->unsetAttributes();
        if(isset($_GET['SanPham'])) {
            $model->setAttributes($_GET['SanPham']);
            $model->ma_chi_nhanh = $_GET['SanPham']['tblChiNhanhs'];
            $dataProvider = $model->search();
        }
        $this->render('xuat',array('dataProvider'=>$dataProvider));
    }

}