<?php


namespace Tiendita;
include_once "Utilidades.php";

class FrontComponents
{
    protected Utilidades $ui;
    protected array $idioma;
    public function __construct()
    {
        $this->ui=new Utilidades();
        $this->idioma=[ "ESPAÑOL"=>[ "MENU"=>[ "TIENDA","ARCHIVO","MARCA","INGRESO","ENGLISH","CARRITO(*)"] ],"ENGLISH"=>[ "MENU"=>[ "SHOP","ARCHIVE","IMPRINT","LOGIN","ESPAÑOL","CART(*)" ] ] ];
    }

    public function MenuDorado($idioma, $idiomaActual,int $numeroProductosCarrito=0):string{

        return "<div class='fixed-top' style='padding-top:2vh;padding-bottom:0;padding-left: 2vw;padding-right: 2vw'>".
        $this->ui->Row([
            $this->ui->Columns(
                "<span onclick='go(\"shop.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][0]."</span>",
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
                "<span style='padding-left: 35%' onclick='go(\"customerLogin.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][3]."</span>",
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
                2,0,2,0,""
            ),
            $this->ui->Columns(
                "<span  style='right: 2%;position: absolute' onclick='go(\"cart.php\")'>".$this->Cart($numeroProductosCarrito,$this->idioma[ $idiomaActual ]["MENU"][5])."</span>",
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
                        $lines[$i]="<label onclick='go(\"shop.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][$i].$select."</label>";
                    }
                    else{
                        $lines[$i]="<span class='menuIcon' onclick='go(\"shop.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][$i]."<i>'</i></span>";
                    }
                    break;
                case 1:
                    if($select=="'"){
                        $lines[$i]="<label  style='padding-left: 5%'>".$this->idioma[ $idiomaActual ]["MENU"][$i].$select."</label>";
                    }
                    else{
                        $lines[$i]="<span class='menuIcon' style='padding-left: 5%' onclick='go(\"archive.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][1]."<i>'</i></span>";
                    }
                    break;
                case 2:
                    if($select=="'"){
                        $lines[$i]="<label  style='padding-left: 20%'>".$this->idioma[ $idiomaActual ]["MENU"][$i].$select."</label>";
                    }
                    else{
                        $lines[$i]="<span class='menuIcon' style='padding-left: 20%' onclick='go(\"imprint.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][2]."$selected[2]<i>'</i></span>";
                    }
                    break;
                case 3:
                    if($select=="'"){
                        $lines[$i]="<label  style='padding-left: 35%'>".$this->idioma[ $idiomaActual ]["MENU"][$i].$select."</label>";
                    }
                    else{
                        $lines[$i]="<span class='menuIcon' style='padding-left: 35%' onclick='go(\"customerLogin.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][3]."$selected[3]<i>'</i></span>";
                    }
                    break;
                case 4:
                    $lines[$i]=$this->FormLink(
                        [
                            $this->ui->Input("language","",$this->idioma[ $idiomaActual ]["MENU"][4],"F",true),
                        ],
                        "",
                        $this->idioma[ $idiomaActual ]["MENU"][4].$selected[4]

                    );
                    break;
                case 5:
                    if($select=="'"){
                        $lines[$i]="<label style='right: 2%;position: absolute'>".$this->Cart($numeroProductosCarrito,$this->idioma[ $idiomaActual ]["MENU"][5]).$selected[5]."</label>";
                    }
                    else{
                        $lines[$i]="<span class='menuIcon' style='right: 2%;position: absolute' onclick='go(\"cart.php\")'>".$this->Cart($numeroProductosCarrito,$this->idioma[ $idiomaActual ]["MENU"][5])."$selected[5]<i>'</i></span>";
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
                        $lines[$i]="<label onclick='go(\"shop.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][$i].$select."</label>";
                    }
                    else{
                        $lines[$i]="<span class='menuIcon' onclick='go(\"shop.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][$i]."<i>'</i></span>";
                    }
                    break;
                case 1:
                    if($select=="'"){
                        $lines[$i]="<label  style='padding-left: 5%'>".$this->idioma[ $idiomaActual ]["MENU"][$i].$select."</label>";
                    }
                    else{
                        $lines[$i]="<span class='menuIcon' style='padding-left: 5%' onclick='go(\"archive.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][1]."<i>'</i></span>";
                    }
                    break;
                case 2:
                    if($select=="'"){
                        $lines[$i]="<label  style='padding-left: 20%'>".$this->idioma[ $idiomaActual ]["MENU"][$i].$select."</label>";
                    }
                    else{
                        $lines[$i]="<span class='menuIcon' style='padding-left: 20%' onclick='go(\"imprint.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][2]."$selected[2]<i>'</i></span>";
                    }
                    break;
                case 3:
                    if($select=="'"){
                        $lines[$i]="<label  style='padding-left: 35%'>".$this->idioma[ $idiomaActual ]["MENU"][$i].$select."</label>";
                    }
                    else{
                        $lines[$i]="<span class='menuIcon' style='padding-left: 35%' onclick='go(\"customerLogin.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][3]."$selected[3]<i>'</i></span>";
                    }
                    break;
                case 4:
                    $lines[$i]=$this->FormLink(
                        [
                            $this->ui->Input("language","",$this->idioma[ $idiomaActual ]["MENU"][4],"F",true),
                        ],
                        "",
                        $this->idioma[ $idiomaActual ]["MENU"][4].$selected[4]

                    );
                    break;
                case 5:
                    if($select=="'"){
                        $lines[$i]="<label style='right: 2%;position: absolute'>".$this->Cart($numeroProductosCarrito,$this->idioma[ $idiomaActual ]["MENU"][5]).$selected[5]."</label>";
                    }
                    else{
                        $lines[$i]="<span class='menuIcon' style='right: 2%;position: absolute' onclick='go(\"cart.php\")'>".$this->Cart($numeroProductosCarrito,$this->idioma[ $idiomaActual ]["MENU"][5])."$selected[5]<i>'</i></span>";
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

    function FormLink(array $content,string $url,string $button,string $color="black"){
        $html= "
            <form method='post' action='$url'>";
        $html.=implode("",$content);
        $html.='
                <div class="form-group row">
                    <div class="col-sm-12" style="padding-left: 45%">
                        <button type="submit" class="btn btn-link" style="text-decoration: none;color: '.$color.';padding: 0px;border: none"><span type="submit">'.$button.'</span></button>
                    </div>
                </div>
            </form>';
        return $html;
    }

    function Cart($number,$label):string
    {
        return str_replace("*",$number,$label);
    }

    public function TMenu(string $htmlIds)
    {
        return "<label id='t' style='font-size:1.1em;font-family: NHaasGroteskDSPro-55Rg;z-index: 100'>T0000'00</label>";
//        return "<label id='t' onmouseover='tOverMenu();' style='font-size:1.1em;font-family: NHaasGroteskDSPro-55Rg;z-index: 100'>T0000'00</label>".
//            "<div style='z-index: 1000' onmouseleave='tOffMenu();' id='t-over'>".
//            $htmlIds.
//            "</div>";
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
        if(isset($_GET["order"])){
            $valor=$_GET["order"];
            if($valor==5) return
                "</div>
                    <div style='position: fixed;top:8.5vh;margin-left: 2vw'>
                    <a style='color: black' href='shop.php?order=6'><span class='menuIcon'>SHOP ALL<i>'</i></span></a><br/>
                    <br/>
                    <span class='menuIcon'>ACCESSORIES<i>'</i></span><br/> 
                    <br/>
                    <a style='color: black' href='shop.php?order=5'><strong>SALE'</strong></a>
                </div>";
            else {
                return
                    "</div>
                    <div style='position: fixed;top:8.5vh;margin-left: 2vw'>
                    <a style='color: black' href='shop.php?order=6'>SHOP ALL'</a><br/>
                    <br/>
                    <span class='menuIcon'>ACCESSORIES<i>'</i></span><br/>
                    <br/>
                    <a style='color: black' class='menuIcon' href='shop.php?order=5'><span><strong>SALE</strong></span><i>'</i></a>
                </div>";
            }
        }
        else {
            return
                "</div>
                    <div style='position: fixed;top:8.5vh;margin-left: 2vw'>
                    <a style='color: black' href='shop.php?order=6'>SHOP ALL'</a><br/>
                    <br/>
                    <span>ACCESSORIES</span><br/>
                    <br/>
                    <a style='color: black' href='shop.php?order=5'><span><strong>SALE</strong></span></a>
                </div>";
        }


    }

    public function SizeButton($botonTalla,$opcionesTallas){
        return '<div class="btn-group" style="width:100%">
                    <button type="button" class="btn btn-block dropdown-toggle" data-toggle="dropdown">
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
        return
        $this->ui->FormButtomInline([
            $this->ui->Input("borrar","",$element["Clave"],"F",false)
        ],"","<button type='submit' style='border:0 solid transparent;background-color:transparent;display: inline-block'>X</button>");
    }

    public function BorrarCarrito(string $clave){
        $productosCarrito=$_SESSION["ProductosCarrito"];
        foreach ($productosCarrito as $key=>$producto){
            if($producto[0]==$clave){
                unset($productosCarrito[$key]);
            }
        }
        $_SESSION["ProductosCarrito"]=$productosCarrito;
    }

    public function BotonEditar(array $element)
    {
        $clave=$element["Clave"];
        $valor=$element["Cantidad"];
        return "<input onchange='edit(this,\"$clave\");' type='text' maxlength='1' value='$valor' style='width: 25px;padding-left: 5px;'>";
    }

    public function Aviso(){
        return
            $this->ui->RowSpace("1em").
            $this->ui->Row([
                $this->ui->Columns("",7),
                $this->ui->Columns("<span style='width: 10vw;display: inline-block' onclick='go(\"privacy.php\")' class='small'>PRIVACY POLICY</span><span  onclick='go(\"shipping.php\")' class='small'>SHIPPING & RETURNS</span>",5)
            ],"");
    }

    public function MenuFiltro()
    {
        return
        "
        <div class='small' style='position: fixed;display: inline-block;top: 8.5vh;right: 1.6vw;width:11vw'>
            <label onclick='filter()' id='s'>SORT +</label>
            <div id='sMenu' style='color:white;background-color: gray;border-radius: 5px;display: none'>
                <div class='container-fluid' style='padding-left: 0;padding-right: 0;padding-top: 0.5vh;padding-bottom: 0.5vh;'>
                    <div class='row item' style='margin-left: 0'>
                        <div class='col-md-1 align-self-center' style='padding-right: 0'>
                            <label style='width: 100%;text-align: right;'></label>
                        </div>
                        <div class='col-md-10'>
                            <a href='shop.php?order=1' style='display: block'>FEATURED</a>
                                                    
                        </div>
                        <div class='col-md-1'>
                            
                        </div>
                    </div>
                    <div class='row item' style='margin-left: 0'>
                        <div class='col-md-1 align-self-center' style='padding-right: 0'>
                            <label style='width: 100%;text-align: right'></label>
                        </div>
                        <div class='col-md-10'>
                            <a href='shop.php?order=2' style='display: block'>A TO Z</a>
                                                    
                        </div>
                        <div class='col-md-1'>
                            
                        </div>
                    </div>
                    <div class='row item' style='margin-left: 0'>
                        <div class='col-md-1 align-self-center' style='padding-right: 0'>
                            <label style='width: 100%;text-align: right'></label>
                        </div>
                        <div class='col-md-10'>
                            <a href='shop.php?order=3' style='display: block'>PRICE LOW TO HIGH</a>
                                                    
                        </div>
                        <div class='col-md-1'>
                            
                        </div>
                        
                    </div>
                    <div class='row item' style='margin-left: 0'>
                        <div class='col-md-1 align-self-center' style='padding-right: 0'>
                            <label style='width: 100%;text-align: right'></label>
                        </div>
                        <div class='col-md-10'>
                            <a href='shop.php?order=4' style='display: block'>PRICE HIGH TO LOW</a>
                                                    
                        </div>
                        <div class='col-md-1'>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        ";
    }

    public function MenuPrivacyReturn(bool $privacy,bool $return){
        $html= "
            <div class='container-fluid' style='position: fixed;bottom: 0;font-size: 0.9em;padding-left: 55%'>
                <label><span style='width: 10vw;display: block'";
        if($privacy) $html.=" onclick='go(\"privacy.php\")'";
        $html.=">PRIVACY POLICY</span></label><label><span";
        if($return) $html.=" onclick='go(\"shipping.php\")'";
        $html.=">SHIPPING RETURNS</span></label>
            </div>";
        return $html;
    }

    public function MenuPrivacyReturnView(bool $privacy,bool $return){
        $html= "
            <div class='container-fluid' style='position: fixed;bottom: 0;font-size: 0.9em;'>
                <label><span style='width: 10vw;display: block'";
        if($privacy) $html.=" onclick='go(\"privacy.php\")'";
        $html.=">PRIVACY POLICY</span></label><label><span  style='width: 10vw;display: block'";
        if($return) $html.=" onclick='go(\"shipping.php\")'";
        $html.=">SHIPPING RETURNS</span></label>";
        $html.="<button type='button' class='btn btn-link' style='text-decoration: none;color: black;padding: 0;border: none;font-weight: normal;font-size: 14.4px'  data-toggle='modal' data-target='#size'><span>SIZE GUIDE</span></button>";
        $html.="</div>";

        return $html;
    }

    public function BlackInput(string $title,$id,bool $password=false){
        $type="";
        if($password){
            $type="type='password'";
        }
        return "<input $type class='form-control' name='$id' placeholder='$title' style='border-color: black;border-radius: 0;min-height: 2em;padding-bottom: 0.3em;padding-top: 0.3em'/>";
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

}