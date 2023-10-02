<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
include '../library/SelectMonth.php';
$day=date("d");
$mont=date("m");
$year=date("Y");
$MontName=CalMonth::CurrentMonth($mont);
$hora=date("H-i-s");
$fecha=$day.'_'.$MontName.'_'.$year;
$DataBASE=$fecha."_(".$hora."_hrs).sql";
$tables=array();
$result=ejecutarSQL::consultar('SHOW TABLES');
if($result){
    while($row=mysqli_fetch_row($result)){
        $tables[] = $row[0];
    }
    $sql='SET FOREIGN_KEY_CHECKS=0;'."\n\n";
    $sql.='CREATE DATABASE IF NOT EXISTS '.BD.";\n\n";
    $sql.='USE '.BD.";\n\n";
    foreach($tables as $table){
        $result=ejecutarSQL::consultar('SELECT * FROM '.$table);
        if($result){
            $numFields=mysqli_num_fields($result);
            $sql.='DROP TABLE IF EXISTS '.$table.';';
            $row2=mysqli_fetch_row(ejecutarSQL::consultar('SHOW CREATE TABLE '.$table));
            $sql.="\n\n".$row2[1].";\n\n";
            for ($i=0; $i < $numFields; $i++){
                while($row=mysqli_fetch_row($result)){
                    $sql.='INSERT INTO '.$table.' VALUES(';
                    for($j=0; $j<$numFields; $j++){
                        $row[$j]=addslashes($row[$j]);
                        $row[$j]=str_replace("\n","\\n",$row[$j]);
                        if (isset($row[$j])){
                            $sql .= '"'.$row[$j].'"' ;
                        }
                        else{
                            $sql.= '""';
                        }
                        if ($j < ($numFields-1)){
                            $sql .= ',';
                        }
                    }
                    $sql.= ");\n";
                }
            }
            $sql.="\n\n\n";
        }else{
            $error=1;
        }
    }
    if($error==1){
        echo 'error';
    }else{
        chmod(BACKUP_PATH, 0777);
        $sql.='SET FOREIGN_KEY_CHECKS=1;';
        $handle=fopen(BACKUP_PATH.$DataBASE,'w+');
        if(fwrite($handle, $sql)){
            fclose($handle);
            echo 'success';
        }else{
            echo 'error';
        }
    }
}else{
    echo 'error';
}
mysqli_free_result($result);