$(document).ready(function () {
    $(document).on(
        "click",
        "#general_return_sales_orders_open_active_bill",
        function () {
            var date = $("#general_return_sales_orders_invoice_date").val();
            let customer_code = $(
                "#general_return_sales_orders_customer_code option:selected"
            ).val();
            let delegate_code = $(
                "#general_return_sales_orders_delegate_code option:selected"
            ).val();
            let sales_material_type_id = $(
                "#general_return_sales_orders_sales_material_type option:selected"
            ).val();

            if (date == null || date == "") {
                alert("ادخل التاريخ");
                return;
            }

            if (
                sales_material_type_id == null ||
                sales_material_type_id == ""
            ) {
                alert("اختر نوع فئه الفاتوره");
                return;
            }

            if (customer_code == null || customer_code == "") {
                alert("اختر العميل");
                return;
            }

            if (delegate_code == null || delegate_code == "") {
                alert("اختر المندوب");
                return;
            }

            var token_search = $("#token_search").val();
            var url = $("#general_return_sales_orders_open_active_bill").val();

            $.ajax({
                url: url,
                type: "POST",
                dataType: "html",
                cache: false,

                data: {
                    date: date,
                    customer_code: customer_code,
                    delegate_code: delegate_code,
                    sales_material_type_id: sales_material_type_id,
                    _token: token_search,
                },

                success: function (response) {
                    $("#general_return_sales_orders_modal_activebill").one(
                        "hidden.bs.modal",
                        function () {
                            // Put the returned HTML into a container
                            $(
                                "#general_return_sales_orders_modal_billitems"
                            ).html(response);

                            // Show the modal that came from the returned HTML

                            $(
                                "#general_return_sales_orders_modal_billitems"
                            ).modal("show");
                        }
                    );

                    $("#general_return_sales_orders_modal_activebill").modal(
                        "hide"
                    );
                },
                error: function (xhr) {
                    alert("يوجد خطا ما");
                },
            });
        }
    );

    $(document).on("click", ".edit_bill", function () {
        var auto_serial = $(this).data("autoserial");
        var url = $(
            "#general_return_sales_orders_get_active_bill_data_url"
        ).val();

        $.ajax({
            url: url,
            type: "GET",
            dataType: "html",
            cache: false,

            data: {
                auto_serial: auto_serial,
            },

            success: function (response) {
                $("#general_return_sales_orders_modal_billitems").html(
                    response
                );

                $("#general_return_sales_orders_modal_billitems").modal("show");
            },
            error: function (xhr) {
                console.log(xhr);
                console.log(status);
                console.log(xhr.responseText);
            },
        });
    });

    $(document).on(
        "change",
        "#general_return_sales_orders_item_code",
        function () {
            $(".related_itemcard_date").hide();
            $("#general_return_sales_orders_sale_type").val("");
            var item_code = $("#general_return_sales_orders_item_code").val();
            let item_type = $(
                "#general_return_sales_orders_item_code option:selected"
            ).data("type");

            if (item_code != "") {
                var token_search = $("#token_search").val();
                var ajax_getUnits = $(
                    "#general_return_sales_order_getUnits_url"
                ).val();

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
                        if (item_type == 2) {
                            $(".related_itemcard_date").show();
                        }
                        $("#general_return_sales_orders_unitsDiv").html(data);
                        $(".related_itemcard").show();
                    },

                    error: function (xhr) {
                        $("#general_return_sales_orders_unitsDiv").html("");
                        $(".related_itemcard").hide();
                    },
                });
            } else {
                $("#general_return_sales_orders_unitsDiv").html("");
                $(".related_to_itemcard").hide();
            }
        }
    );

    $(document).on(
        "input",
        "#general_return_sales_orders_quantity",
        function () {
            var quantity = $("#general_return_sales_orders_quantity").val();
            var price = $("#general_return_sales_orders_price").val("");
            var value = (price * 100 * quantity) / 100;
            $("#general_return_sales_orders_total_price").val(value);
        }
    );

    $(document).on("input", "#general_return_sales_orders_price", function () {
        var quantity = $("#general_return_sales_orders_quantity").val() || 0;
        var price = $("#general_return_sales_orders_price").val();
        var value = price * quantity;
        $("#general_return_sales_orders_total_price").val(value);
    });

    $(document).on(
        "click",
        "#general_return_sales_orders_save_edit_item",
        function () {
            var auto_serial = $(
                "#general_return_sales_orders_autoserial"
            ).val();

            var date = $(
                "#general_return_sales_orders_update_invoice_date"
            ).val();
            let customer_code = $(
                "#general_return_sales_orders_update_customer_code option:selected"
            ).val();
            let delegate_code = $(
                "#general_return_sales_orders_update_delegate_code option:selected"
            ).val();
            let sales_material_type_id = $(
                "#general_return_sales_orders_update_sales_material_type option:selected"
            ).val();

            if (date == null || date == "") {
                alert("ادخل التاريخ");
                return;
            }

            if (
                sales_material_type_id == null ||
                sales_material_type_id == ""
            ) {
                alert("اختر نوع فئه الفاتوره");
                return;
            }

            if (customer_code == null || customer_code == "") {
                alert("اختر العميل");
                return;
            }

            if (delegate_code == null || delegate_code == "") {
                alert("اختر المندوب");
                return;
            }

            var store_id = $(
                "#general_return_sales_orders_store option:selected"
            ).val();

            if (
                $("#general_return_sales_orders_store").val() == null ||
                $("#general_return_sales_orders_store").val() == ""
            ) {
                alert("اختر المخزن");
                return;
            }

            if (
                $("#general_return_sales_orders_item_code").val() == null ||
                $("#general_return_sales_orders_item_code").val() == ""
            ) {
                alert("اختر الصنف");
                return;
            }

            if (
                $("#general_return_sales_orders_unit_id_add").val() == null ||
                $("#general_return_sales_orders_unit_id_add").val() == ""
            ) {
                alert("اختر وحده الصنف");
                return;
            }

            let item_type = $(
                "#general_return_sales_orders_item_code option:selected"
            ).data("type");

            if (
                item_type == 2 &&
                ($("#general_return_sales_orders_production_date").val() ==
                    null ||
                    $("#general_return_sales_orders_production_date").val() ==
                        "")
            ) {
                alert("ادخل تاريخ الانتاج");
                return;
            }

            if (
                item_type == 2 &&
                ($("#general_return_sales_orders_end_date").val() == null ||
                    $("#general_return_sales_orders_end_date").val() == "")
            ) {
                alert("ادخل تاريخ الانتهاء");
                return;
            }

            if (
                $(
                    "#general_return_sales_orders_sale_type option:selected"
                ).val() == null ||
                $(
                    "#general_return_sales_orders_sale_type option:selected"
                ).val() == ""
            ) {
                alert("اختر نوع البيع");
                return;
            }

            if (
                $("#general_return_sales_orders_quantity").val() == null ||
                $("#general_return_sales_orders_quantity").val() == "" ||
                $("#general_return_sales_orders_quantity").val() < 0
            ) {
                alert("ادخل الكميه المطلوبه بطريقه صحيحه");
                return;
            }

            if (
                $("#general_return_sales_orders_price").val() == null ||
                $("#general_return_sales_orders_price").val() == "" ||
                $("#general_return_sales_orders_price").val() < 0
            ) {
                alert("السعر مطلوب وبطريقه صحيحه ");
                return;
            }

            if (
                $("#general_return_sales_orders_total_price").val() == null ||
                $("#general_return_sales_orders_total_price").val() == ""
            ) {
                alert("السعر مطلوب");
                return;
            }

            var item_code = $("#general_return_sales_orders_item_code").val();
            var unit_id = $("#general_return_sales_orders_unit_id_add").val();
            var sale_type = $("#general_return_sales_orders_sale_type").val();
            var quantity = $("#general_return_sales_orders_quantity").val();
            var price = $("#general_return_sales_orders_price").val();
            var production_date = $(
                "#general_return_sales_orders_production_date"
            ).val();
            var end_date = $("#general_return_sales_orders_end_date").val();
            var total_price = $(
                "#general_return_sales_orders_total_price"
            ).val();
            var url = $(
                "#general_return_sales_orders_active_add_items_url"
            ).val();
            let parent_unit = $(
                "#general_return_sales_orders_unit_id_add option:selected"
            ).data("isparentunit");

            var sale_type_name = $(
                "#general_return_sales_orders_sale_type option:selected"
            ).text();
            var item_name = $(
                "#general_return_sales_orders_item_code option:selected"
            ).text();
            var unit_name = $(
                "#general_return_sales_orders_unit_id_add option:selected"
            ).text();

            var token_search = $("#token_search").val();

            $.ajax({
                url: url,
                type: "POST",
                dataType: "html",
                cache: false,

                data: {
                    date: date,
                    customer_code: customer_code,
                    delegate_code: delegate_code,
                    sales_material_type_id: sales_material_type_id,
                    auto_serial: auto_serial,
                    store_id: store_id,
                    item_code: item_code,
                    unit_id: unit_id,
                    sale_type: sale_type,
                    quantity: quantity,
                    price: price,
                    total_price: total_price,
                    production_date: production_date,
                    end_date: end_date,
                    parent_unit: parent_unit,
                    unit_name: unit_name,
                    item_name: item_name,
                    sale_type_name: sale_type_name,
                    _token: token_search,
                },

                success: function (data) {
                    $("#general_return_sales_orders_table_items").html(data);

                    var item_total_price = 0;

                    $(".item_total_price").each(function () {
                        item_total_price += Number($(this).val());
                    });

                    $("#total").val(item_total_price / 100);
                    $("#item_code").val("");
                    $("#unit_id_add").val("");
                    $("#quantity_with_date").val("");
                    $("#price").val("");
                    $("#sale_type").val("");
                },

                error: function (xhr) {
                    console.log(xhr.responseText);
                },
            });
        }
    );

});
