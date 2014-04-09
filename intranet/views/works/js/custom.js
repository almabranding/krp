function updateListItem(itemId, newStatus) {
    var sorted = $("#sortable").sortable("serialize");
    $.post(ROOT + 'works/sort', sorted).done(function(data) {
    });
}

$(document).ready(function() {
    var id=$('#id').val();
    $('#saveInputs').on('click', function() {
        var $listaInputs = $(':input').serialize();
        $.post(ROOT + 'works/saveInputs', $listaInputs).done(function(data) {
            alert("Changes has been saved");
        });
    });
    $('.modelList').on('click',function(){
        var $checkbox=$(this).children('.checkFoto');
        $checkbox.prop('checked', !$checkbox.prop('checked'));
    });
     $('#deleteSelected').on('click',function(){
        var $lista=$('.checkFoto:checked').serialize();
        console.log($lista);
        if(confirm('¿Estas seguro?'))
        $.post(ROOT+'works/deleteSelected/',$lista).done(function(data) {location.reload();});
    });
    $('#selectHeadsheet').on('click', function() {
        $('.checkFoto:checked').index();
        var $listaImages = $('.checkFoto:checked').serialize();
        if ($('.checkFoto:checked').size() > 1) {
            alert('Select only one picture');
            return 0;
        }
        $.post(ROOT + 'works/selectHeadsheet/'+id, $listaImages).done(function(data) {location.reload();});
    });
});