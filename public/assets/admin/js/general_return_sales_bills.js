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
                                "#general_return_sales_orders_modal_activebill"
                            ).html(response);

                            // Show the modal that came from the returned HTML

                            $(
                                "#general_return_sales_orders_modal_activebill"
                            ).modal("show");

                            $("#general_return_sales_orders_modal_activebill").on("hidden.bs.modal", function () {
                                location.reload();
                            });
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

                    $("#general_return_sales_orders_table_items")
                        .find(".general_return_sales_orders_item_total_price")
                        .each(function () {
                            item_total_price += Number($(this).text().trim());
                        });

                    $("#general_return_sales_orders_total").val(
                        item_total_price
                    );
                },

                error: function (xhr) {
                    console.log(xhr.responseText);
                },
            });
        }
    );

    $(document).on(
        "click",
        "#general_return_sales_orders_delete",
        function (e) {
            e.preventDefault();

            let row = $(this).closest("tr");

            var record_id = $("#item_record_id").val();
            var is_parent_unit = $("#is_parent_unit").val();
            var token_search = $("#token_search").val();
            var ajax_deleteItem = $(
                "#general_return_sales_orders_delete_item_url"
            ).val();

            $.ajax({
                url: ajax_deleteItem,
                type: "DELETE",
                dataType: "json",
                data: {
                    record_id: record_id,
                    is_parent_unit: is_parent_unit,
                    _token: token_search,
                },

                success: function (response) {
                    alert(response.message);

                    row.remove();

                    var item_total_price = 0;

                    $(".item_total_price").each(function () {
                        item_total_price += Number($(this).val());
                    });

                    $("#total").val(item_total_price);
                },

                error: function (xhr) {
                    alert(xhr.responseJSON?.message || "يوجد خطأ ما");
                },
            });
        }
    );

    $("#general_return_sales_orders_modal_billitems").on("hidden.bs.modal", function () {
        location.reload();
    });

    $(document).on("input", "#general_return_sales_orders_tax_percent", function () {

        $("#general_return_sales_orders_discount_percent").val("");
        $("#general_return_sales_orders_discount_value").val("");

        var tax_percent = $("#general_return_sales_orders_tax_percent").val();

        if (tax_percent > 100 || tax_percent < 0) {
            alert(" خطا بنسبه الضريبه ادخل نسبه صحيحه");
            $("#general_return_sales_orders_tax_percent").val("");
            $("#general_return_sales_orders_tax_value").val("");
            return false;
        }

        var total = $("#general_return_sales_orders_total").val();

        value = (total * tax_percent) / 100;

        $("#general_return_sales_orders_tax_value").val(value);
        var total_value = parseFloat(total) + parseFloat(value);

        $("#general_return_sales_orders_total_value").val(total_value);

        var what_paid = $("#general_return_sales_orders_what_paid").val();
        if (what_paid != null && what_paid != "") {
            $("#general_return_sales_orders_what_remain").val(total_value - what_paid);
        }
    });

    $(document).on("input", "#general_return_sales_orders_discount_percent", function () {
        var discount_percent = $("#general_return_sales_orders_discount_percent").val();
        if (discount_percent > 100 || discount_percent < 0) {
            alert(" خطا بنسبه الخصم ادخل نسبه صحيحه");
            $("#general_return_sales_orders_discount_percent").val("");
            $("#general_return_sales_orders_discount_value").val("");
            return false;
        }

        var total = parseFloat($("#general_return_sales_orders_total").val());
        var tax_value = parseFloat($("#general_return_sales_orders_tax_value").val() || 0);

        value = ((total + tax_value) * discount_percent) / 100;

        $("#general_return_sales_orders_discount_value").val(value);

        var total_value = total + tax_value - value;
        $("#general_return_sales_orders_total_value").val(total_value);

        var what_paid = $("#general_return_sales_orders_what_paid").val();
        if (what_paid != null && what_paid != "") {
            console.log(total_value);
            $("#general_return_sales_orders_what_remain").val(total_value - what_paid);
        }
    });

    $(document).on("input", "#general_return_sales_orders_what_paid", function () {
        var total = $("#general_return_sales_orders_total_value").val();

        if (total == null || total == "") {
            var total = $("#general_return_sales_orders_total").val();
        }
        var what_paid = $("#general_return_sales_orders_what_paid").val();

        $("#general_return_sales_orders_what_remain").val(total - what_paid);
    });


    $(document).on(
        "click",
        "#general_return_sales_orders_approve_sale_bill",
        function (e) {
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

            var tax_percent = $(
                "#general_return_sales_orders_tax_percent"
            ).val();
            var tax_value = $("#general_return_sales_orders_tax_value").val();

            if (tax_percent == null || tax_percent == "") {
                alert("يجب ادخال نسبه الضريبه");
                return;
            }
            if (tax_value == null || tax_value == "") {
                alert("يجب ادخال قيمه الضريبه");
                return;
            }

            var discount_percent = $(
                "#general_return_sales_orders_discount_percent"
            ).val();
            var discount_value = $(
                "#general_return_sales_orders_discount_value"
            ).val();

            if (discount_percent == null || discount_percent == "") {
                alert("يجب ادخال نسبه الخصم");
                return;
            }
            if (discount_value == null || discount_value == "") {
                alert("يجب ادخال قيمه الخصم");
                return;
            }

            var total_value = $(
                "#general_return_sales_orders_total_value"
            ).val();
            if (total_value == null || total_value == "") {
                alert("يجب ادخال المبلغ الكلى");
                return;
            }

            var bill_type = $(
                "#general_return_sales_orders_bill_type option:selected"
            ).val();
            if (bill_type == null || bill_type == "") {
                alert("اختر طريقه الدفع");
                return;
            }

            var what_paid = $("#general_return_sales_orders_what_paid").val();
            if (what_paid == null || what_paid == "") {
                alert("يجب ادخال المبلغ المدفوع");
                return;
            }

            var what_remain = $(
                "#general_return_sales_orders_what_remain"
            ).val();
            if (what_remain == null || what_remain == "") {
                alert("يجب ادخال المبلغ المتبقى");
                return;
            }

            var notes = $("#general_return_sales_orders_notes").val();
            if (notes == null || notes == "") {
                alert("ادخل الملاحظات على الفاتوره");
                return;
            }

            var total_before_discount = $(
                "#general_return_sales_orders_total"
            ).val();
            if (total_before_discount == null || total_before_discount == "") {
                alert("يوجد خطا بالسعر قبل الخصم");
                return;
            }

            if (bill_type == 0 && what_paid < total_value) {
                alert("يجب دفع المبلغ كامل لان الفاتوره كاش");
                return;
            }

            if (bill_type == 1 && what_paid == total_value) {
                alert("الفاتوره اجل لا يمكن الدفع كامل");
                return;
            }

            var auto_serial = $("#general_return_sales_orders_autoserial").val();

            var url = $(
                "#general_return_sales_orders_approve_active_bill_url"
            ).val();
            var token_search = $("#token_search").val();

            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                cache: false,
                data: {
                    date: date,
                    customer_code: customer_code,
                    delegate_code: delegate_code,
                    sales_material_type_id: sales_material_type_id,

                    discount_percent: discount_percent,
                    discount_value: discount_value,

                    tax_percent: tax_percent,
                    tax_value: tax_value,

                    total_value: total_value,

                    bill_type: bill_type,

                    what_paid: what_paid,
                    what_remain: what_remain,

                    notes: notes,

                    total_before_discount: total_before_discount,

                    auto_serial: auto_serial,
                    _token: token_search,
                },

                success: function (response) {
                    alert(response.message);
                    $("#modal_billitems").modal("hide");
                    location.reload();
                },

                error: function (xhr) {
                    alert("يوجد خطأ ما");
                },
            });
        }
    );
});
