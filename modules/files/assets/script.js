$.blockUI.defaults.message = 'Пожалуйста, подождите...';
$.blockUI.defaults.css = {
    padding: 0,
    margin: 0,
    width: '30%',
    top: '40%',
    left: '35%',
    textAlign: 'center',
    color: '#000',
    border: '0px solid #aaa',
    cursor: 'wait'
};


$(document).on('pjax:start', function (xhr, options) {
    $(xhr.target).block();
})

$(document).on('pjax:end', function (xhr, options) {
    $(xhr.target).unblock();
})

$(document).on('click', '[data-delete-files]', function (e) {
    if (!confirm('Удалить файлы?')) return false;

    e.preventDefault();
    var gridId = $(this).data('grid-id');
    var keys = $('#' + gridId).yiiGridView('getSelectedRows');
    var url = $(this).data('delete-url');
    var container = $(this).data('pjax');

    $.pjax.reload({
        container: '#' + container,
        history: false,
        type: 'POST',
        data: {ids: keys},
        url: url,
        timeout: false
    });

    $.pjax.reload({container: '#' + container});
    noty({text: 'Файлы успешно удалены!', layout: 'topRight', timeout: 3000, type: 'success', theme: 'relax'});

});

$(document).on('click', '[data-delete-file]', function (e) {
    var id = $(this).data('delete-file');
    var url = $(this).data('delete-url');
    var container = $(this).data('pjax');

    krajeeDialog.confirm('Удалить файл?', function (result) {
        if (result) {
            e.preventDefault();


            $.ajax({
                url: url,
                type: 'POST',
                data: {ids: [id]},
                success: function (result) {
                    $.pjax.defaults.timeout = false;//IMPORTANT
                    $.pjax.reload({container: '#' + container});
                }
            });
        } else {

        }
    });


});

$(document).on('click', '[data-reset-sort]', function (e) {
    if (!confirm('Сбросить сортировку?')) return false;

    e.preventDefault();
    var url = $(this).data('url');
    var container = $(this).data('pjax');
    var section_id = $(this).data('section-id');

    $.ajax({
        url: url,
        type: 'POST',
        data: {section_id: section_id},
        success: function (result) {
            $.pjax.defaults.timeout = false;//IMPORTANT
            $.pjax.reload({container: '#' + container});
        }
    });
});


/**
 * Редактирование файла в модальном окне
 */

$(document).on('click', '.editFileModal', function () {
    $('#modal').modal('show')
        .find('#modalContent')
        .load($(this).attr('value'));
    //устанавливаем pjax container
    $('#modal').data('pjax_c', $(this).data('pjax'));
    //dynamiclly set the header for the modal via title tag
    document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).data('title') + '</h4>';
});

$('#modal').on('shown.bs.modal', function (e) {
    $(this).find('.modal-dialog').css('margin-top', ($(window).height() - $(this).find('.modal-dialog').height()) / 2);
});
