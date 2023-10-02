<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
include '../library/SED.php';
$studentNIE=consultasSQL::CleanStringText($_POST['studentNIE']);
$studentName=consultasSQL::CleanStringText($_POST['studentName']);
$studentSurname=consultasSQL::CleanStringText($_POST['studentSurname']);
$studentSection=consultasSQL::CleanStringText($_POST['studentSection']);
$representativeDUI=consultasSQL::CleanStringText($_POST['representativeDUI']);
$representativeName=consultasSQL::CleanStringText($_POST['representativeName']);
$representativeRelationship=consultasSQL::CleanStringText($_POST['representativeRelationship']);
$representativePhone=consultasSQL::CleanStringText($_POST['representativePhone']);
$responStatus=consultasSQL::CleanStringText($_POST['responStatus']);
$UserName=consultasSQL::CleanStringText($_POST['UserName']);
$Password1=consultasSQL::CleanStringText($_POST['Password1']);
$Password2=consultasSQL::CleanStringText($_POST['Password2']);
if($studentSection!=""){
    $checkRStudent=ejecutarSQL::consultar("SELECT * FROM estudiante WHERE Nombre='".$studentName."' AND Apellido='".$studentSurname."' AND CodigoSeccion='".$studentSection."'");
    if(mysqli_num_rows($checkRStudent)<=0){
        $checkNIE=ejecutarSQL::consultar("SELECT * FROM estudiante WHERE NIE='".$studentNIE."'");
        if(mysqli_num_rows($checkNIE)<=0){
            if($Password1==$Password2){
                $checkUserName=ejecutarSQL::consultar("SELECT * FROM estudiante WHERE NombreUsuario='".$UserName."'");
                if(mysqli_num_rows($checkUserName)<=0){
                    $Password1=SED::encryption($Password1);
                    if($responStatus==1){
                       if(consultasSQL::InsertSQL("estudiante", "NIE, DUI, CodigoSeccion, Nombre, NombreUsuario, Clave, Apellido, Parentesco", "'$studentNIE','$representativeDUI','$studentSection','$studentName','$UserName','$Password1','$studentSurname','$representativeRelationship'")){
                                echo '<script type="text/javascript">
                                    swal({
                                       title:"¡Estudiante registrado!",
                                       text:"Los datos del estudiante se registraron exitosamente",
                                       type: "success",
                                       confirmButtonText: "Aceptar"
                                    });
                                    $(".form_SRCB")[0].reset();
                                </script>';
                        }else{ 
                            echo '<script type="text/javascript">
                                swal({ 
                                    title:"¡Ocurrió un error inesperado!", 
                                    text:"No se pudo registrar el estudiante, por favor intenta nuevamente", 
                                    type: "error", 
                                    confirmButtonText: "Aceptar" 
                                });
                            </script>';
                        } 
                    }else{
                        if(consultasSQL::InsertSQL("encargado", "DUI, Nombre, Telefono", "'$representativeDUI','$representativeName','$representativePhone'")){
                            if(consultasSQL::InsertSQL("estudiante", "NIE, DUI, CodigoSeccion, Nombre, NombreUsuario, Clave, Apellido, Parentesco", "'$studentNIE','$representativeDUI','$studentSection','$studentName','$UserName','$Password1','$studentSurname','$representativeRelationship'")){
                                    echo '<script type="text/javascript">
                                        swal({
                                           title:"¡Estudiante registrado!",
                                           text:"Los datos del estudiante se registraron exitosamente",
                                           type: "success",
                                           confirmButtonText: "Aceptar"
                                        });
                                        $(".form_SRCB")[0].reset();
                                    </script>';
                            }else{
                               consultasSQL::DeleteSQL("encargado", "DUI='$representativeDUI'");
                                echo '<script type="text/javascript">
                                    swal({ 
                                        title:"¡Ocurrió un error inesperado!", 
                                        text:"No se pudo registrar el estudiante, por favor intenta nuevamente", 
                                        type: "error", 
                                        confirmButtonText: "Aceptar" 
                                    });
                                </script>';
                            }
                        }else{
                            echo '<script type="text/javascript">
                                swal({ 
                                    title:"¡Ocurrió un error inesperado!", 
                                    text:"No se pudo registrar el estudiante, por favor intenta nuevamente", 
                                    type: "error", 
                                    confirmButtonText: "Aceptar" 
                                });
                            </script>';
                        } 
                    }
                }else{
                    echo '<script type="text/javascript">
                        swal({ 
                            title:"¡Ocurrió un error inesperado!", 
                            text:"Has introducido un nombre de usuario que ya esta siendo utilizado, por favor ingresa otro nombre", 
                            type: "error", 
                            confirmButtonText: "Aceptar" 
                        });
                    </script>'; 
                }
            }else{
                echo '<script type="text/javascript">
                    swal({ 
                        title:"¡Ocurrió un error inesperado!", 
                        text:"Las contraseñas no coinciden. Por favor ingresa nuevamente las contraseñas", 
                        type: "error", 
                        confirmButtonText: "Aceptar" 
                    });
                </script>';
            }
        }else{
            echo '<script type="text/javascript">
                swal({ 
                    title:"¡Ocurrió un error inesperado!", 
                    text:"El NIE ya está registrado. Dígita otro número de NIE, e intenta nuevamente", 
                    type: "error", 
                    confirmButtonText: "Aceptar" 
                });
            </script>';
        }
    }else{
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Ocurrió un error inesperado!", 
                text:"Ya existe un estudiante registrado con el nombre y apellido que acabas de ingresar en la sección seleccionada", 
                type: "error", 
                confirmButtonText: "Aceptar" 
            });
        </script>';
    }   
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"No hay secciones disponibles. Debes registrar docentes y asignarles una sección encargada", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}
mysqli_free_result($checkNIE);
mysqli_free_result($checkRStudent);
mysqli_free_result($checkUserName);
