$(document).ready(function () {
    $(document).on("change", "#item_code", function () {
        get_units();
    });

    $(document).on("change", "#unit_id_add", function () {
        get_quantity_batches();
    });

    $(document).on("change", "#sale_type", function () {
        var quantity = $("#quantity").val();
        var price = $("#price").val();

        $("#total_price").val(price * quantity);

        if (
            $("#store_id option:selected").val() == null ||
            $("#store_id option:selected").val() == ""
        ) {
            alert("اختر المخزن");
            $("#sale_type").val("").trigger("change.select2");
            return;
        }

        if ($("#item_code").val() == null || $("#item_code").val() == "") {
            alert("اختر الصنف");
            $("#sale_type").val("").trigger("change.select2");
            return;
        }

        if ($("#unit_id_add").val() == null || $("#unit_id_add").val() == "") {
            alert("اختر وحده الصنف");
            $("#sale_type").val("").trigger("change.select2");
            return;
        }

        if ($("#item_code").val() == null || $("#item_code").val() == "") {
            alert("اختر الصنف");
            $("#sale_type").val("").trigger("change.select2");
            return;
        }

        if ($("#normal_sale").val() === "0") {
            let type = $("#sale_type option:selected").val();
            let unit_type = $("#unit_id_add option:selected").data(
                "isparentunit"
            );
            let unit_id = $("#unit_id_add option:selected").val();

            var token_search = $("#token_search").val();
            var ajax_getUnits = $("#sales_item_getprice_url").val();
            var item_code = $("#item_code").val();

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
                    $("#price").val(response.price);
                    var quantity = $("#quantity").val();
                    var price = $("#price").val();
                    var value = (price * 100 * quantity) / 100;
                    $("#total_price").val(value);
                },
                error: function (xhr) {
                    $("#price").html("");
                },
            });
        }
    });

    function get_units() {
        var item_code = $("#item_code").val();
        let item_type = $("#item_code option:selected").data("type");
        let store_id = $("#store_id option:selected").val();

        if (store_id == null || store_id == "") {
            alert("اختر المخزن");
            $("#item_code").val("").trigger("change.select2");
            return;
        }

        if (item_code != "") {
            var token_search = $("#token_search").val();
            var ajax_getUnits = $("#sales_item_getUnits_url").val();

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
                    $("#unitsDiv").html(data);
                    $(".related_itemcard").show();
                },

                error: function (xhr) {
                    $("#unitsDiv").html("");
                    $(".related_itemcard").hide();
                },
            });
        } else {
            $("#unitsDiv").html("");
            $(".related_to_itemcard").hide();
        }
    }

    function get_quantity_batches() {
        $("#sale_type").val("");
        $("#quantity").val("");
        $("#price").val("");

        var item_code = $("#item_code").val();
        var unit_id = $("#unit_id_add").val();
        let item_type = $("#item_code option:selected").data("type");
        let store_id = $("#store_id option:selected").val();

        if (item_code != "" && store_id != "") {
            var token_search = $("#token_search").val();
            var ajax_get_batches = $("#sales_item_get_batches_url").val();
            $.ajax({
                url: ajax_get_batches,
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
                    $("#batches_div").html(data);
                    $(".batches").show();
                },

                error: function (xhr) {
                    $("#batches_div").html("");
                    $(".batches").hide();
                },
            });
        } else {
            $("#batches_div").html("");
            $(".batches").hide();
        }
    }

    $(document).on("change", "#normal_sale", function () {
        var value = $(this).val();
        if (value == "0") {
            $("#price_div").show();
        } else {
            $("#price_div").hide();
            $("#price").val(0);
        }
        $("#sale_type").val("");
    });

    $(document).on("change", "#store_id", function () {
        $("#unit_id_add").val("").trigger("change.select2");
        $("#sale_type").val("");
        $("#price").val("");
    });

    $(document).on("input", "#quantity", function () {
        var quantity = $("#quantity").val();
        var price = $("#price").val();
        var value = (price * 100 * quantity) / 100;
        $("#total_price").val(value);
    });

    $(document).on("click", "#save_item", function () {
        if (
            $("#normal_sale option:selected").val() == null ||
            $("#normal_sale option:selected").val() == ""
        ) {
            alert("اختر نوع المنتج");
            return;
        }

        if (
            $("#store_id option:selected").val() == null ||
            $("#store_id option:selected").val() == ""
        ) {
            alert("اختر المخزن");
            return;
        }

        if ($("#item_code").val() == null || $("#item_code").val() == "") {
            alert("اختر الصنف");
            return;
        }

        if ($("#unit_id_add").val() == null || $("#unit_id_add").val() == "") {
            alert("اختر وحده الصنف");
            $("#sale_type").val("").trigger("change.select2");
            return;
        }

        if (
            $("#quantity_with_date option:selected").val() == null ||
            $("#quantity_with_date option:selected").val() == ""
        ) {
            alert("اختر الكميات");
            return;
        }

        if (
            $("#sale_type option:selected").val() == null ||
            $("#sale_type option:selected").val() == ""
        ) {
            alert("اختر نوع البيع");
            return;
        }

        if ($("#quantity").val() == null || $("#quantity").val() == "") {
            alert("ادخل الكميه المطلوبه");
            return;
        }

        if (
            $("#price").val() == null ||
            ($("#price").val() == "" &&
                $("#normal_sale option:selected").val() == 0)
        ) {
            alert("السعر مطلوب");
            return;
        }

        if (
            $("#total_price").val() == null ||
            ($("#total_price").val() == "" &&
                $("#normal_sale option:selected").val() == 0)
        ) {
            alert("السعر مطلوب");
            return;
        }

        var normal_sale = $("#normal_sale").val();
        var store_id = $("#store_id").val();
        var item_code = $("#item_code").val();
        var unit_id = $("#unit_id_add").val();
        var quantity_with_date = $("#quantity_with_date").val();
        var sale_type = $("#sale_type").val();
        var quantity = $("#quantity").val();
        var price = $("#price").val();
        var total_price = $("#total_price").val();
        var url = $("#sales_item_getitems_url").val();
        let parent_unit = $("#unit_id_add option:selected").data(
            "isparentunit"
        );

        var sale_type_name = $("#sale_type option:selected").text();
        var item_name = $("#item_code option:selected").text();
        var normal_sale_name = $("#normal_sale option:selected").text();
        var unit_name = $("#unit_id_add option:selected").text();

        var token_search = $("#token_search").val();

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
                $("#table_items").append(data);

                var item_total_price = 0;

                $(".item_total_price").each(function () {
                    item_total_price += Number($(this).val());
                });

                $("#total").val(item_total_price);
            },

            error: function (xhr) {
                $("#items_table").html("");
            },
        });
    });

    $(document).on("click", "#save_edit_item", function () {
        if (
            $("#update_invoice_date").val() == null ||
            $("#update_invoice_date").val() == ""
        ) {
            alert("ادخل التاريخ ");
            return;
        }
        if (
            $("#update_sales_material_type option:selected").val() == null ||
            $("#update_sales_material_type option:selected").val() == ""
        ) {
            alert("اختر فئه المنتح");
            return;
        }
        if (
            $("#update_customer_code option:selected").val() == null ||
            $("#update_customer_code option:selected").val() == ""
        ) {
            alert("اختر العميل");
            return;
        }
        if (
            $("#update_delegate_code option:selected").val() == null ||
            $("#update_delegate_code option:selected").val() == ""
        ) {
            alert("اختر المندوب");
            return;
        }
        if (
            $("#normal_sale option:selected").val() == null ||
            $("#normal_sale option:selected").val() == ""
        ) {
            alert("اختر نوع المنتج");
            return;
        }

        if (
            $("#store_id option:selected").val() == null ||
            $("#store_id option:selected").val() == ""
        ) {
            alert("اختر المخزن");
            return;
        }

        if ($("#item_code").val() == null || $("#item_code").val() == "") {
            alert("اختر الصنف");
            return;
        }

        if ($("#unit_id_add").val() == null || $("#unit_id_add").val() == "") {
            alert("اختر وحده الصنف");
            $("#sale_type").val("").trigger("change.select2");
            return;
        }

        if (
            $("#quantity_with_date option:selected").val() == null ||
            $("#quantity_with_date option:selected").val() == ""
        ) {
            alert("اختر الكميات");
            return;
        }

        if (
            $("#sale_type option:selected").val() == null ||
            $("#sale_type option:selected").val() == ""
        ) {
            alert("اختر نوع البيع");
            return;
        }

        if ($("#quantity").val() == null || $("#quantity").val() == "") {
            alert("ادخل الكميه المطلوبه");
            return;
        }

        if (
            $("#price").val() == null ||
            ($("#price").val() == "" &&
                $("#normal_sale option:selected").val() == 0)
        ) {
            alert("السعر مطلوب");
            return;
        }

        if (
            $("#total_price").val() == null ||
            ($("#total_price").val() == "" &&
                $("#normal_sale option:selected").val() == 0)
        ) {
            alert("السعر مطلوب");
            return;
        }

        var customer_code = $("#update_customer_code").val();
        var delegate_code = $("#update_delegate_code").val();
        var sales_material_type = $("#update_sales_material_type").val();
        var invoice_date = $("#update_invoice_date").val();
        var normal_sale = $("#normal_sale").val();
        var store_id = $("#store_id").val();
        var item_code = $("#item_code").val();
        var unit_id = $("#unit_id_add").val();
        var quantity_with_date = $("#quantity_with_date").val();
        var sale_type = $("#sale_type").val();
        var quantity = $("#quantity").val();
        var price = $("#price").val();
        var total_price = $("#total_price").val();

        let parent_unit = $("#unit_id_add option:selected").data(
            "isparentunit"
        );

        var sale_type_name = $("#sale_type option:selected").text();
        var item_name = $("#item_code option:selected").text();
        var normal_sale_name = $("#normal_sale option:selected").text();
        var unit_name = $("#unit_id_add option:selected").text();

        var url = $("#active_add_items_url").val();
        var token_search = $("#token_search").val();

        $.ajax({
            url: url,
            type: "POST",
            dataType: "html",
            cache: false,

            data: {
                normal_sale: normal_sale,
                invoice_date: invoice_date,
                sales_material_type: sales_material_type,
                delegate_code: delegate_code,
                customer_code: customer_code,
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
                $("#table_items").append(data);

                var item_total_price = 0;

                $(".item_total_price").each(function () {
                    item_total_price += Number($(this).val());
                });

                $("#total").val(item_total_price);
            },

            error: function (xhr) {
                $("#table_items").html("");
            },
        });
    });

    $(document).on("click", ".delete", function (e) {
        e.preventDefault();
        $(this).closest("tr").remove();

        var item_total_price = 0;

        $(".item_total_price").each(function () {
            item_total_price += Number($(this).val());
        });

        $("#total").val(item_total_price);
    });

    /////////////////////////////////////////////

    $(document).on("input", "#tax_percent", function () {
        $("#discount_percent").val("");
        $("#discount_value").val("");
        var tax_percent = $("#tax_percent").val();
        if (tax_percent > 100 || tax_percent < 0) {
            alert(" خطا بنسبه الضريبه ادخل نسبه صحيحه");
            $("#tax_percent").val("");
            $("#tax_value").val("");
            return false;
        }

        var total = $("#total").val();

        value = (total * tax_percent) / 100;

        $("#tax_value").val(value);
        var total_value = parseFloat(total) + parseFloat(value);

        $("#total_value").val(total_value);

        var what_paid = $("#what_paid").val();
        if (what_paid != null && what_paid != "") {
            $("#what_remain").val(total_value - what_paid);
        }
    });

    $(document).on("input", "#discount_percent", function () {
        var discount_percent = $("#discount_percent").val();
        if (discount_percent > 100 || discount_percent < 0) {
            alert(" خطا بنسبه الخصم ادخل نسبه صحيحه");
            $("#discount_percent").val("");
            $("#discount_value").val("");
            return false;
        }

        var total = parseFloat($("#total").val());
        var tax_value = parseFloat($("#tax_value").val() || 0);

        value = ((total + tax_value) * discount_percent) / 100;

        $("#discount_value").val(value);

        var total_value = total + tax_value - value;
        $("#total_value").val(total_value);

        var what_paid = $("#what_paid").val();
        if (what_paid != null && what_paid != "") {
            console.log(total_value);
            $("#what_remain").val(total_value - what_paid);
        }
    });

    $(document).on("input", "#what_paid", function () {
        var total = $("#total_value").val();

        if (total == null || total == "") {
            var total = $("#total").val();
        }
        var what_paid = $("#what_paid").val();

        $("#what_remain").val(total - what_paid);
    });

    $(document).on("click", "#open_active_bill", function () {
        var date = $("#invoice_date").val();
        let customer_code = $("#customer_code option:selected").val();
        let delegate_code = $("#delegate_code option:selected").val();
        let sales_material_type_id = $(
            "#sales_material_type option:selected"
        ).val();

        if (date == null || date == "") {
            alert("ادخل التاريخ");
            return;
        }

        if (sales_material_type_id == null || sales_material_type_id == "") {
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
        var url = $("#open_active_bill").val();

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
                $("#modal_activebill").one("hidden.bs.modal", function () {
                    // Put the returned HTML into a container
                    $("#modal_billitems").html(response);

                    // Show the modal that came from the returned HTML
                    $("#modal_billitems").modal("show");
                });

                $("#modal_activebill").modal("hide");
            },
            error: function (xhr) {
                alert("يوجد خطا ما");
            },
        });
    });

    $(document).on("click", ".delete_bill", function () {
        var auto_serial = $(".delete_bill").data("autoserial");
        console.log(auto_serial);
    });

    $(document).on("click", ".edit_bill", function () {
        var auto_serial = $(this).data("autoserial");
        var url = $("#get_active_bill_data_url").val();

        $.ajax({
            url: url,
            type: "GET",
            dataType: "html",
            cache: false,

            data: {
                auto_serial: auto_serial,
            },

            success: function (response) {
                $("#modal_billitems").html(response);

                $("#modal_billitems").modal("show");
            },
            error: function (xhr) {
                alert("حدث خطا ما");
            },
        });
    });
});
