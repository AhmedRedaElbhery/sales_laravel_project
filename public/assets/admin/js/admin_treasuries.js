$(document).ready(function () {

    $(document).on("click", "#add", function () {
        var treasuries = $("#name").val();
        if (treasuries == null) {
            alert("من فضلك اختر الصنف");
            $("#name").focus();
            return false;
        }


        var token_search = $("#token_search").val();
        var ajax_addtreasuries = $("#ajax_addtreasuries").val();
        var admin_id = $("#admin_id").val();

        $.ajax({
            url: ajax_addtreasuries,
            type: "POST",
            dataType: "json",
            cache: false,

            data: {
                treasuries: treasuries,
                _token: token_search,
                admin_id: admin_id,
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

});
