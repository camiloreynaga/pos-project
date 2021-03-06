<?php

class BaoCaoController extends CPOSController
{

    public function actionDanhSach()
    {
        if (Yii::app()->user->checkAccess('Quanlybaocao.BaoCao.DanhSach'))
            $this->render('danhsach');
        else
            throw new CHttpException(403, Yii::t('viLib', 'You are not allowed to access this section. Please contact to your administrator for help'));

    }

    public function actionNhapXuatTon()
    {
        if (Yii::app()->user->checkAccess('Quanlybaocao.BaoCao.NhapXuatTon')) {
            Yii::app()->CPOSSessionManager->clearKey('DanhSachSanPham');
            Yii::app()->CPOSSessionManager->clearKey('KhoangThoiGian');
            if (isset($_POST['CPOSNhapXuatTonForm'])) {

                $chi_nhanh_id = $_POST['CPOSNhapXuatTonForm']['chi_nhanh_id'];
                $thoi_gian_bat_dau = $_POST['CPOSNhapXuatTonForm']['thoi_gian_bat_dau'];
                $thoi_gian_ket_thuc = $_POST['CPOSNhapXuatTonForm']['thoi_gian_ket_thuc'];
                $chiNhanh = $this->loadModel($chi_nhanh_id, 'ChiNhanh');
                if (strtotime($thoi_gian_ket_thuc) > strtotime($thoi_gian_bat_dau)) {

                    $criteria = new CDbCriteria();
                    $criteria->with = 'sanPhamChiNhanh';
                    $criteria->together = true;
                    $criteria->compare('sanPhamChiNhanh.chi_nhanh_id', $chi_nhanh_id, false);
                    $danhSachSanPham = new CActiveDataProvider('SanPham', array('criteria' => $criteria));
                    $danhSachSanPhamData = $danhSachSanPham->getData();

                    foreach ($danhSachSanPhamData as $sanPham) {
                        $sanPham->chi_nhanh_id = $chi_nhanh_id;
                        $sanPham->tinhNhapXuatTon($thoi_gian_bat_dau, $thoi_gian_ket_thuc);
                    }
                    Yii::app()->CPOSSessionManager->setItem('DanhSachSanPham', $danhSachSanPham);
                    Yii::app()->CPOSSessionManager->setItem('KhoangThoiGian', array('thoi_gian_bat_dau'=>$thoi_gian_bat_dau,'thoi_gian_ket_thuc'=>$thoi_gian_ket_thuc));
                } else
                    Yii::app()->user->setFlash('info-board', Yii::t('viLib', 'Time period is wrong format'));

            }
            if (isset($chiNhanh))
                $this->render('nhapxuatton', array('model' => (isset($danhSachSanPham)) ? $danhSachSanPham : null, 'chiNhanh' => $chiNhanh, 'thoi_gian_bat_dau' => $thoi_gian_bat_dau, 'thoi_gian_ket_thuc' => $thoi_gian_ket_thuc));
            // render content
            else
                $this->render('nhapxuatton'); // render intro
        } else
            throw new CHttpException(403, Yii::t('viLib', 'You are not allowed to access this section. Please contact to your administrator for help'));
    }

