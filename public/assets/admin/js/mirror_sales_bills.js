$(document).ready(function () {
    $(document).on("change", "#mirror_item_code", function () {

        var item_code = $("#mirror_item_code").val();
        let item_type = $("#mirror_item_code option:selected").data("type");
        let store_id = $("#mirror_store_id option:selected").val();

        if (store_id == null || store_id == "") {
            alert("اختر المخزن");
            $("#mirror_item_code").val("").trigger("change.select2");
            return;
        }

        if (item_code != "") {
            var token_search = $("#token_search").val();
            var ajax_getUnits = $("#mirror_sales_item_getUnits_url").val();

            $.ajax({
                url: ajax_getUnits,
                type: "GET",
                dataType: "html",
                cache: false,

                data: {
                    item_code: item_code,
                    item_type: item_type,
                    _token: token_search,
                },

                success: function (data) {
                    $("#mirror_unitsDiv").html(data);
                    $("#mirror_unitsDiv").show();
                },

                error: function (xhr) {
                    $("#mirror_unitsDiv").html("");
                    $("#mirror_unitsDiv").hide();
                },
            });
        } else {
            $("#mirror_unitsDiv").html("");
            $("#mirror_unitsDiv").hide();
        }
    });

    $(document).on("change", "#mirror_unit_id_add", function () {
        var item_code = $("#mirror_item_code").val();
        var unit_id = $("#mirror_unit_id_add option:selected").val();
        let item_type = $("#mirror_item_code option:selected").data("type");
        let store_id = $("#mirror_store_id option:selected").val();

        if (item_code != "" && store_id != "") {
            var token_search = $("#token_search").val();
            var ajax_get_batchs = $(
                "#mirror_sales_item_get_batchs_url"
            ).val();

            $.ajax({
                url: ajax_get_batchs,
                type: "GET",
                dataType: "html",
                cache: false,

                data: {
                    item_code: item_code,
                    item_type: item_type,
                    unit_id: unit_id,
                    store_id: store_id,
                    _token: token_search,
                },

                success: function (data) {
                    $("#mirror_batchs_div").html(data);
                    $("#mirror_batchs_div").show();
                },

                error: function (xhr) {
                    $("#mirror_batchs_div").html("");
                    $("#mirror_batchs_div").hide();
                },
            });
        } else {
            $("#mirror_batchs_div").html("");
            $("#mirror_batchs_div").hide();
        }
    });

    $(document).on("change", "#mirror_sale_type", function () {
        var quantity = $("#mirror_quantity").val();
        var price = $("#mirror_price").val();

        $("#mirror_total_price").val(price * quantity);

        if (
            $("#mirror_store_id option:selected").val() == null ||
            $("#mirror_store_id option:selected").val() == ""
        ) {
            alert("اختر المخزن");
            $("#mirror_sale_type").val("").trigger("change.select2");
            return;
        }

        if (
            $("#mirror_item_code").val() == null ||
            $("#mirror_item_code").val() == ""
        ) {
            alert("اختر الصنف");
            $("#mirror_sale_type").val("").trigger("change.select2");
            return;
        }

        if (
            $("#mirror_unit_id_add").val() == null ||
            $("#mirror_unit_id_add").val() == ""
        ) {
            alert("اختر وحده الصنف");
            $("#mirror_sale_type").val("").trigger("change.select2");
            return;
        }

        let type = $("#mirror_sale_type option:selected").val();
        let unit_type = $("#mirror_unit_id_add option:selected").data(
            "isparentunit"
        );
        let unit_id = $("#mirror_unit_id_add option:selected").val();

        var token_search = $("#token_search").val();
        var ajax_getUnits = $("#sales_item_getprice_url").val();
        var item_code = $("#mirror_item_code").val();

        $.ajax({
            url: ajax_getUnits,
            type: "GET",
            dataType: "json",
            cache: false,

            data: {
                type: type,
                unit_type: unit_type,
                item_code: item_code,
                unit_id: unit_id,
                _token: token_search,
            },

            success: function (response) {
                $("#mirror_price_div").show();
                $("#mirror_price").val(response.price);
                var quantity = $("#mirror_quantity").val();
                var price = $("#mirror_price").val();
                var value = (price * 100 * quantity) / 100;
                $("#mirror_total_price").val(value);
            },
            error: function (xhr) {
                $("#mirror_price").html("");
            },
        });
    });

    $(document).on("input", "#mirror_quantity", function () {
        var quantity = $("#mirror_quantity").val();
        var price = $("#mirror_price").val();
        var value = (price * 100 * quantity) / 100;
        $("#mirror_total_price").val(value);
    });

    $(document).on("change", "#mirror_store_id", function () {
        $("#mirror_unit_id_add").val("").trigger("change.select2");
        $("#mirror_sale_type").val("");
        $("#mirror_price").val("");
    });

    $(document).on("click", "#mirror_save_item", function () {
        if (
            $("#mirror_store_id option:selected").val() == null ||
            $("#mirror_store_id option:selected").val() == ""
        ) {
            alert("اختر المخزن");
            return;
        }

        if (
            $("#mirror_item_code").val() == null ||
            $("#mirror_item_code").val() == ""
        ) {
            alert("اختر الصنف");
            return;
        }

        if (
            $("#mirror_unit_id_add").val() == null ||
            $("#mirror_unit_id_add").val() == ""
        ) {
            alert("اختر وحده الصنف");
            $("#mirror_sale_type").val("").trigger("change.select2");
            return;
        }

        if (
            $("#mirror_quantity_with_date option:selected").val() == null ||
            $("#mirror_quantity_with_date option:selected").val() == ""
        ) {
            alert("اختر الكميات");
            return;
        }

        if (
            $("#mirror_sale_type option:selected").val() == null ||
            $("#mirror_sale_type option:selected").val() == ""
        ) {
            alert("اختر نوع البيع");
            return;
        }

        if (
            $("#mirror_quantity").val() == null ||
            $("#mirror_quantity").val() == ""
        ) {
            alert("ادخل الكميه المطلوبه");
            return;
        }

        if (
            $("#mirror_price").val() == null ||
            $("#mirror_price").val() == ""
        ) {
            alert("السعر مطلوب");
            return;
        }

        if (
            $("#mirror_total_price").val() == null ||
            $("#mirror_total_price").val() == ""
        ) {
            alert("السعر مطلوب");
            return;
        }

        var store_id = $("#mirror_store_id").val();
        var item_code = $("#mirror_item_code").val();
        var unit_id = $("#mirror_unit_id_add").val();
        var quantity_with_date = $("#mirror_quantity_with_date").val();
        var sale_type = $("#mirror_sale_type").val();
        var quantity = $("#mirror_quantity").val();
        var price = $("#mirror_price").val();
        var total_price = $("#mirror_total_price").val();
        var url = $("#sales_item_getitems_url").val();
        let parent_unit = $("#mirror_unit_id_add option:selected").data(
            "isparentunit"
        );

        var sale_type_name = $("#mirror_sale_type option:selected").text();
        var item_name = $("#mirror_item_code option:selected").text();
        var unit_name = $("#mirror_unit_id_add option:selected").text();

        var token_search = $("#token_search").val();

        var normal_sale_name = "بيع عادى";
        var normal_sale = "0";

        $.ajax({
            url: url,
            type: "GET",
            dataType: "html",
            cache: false,

            data: {
                normal_sale: normal_sale,
                store_id: store_id,
                item_code: item_code,
                unit_id: unit_id,
                quantity_with_date: quantity_with_date,
                sale_type: sale_type,
                quantity: quantity,
                price: price,
                total_price: total_price,
                parent_unit: parent_unit,
                unit_name: unit_name,
                normal_sale_name: normal_sale_name,
                item_name: item_name,
                sale_type_name: sale_type_name,
                _token: token_search,
            },

            success: function (data) {

                $("#mirror_items_table").append(data);

                let item_total_price = 0;

                $(".mirror_total_price").each(function () {
                    item_total_price += parseFloat($(this).text()) || 0;
                });

                $("#mirror_total").val(item_total_price);
            },

            error: function (xhr) {
                $("#mirror_items_table").html("");
            },
        });
    });

    $(document).on("input", "#mirror_tax_percent", function () {
        $("#mirror_discount_percent").val("");
        $("#mirror_discount_value").val("");
        var tax_percent = $("#mirror_tax_percent").val();
        if (tax_percent > 100 || tax_percent < 0) {
            alert(" خطا بنسبه الضريبه ادخل نسبه صحيحه");
            $("#tax_percent").val("");
            $("#tax_value").val("");
            return false;
        }

        var total = $("#mirror_total").val();

        value = (total * tax_percent) / 100;

        $("#mirror_tax_value").val(value);
        var total_value = parseFloat(total) + parseFloat(value);

        $("#mirror_total_value").val(total_value);
    });

    $(document).on("input", "#mirror_discount_percent", function () {
        var discount_percent = $("#mirror_discount_percent").val();
        if (discount_percent > 100 || discount_percent < 0) {
            alert(" خطا بنسبه الخصم ادخل نسبه صحيحه");
            $("#mirror_discount_percent").val("");
            $("#mirror_discount_value").val("");
            return false;
        }

        var total = parseFloat($("#mirror_total").val());
        var tax_value = parseFloat($("#mirror_tax_value").val() || 0);

        value = ((total + tax_value) * discount_percent) / 100;

        $("#mirror_discount_value").val(value);

        var total_value = total + tax_value - value;
        $("#mirror_total_value").val(total_value);

    });


});
