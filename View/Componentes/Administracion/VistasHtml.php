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



    public function Body(array $contents,string $attributes){
        $html= "<body $attributes>";
        foreach ($contents as $content){
            $html.=$content;
        }
        $html.="</body>";
        return $html;
    }

    public function MenuMovil($idioma, $idiomaActual,int $numeroProductosCarrito=0, $funcionMenuCLick = "cambiarLogoFijo()")
    {
        $fc=new \Tiendita\FrontComponents();


        $nav  = "<nav id='menu-movil-dorado' class='navbar navbar-inverse navbar-static-top  d-sm-block d-md-none d-block d-block ' style='position: fixed; background-color: white; width: 100%; top:0' role='navigation'>
                        <div class='ml-1'>
                    <div class='navbar-header d-flex justify-content-around align-items-center'>
                    <button type='button' class='navbar-toggle collapsed ml-3' data-toggle='collapse' id='botonMenuMovil'
                        onClick='".$funcionMenuCLick."'
                        ;
                        style='border: none; background-color: transparent;'>
                        <span class='sr-only'>MENU</span>
                        <i class='fa fa-bars' style='font-size: 18px;' > </i>
                    </button>";



        if (isset($idioma[ $idiomaActual ]["MENU"][6]))
        {
            $nav .="<a CLASS='elemento-menu-movil filtro' href='#'  onclick='AbrirMenuMovilFiltro()'>".$idioma[ $idiomaActual ]["MENU"][6]."</a>";
        }

        if (isset($idioma[ $idiomaActual ]["MENU"][7]))
        {
            $nav .= " <a CLASS='elemento-menu-movil ordenamiento' href='#' onclick='AbrirMenuMovilOrdenar()'>".$idioma[ $idiomaActual ]["MENU"][7]."</a>";
        }

        if (isset($idioma[ $idiomaActual ]["MENU"][5]))
        {
            $nav.= " <a CLASS='elemento-menu-movil carrito' href='cart.php' >".$fc->cart($numeroProductosCarrito,$idioma[ $idiomaActual ]["MENU"][5])."</a>";
        }

        $nav .=
            "
                </div>

                <div id='menu-movil-dorado-opcion' class='collapse navbar-collapse'  >
                    <ul class='nav navbar-nav row' style='padding: 35vh;padding-left: 2rem;margin-right: 0;'>
                        <li class='col-md-2'><a href='shop.php'>".$idioma[ $idiomaActual ]["MENU"][0]."</a></li>
                        <li><a href='archive.php'>".$idioma[ $idiomaActual ]["MENU"][1]."</a></li>
                        <li><a href='imprint.php'>".$idioma[ $idiomaActual ]["MENU"][2]."</a></li>
                        ".
                        "<form method='post'>
                        <input type='hidden' value='".$idioma[ $idiomaActual]["MENU"][4]."' name='language' id='language'>
                        <button type='submit' class='btn btn-link' style='text-decoration: none;padding: 0px !important; margin:0;border: none; color:black'>
                            <span type='submit'>".$idioma[ $idiomaActual]["MENU"][4]."</span></button>
                        </form>
                    </ul>
                </div>".
            "<div id='menu-movil-filtro' class='collapse navbar-collapse'  >
                    <ul class='nav navbar-nav row' style='padding: 35vh;padding-left: 2rem;margin-right: 0;'>
                        <li class='col-md-2'><a href='shop.php?order=6'><span>SHOP ALL</span> </a></li>
                        <li><a href='shop.php?order=7'><span>ACCESSORIES</span></a></li>
                        <li><a href='shop.php?order=5'><strong>SALE'</strong></a></li>
                    </ul>
            </div>".
            "<div id='menu-movil-ordenamiento' class='collapse navbar-collapse'  >
                    <ul class='nav navbar-nav row' style='padding: 35vh;padding-left: 2rem;margin-right: 0;'>
                    
                        <li class='col-md-2'><a href='shop.php?order=1' style='display: block'>FEATURED</a></li>
                        <li><a href='shop.php?order=2' style='display: block'>A TO Z</a></li>
                        <li><a href='shop.php?order=3' style='display: block'>PRICE LOW TO HIGH</a></li>
                        <li><a href='shop.php?order=4' style='display: block'>PRICE HIGH TO LOW</a></li>
                        
                    </ul>
            </div>"
            .$fc->PoliticaPrivacidadMovil("fixed").
            "</nav>
                ";

        return $nav;
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