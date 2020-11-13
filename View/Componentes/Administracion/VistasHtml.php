<?php


namespace Administracion;


class VistasHtml
{
    protected $Html5="";
    protected $Head="";
    protected $Script="";
    protected $Body="";

    public function __construct()
    {

    }

    protected function Html5($head,$body){
        return '';
    }

    protected function Head($title, $meta, $loadStyles, $loadScripts, $styles="", $scripts=""){
        $title='<title>'.$title.'</title>';
        return '<head>'.$meta.$title.$loadStyles.$loadScripts.$styles.$scripts.'</head>';
    }

    protected function Meta($charset="utf-8",$descripcion,$author){
        return '
            <meta charset="'.$charset.'">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="description" content="'.$descripcion.'">
            <meta name="author" content="'.$author.'">';

    }

    protected function LoadStyles($archivos){
        $html="";
        if(!is_array($archivos)){
            $html.='<link href="'.$archivos.'" rel="stylesheet" type="text/css">';
        }
        else{
            foreach ($archivos as $archivo){
                $html.='<link href="'.$archivo.'" rel="stylesheet" type="text/css">';
            }
        }
        return $html;
    }

    protected function LoadScripts($archivos){
        $html="";
        if(!is_array($archivos)){
            $html.='<script src="'.$archivos.'"></script>'."\n";
        }
        else{
            foreach ($archivos as $archivo){
                $html.='<script src="'.$archivo.'"></script>'."\n";
            }
        }
        return $html;
    }

}