    public function actionBanHangChiNhanh()
    {
        if (Yii::app()->user->checkAccess('Quanlybaocao.BaoCao.BanHangChiNhanh')) {
            Yii::app()->CPOSSessionManager->clearKey('BanHangChiNhanh');
            Yii::app()->CPOSSessionManager->clearKey('KhoangThoiGian');
            if (isset($_POST['CPOSBanHangChiNhanhForm'])) {
                $chi_nhanh_id = $_POST['CPOSBanHangChiNhanhForm']['chi_nhanh_id'];
                $thoi_gian_bat_dau = $_POST['CPOSBanHangChiNhanhForm']['thoi_gian_bat_dau'];
                $thoi_gian_ket_thuc = $_POST['CPOSBanHangChiNhanhForm']['thoi_gian_ket_thuc'];
                if (strtotime($thoi_gian_bat_dau) < strtotime($thoi_gian_ket_thuc)) {
                    if (!empty($chi_nhanh_id)) {
                        $criteria = new CDbCriteria();
                        $criteria->compare('id', $chi_nhanh_id);
                        $danhSachChiNhanh = new CActiveDataProvider('ChiNhanh', array('criteria' => $criteria));
                        $danhSachChiNhanhData = $danhSachChiNhanh->getData();
                        foreach ($danhSachChiNhanhData as $cn)
                            $cn->tinhDoanhSoTheoKhoangThoiGian($thoi_gian_bat_dau, $thoi_gian_ket_thuc);
                    } else {
                        $criteria = new CDbCriteria();
                        $criteria->addCondition(array('trang_thai' => 1));
                        $criteria->compare('id', 1, false, '>');
                        $danhSachChiNhanh = new CActiveDataProvider('ChiNhanh', array('criteria' => $criteria));
                        $danhSachChiNhanhData = $danhSachChiNhanh->getData();
                        foreach ($danhSachChiNhanhData as $cn)
                            $cn->tinhDoanhSoTheoKhoangThoiGian($thoi_gian_bat_dau, $thoi_gian_ket_thuc);

                    }
                    Yii::app()->CPOSSessionManager->setItem('BanHangChiNhanh',$danhSachChiNhanh);
                    Yii::app()->CPOSSessionManager->setItem('KhoangThoiGian', array('thoi_gian_bat_dau'=>$thoi_gian_bat_dau,'thoi_gian_ket_thuc'=>$thoi_gian_ket_thuc));
                } else
                    Yii::app()->user->setFlash('info-board', Yii::t('viLib', 'Time period is wrong format'));
            }
            $this->render('banhangchinhanh', array('chiNhanh' => isset($danhSachChiNhanh) ? $danhSachChiNhanh : null, 'thoi_gian_bat_dau' => isset($thoi_gian_bat_dau) ? $thoi_gian_bat_dau : null, 'thoi_gian_ket_thuc' => isset($thoi_gian_ket_thuc) ? $thoi_gian_ket_thuc : null));
        } else
            throw new CHttpException(403, Yii::t('viLib', 'You are not allowed to access this section. Please contact to your administrator for help'));

    }

    public function actionBanHangSanPham()
    {
        if (Yii::app()->user->checkAccess('Quanlybaocao.BaoCao.BanHangSanPham')) {

            if (isset($_POST['CPOSBanHangSanPhamForm'])) {
                $chi_nhanh_id = $_POST['CPOSBanHangSanPhamForm']['chi_nhanh_id'];
                $ma_vach = $_POST['CPOSBanHangSanPhamForm']['ma_vach'];
                $thoi_gian_bat_dau = $_POST['CPOSBanHangSanPhamForm']['thoi_gian_bat_dau'];
                $thoi_gian_ket_thuc = $_POST['CPOSBanHangSanPhamForm']['thoi_gian_ket_thuc'];
                if (strtotime($thoi_gian_bat_dau) < strtotime($thoi_gian_ket_thuc)) {


                    if (!empty($ma_vach)) {
                        $criteria = new CDbCriteria();
                        $criteria->compare('ma_vach', $ma_vach);
                        $sanPham = new CActiveDataProvider('SanPham', array('criteria' => $criteria));
                        if (!empty($chi_nhanh_id)) {
                            // co 1 chi nhanh

                            $criteria = new CDbCriteria();
                            $criteria->compare('id', $chi_nhanh_id);
                            $chiNhanh = new CActiveDataProvider('ChiNhanh', array('criteria' => $criteria));
                            $danhSachSanPham = $sanPham->getData();
                            foreach ($danhSachSanPham as $sp) {
                                $sp->chi_nhanh_id = $chi_nhanh_id;
                                $sp->tinhDoanhSoTheoKhoangThoiGian($thoi_gian_bat_dau, $thoi_gian_ket_thuc);
                            }

                        } else {
                            // tat ca chi nhanh
                            $criteria = new CDbCriteria();
                            $criteria->addCondition(array('trang_thai' => 1));
                            $criteria->compare('id', 1, false, '>');
                            $chiNhanh = new CActiveDataProvider('ChiNhanh', array('criteria' => $criteria));
                            $danhSachSanPham = $sanPham->getData();
                            foreach ($danhSachSanPham as $sp) {
                                $sp->chi_nhanh_id = $chi_nhanh_id;
                                $sp->tinhDoanhSoSanPhamTheoKhoangThoiGianTrenCacChiNhanh($thoi_gian_bat_dau, $thoi_gian_ket_thuc);
                            }
                        }

                    } else {
                        Yii::app()->user->setFlash('info-board', Yii::t('viLib', 'Product not found'));

                    }

                } else
                    Yii::app()->user->setFlash('info-board', Yii::t('viLib', 'Time period is wrong format'));
            }

            $this->render('banhangsanpham', array('sanPham' => isset($sanPham) ? $sanPham : null, 'chiNhanh' => isset($chiNhanh) ? $chiNhanh : null, 'thoi_gian_bat_dau' => isset($thoi_gian_bat_dau) ? $thoi_gian_bat_dau : null, 'thoi_gian_ket_thuc' => isset($thoi_gian_ket_thuc) ? $thoi_gian_ket_thuc : null));
        } else
            throw new CHttpException(403, Yii::t('viLib', 'You are not allowed to access this section. Please contact to your administrator for help'));
    }


