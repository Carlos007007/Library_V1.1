$(document).ready(function(){
    $('.tooltips-general').tooltip('hide');
    $('.popover-general').popover('hide');
    $('.btn-help').on('click', function(){
        $('#ModalHelp').modal({
            show: true,
            backdrop: "static"
        });
    });
    $('.mobile-menu-button').on('click', function(){
        var mobileMenu=$('.navbar-lateral');	
        if(mobileMenu.css('display')=='none'){
            mobileMenu.fadeIn(300);
        }else{
            mobileMenu.fadeOut(300);
        }
    });
    $('.dropdown-menu-button').on('click', function(){
        var dropMenu=$(this).next('ul');
        dropMenu.slideToggle('slow');
    });
    $('.exit-system-button').on('click', function(e){
        e.preventDefault();
        var LinkExitSystem=$(this).attr("data-href");
        swal({
            title: "¿Estás seguro?",
            text: "Quieres salir del sistema y cerrar la sesión actual",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#5cb85c",
            confirmButtonText: "Si, salir",
            cancelButtonText: "No, cancelar",
            animation: "slide-from-top",
            closeOnConfirm: false 
        },function(){
            window.location=LinkExitSystem; 
        });  
    });
    $('.search-book-button').click(function(e){
        e.preventDefault();
        var LinkSearchBook=$(this).attr("data-href");
        swal({
           title: "¿Qué libro estás buscando?",
           text: "Por favor escribe el nombre del libro",
           type: "input",   
           showCancelButton: true,
           closeOnConfirm: false,
           animation: "slide-from-top",
           cancelButtonText: "Cancelar",
           confirmButtonText: "Buscar",
           confirmButtonColor: "#3598D9",
           inputPlaceholder: "Escribe aquí el nombre de libro" }, 
      function(inputValue){
           if (inputValue === false) return false;  

           if (inputValue === "") {
               swal.showInputError("Debes escribir el nombre del libro");     
               return false;   
           } 
            window.location=LinkSearchBook+"?bookName="+inputValue;
       });
    });
    $('.tile').on('click', function(){
        var urlTile=$(this).attr('data-href');
        var numFile=$(this).attr('data-num');
        if(numFile>0){
            window.location=urlTile;
        }else{
            swal("¡Lo sentimos!", "No hay registros para mostrar");
        }
    });
    $('.footer-social').on('click', function(){
        var link=$(this).attr('data-link');
        window.open(link,"_blank");
    });
    $('.btn-addBook').on('click', function(e){
        e.preventDefault();
        var dir=$(this).attr('data-href');
        var url=$(this).attr('data-process');
        $.ajax({
            url:url,
            success:function(data){
                if(data==="Avaliable"){
                    window.location=dir;
                }else if (data==="NotAvaliable"){
                    swal({
                       title:"¡Opción no disponible!",
                       text:"No puedes registrar libros por el momento, primero debes de agregar los datos de la institución, administradores y categorías. Ve a la opción Administración del menu",
                       type: "error",
                       confirmButtonText: "Aceptar"
                    });
                }else{
                    swal({
                       title:"¡Ocurrió un error inesperado!",
                       text:"Hemos tenido un error al tratar de acceder a esta sección, por favor recarga la página e intenta nuevamente",
                       type: "error",
                       confirmButtonText: "Aceptar"
                    });
                }
            }
        });
    });
    $('.btn-update').on('click', function(){
        var code=$(this).attr('data-code');
        var url=$(this).attr('data-url');
        $.ajax({
            url:url,
            type: 'POST',
            data: 'code='+code,
            success:function(data){
                $('#ModalData').html(data);
                $('#ModalUpdate').modal({
                    show: true,
                    backdrop: "static"
                });
            }
        });
        return false;
    });
    $(".input-check-user").keyup(function(){
        var userType=$(this).attr("data-user");
        var userName=$(this).val();
        $.ajax({
            url:"../process/check-user.php?userName="+userName+"&&userType="+userType,
            success:function(data){
               $(".check-user-bd").html(data);
            }
        });
    });
});
(function($){
    $(window).load(function(){
        $(".custom-scroll-containers").mCustomScrollbar({
            theme:"dark-thin",
            scrollbarPosition: "inside",
            autoHideScrollbar: true,
            scrollButtons:{ enable: true }
        });
    });
})(jQuery);