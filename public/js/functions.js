(function($){$(function(){

    function get_radio(id){
        if ($("#"+id).prop('checked')){
            return 0;
        } else {
            return 1;
        }
    }

    function get_check(id){//проверка ckeckbox элементов
        var c = $('#'+id);
        if (c.prop('checked')){
            return 1;
        } else {
            return 0;
        }
    }

})})(jQuery)
