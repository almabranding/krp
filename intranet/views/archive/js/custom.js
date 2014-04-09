function updateListItem(itemId, newStatus) {
    var sorted = $("#sortable").sortable("serialize");
    $.post(ROOT + 'archive/sort', sorted).done(function(data) {
    });
}

$(document).ready(function() {
    var id=$('#id').val();
    $('#saveInputs').on('click', function() {
        var $listaInputs = $(':input').serialize();
        $.post(ROOT + 'archive/saveInputs', $listaInputs).done(function(data) {
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
        $.post(ROOT+'archive/deleteSelected/'+id,$lista).done(function(data) {location.reload();});
    });
});