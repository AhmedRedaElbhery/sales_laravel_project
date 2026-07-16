$(document).ready(function () {
    $(document).on("change", "#item_code", function () {
        var item_code = $(this).val();
        console.log(item_code);

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

    $(document).on('change','#normal_sale',function(){

        var value = $(this).val();
        if(value == "0")
        {
            $('#price_div').show();
        }
        else{
            $('#price_div').hide();
        }
    });
});
