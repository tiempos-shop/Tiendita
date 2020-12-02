<?php


namespace Administracion;


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

    public function Html5($head, $body,$lang="es"){
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



    public function Body(array $content,$atributes){
        $html= "
            <body $atributes>";
        foreach ($content as $html){
            $html.=$html;
        }
        $html.="</body>
        ";
        return $html;
    }

    protected function Head($title, $meta, $loadStyles, $loadScripts, $styles="", $scripts=""){
        $title='<title>'.$title.'</title>';
        $this->title=$title;
        $this->meta=$meta;
        $this->loadStyles=$loadStyles;
        $this->loadScripts=$loadScripts;
        $this->scripts=$scripts;
        $this->styles=$styles;
        return '<head>'.$meta.$title.$loadStyles.$loadScripts.$styles.$scripts.'</head>';
    }

    public function RefreshHead(){
        $this->head='<head>'.$this->meta.$this->title.$this->loadStyles.$this->loadScripts.$this->styles.$this->scripts.'</head>';
        return $this->head;
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
        $this->loadStyles=$html;
        return $html;
    }

    public function AddLoadStyles($archivos){
        $last=$this->loadStyles;
        $this->LoadStyles($archivos);
        $this->loadStyles.=$last;
        return $this->loadStyles;
    }

    public function AddLoadScripts($archivos){
        $last=$this->loadScripts;
        $this->LoadScripts($archivos);
        $this->loadScripts.=$last;
        return $this->loadScripts;
    }

    public function SetBody($body){
        $this->body=$body;
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
        $this->loadScripts=$html;
        return $html;
    }

}