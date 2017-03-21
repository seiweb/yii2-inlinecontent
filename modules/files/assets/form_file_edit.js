$(document).on('submit', "#file_form", function (event) {
    event.preventDefault();
    var data = $(this).serialize();
    var form = document.getElementById('file_form');
    data = new FormData(form);

    var action = $(this).attr("action");
    $.ajax(
        {
            url: action,
            type: "POST",
            data: data,
            contentType: false,
            processData: false,
            dataType:'json',
            success: function (data, textStatus, jqXHR) {
                $("#modal").modal("hide");
                $.pjax.defaults.timeout = false;//IMPORTANT
                $.pjax.reload({container: '#' + $("#modal").data('pjax_c')});
                noty({
                    text: data.message,
                    layout: 'topRight',
                    timeout: 20000,
                    type: 'success',
                    theme: 'relax',
                    progressBar:true
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                noty({text: jqXHR.responseJSON.message, layout: 'topRight', timeout: 3000, type: 'error', theme: 'relax'});
            }
        });

    return false;
});