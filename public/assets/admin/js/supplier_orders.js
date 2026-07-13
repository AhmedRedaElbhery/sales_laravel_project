$(document).ready(function () {
    $(document).on("change", "#item_card_add", function () {
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

    $(document).on("click", "#addtobill", function () {
        var item_card = $("#item_card_add").val();
        if (item_card == null) {
            alert("من فضلك اختر الصنف");
            $("#item_card_add").focus();
            return false;
        }

        var unit = $("#unit_id_add").val();
        if (unit == null) {
            alert("من فضلك اختر الوحده");
            $("#unit_id_add").focus();
            return false;
        }

        var quantity = $("#quantity_add").val();
        if (quantity == "" || quantity <= "0") {
            alert("من فضلك ادخل الكميه");
            $("#quantity_add").focus();
            return false;
        }

        var price = $("#price_add").val();
        if (price == "" || price <= "0") {
            alert("من فضلك ادخل السعر");
            $("#price_add").focus();
            return false;
        }

        var type = $("#item_card_add").find(":selected").attr("data-type");

        if (type == "2") {
            var production_date = $("#production_date").val();

            if (production_date == "") {
                alert("من فضلك ادخل تاريخ الانتاج");
                $("#production_date").focus();
                return false;
            }

            var end_date = $("#end_date").val();
            if (end_date == "" || end_date <= production_date) {
                alert("من فضلك ادخل تاريخ الانتهاء");
                $("#end_date").focus();
                return false;
            }
        } else {
            var production_date = $("#production_date").val();
            var end_date = $("#end_date").val();
        }

        var autoserialparent = $("#autoserialparent").val();
        var isparent = $("#unit_id_add")
            .find(":selected")
            .attr("data-isparentunit");

        var token_search = $("#token_search").val();
        var ajax_addunits = $("#ajax_addunits").val();
        var total_price = $("#total_price").val();

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
                quantity: quantity,
                price: price,
                type: type,
                isparent: isparent,
                end_date: end_date,
                production_date: production_date,
                total_price: total_price,
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

    function calculate() {
        var quantity = $("#quantity_add").val();
        var price = $("#price_add").val();

        if (quantity == "" || quantity <= "0") {
            quantity = 0;
        }

        if (price == "" || price <= "0") {
            price = 0;
        }

        price = price * 100;

        $("#total_price").val((price * quantity) / 100);
    }

    $(document).on("input", "#quantity_add", function () {
        calculate();
    });

    $(document).on("input", "#price_add", function () {
        calculate();
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

    $(document).on("click", "#update_items", function () {
        var unit = $("#unit_id_edit").val();
        if (unit == null) {
            alert("من فضلك اختر الوحده");
            $("#unit_id_edit").focus();
            return false;
        }

        var quantity = $("#quantity_edit").val();
        console.log(quantity);
        if (quantity == "" || quantity <= "0") {
            alert("من فضلك ادخل الكميه");
            $("#quantity_edit").focus();
            return false;
        }

        var price = $("#price_edit").val();
        if (price == "" || price <= "0") {
            alert("من فضلك ادخل السعر");
            $("#price_edit").focus();
            return false;
        }

        var type = $("#item_card_add").find(":selected").attr("data-type");

        if (type == "2") {
            var production_date = $("#production_date").val();

            if (production_date == "") {
                alert("من فضلك ادخل تاريخ الانتاج");
                $("#production_date_edit").focus();
                return false;
            }

            var end_date = $("#end_date").val();
            if (end_date == "" || end_date <= production_date) {
                alert("من فضلك ادخل تاريخ الانتهاء");
                $("#end_date_edit").focus();
                return false;
            }
        } else {
            var production_date = $("#production_date_edit").val();
            var end_date = $("#end_date_edit").val();
        }

        var autoserialparent = $("#autoserialparent").val();
        var isparent = $("#unit_id_edit")
            .find(":selected")
            .attr("data-isparentunit");

        var token_search = $("#token_search").val();
        var ajax_addunits = $("#ajax_updateitem").val();
        var total_price = $("#total_price_edit").val();
        var id = $("#id").val();

        $.ajax({
            url: ajax_addunits,
            type: "POST",
            dataType: "json",
            cache: false,

            data: {
                autoserialparent: autoserialparent,
                _token: token_search,
                unit: unit,
                quantity: quantity,
                price: price,
                type: type,
                id: id,
                isparent: isparent,
                end_date: end_date,
                production_date: production_date,
                total_price: total_price,
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

    $(document).on("input", "#quantity_edit", function () {
        calculateedit();
    });

    $(document).on("input", "#price_edit", function () {
        calculateedit();
    });

    function calculateedit() {
        var quantity = $("#quantity_edit").val();
        var price = $("#price_edit").val();

        if (quantity == "" || quantity <= "0") {
            quantity = 0;
        }

        if (price == "" || price <= "0") {
            price = 0;
        }

        price = price * 100;

        $("#total_price_edit").val((price * quantity) / 100);
    }

    $(document).on("click", "#approve_bill", function () {
        var tax_percent = $("#tax_percent").val();

        if (tax_percent == null || tax_percent == "") {
            alert("من فضلك ادخل نسبه الضريبه");
            $("#tax_percent").focus();
            return false;
        }

        var discount_percent = $("#discount_percent").val();

        if (discount_percent == null || discount_percent == "") {
            alert("من فضلك ادخل نسبه الخصم");
            $("#discount_percent").focus();
            return false;
        }

        var what_paid = $("#what_paid").val();
        var treasuries_balance = $("#treasuries_balance").val();

        if (what_paid > treasuries_balance) {
            alert("الرصيد الحالى لا يسمح");
            return false;
        }

        if (what_paid == null || what_paid == "") {
            alert("ادخل الرصيد المدفوع");
            $("#what_paid").focus();
            return false;
        }

        var autoserialparent = $("#autoserialparent").val();
        var what_remain = $("#what_remain").val();
        var tax_value = $("#tax_value").val();
        var discount_value = $("#discount_value").val();
        var total_value = $("#total_value").val();
        var treasuries_id = $("#treasuries_id").val();
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

                what_paid: what_paid,
                what_remain: what_remain,


                treasuries_id: treasuries_id,
                total_value: total_value,
                treasuries_balance: treasuries_balance,
            },

            success: function (data) {
                if (!data.status) {
                    alert(data.message);
                    window.location.href = data.redirect;
                    return;
                }

                alert(data.message);
                window.location.reload();
            },

            error: function (xhr) {
                alert("يوجد خطا ما");
            },
        });
    });

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

        value = ((total / 100) * tax_percent) / 100;

        $("#tax_value").val(value);
        var total_value = parseFloat(total) / 100 + parseFloat(value);

        $("#total_value").val(total_value);

        var what_paid = $("#what_paid").val();
        if (what_paid != null && what_paid != "") {
            console.log(total_value);
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

        value = ((total / 100 + tax_value) * discount_percent) / 100;

        $("#discount_value").val(value);

        var total_value = total / 100 + tax_value - value;
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
            var total = total / 100;
        }
        var what_paid = $("#what_paid").val();

        $("#what_remain").val(total - what_paid);
    });
});
