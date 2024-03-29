<?php


namespace Administracion;


use ErrorException;

class VistasHtml
{

    protected $head="";
    public $title="";
    protected $meta="";
    protected $loadStyles="";
    protected $loadScripts="";
    public $styles="";
    public $scripts="";
    protected $body="";
    protected $lang="";
    public $lastScripts="";

    public function __construct()
    {

    }

    public function ValidarSession()
    {
        
        if (isset($_SESSION["idCliente"]) && isset($_SESSION["nombre"]))
        {
            return false;            
        }

        return true;
    }

    public function Html5(string $head, string $body,$lang="es"){
        $this->head=$head;
        $this->body=$body;
        $this->lang=$lang;

        return '
        <!DOCTYPE html>
        <html lang="'.$lang.'">
            '.$head.'
            '.$body.'
            '.$this->lastScripts.'
        </html>';
    }

    public function Html5Shop(string $head, string $body,$lang="es"){
        $this->head=$head;
        $this->body=$body;
        $this->lang=$lang;

        return '
        <!DOCTYPE html>
        <html lang="'.$lang.'">
            '.$head.'
            <body '.$body.'>
            '.$this->lastScripts.'
        ';
    }



    public function Body(array $contents,string $attributes){
        $html= "<body $attributes>";
        foreach ($contents as $content){
            $html.=$content;
        }
        $html.="</body>";
        return $html;
    }

    public function Head($title, $meta, $loadStyles, $loadScripts, $styles="", $scripts=""){
        $title='<title>'.$title.'</title>';
        $this->title=$title;
        $this->meta=$meta;
        $this->loadStyles.=$loadStyles;
        $this->loadScripts.=$loadScripts;
        $this->scripts.=$scripts;
        $this->styles.=$styles;
        return '<head>'.$meta.$title.$loadStyles.$loadScripts.$styles.$scripts.'</head>';
    }

    public function RefreshHead():string
    {
        $this->head='<head>'.$this->meta.$this->title.$this->loadStyles.$this->loadScripts.$this->styles.$this->scripts.'</head>';
        return $this->head;
    }

    public function Meta($charset="utf-8",$descripcion,$author){
        return '
            <meta charset="'.$charset.'">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="description" content="'.$descripcion.'">
            <meta name="author" content="'.$author.'">';

    }

    public function LoadStyles(array $archivos){
        $html="";
        foreach ($archivos as $archivo){
            $html.='<link href="'.$archivo.'" rel="stylesheet" type="text/css">';
        }

        $this->loadStyles=$html;
        return $html;
    }

    public function LoadStylesProperties(array $archivos){
        $html="";
        foreach ($archivos as $archivo=>$properties){
            $html.='<link href="'.$archivo.'" rel="stylesheet" type="text/css" '.$properties.'>';
        }

        $this->loadStyles=$html;
        return $html;
    }

    public function LoadScriptsProperties(array $archivos){
        $html="";
        foreach ($archivos as $archivo=>$properties){
            $html.='<script src="'.$archivo.' '.$properties.'"></script>'."\n";
        }

        $this->loadScripts=$html;
        return $html;
    }

    public function AddLoadStyles(array $archivos){
        $this->loadStyles.=$this->LoadStyles($archivos);
        return "";
    }

    public function AddLoadScripts(array $archivos){
        $this->loadScripts=$this->LoadScripts($archivos);
        return "";
    }

    public function SetBody(string $body)
    {
        $this->body=$body;
    }

    public function LoadScripts(array $archivos){
        $html="";

        foreach ($archivos as $archivo){
            $html.='<script src="'.$archivo.'"></script>'."\n";
        }

        $this->loadScripts=$html;
        return $html;
    }



}