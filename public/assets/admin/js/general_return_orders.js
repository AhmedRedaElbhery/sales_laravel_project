$(document).ready(function () {
    $(document).on("change", "#general_item_card_add", function () {
        var item_code = $(this).val();

        if (item_code != "") {
            var token_search = $("#token_search").val();
            var ajax_getUnits = $("#ajax_getUnits_url").val();

            $.ajax({
                url: ajax_getUnits,
                type: "POST",
                dataType: "html",
                cache: false,

                data: {
                    item_code: item_code,
                    _token: token_search,
                },

                success: function (data) {
                    $("#unitsDiv").html(data);
                    $(".related_to_itemcard").show();

                    var type = $("#item_card_add")
                        .find(":selected")
                        .attr("data-type");
                    if (type == "2") {
                        $(".related_to_date").show();
                    } else {
                        $(".related_to_date").hide();
                    }

                    $("#unit_id_add").select2({
                        theme: "bootstrap4",
                    });
                },

                error: function (xhr) {
                    $("#unitsDiv").html("");
                    $(".related_to_itemcard").hide();
                    $(".related_to_date").hide();
                },
            });
        } else {
            $("#unitsDiv").html("");
            $(".related_to_itemcard").hide();
        }
    });

    $(document).on("change", "#general_unit_id_add", function () {

        var item_code =  $("#general_item_card_add").val();
        var unit_id = $("#general_unit_id_add").val();
        var store_id = $("#store_id").val();

        if (item_code != "") {
            var token_search = $("#token_search").val();
            var ajax_get_batchs = $("#ajax_get_batchs").val();

            $.ajax({
                url: ajax_get_batchs,
                type: "GET",
                dataType: "html",
                cache: false,

                data: {
                    item_code: item_code,
                    unit_id: unit_id,
                    store_id: store_id,
                    _token: token_search,
                },

                success: function (data) {
                    $("#batchs_div").html(data);
                    $(".batchs").show();
                },

                error: function (xhr) {
                    $("#batchs_div").html("");
                    $(".batchs").hide();
                },
            });
        } else {
            $("#batchs_div").html("");
            $(".batchs").hide();
        }
    });

    $(document).on("click", "#addtobill", function () {
        var item_card = $("#general_item_card_add").val();
        if (item_card == null) {
            alert("من فضلك اختر الصنف");
            $("#general_item_card_add").focus();
            return false;
        }

        var unit = $("#general_unit_id_add").val();
        if (unit == null) {
            alert("من فضلك اختر الوحده");
            $("#general_unit_id_add").focus();
            return false;
        }

        var batch = $("#quantity_with_date option:selected").val();
        if (batch == "" || batch <= "0") {
            alert("من فضلك اختر الباتش المراد الاسترجاع منه");
            $("#quantity_with_date").focus();
            return false;
        }

        var return_quantity = $("#return_quantity").val();
        if (return_quantity == "" || return_quantity <= "0") {
            alert("من فضلك ادخل الكميه");
            $("#return_quantity").focus();
            return false;
        }



        var autoserialparent = $("#autoserialparent").val();

        var token_search = $("#token_search").val();
        var ajax_addunits = $("#ajax_addunits").val();
        var isparent = $("#general_unit_id_add option:selected").data('isparentunit');

        $.ajax({
            url: ajax_addunits,
            type: "POST",
            dataType: "json",
            cache: false,

            data: {
                autoserialparent: autoserialparent,
                _token: token_search,
                item_card: item_card,
                unit: unit,
                batch: batch,
                return_quantity: return_quantity,
                isparent: isparent,
            },

            success: function (data) {
                alert("تمت الاضافه بنجاح");
                window.location.reload();
            },

            error: function (xhr) {
                alert("يوجد خطا ما");
            },
        });
    });

    $(document).on("click", ".edititem", function () {
        var id = $(this).data("id");
        var autoserialparent = $("#autoserialparent").val();
        var token_search = $("#token_search").val();
        var ajax_getUnits = $("#ajax_edititem").val();

        $.ajax({
            url: ajax_getUnits,
            type: "POST",
            dataType: "html",
            cache: false,

            data: {
                autoserialparent: autoserialparent,
                _token: token_search,
                id: id,
            },

            success: function (data) {
                $("#edit_item_model_body").html(data);
                $("#edit_item_model").modal("show");
            },

            error: function (xhr, status, error) {
                $("#edit_item_model_body").html("");
                $("#edit_item_model").modal("hide");
            },
        });
    });

    $(document).on("click", "#general_update_items", function () {

        var return_quantity = $("#edit_return_quantity").val();
        if (return_quantity == "" || return_quantity <= "0") {
            alert("من فضلك ادخل الكميه");
            $("#return_quantity").focus();
            return false;
        }

        var isparent = $("#general_unit_id_edit option:selected").data('isparentunit');
        var item_card = $('#general_item_card_edit option:selected').val();
        var autoserialparent = $("#autoserialparent").val();
        var token_search = $("#token_search").val();
        var ajax_addunits = $("#ajax_updateitem").val();
        var id = $("#id").val();


        $.ajax({
            url: ajax_addunits,
            type: "POST",
            dataType: "json",
            cache: false,

            data: {
                autoserialparent: autoserialparent,
                _token: token_search,
                return_quantity: return_quantity,
                id: id,
                isparent: isparent,
                item_card: item_card,
            },

            success: function (data) {
                alert("تم التعديل بنجاح");
                window.location.reload();
            },

            error: function (xhr) {
                alert("يوجد خطا ما");
            },
        });
    });

    $(document).on("input", "#general_tax_percent", function () {
        $("#general_discount_percent").val("");
        $("#general_discount_value").val("");
        var what_received = $("#general_what_received").val("");
        var tax_percent = $("#general_tax_percent").val();

        if (tax_percent > 100 || tax_percent < 0) {
            alert(" خطا بنسبه الضريبه ادخل نسبه صحيحه");
            $("#general_tax_percent").val("");
            $("#general_tax_value").val("");
            return false;
        }

        var total = $("#general_total").val();

        value = (total * tax_percent) / 100;

        $("#general_tax_value").val(value);

        var total_value = parseFloat(total) + parseFloat(value);

        $("#general_total_value").val(total_value);

    });

    $(document).on("input", "#general_discount_percent", function () {
        var discount_percent = $("#general_discount_percent").val();
        $("#general_what_received").val("");
        if (discount_percent > 100 || discount_percent < 0) {
            alert(" خطا بنسبه الخصم ادخل نسبه صحيحه");
            $("#general_discount_percent").val("");
            $("#general_discount_value").val("");
            return false;
        }

        var total = parseFloat($("#general_total").val());
        var tax_value = parseFloat($("#general_tax_value").val() || 0);

        value = ((total + tax_value) * discount_percent) / 100;

        $("#general_discount_value").val(value);

        var total_value = total + tax_value - value;
        $("#general_total_value").val(total_value);

    });

    $(document).on("input", "#general_what_received", function () {
        var total = $("#general_total_value").val();

        var what_received = $("#general_what_received").val();

        $("#general_what_remain").val(total - what_received);
    });

    $(document).on("click", "#general_approve_bill", function () {

        var tax_percent = $("#general_tax_percent").val();

        if (tax_percent == null || tax_percent == "") {
            alert("من فضلك ادخل نسبه الضريبه");
            $("#general_tax_percent").focus();
            return false;
        }

        var discount_percent = $("#general_discount_percent").val();

        if (discount_percent == null || discount_percent == "") {
            alert("من فضلك ادخل نسبه الخصم");
            $("#general_discount_percent").focus();
            return false;
        }

        let what_received = $("#general_what_received").val();

        if (what_received == null || what_received === "") {
            alert("ادخل الرصيد المستلم");
            $("#general_what_received").focus();
            return false;
        }

        var autoserialparent = $("#autoserialparent").val();
        var what_remain = $("#general_what_remain").val();
        var tax_value = $("#general_tax_value").val();
        var discount_value = $("#general_discount_value").val();
        var total_value = $("#general_total_value").val();
        var treasuries_id = $("#general_treasuries_id").val();
        var token_search = $("#token_search").val();
        var model_approve_route = $("#model_approve_route").val();

        $.ajax({
            url: model_approve_route,
            type: "POST",
            dataType: "json",
            cache: false,

            data: {
                autoserialparent: autoserialparent,
                _token: token_search,

                tax_percent: tax_percent,
                tax_value: tax_value,

                discount_percent: discount_percent,
                discount_value: discount_value,

                what_received: what_received,
                what_remain: what_remain,

                treasuries_id: treasuries_id,
                total_value: total_value,
            },

            success: function (data) {
                alert(data.message);
                window.location.href = data.redirect;
            },

            error: function (xhr) {
                alert("حدث خطا ما");
            },


        });
    });
});
