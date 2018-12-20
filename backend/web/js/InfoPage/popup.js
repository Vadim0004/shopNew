$(function(){
    // changed id to class
    $('.modalButton').click(function (){
        $.get($(this).attr('href'), function(data) {
            $('#modal').modal('show').find('#modalContent').html(data)
        });
        return false;
    });
});