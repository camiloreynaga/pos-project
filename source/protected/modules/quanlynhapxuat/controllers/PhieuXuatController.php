<?php

class PhieuXuatController extends CPOSController
{


    public function actionChiTiet($id)
    {
        $this->render('chitiet', array(
            'model' => $this->loadModel($id, 'PhieuXuat'),
        ));
    }

    public function actionThem($id = null)
    {
        $this->layout = '//layouts/column1';
        $model = new PhieuXuat;

        if (isset($_POST['ChungTu'])) {
            $result = $model->them($_POST);
            switch ($result) {
                case 'ok':
                {
                    Yii::app()->CPOSSessionManager->clear('ChiTietPhieuXuat');
                    if (Yii::app()->getRequest()->getIsAjaxRequest())
                        Yii::app()->end();
                    else
                        $this->redirect(array('chitiet', 'id' => $model->id));
                    break;
                }
                case 'dup-error':
                {
                    Yii::app()->user->setFlash('info-board', Yii::t('viLib', 'Data existed in sytem. Please try another one!'));
                    break;
                }
                case 'detail-error':
                {
                    Yii::app()->user->setFlash('info-board', Yii::t('viLib', 'Detail import is not existed. Please fill it'));
                    break;
                }
                case 'fail':
                {
                    // co the lam them canh bao cho nguoi dung
                    break;
                }
            }
        }
        if (isset($id))
            $this->render('them', array('model' => $model, 'id' => $id));
        else
            $this->render('them', array('model' => $model));

    }

    public function actionCapNhat($id)
    {
        $model = $this->loadModel($id, 'PhieuXuat');


        if (isset($_POST['PhieuXuat'])) {
            $result = $model->capNhat($_POST['PhieuXuat']);
            switch ($result) {
                case 'ok':
                {
                    $this->redirect(array('chitiet', 'id' => $id));
                    break;
                }
                case 'dup-error':
                {
                    Yii::app()->user->setFlash('info-board', Yii::t('viLib', 'Data existed in sytem. Please try another one!'));
                    break;
                }
                case 'fail':
                {
                    // co the lam them canh bao cho nguoi dung
                    break;
                }
            }
        }
        $this->render('capnhat', array('model' => $model));
    }

    public function actionXoaGrid($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $delModel = $this->loadModel($id, 'PhieuXuat');
            $result = $delModel->xoa();
            switch ($result) {
                case 'ok':
                {
                    break;
                }
                case 'rel-error':
                {
                    echo Yii::t('viLib', 'Can not delete this item because it contains relative data');
                    break;
                }
                case 'fail':
                {
                    echo Yii::t('viLib', 'Some errors occur in delete process. Please check your DBMS!');
                    break;
                }
            }
            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('danhsach'));
        } else
            throw new CHttpException(400, Yii::t('viLib', 'Your request is invalid.'));
    }

    public function actionXoa($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $delModel = $this->loadModel($id, 'PhieuXuat');
            $message = '';
            $canDelete = true;
            $result = $delModel->xoa();
            switch ($result) {
                case 'ok':
                {
                    break;
                }
                case 'rel-error':
                {
                    $message = Yii::t('viLib', 'Can not delete this item because it contains relative data');
                    $canDelete = false;
                    break;
                }
                case 'fail':
                {
                    $message = Yii::t('viLib', 'Some errors occur in delete process. Please check your DBMS!');
                    $canDelete = false;
                    break;
                }
            }
            if ($canDelete) {
                if (!Yii::app()->getRequest()->getIsAjaxRequest())
                    $this->redirect(array('danhsach'));
            } else {
                Yii::app()->user->setFlash('info-board', $message);
                $this->redirect(array('chitiet', 'id' => $id));
            }
            /*if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('danhsach'));*/
        } else
            throw new CHttpException(400, Yii::t('viLib', 'Your request is invalid.'));
    }

    public function actionDanhSach()
    {

        $model = new PhieuXuat('search');
        $model->unsetAttributes();
        Yii::app()->CPOSSessionManager->clearKey('ExportData');
        if (isset($_GET['PhieuXuat'])) {
            // set vao session
            Yii::app()->CPOSSessionManager->setItem('ExportData', $_GET['PhieuXuat']);
            $model->setAttributes($_GET['PhieuXuat']);
        }
        $this->render('danhsach', array('model' => $model));
    }

    public function  actionXuat()
    {
        $model = new PhieuXuat('search');
        $model->unsetAttributes();
        if (!Yii::app()->CPOSSessionManager->isEmpty('ExportData')) {
            $model->setAttributes(Yii::app()->CPOSSessionManager->getItem('ExportData'));
            $dataProvider = $model->xuatFileExcel();
            $this->render('xuat', array('dataProvider' => $dataProvider));
        }
        $this->render('xuat', array('dataProvider' => new CActiveDataProvider('PhieuXuat')));
    }

    public function actionLaySoLuongTon($ma_vach, $chi_nhanh_id)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            if (isset($chi_nhanh_id) && isset($ma_vach)) {
                $model = SanPham::model()->findByAttributes(array('ma_vach' => $ma_vach));
                $model->chi_nhanh_id = $chi_nhanh_id;
                $tonHienTai = $model->laySoLuongTonHienTai();
                $item = array(
                    'so_ton' => $tonHienTai,
                    'ton_toi_thieu' => $model->ton_toi_thieu,
                );
            }
            echo json_encode($item);
        } else
            throw new CHttpException(400, Yii::t('viLib', 'Your request is invalid.'));

    }

    public function actionSyncData()
    {
        if (isset($_POST)) {
            Yii::app()->CPOSSessionManager->clear('ChiTietPhieuXuat');
            Yii::app()->CPOSSessionManager->setItem('ChiTietPhieuXuat', $_POST);
        }
    }


}