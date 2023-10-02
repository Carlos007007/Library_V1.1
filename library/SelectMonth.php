<?php
Class CalMonth{
    public static function CurrentMonth($month) {
        switch($month){
            case 1: $montname="enero"; break;
            case 2: $montname="febrero"; break;
            case 3: $montname="marzo"; break;
            case 4: $montname="abril"; break;
            case 5: $montname="mayo"; break;
            case 6: $montname="junio"; break;
            case 7: $montname="julio"; break;
            case 8: $montname="agosto"; break;
            case 9: $montname="septiembre"; break;
            case 10: $montname="octubre"; break;
            case 11: $montname="noviembre"; break;
            case 12: $montname="diciembre"; break;
            default : $montname=""; break;
        }
        return $montname;
    }   
}