$(document).ready(function () {

    $('#search_by_name').on('keyup', function () {

        let value = $(this).val().toLowerCase();

        $('#ajax_responce_searchDiv table tbody tr').filter(function () {

            $(this).toggle(
                $(this).text().toLowerCase().indexOf(value) > -1
            );

        });

    });

});