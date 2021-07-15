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

    public function  MenuMovil($idioma, $idiomaActual,int $numeroProductosCarrito=0, $funcionMenuCLick = "cambiarLogoFijo()", $clase = '', $numPaginaActual = -1, $filtroActual = -1, $ordenamientoActual = -1)
    {
        $fc=new \Tiendita\FrontComponents();

        $caracterFocus = "'";

        if (isset($idioma[ $idiomaActual ]["MENU"][$numPaginaActual]))
        {
            $idioma[ $idiomaActual ]["MENU"][$numPaginaActual] =   $idioma[ $idiomaActual ]["MENU"][$numPaginaActual].$caracterFocus;
        }

        if (isset($idioma[ $idiomaActual ]["FILTER"][$filtroActual]))
        {
            $idioma[ $idiomaActual ]["FILTER"][$filtroActual] = $idioma[ $idiomaActual ]["FILTER"][$filtroActual].$caracterFocus;
        }



        if (isset($idioma[ $idiomaActual ]["ORDER"][$ordenamientoActual]))
        {
            $idioma[ $idiomaActual ]["ORDER"][$ordenamientoActual] = $idioma[ $idiomaActual ]["ORDER"][$ordenamientoActual].$caracterFocus;
        }

        $nav  = "<nav id='menu-movil-dorado' class='navbar navbar-inverse navbar-static-top position-fixed d-sm-block d-md-none d-block d-block bg-white ".$clase."' style='width: 100%; top:0; z-index: 2;left: 0;' role='navigation'>
                        <div class='ml-1 mr-1'>
                    <div class='navbar-header d-flex justify-content-between align-items-center ml-2 mr-2' style='margin-top: 0;'>
                    <button type='button' class='navbar-toggle collapsed menu' data-toggle='collapse' id='botonMenuMovil'
                        onClick='".$funcionMenuCLick."'
                        ;
                        style='border: none; background-color: transparent;'>
                        
                        <span class='sincaracter omitir'>MENU</span>
                    </button>";


        if (isset($idioma[ $idiomaActual ]["MENU"][6]))
        {
            $nav .="<a id='filtro' CLASS='elemento-menu-movil filtro menu' href='#'  onclick='AbrirMenuMovilFiltro()'><span class='sincaracter omitir'>".$idioma[ $idiomaActual ]["MENU"][6]."</span></a>";
        }

        if (isset($idioma[ $idiomaActual ]["MENU"][7]))
        {
            $nav .= " <a id='orden' CLASS='elemento-menu-movil ordenamiento menu' href='#' onclick='AbrirMenuMovilOrdenar()'><span class='sincaracter omitir'>".$idioma[ $idiomaActual ]["MENU"][7]."</span></a>";
        }

        if (isset($idioma[ $idiomaActual ]["MENU"][5]))
        {
            $nav.= " <a CLASS='elemento-menu-movil carrito menu' id='carrito' href='cart.php' >".$fc->cart($numeroProductosCarrito,$idioma[ $idiomaActual ]["MENU"][5])."</a>";
        }

        $nav .=
            "
                </div>

                <div id='menu-movil-dorado-opcion' class='collapse navbar-collapse'  >
                    <ul id='lista-menu' class='nav navbar-nav row' style='margin-right: 0;'>
                        <li ><a href='shop.php'>".$idioma[ $idiomaActual ]["MENU"][0]."</a></li>
                        <li><a href='archive.php' id='archive'>".$idioma[ $idiomaActual ]["MENU"][1]."</a></li>
                        <li><a href='imprint.php'>".$idioma[ $idiomaActual ]["MENU"][2]."</a></li>
                        <li><a href='customerLogin.php'>".$idioma[ $idiomaActual ]["MENU"][3]."</a></li>
                        ".
                        "<form method='post'>
                        <input type='hidden' value='".$idioma[ $idiomaActual]["MENU"][4]."' name='language' id='language'>
                        <button type='submit' class='btn btn-link' style='text-decoration: none;padding: 0px !important; margin:0;border: none; color:black'>
                            <span type='submit'>".$idioma[ $idiomaActual]["MENU"][4]."</span></button>
                        </form>
                    </ul>
                </div>";

        if (isset($idioma[ $idiomaActual]["FILTER"]))
        {
            $nav .= "<div id='menu-movil-filtro' class='collapse navbar-collapse'  >
                    <ul id='lista-filtro' class='nav navbar-nav row' style='margin-right: 0;'>";

            $indexFiltro = 0;
            $indexColapsado = 0;

            foreach ($idioma[$idiomaActual]["FILTER"] as $filtro => $valor) {

                if (is_array($valor))
                {

                    $nav .= "<li class='opcion'><a href='#' style='display: block' onclick='AbrirSubMenuFiltro($indexColapsado)'>". $filtro."</a>";
                    //$nav .= "<li class='opcion'><a href='#' style='display: block; margin-top: -11px;' >". $filtro."</a>";
                    $nav .="<ul class='navbar-nav collapse'>";
                    foreach ($valor as $elemento)
                    {
                        $nav .= "<li class='elemento' ><a href='#' style='display: block'>".$elemento."</a>";
                    }
                    $nav .="</ul>";
                    $nav .= "</li>";
                    $indexColapsado++;
                }
                else
                {
                    $nav .= "<li class='opcion'><a href='".$idioma[$idiomaActual]["ACCIONFILTRO"][$indexFiltro]."' style='display: block; margin-top: -10px;'>".$valor."</a></li>";

                }

                $nav .= "</li>";
                $indexFiltro++;

            }

            $nav .= " </ul>
                </div>";
        }

        if (isset($idioma[ $idiomaActual]["ORDER"]))
        {
            $nav .= "<div id='menu-movil-ordenamiento' class='collapse navbar-collapse'  >
                    <ul id='lista-orden' class='nav navbar-nav row' style='margin-right: 0;'>
                        <li class='col-md-2'><a href='shop.php?order=1' style='display: block'>".$idioma[ $idiomaActual]["ORDER"][0]."</a></li>
                        <li><a href='shop.php?order=2' style='display: block'>".$idioma[ $idiomaActual]["ORDER"][1]."</a></li>
                        <li><a href='shop.php?order=3' style='display: block'>".$idioma[ $idiomaActual]["ORDER"][2]."</a></li>
                        <li><a href='shop.php?order=4' style='display: block'>".$idioma[ $idiomaActual]["ORDER"][3]."</a></li>
                    </ul>
            </div>";
        }



        $nav .= $fc->PoliticaPrivacidadMovil("fixed").
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

public function Carousel(){

    $caro='<html> <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-sm-6">
<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">';

      foreach ($images as $image){
          $count++;
          $id="id".$count;
    //$collage.="<img id='$id' class='img-fluid' src='$image' data-big='$image' data-overlay=''><br/>";// data-overlay="fondo.png"
$caro.=ImagenCarrusel($id,$image);

  $caro.='</div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
    </div>
  </div>
</div>
<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>
</html>';
   return $caro;
}


    //$innerScript.=$fc->ScriptAmpliarFoto($id);
}
function ImagenCarrusel($id,$rutaImagen)
{
    return '<div class="item">
        <img id="' . $id . '" src="' . $rutaImagen . '">
      </div>';
}
}