<?php


namespace Tiendita;
include_once "Utilidades.php";

class FrontComponents
{
    protected Utilidades $ui;
    protected array $idioma;
    private $submenu = 1;
    public function __construct()
    {
        $this->ui=new Utilidades();
        $this->idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "TIENDA","ARCHIVO","MARCA","INGRESO","ENGLISH","CARRITO(*)"] ],"ENGLISH"=>[ "MENU"=>[ "SHOP","ARCHIVE","IMPRINT","LOGIN","ESPAÑOL","CART(*)" ] ] ];
    }

    public function MenuDorado($idioma, $idiomaActual,int $numeroProductosCarrito=0):string{

        return "<div class='fixed-top' style='padding-top:2vh;padding-bottom:0;padding-left: 2vw;padding-right: 2vw'>".
        $this->ui->Row([
            $this->ui->Columns(
                "<span onclick='go(\"shoptienda.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][0]."</span>",
                2,0,2,0,""
            ),
            $this->ui->Columns(
                "<span style='padding-left: 5%' onclick='go(\"archive.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][1]."</span>",
                2,0,2,0,""
            ),
            $this->ui->Columns(
                "<span style='padding-left: 20%' onclick='go(\"imprint.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][2]."</span>",
                2,0,2,0,""
            ),
            $this->ui->Columns(
                "<span style='padding-left: 35%' onclick='go(\"loginshop.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][3]."</span>",
                2,0,2,0,""
            ),
            $this->ui->Columns(
                $this->FormLink(
                    [
                        $this->ui->Input("language","",$this->idioma[ $idiomaActual ]["MENU"][4],"F",true),
                    ],
                    "",
                    $this->idioma[ $idiomaActual ]["MENU"][4],"#AC9950"

                ),
                2,0,2,0,"adjust"
            ),
            $this->ui->Columns(
                "<span  style='right: 2%;position: absolute' onclick='go(\"carttienda.php\")'>".$this->Cart($numeroProductosCarrito,$this->idioma[ $idiomaActual ]["MENU"][5])."</span>",
                2,0,2,0,""
            )
        ],"right").
        "</div>";
    }

    public function Menu($idioma, $idiomaActual,int $numeroProductosCarrito,array $selected,bool $transparente=false,bool $unremark=false):string{
        if($transparente){
            $hr="";
            $back="transparent";
        }
        else{
            $back="white";
            if($unremark){
                $hr="<hr style='margin-bottom: 0'/>";
            }
            else
            {
                $hr="<hr style='margin: 1em -3vw 0px -2vw;opacity: 1;'/>";
            }
        }
        $lines=array();
        $i=0;

        foreach ($selected as $select){

            switch($i)
            {
                case 0:
                    if($select=="'"){
                        $lines[$i]="<label onclick='go(\"shoptienda.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][$i].$select."</label>";
                    }
                    else{
                        $lines[$i]="<span  onclick='go(\"shoptienda.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][$i]."</span>";
                    }
                    break;
                case 1:
                    if($select=="'"){
                        $lines[$i]="<label  style='padding-left: 5%'>".$this->idioma[ $idiomaActual ]["MENU"][$i].$select."</label>";
                    }
                    else{
                        $lines[$i]="<span  style='padding-left: 5%' onclick='go(\"archive.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][1]."</span>";
                    }
                    break;
                case 2:
                    if($select=="'"){
                        $lines[$i]="<label  style='padding-left: 20%'>".$this->idioma[ $idiomaActual ]["MENU"][$i].$select."</label>";
                    }
                    else{
                        $lines[$i]="<span  style='padding-left: 20%' onclick='go(\"imprint.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][2]."$selected[2]</span>";
                    }
                    break;
                case 3:
                    if($select=="'"){
                        $lines[$i]="<label  style='padding-left: 35%'>".$this->idioma[ $idiomaActual ]["MENU"][$i].$select."</label>";
                    }
                    else{
                        $lines[$i]="<span style='padding-left: 35%' onclick='go(\"loginshop.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][3]."$selected[3]</span>";
                    }
                    break;
                case 4:
                    $lines[$i]=$this->FormLink(
                        [
                            $this->ui->Input("language","",$this->idioma[ $idiomaActual ]["MENU"][4],"F",true),
                        ],
                        "",
                        $this->idioma[ $idiomaActual ]["MENU"][4].$selected[4],"black" , "font-size: .9rem !important;vertical-align: sub; letter-spacing: 0.081rem !important;"

                    );
                    break;
                case 5:
                    if($select=="'"){
                        $lines[$i]="<label style='right: 2%;position: absolute'>".$this->Cart($numeroProductosCarrito,$this->idioma[ $idiomaActual ]["MENU"][5]).$selected[5]."</label>";
                    }
                    else{
                        $lines[$i]="<span style='right: 2%;position: absolute' onclick='go(\"carttienda.php\")'>".$this->Cart($numeroProductosCarrito,$this->idioma[ $idiomaActual ]["MENU"][5])."$selected[5]</span>";
                    }

                    break;

            }
            $i++;
        }

        return "<div class='fixed-top' style='padding-top:2vh;padding-bottom:0;padding-left: 2vw;padding-right: 2vw;background-color: $back;'>".
            $this->ui->Row([
                $this->ui->Columns(
                    $lines[0],
                    2,0,0,0,""
                ),
                $this->ui->Columns(
                    $lines[1],
                    2,0,0,0,""
                ),
                $this->ui->Columns(
                    $lines[2],
                    2,0,0,0,""
                ),
                $this->ui->Columns(
                    $lines[3],
                    2,0,2,0,""
                ),
                $this->ui->Columns(
                    $lines[4],2,0,0,0,"adjust"
                ),
                $this->ui->Columns(
                    $lines[5],
                    2,0,0,0,""
                )
            ],"right").$hr.
            "</div>";
    }

    public function MenuArchive($idioma, $idiomaActual,int $numeroProductosCarrito,array $selected,bool $transparente=false,bool $unremark=false):string{
        if($transparente){
            $hr="";
            $back="transparent";
        }
        else{
            $back="white";
            if($unremark){
                $hr="<hr style='margin-bottom: 0'/>";
            }
            else
            {
                $hr="<hr style='margin: 1em -3vw 0px -2vw;opacity: 1;'/>";
            }
        }
        $lines=array();
        $i=0;

        foreach ($selected as $select){

            switch($i)
            {
                case 0:
                    if($select=="'"){
                        $lines[$i]="<label onclick='go(\"shoptienda.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][$i].$select."</label>";
                    }
                    else{
                        $lines[$i]="<span class='menuIcon' onclick='go(\"shoptienda.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][$i]."</span>";
                    }
                    break;
                case 1:
                    if($select=="'"){
                        $lines[$i]="<label  style='padding-left: 5%'>".$this->idioma[ $idiomaActual ]["MENU"][$i].$select."</label>";
                    }
                    else{
                        $lines[$i]="<span class='menuIcon' style='padding-left: 5%' onclick='go(\"archive.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][1]."</span>";
                    }
                    break;
                case 2:
                    if($select=="'"){
                        $lines[$i]="<label  style='padding-left: 20%'>".$this->idioma[ $idiomaActual ]["MENU"][$i].$select."</label>";
                    }
                    else{
                        $lines[$i]="<span class='menuIcon' style='padding-left: 20%' onclick='go(\"imprint.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][2]."$selected[2]</span>";
                    }
                    break;
                case 3:
                    if($select=="'"){
                        $lines[$i]="<label  style='padding-left: 35%'>".$this->idioma[ $idiomaActual ]["MENU"][$i].$select."</label>";
                    }
                    else{
                        $lines[$i]="<span class='menuIcon' style='padding-left: 35%' onclick='go(\"loginshop.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][3]."$selected[3]</span>";
                    }
                    break;
                case 4:
                    $lines[$i]=$this->FormLink(
                        [
                            $this->ui->Input("language","",$this->idioma[ $idiomaActual ]["MENU"][4],"F",true),
                        ],
                        "",
                        $this->idioma[ $idiomaActual ]["MENU"][4].$selected[4], "", "font-size: .9rem !important;vertical-align: inherit;"

                    );
                    break;
                case 5:
                    if($select=="'"){
                        $lines[$i]="<label style='right: 2%;position: absolute'>".$this->Cart($numeroProductosCarrito,$this->idioma[ $idiomaActual ]["MENU"][5]).$selected[5]."</label>";
                    }
                    else{
                        $lines[$i]="<span style='right: 2%;position: absolute' onclick='go(\"carttienda.php\")'>".$this->Cart($numeroProductosCarrito,$this->idioma[ $idiomaActual ]["MENU"][5])."$selected[5]</span>";
                    }

                    break;

            }
            $i++;
        }



        return "<div class='fixed-top' style='padding-top:2vh;padding-bottom:0;padding-left: 2vw;padding-right: 2vw;background-color: $back;'>".
            $this->ui->Row([
                $this->ui->Columns(
                    $lines[0],
                    2,0,0,0,""
                ),
                $this->ui->Columns(
                    $lines[1],
                    2,0,0,0,""
                ),
                $this->ui->Columns(
                    $lines[2],
                    2,0,0,0,""
                ),
                $this->ui->Columns(
                    $lines[3],
                    2,0,2,0,""
                ),
                $this->ui->Columns(
                    $lines[4],2
                ),
                $this->ui->Columns(
                    $lines[5],
                    2,0,0,0,""
                )
            ],"right").
            "</div>";
    }

    public function FaceInit():string{
        return // Load Facebook button
            "
            <div id=\"fb-root\"></div>
            <script async defer 
                crossorigin=\"anonymous\" 
                src=\"https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v9.0&appId=1794600520762591&autoLogAppEvents=1\" 
                nonce=\"wlJTE7aj\">
            </script>";
    }

    public function LogoNegro():string{
        return "<img onclick='go(\"index.php\")' alt='SP' id='logo' class='fixed-top' src='img/ts_iso_negro.png' style='width: 7%'>";
    }

    public function LogoDorado():string{
        return "<img alt='SP' id='logo' class='fixed-top' src='img/ts_iso_oro.png' style='width: 7%'>";
    }

    // Funciones

    function FormLink(array $content,string $url,string $button,string $color="black", string $estiloBoton =""){
        $color= ($color == "" ? "black" : $color);
        $html= "
            <form method='post' action='$url'>";
        $html.=implode("",$content);

        $html.='
                <div class="form-group row">
                    <div class="col-sm-12" style="padding-left: 45%">
                        <button type="submit" class="btn btn-link" style="text-decoration: none;color: '.$color.';padding: 0px;border: none;'.$estiloBoton.'"><span type="submit">'.$button.'</span></button>
                    </div>
                </div>
            </form>';
        return $html;
    }

    function Cart($number,$label):string
    {
        return str_replace("*",$number,$label);
    }

    public function TMenu(int $catalogo)
    {
        $msg = "<div id='t' style='font-size:1.1em;font-family: NHaasGroteskDSPro-55Rg;z-index: 900'>";
        for ($i = 0; $i <$catalogo; $i++){
            $msg .= "<span onclick='ircatalogo($i)' class='hidden catalogolabel'>T0".($catalogo - $i)."00'00</span>";
        }
        $msg .= "</div>";
        return $msg;
    }

    public function About($idiomaActual):string{
        return "<div class='fixed-top' style='top:57vh;padding-bottom:2vh;padding-left: 2vw;padding-right: 2vw'>".
            $this->ui->Row([
                $this->ui->Columns(
                    "<p>PIECES OF EVIDENCE</p>",
                    12,0,0,0,""
                )
            ],"").
            $this->ui->Row([
                $this->ui->Columns(
                    "<p>WITHIN FLEETING TIMES . AN AIM TO CREATE</p>",
                    12,0,0,0,""
                )
            ],"").
            $this->ui->Row([
                $this->ui->Columns(
                    "<p>PUNCTUAL YET LASTING MOMENTS</p>",
                    12,0,0,0,""
                )
            ],"").
            $this->ui->Row([
                $this->ui->Columns(
                    "<p>WWW . TIEMPOS . SHOP</p>",
                    12,0,0,0,""
                )
            ],"").
            "</div>";
    }

    public function Foot($idiomaActual):string{
        return "<div class='fixed-bottom' style='padding-top:2vh;padding-bottom:2vh;padding-left: 2vw;padding-right: 2vw'>".
            $this->ui->Row([
                $this->ui->Columns(
                    "<p>ABOUT BRANDS S.A. DE C.V. ABR181008L27</p>",
                    12,0,0,0,""
                )
            ],"").
            $this->ui->Row([
                $this->ui->Columns(
                    "<p>CALLE INDUSTRIAL 4 51D</p>",
                    12,0,0,0,""
                )
            ],"").
            $this->ui->Row([
                $this->ui->Columns(
                    "<p>COL. LA PRIMAVERA 8030 CULIACÁN SIN. MX</p>",
                    12,0,0,0,""
                )
            ],"").
            "</div>";
    }
    public function MenuFamilia(){
            if(isset($_GET["submenu"])){
                $this->submenu = $_GET["submenu"];
            }
            switch ($this->submenu) {
                case 2:
                    return
                        "</div>
                    <div style='position: fixed;top:8.5vh;margin-left: 2vw'>
                    <a style='color: black' href='shoptienda.php?submenu=1'><span>SHOP ALL</span></a><br/>
                    <br/>
                    <a style='color: black'>MENS</a><br/>
                    <br/>
                     <a style='color: black'>WOMENS</a><br/>
                    <br/>
                    <a style='color: black' href='shoptienda.php?submenu=2'>ACCESSORIES'</a><br/>
                    <br/>
                    <a style='color: black' href='shoptienda.php?submenu=3'><span><strong>SALE</strong></span></a>
                </div>";
                case 3:
                    return
                        "</div>
                    <div style='position: fixed;top:8.5vh;margin-left: 2vw'>
                    <a style='color: black' href='shoptienda.php?submenu=1'><span>SHOP ALL</span></a><br/>
                    <br/>
                    <a style='color: black'>MENS</a><br/>
                    <br/>
                     <a style='color: black'>WOMENS</a><br/>
                    <br/>
                    <a style='color: black' href='shoptienda.php?submenu=2'><span>ACCESSORIES</span></a><br/>
                    <br/>
                    <a style='color: black' href='shoptienda.php?submenu=3'><strong>SALE</strong>'</a>
                </div>'";
                default:
                    return
                        "</div>
                            <div style='position: fixed;top:8.5vh;margin-left: 2vw'>
                            <a style='color: black' href='shoptienda.php?submenu=1'>SHOP ALL'</a><br/>
                            <br/>
                            <a style='color: black'>MENS</a><br/>
                            <br/>
                            <a style='color: black'>WOMENS</a><br/>
                            <br/>
                            <a style='color: black' href='shoptienda.php?submenu=2'><span>ACCESSORIES</span></a><br/>
                            <br/>
                            <a style='color: black' href='shoptienda.php?submenu=3'><span><strong>SALE</strong></span></a>
                        </div>";
                    break;
            }
        }

    public function MenuFamilia2($idioma = [], $accionFiltro = [], $menu = 0){
        $submenu = 0;
        $index = 0;
        $nav ="<div style='position: fixed;top:8.5vh;margin-left: -12vw'>";
        foreach ($idioma as $valor => $key){
            if( is_array($key) )
            {
                $nav .= "<div class='p-2'>";
                $nav .= "<a href='#' class='d-block text-dark' data-menu='$submenu' onclick='openSubmenu(this);'>$valor</a>";
                $nav .= "<div class='submenu d-none'>";
                foreach ($key as $sub){
                    $nav .= "<a href='#' class='d-block text-dark pl-2'>$sub</a>";
                }
                $nav .= "</div>";
                $nav .= "</div>";
                $submenu++;
            }else {

                if( $index == 4 )
                    $idioma[$valor] = "<b>$idioma[$valor]</b>";
                if( $menu == $index  )
                    $nav .= "<a href='$accionFiltro[$index]' class='d-block text-dark p-1'>$idioma[$valor]'</a>";
                else
                    $nav .= "<a href='$accionFiltro[$index]' class='d-block text-dark p-1'><span>$idioma[$valor]</span></a>";
            }
            $index++;
        }
        $nav .= "</div>";
        return $nav;
    }


    public function SizeButton($botonTalla,$opcionesTallas){
        return '<div class="btn-group" style="width:100%">
                    <button type="button" class="btn btn-block dropdown-toggle" data-bs-toggle="dropdown">
                      '.$botonTalla.'
                    </button>
                    <div class="dropdown-menu align-content-center" role="menu" style="width:100%">
                        '.$opcionesTallas.'
                    </div>
                  </div>'.
                '<hr style="margin: 0 0 0 0"/>';
    }

    public function CartButton(){
        return $this->ui->FormButtom([
                    $this->ui->Input("Cart","",1,"F",false)
                ],"",'<button id="cart" type="submit" class="btn btn-dark btn-block" style="border-radius: 0">ADD TO CART</button>');
    }

    public function CheckoutButton(){
        return $this->ui->FormButtom([
            $this->ui->Input("CheckOut","",1,"F",false)
        ],"cart.php",'<button id="checkout" type="submit" class="btn btn-dark btn-block" style="border-radius: 0">PROCEED TO CHECKOUT</button>');
    }

    public function Existe($clave, array $productosCarrito)
    {
        foreach ($productosCarrito as $producto){
            if(in_array($clave,$producto)) return true;
        }
        return false;

    }

    public function Borrar(array $element)
    {
        $clave = strval($element["Clave"]);
        return
        $this->ui->FormButtomInline([
            $this->ui->Input("borrar","", $clave ,"F",false)
        ],"",
        "<button type='submit' style='border:0 solid transparent;background-color:transparent;display: inline-block'>X</button>", $clave);
    }

    public function BorrarCarrito(string $clave){
        $productosCarrito=$_SESSION["ProductosCarrito"];
        $productoEliminado = false;
        foreach ($productosCarrito as $key=>$producto){
            if($producto[0]==$clave){
                unset($productosCarrito[$key]);
                $productoEliminado = true;
            }
        }
        $_SESSION["ProductosCarrito"]=$productosCarrito;
        return $productoEliminado;
    }

    public function BotonEditar(array $element)
    {
        $clave=$element["Clave"];
        $valor=$element["Cantidad"];
        return "<input onchange='edit(this,\"$clave\");' type='text' maxlength='1' value='$valor' style='width: 25px;padding-left: 5px;'>";
    }

    public function Aviso(string $position = "inherit"){
        return
            $this->ui->RowSpace("1em").
            $this->PoliticaPrivacidad($position);
    }



    public function MenuFiltro()
    {
        return
        "
        <div class='small' style='position: fixed;display: inline-block;top: 8.5vh;right: 1.6vw;width:11vw'>
            <label onclick='filter()' id='s' style='font-size: 0.9rem;'>SORT +</label>
            <div id='sMenu' style='color:white;background-color: gray;border-radius: 5px;display: none'>
                <div class='container-fluid' style='padding-left: 0;padding-right: 0;padding-top: 0.5vh;padding-bottom: 0.5vh;'>
                    <div class='row item' style='margin-left: 0'>
                        <div class='col-md-1 align-self-center' style='padding-right: 0'>
                            <label style='width: 100%;text-align: right;'></label>
                        </div>
                        <div class='col-md-10'>
                            <a href='shoptienda.php?submenu={$this->submenu}&order=1' style='display: block'>FEATURED</a>                        
                            
                                                    
                        </div>
                        <div class='col-md-1'>
                            
                        </div>
                    </div>
                    <div class='row item' style='margin-left: 0'>
                        <div class='col-md-1 align-self-center' style='padding-right: 0'>
                            <label style='width: 100%;text-align: right'></label>
                        </div>
                        <div class='col-md-10'>
                            <a href='shoptienda.php?submenu={$this->submenu}&order=2' style='display: block'>A TO Z</a>
                                                    
                        </div>
                        <div class='col-md-1'>
                            
                        </div>
                    </div>
                    <div class='row item' style='margin-left: 0'>
                        <div class='col-md-1 align-self-center' style='padding-right: 0'>
                            <label style='width: 100%;text-align: right'></label>
                        </div>
                        <div class='col-md-10'>
                            <a href='shoptienda.php?submenu={$this->submenu}&order=3' style='display: block'>PRICE LOW TO HIGH</a>
                                                    
                        </div>
                        <div class='col-md-1'>
                            
                        </div>
                        
                    </div>
                    <div class='row item' style='margin-left: 0'>
                        <div class='col-md-1 align-self-center' style='padding-right: 0'>
                            <label style='width: 100%;text-align: right'></label>
                        </div>
                        <div class='col-md-10'>
                            <a href='shoptienda.php?submenu={$this->submenu}&order=4' style='display: block'>PRICE HIGH TO LOW</a>
                                                    
                        </div>
                        <div class='col-md-1'>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        ";
    }

    public function PoliticaPrivacidad(string $position = "inherit")
    {
        return "<div style='position: ".$position.";bottom: 0;margin-bottom: 0.8rem; min-height: 150px;' class='col-md-8 col-sm-12 text-right pr-4 pl-4 d-flex align-items-end'><span class='small mr-4 col-md-6' onclick='go(\"privacy.php\")'> PRIVACY POLICY</span><span  onclick='go(\"shipping.php\")' class='small ml-4 col-md-5'>SHIPPING & RETURNS</span></div>";
    }

    public function MenuPrivacyReturn(bool $privacy,bool $return){
        return $this->PoliticaPrivacidad();
        $html= "
            <div class='container-fluid' style='position: fixed;bottom: 0;font-size: 0.7em;padding-left: 35%'>
                <label><span style='width: 10vw;display: block'";
        if($privacy) $html.=" onclick='go(\"privacy.php\")'";
        $html.=">PRIVACY POLICY</span></label><label><span";
        if($return) $html.=" onclick='go(\"shipping.php\")'";
        $html.=">SHIPPING RETURNS</span></label>
            </div>";
        return $html;
    }

    public function MenuPrivacyReturnInside(bool $privacy,bool $return){
        $html= "
            <div class='container-fluid mb-2' style='position: fixed;bottom: 1vh;font-size: 0.7rem;padding-left: 50%; padding-bottom: 0.5em;'>
                <label style='width: 10vw;display: inline-block'>";
        if($privacy) $html.="<span  onclick='go(\"privacy.php\")'>";
        $html.="PRIVACY POLICY";
        if($return) $html.="'";
        if($privacy) $html.="</span>";
        $html.="</label><label style='width: 20vw;display: inline-block'>";
        if($return) $html.="<span onclick='go(\"shipping.php\")'>";
        $html.="SHIPPING RETURNS";
        if($privacy) $html.="'";
        if($return) $html.="</span>";
        $html.="</label>
            </div>";
        return $html;
    }

    public function MenuPrivacyReturnView(bool $privacy,bool $return){
        $html= "
            <div class='container-fluid' style='position: fixed;bottom: 0;font-size: 0.7rem; margin-top: calc(5% - 1rem);'>
                <label class='mr-4'><span style='width: 10vw;'";
        if($privacy) $html.=" onclick='go(\"privacy.php\")'";
        $html.=">PRIVACY POLICY</span></label><label class='mr-4'><span  style='width: 10vw;'";
        if($return) $html.=" onclick='go(\"shipping.php\")'";
        $html.=">SHIPPING RETURNS</span></label>";
        $html.="<button type='button' class='btn btn-link' style='text-decoration: none;color: #212529;padding: 0;border: none;font-weight: normal; vertical-align: baseline;font-size: inherit !important;; '  data-bs-toggle='modal' data-bs-target='#size'><span>SIZE GUIDE</span></button>";
        $html.="</div>";

        return $html;
    }

    public function BlackInput(string $title,$id,bool $password=false, $maxlength  = 999999){
        $type="";
        if($password){
            $type="type='password'";
        }
        return "<input $type class='form-control' name='$id' id='$id' maxlength='$maxlength' placeholder='$title' style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em'/>";
    }

    public function BlackInputType(string $title,$id,string $type,bool $requiered=false):string
    {
        if($requiered) return  "<input required type='$type' class='form-control' name='$id' placeholder='$title' style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em'/>";
        else return "<input type='$type' class='form-control' name='$id' placeholder='$title' style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em'/>";
    }

    public function BlackInputTypeAttrib(string $title,$id,string $type,bool $requiered=false,string $attr=""):string
    {
        if($requiered) return  "<input $attr required type='$type' class='form-control' name='$id' id='$id' placeholder='$title' style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em'/>";
        else return "<input $attr type='$type' class='form-control' name='$id' id='$id' placeholder='$title' style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em'/>";
    }


    public function BlackInputEye(string $title, $id ,bool $password = false) {
        $type="";
        if($password){
            $type="type='password'";
        }
        return "
                <div class='input-group'>
                    <input $type class='form-control' name='$id' id='$id' placeholder='$title' style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em'>
                    <a href='#' onclick='seteyePassword(this);' style='position: absolute; right: 10px;z-index: 99;top: 2px;'><i class='fa fa-eye-slash' style='color: black;' aria-hidden='true'></i></a>
                </div>
            ";
    }

    public function ScriptAmpliarFoto($id){
        return
            '
            $("#'.$id.'").mlens(
            {
                imgSrc: $("#'.$id.'").attr("data-big"),
                lensShape: "circle",
                lensSize: 180,
                borderSize: 4,
                borderColor: "#fff",
                borderRadius: 0,
                imgOverlay: $("#'.$id.'").attr("data-overlay"),
                overlayAdapt: true
            });
            ';
    }
    public function Lupa($idsScripts){
        return
        '
        $(document).ready(function()
        {
        '.$idsScripts.'            
        });
        ';
    }

    public function setIndexView($urls = [], $type = "img"){
        $html = "<div class='row' style='padding: 0px; margin: 0px;'>";
        foreach ($urls as $url){
            $html .= "<div class='col' style='padding: 0px; margin: 0px;'>";

            if($type == "img")
                $html .= "<img src='$url' style='padding: 0px;margin: 0px; width: 100%; height: 100%;' />";
            else
                $html .= "<iframe src='$url' style='height: 100%; width: 100%; position: absolute;'></iframe>";

            $html .= "</div>";
        }
        $html .= "</div>";
        return $html;
    }

    public function MenuAccount($idioma){
        //$nav ="<div style='position: fixed;top:8.5vh;margin-left: 2vw'>"
        $nav ="<div>";
        foreach ($idioma as $valor){
            $nav .= "<a href='#' class='d-block text-dark p-1'><span>$valor</span></a>";
        }
        $nav .= "</div>";
        return $nav;
    }
}