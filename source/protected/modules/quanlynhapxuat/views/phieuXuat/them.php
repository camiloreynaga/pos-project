<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/BaseAjaxTransferData.js');
?>
    <script>
    // ===================================== GLOBAL AREA ============================================
    extendClass(AjaxTransferData, BaseAjaxTransferData);
    var ajaxTransferDataObject = new AjaxTransferData();
    ajaxTransferDataObject.defaultAjaxUrl = "<?php echo Yii::app()->createUrl('quanlynhapxuat/phieuXuat') ?>";

    $(window).load(function () {
        // When grid is empty and data is exist on session. Fill grid again with data from the session
        if (ajaxTransferDataObject.isEmptyGrid()) {
            var isEmptySession = <?php echo (Yii::app()->CPOSSessionManager->isEmpty('ChiTietPhieuXuat'))?1:0?>;
            if (!isEmptySession) {
                ajaxTransferDataObject.addedItems = <?php echo json_encode(Yii::app()->CPOSSessionManager->getItem('ChiTietPhieuXuat'))?>;
                // Refill grid
                $.each(ajaxTransferDataObject.addedItems.items, function (key, value) {
                    var item = ajaxTransferDataObject.addedItems.items[key];
                    ajaxTransferDataObject.renderRow(item);
                });
                calTotal();
            }
        }
    });

    $(document).ready(function () {
        $('#barcode').blur(function () {
            item = BaseAjaxTransferData.getStaticProduct(ajaxTransferDataObject.defaultAjaxUrl);
            if (item != null)
                $('#productname').val(item.ten_san_pham);
        });

    });

    function keypressInputMa(e) {
        switch (e.keyCode) {
            case 13:
            {
                if (ajaxTransferDataObject.hasInputErrors()) {
                    ajaxTransferDataObject.renderErrors();
                    ajaxTransferDataObject.focusErrors();
                    return false; //  ko cho thuc thi tiep
                } else {
                    // khong co loi xay ra. Dua du lieu vao Grid
                    // truoc khi dua du lieu thi kiem tra no co ton tai tren grid chua
                    ajaxTransferDataObject.fillItemsToGrid();
                    ajaxTransferDataObject.syncSession(ajaxTransferDataObject.defaultAjaxUrl);
                    ajaxTransferDataObject.resetInputs();
                    calTotal();

                }
            }
        }
    }
    // =====================================================================================

    // ==================================== CLASS AREA ====================================
    function AjaxTransferData() {
        this.barcode = "#barcode";
        this.productName = "#productname";
        this.quantity = "#quantity";
        this.price = "#price";
        this.exportBranch = "#ChungTu_chi_nhanh_id";
    };

    AjaxTransferData.prototype.fillItemsToGrid = function () {
        var item = $.parseJSON(this.dataStored);
        var position = this.isInArray(item.id);   // position of item in added list.
        if (position < 0) {
            // not found in added Array. Need to add new it.
            item.so_luong = parseInt(trimNumber($(this.quantity).val()));
            item.gia_nhap = parseInt(trimNumber($(this.price).val()));
            this.renderRow(item);
            this.addedItems.items.push(item);
        } else {
            // modify existed record on grid. Plus the quantity and change the price
            var quantitySelector = '#sl_' + item.id;
            var priceSelector = '#dg_' + item.id;
            var newQuantity = parseInt(trimNumber($(quantitySelector).val())) + parseInt(trimNumber($(this.quantity).val()));
            var newPrice = parseInt(trimNumber($(this.price).val()));

            $(quantitySelector).val(newQuantity);
            $(priceSelector).val(newPrice);
            // modify data in addedItems
            var newData = {
                'so_luong': newQuantity,
                'gia_nhap': newPrice
            };
            this.updateItemAtPosition(position, newData);
        }
        // clear dataStored after fill to grids
        this.dataStored = null;

    }

    AjaxTransferData.prototype.hasInputErrors = function () {
        this.checkInputErrors();
        if (this.errors.length > 0)
            return true;
        else
            return false;

    }

    // kiem tra loi nhap lieu khi nguoi dung nhap vao va dua vao info-board
    AjaxTransferData.prototype.checkInputErrors = function () {
        this.errors = new Array();
        this.customInfoBoard = $('<div>').addClass('error');
        //1. Kiem tra ma_vach xem neu ma vach do thuoc san pham nao
        if ($(this.barcode).val() === 'undefined') {
            $('<p>', {
                class: 'custom-error-messages'
            }).text('<?php print(Yii::t('viLib','Product is undefined. Please type a barcode'))?>').appendTo(this.customInfoBoard);
            this.errors.push(1);

        }
        else {
            if (!this.getProduct(this.defaultAjaxUrl, $(this.barcode).val())) {
                // neu san pham chua co trong danh sach san pham. Lam thong bao loi dua vao trong info-message
                $('<p>', {
                    class: 'custom-error-messages'
                }).text('<?php print(Yii::t('viLib','Product not found. Please try another barcode'))?>').appendTo(this.customInfoBoard);
                this.errors.push(1);
            }
        }

        //2. Kiem tra gia nhap
        if ($(this.price).val() === 'undefined') {
            $('<p>', {
                class: 'custom-error-messages'
            }).text('<?php print(Yii::t('viLib','Import price is undefined. Please fill it'))?>').appendTo(this.customInfoBoard);
            this.errors.push(2);
        } else if ($(this.price).val() <= 0) {
            // set  error
            $('<p>', {
                class: 'custom-error-messages'
            }).text('<?php print(Yii::t('viLib','Import price must have greater than zero'))?>').appendTo(this.customInfoBoard);
            this.errors.push(2);
        } else if (isNaN($(this.price).val())) {
            $('<p>', {
                class: 'custom-error-messages'
            }).text('<?php print(Yii::t('viLib','Data mistmatch'))?>').appendTo(this.customInfoBoard);
            this.errors.push(2);
        }

        //3. Kiem tra so luong
        if ($(this.quantity).val() === 'undefined') {
            $('<p>', {
                class: 'custom-error-messages'
            }).text('<?php print(Yii::t('viLib','Quantity is undefined. Please fill it'))?>').appendTo(this.customInfoBoard);
            this.errors.push(3);
        } else if ($(this.quantity).val() <= 0) {
            // set  error
            $('<p>', {
                class: 'custom-error-messages'
            }).text('<?php print(Yii::t('viLib','Quantity must have greater than zero'))?>').appendTo(this.customInfoBoard);
            this.errors.push(3);
        } else if (isNaN($(this.quantity).val())) {
            $('<p>', {
                class: 'custom-error-messages'
            }).text('<?php print(Yii::t('viLib','Data mistmatch'))?>').appendTo(this.customInfoBoard);
            this.errors.push(3);
        } else {
            var result = this.isOverInstock(this.defaultAjaxUrl,$(this.barcode).val(),$(this.exportBranch).val());
            switch (result) {
                case 'over': {
                    $('<p>', {
                        class: 'custom-error-messages'
                    }).text('<?php print(Yii::t('viLib','Input quantity is greater than instock.'))?>').appendTo(this.customInfoBoard);
                    this.errors.push(3);
                    break;
                }
                case 'over-limit':{
                    $('<p>', {
                        class: 'custom-error-messages'
                    }).text('<?php print(Yii::t('viLib','Input quantity is greater than limit minimum instock.'))?>').appendTo(this.customInfoBoard);
                    this.errors.push(3);
                    break;
                }
                case 'not-found': {
                    $('<p>', {
                        class: 'custom-error-messages'
                    }).text('<?php print(Yii::t('viLib','Quantity of this product is not exist in this branch'))?>').appendTo(this.customInfoBoard);
                    this.errors.push(3);
                    break;
                }

            }
        }
        // neu co loi xay ra hien thi info-board de nguoi dung sua lai
        return this.errors;

    }

    AjaxTransferData.prototype.focusErrors = function () {
        if (this.errors.length > 0) {
            // focus vao error dau tien
            var error = this.errors[0];
            switch (error) {
                case 1:
                {
                    $(this.barcode).val('');
                    $(this.barcode).focus();
                    break;
                }
                case 2:
                {
                    $(this.price).val('');
                    $(this.price).focus();
                    break;
                }
                case 3:
                {
                    $(this.quantity).val('');
                    $(this.quantity).focus();
                    break;
                }

            }
        }
        this.errors = null;
    }

    AjaxTransferData.prototype.resetInputs = function () {
        $(this.barcode).val('');
        $(this.productName).val('');
        $(this.quantity).val(0);
        $(this.price).val(0);
    }


    AjaxTransferData.prototype.renderRow = function (item) {
        var even_odd = 'even';
        if (this.getNumRowsTable() % 2 == 0)
            even_odd = 'odd';
        var strRow =
            '<tr class="' + even_odd + '">' +
                '<input type="hidden" value="' + item.id + '" id="" />' +
                '<td>' + item.ma_vach + '<input type="hidden" name="ma_vach[]" value="' + item.ma_vach + '"/>' + '</td>' +
                '<td>' + item.ten_san_pham + '<input type="hidden" name="ten_san_pham[]" value="' + item.ten_san_pham + '"/>' + '</td>' +
                '<td>' + '<input type="text" name="so_luong[]" onblur="return changeQuantity(' + item.id + ')" value="' + item.so_luong + '" id="sl_' + item.id + '" class="number" />' + '</td>' +
                '<td>' + '<input type="text" name="gia_nhap[]" onblur="return changePrice(' + item.id + ')" value="' + item.gia_nhap + '" id="dg_' + item.id + '" class="number" />' + '</td>' +
                '<td>' + '<a href="#" onclick="return ajaxTransferDataObject.removeItem(' + item.id + ')">' + '<img src="<?php echo Yii::app()->theme->baseUrl . '/images/delete.png'?>" id="cl_' + item.id + '" class="clearitems" alt="Xóa"/>' + '</a>' + '</td>' +

                '</tr>';
        $(this.gridTable).append(strRow);
    }


    AjaxTransferData.prototype.removeItem = function (id) {
        this.clearItem(id);
        $('#cl_' + id).parent().parent().parent().remove();
        ajaxTransferDataObject.syncSession(ajaxTransferDataObject.defaultAjaxUrl);
        calTotal();
        return false;

    }

    function calTotal() {
        var total = 0;
        for (var i = 0; i < ajaxTransferDataObject.addedItems.items.length; i++) {
            total = total + ajaxTransferDataObject.addedItems.items[i].so_luong * ajaxTransferDataObject.addedItems.items[i].gia_nhap;
        }
        $('#ChungTu_tri_gia').val(total);
    }

    function changeQuantity(id) {
        var newData = {
            'so_luong': parseInt($('#sl_' + id).val())
        };
        var position = ajaxTransferDataObject.isInArray(id);
        ajaxTransferDataObject.updateItemAtPosition(position, newData);
        ajaxTransferDataObject.syncSession(ajaxTransferDataObject.defaultAjaxUrl);
        calTotal();
    }

    function changePrice(id) {
        var newData = {
            'gia_nhap': parseInt($('#dg_' + id).val())
        };
        var position = ajaxTransferDataObject.isInArray(id);
        ajaxTransferDataObject.updateItemAtPosition(position, newData);
        ajaxTransferDataObject.syncSession(ajaxTransferDataObject.defaultAjaxUrl);
        calTotal();
    }

    AjaxTransferData.prototype.isOverInstock = function(url, ma_vach, chi_nhanh_id) {
        var strUrl;
        var result = 'ok';
        if(typeof (url)==='undefined')
            strUrl = "/laysoluongton/ma_vach/" + ma_vach + "/chi_nhanh_id/"  + chi_nhanh_id;
        strUrl = url + "/laysoluongton/ma_vach/" + ma_vach + "/chi_nhanh_id/"  + chi_nhanh_id;
        var ret;
        $.ajax({
            url: strUrl,
            type:"POST",
            async:false,
            success:function(response) {
                ret = response;
            }
        });

        var item = $.parseJSON(ret);
        var slnhapvao = parseInt($(this.quantity).val());

        if(item.so_ton==false)
            return result = 'not-found';
        if(item.so_ton < slnhapvao)        // so xuat > ton
            return result = 'over-instock';
        if(item.ton_toi_thieu > (item.so_ton - slnhapvao))  // so xuat < ton. Nhung khi tru thi ket qua duoi dinh muc ton toi thieu
            return result = 'over-limit';
        return result;
    }

    </script>

<?php
$this->breadcrumbs = array(
    Yii::t('viLib', 'Import/Export management') => array('chiNhanh/danhsach'),
    Yii::t('viLib', 'Export form') => array(),
    Yii::t('viLib', 'Create') => array(),
);
?>

    <h1><?php echo Yii::t('viLib', 'Create') . ' ' . Yii::t('viLib','Export form'); ?></h1>

<?php
    $this->renderPartial('_form', array(
    'model' => $model,
    'id' => isset($id) ? $id : null,
    'buttons' => 'create'));
?>