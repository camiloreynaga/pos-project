<?php
/**
 * User: ${Cristazn}
 * Date: 4/20/13
 * Time: 2:20 PM
 * Email: crist.azn@gmail.com | Phone : 0963-500-980
 */

abstract class CPOSController extends GxController
{

    public function loadModel($key, $modelClass)
    {
        // Get the static model.
        $staticModel = CPOSActiveRecord::model($modelClass);

        if (is_array($key)) {
            // The key is an array.
            // Check if there are column names indexing the values in the array.
            reset($key);
            if (key($key) === 0) {
                // There are no attribute names.
                // Check if there are multiple PK values. If there's only one, start again using only the value.
                if (count($key) === 1)
                    return $this->loadModel($key[0], $modelClass);

                // Now we will use the composite PK.
                // Check if the table has composite PK.
                $tablePk = $staticModel->getTableSchema()->primaryKey;
                if (!is_array($tablePk))
                    throw new CHttpException(400, Yii::t('giix', 'Your request is invalid.'));

                // Check if there are the correct number of keys.
                if (count($key) !== count($tablePk))
                    throw new CHttpException(400, Yii::t('giix', 'Your request is invalid.'));

                // Get an array of PK values indexed by the column names.
                $pk = $staticModel->fillPkColumnNames($key);

                // Then load the model.
                $model = $staticModel->findByPk($pk);
            } else {
                // There are attribute names.
                // Then we load the model now.
                $model = $staticModel->findByAttributes($key);
            }
        } else {
            // The key is not an array.
            // Check if the table has composite PK.
            $tablePk = $staticModel->getTableSchema()->primaryKey;
            if (is_array($tablePk)) {
                // The table has a composite PK.
                // The key must be a string to have a PK separator.
                if (!is_string($key))
                    throw new CHttpException(400, Yii::t('giix', 'Your request is invalid.'));

                // There must be a PK separator in the key.
                if (stripos($key, CPOSActiveRecord::$pkSeparator) === false)
                    throw new CHttpException(400, Yii::t('giix', 'Your request is invalid.'));

                // Generate an array, splitting by the separator.
                $keyValues = explode(CPOSActiveRecord::$pkSeparator, $key);

                // Start again using the array.
                return $this->loadModel($keyValues, $modelClass);
            } else {
                // The table has a single PK.
                // Then we load the model now.
                $model = $staticModel->findByPk($key);
            }
        }

        // Check if we have a model.
        if ($model === null)
            throw new CHttpException(404, Yii::t('giix', 'The requested page does not exist.'));


        // kiem tra xem co truong nao la kieu du lieu date. Chuyen thanh dang d-m-Y
        $tableSchema = $model->getTableSchema();
        $columnNames = $tableSchema->getColumnNames();
        foreach ($columnNames as $column) {
            $columnSchema = $tableSchema->getColumn($column);
            if ($columnSchema->dbType == 'date')
                $model->formatDate($column);
            if ($columnSchema->dbType == 'datetime')
                $model->formatDate($column, 'd-m-Y h:i:s');

        }

        return $model;

    }


    public function actionGetSanPhamBan($ma_vach)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            if (isset($ma_vach))
                $model = SanPham::model()->findByAttributes(array('ma_vach' => $ma_vach));

                $item = array(
                    'id' => $model->getAttribute('id'),
                    'ma_vach' => $model->getAttribute('ma_vach'),
                    'ten_san_pham' => $model->getAttribute('ten_san_pham'),
                    'gia_goc' => $model->getAttribute('gia_goc'),
                );
                echo json_encode($item);

        } else
            throw new CHttpException(400, Yii::t('viLib', 'Your request is invalid.'));
    }

    public function actionGetSanPhamTang($ma_vach)
    {

        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            if (isset($ma_vach))
                $model = SanPhamTang::model()->findByAttributes(array('ma_vach' => $ma_vach));

            $item = array(
                'id' => $model->getAttribute('id'),
                'ma_vach' => $model->getAttribute('ma_vach'),
                'ten_san_pham' => $model->getAttribute('ten_san_pham'),
                'gia_tang' => $model->getAttribute('gia_tang'),
            );
            echo json_encode($item);
        } else
            throw new CHttpException(400, Yii::t('viLib', 'Your request is invalid.'));
    }

}