    public function actionBanHangTop()
    {
        if (Yii::app()->user->checkAccess('Quanlybaocao.BaoCao.BanHangTop')) {

            // find top 10 products in branch or all branchs
            Yii::app()->CPOSSessionManager->clearKey('BanHangTop');
            Yii::app()->CPOSSessionManager->clearKey('KhoangThoiGian');
            if (isset($_POST['CPOSBanHangTopForm'])) {

                $top = $_POST['CPOSBanHangTopForm']['top'];
                $chi_nhanh_id = $_POST['CPOSBanHangTopForm']['chi_nhanh_id'];
                $thoi_gian_bat_dau = $_POST['CPOSBanHangTopForm']['thoi_gian_bat_dau'];
                $thoi_gian_ket_thuc = $_POST['CPOSBanHangTopForm']['thoi_gian_ket_thuc'];
                if (strtotime($thoi_gian_bat_dau) < strtotime($thoi_gian_ket_thuc)) {
                    if (!empty($chi_nhanh_id)) {

                        $criteria = new CDbCriteria();
                        $criteria->compare('id', $chi_nhanh_id);
                        $chiNhanh = new CActiveDataProvider('ChiNhanh', array('criteria' => $criteria));

                        $tgbd = date('Y-m-d', strtotime($thoi_gian_bat_dau));
                        $tgkt = date('Y-m-d', strtotime($thoi_gian_ket_thuc));
                        $danhSachRow = Yii::app()->db->createCommand()
                            ->select('san_pham_id, sum( so_luong * don_gia ) AS thanh_tien')
                            ->from('tbl_ChungTu, tbl_ChiTietHoaDonBan')
                            ->where("tbl_ChungTu.id = tbl_ChiTietHoaDonBan.hoa_don_ban_id AND tbl_ChungTu.ngay_lap BETWEEN '$tgbd' AND '$tgkt' AND tbl_ChungTu.chi_nhanh_id = '$chi_nhanh_id'")
                            ->group('san_pham_id')
                            ->order('thanh_tien DESC')
                            ->limit($top)
                            ->queryAll();

                        $criteria = new CDbCriteria();

                        foreach ($danhSachRow as $row)
                            $criteria->compare('id', $row['san_pham_id'], false, 'OR');
                        $criteria->limit = $top;
                        $sanPham = new CActiveDataProvider('SanPham', array('criteria' => $criteria));
                        $danhSachSanPhamData = $sanPham->getData();
                        foreach ($danhSachSanPhamData as $sp) {
                            $sp->chi_nhanh_id = $chi_nhanh_id;
                            $sp->tinhDoanhSoTheoKhoangThoiGian($thoi_gian_bat_dau, $thoi_gian_ket_thuc);
                        }

                    } else {
                        // view all branch
                        $tgbd = date('Y-m-d', strtotime($thoi_gian_bat_dau));
                        $tgkt = date('Y-m-d', strtotime($thoi_gian_ket_thuc));
                        $danhSachRow = Yii::app()->db->createCommand()
                            ->select('san_pham_id, sum( so_luong * don_gia ) AS thanh_tien')
                            ->from('tbl_ChungTu, tbl_ChiTietHoaDonBan')
                            ->where("tbl_ChungTu.id = tbl_ChiTietHoaDonBan.hoa_don_ban_id AND tbl_ChungTu.ngay_lap BETWEEN '$tgbd' AND '$tgkt'")
                            ->group('san_pham_id')
                            ->order('thanh_tien DESC')
                            ->limit($top)
                            ->queryAll();

                        $criteria = new CDbCriteria();

                        foreach ($danhSachRow as $row)
                            $criteria->compare('id', $row['san_pham_id'], false, 'OR');
                        $criteria->limit = $top;
                        $sanPham = new CActiveDataProvider('SanPham', array('criteria' => $criteria));
                        $danhSachSanPhamData = $sanPham->getData();
                        foreach ($danhSachSanPhamData as $sp)
                            $sp->tinhDoanhSoSanPhamTheoKhoangThoiGianTrenCacChiNhanh($thoi_gian_bat_dau, $thoi_gian_ket_thuc);
                    }

                    Yii::app()->CPOSSessionManager->setItem('BanHangTop',$sanPham);
                    Yii::app()->CPOSSessionManager->setItem('KhoangThoiGian', array('thoi_gian_bat_dau'=>$thoi_gian_bat_dau,'thoi_gian_ket_thuc'=>$thoi_gian_ket_thuc));
                } else {
                    Yii::app()->user->setFlash('info-board', Yii::t('viLib', 'Time period is wrong format'));
                }
            }
            $this->render('banhangtop', array('sanPham' => isset($sanPham) ? $sanPham : null, 'chiNhanh' => isset($chiNhanh) ? $chiNhanh : null, 'thoi_gian_bat_dau' => isset($thoi_gian_bat_dau) ? $thoi_gian_bat_dau : null, 'thoi_gian_ket_thuc' => isset($thoi_gian_ket_thuc) ? $thoi_gian_ket_thuc : null));
        } else
            throw new CHttpException(403, Yii::t('viLib', 'You are not allowed to access this section. Please contact to your administrator for help'));
    }


