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

                    var type = $('#item_card_add').find(":selected").attr("data-type");
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
});
