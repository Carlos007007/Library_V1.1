<?php
$ruta=BACKUP_PATH;
if(is_dir($ruta)){
    if($aux=opendir($ruta)){
        while(($archivo = readdir($aux)) !== false){
            if($archivo!="."&&$archivo!=".."){
                $nombrearchivo=str_replace(".sql", "", $archivo);
                $nombrearchivo=str_replace("_", " ", $nombrearchivo);
                $nombrearchivo=str_replace("-", ":", $nombrearchivo);
                $ruta_completa=$ruta.$archivo;
                if(is_dir($ruta_completa)){
                }else{
                    echo '<option value="'.$ruta_completa.'">'.$nombrearchivo.'</option>';
                }
            }
        }
        closedir($aux);
    }
}else{
    echo $ruta." No es ruta valida";
}