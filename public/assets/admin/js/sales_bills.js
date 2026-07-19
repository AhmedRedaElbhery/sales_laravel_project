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
                    $(".related_to_itemcard").show();
                },

                error: function (xhr) {
                    $("#unitsDiv").html("");
                    $(".related_to_itemcard").hide();
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

        if ($("#total_price").val() == null || $("#total_price").val() == "" &&
        $("#normal_sale option:selected").val() == 0)
        {
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
                $("#items_table").append(data);
            },

            error: function (xhr) {
                $("#items_table").html("");
            },
        });
    });
});