    public function actionXuatExcelNhapXuatTon()
    {

        if (!Yii::app()->CPOSSessionManager->isEmpty('DanhSachSanPham') && !Yii::app()->CPOSSessionManager->isEmpty('KhoangThoiGian')) {
            $data = Yii::app()->CPOSSessionManager->getItem('DanhSachSanPham');
            $data1=  Yii::app()->CPOSSessionManager->getItem('KhoangThoiGian');
            $danhSachSanPham = $data[0];
            $khoangThoiGian = $data1[0];
        }

        isset($danhSachSanPham) ? $this->render('xuatexcelnhapxuatton', array('dataProvider' => $danhSachSanPham,'khoangThoiGian'=>$khoangThoiGian)) : $this->render('_blank');
    }

    public function actionXuatExcelBanHangChiNhanh() {
        if (!Yii::app()->CPOSSessionManager->isEmpty('BanHangChiNhanh') && !Yii::app()->CPOSSessionManager->isEmpty('KhoangThoiGian')) {
            $data = Yii::app()->CPOSSessionManager->getItem('BanHangChiNhanh');
            $data1=  Yii::app()->CPOSSessionManager->getItem('KhoangThoiGian');
            $danhSachChiNhanh = $data[0];
            $khoangThoiGian = $data1[0];
        }

        isset($danhSachChiNhanh) ? $this->render('xuatexcelbanhangchinhanh', array('dataProvider' => $danhSachChiNhanh,'khoangThoiGian'=>$khoangThoiGian)) : $this->render('_blank');
    }

    public function actionXuatExcelBanHangTop() {

        if (!Yii::app()->CPOSSessionManager->isEmpty('BanHangTop') && !Yii::app()->CPOSSessionManager->isEmpty('KhoangThoiGian')) {
            $data = Yii::app()->CPOSSessionManager->getItem('BanHangTop');
            $data1=  Yii::app()->CPOSSessionManager->getItem('KhoangThoiGian');
            $danhSachSanPham = $data[0];
            $khoangThoiGian = $data1[0];
        }

        isset($danhSachSanPham) ? $this->render('xuatexcelbanhangtop', array('dataProvider' => $danhSachSanPham,'khoangThoiGian'=>$khoangThoiGian)) : $this->render('_blank');
    }




}