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
                "<span onclick='go(\"shop.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][0]."<span>",
                2,0,2,0,""
            ),
            $this->ui->Columns(
                "<span style='padding-left: 10%' onclick='go(\"archive.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][1]."</span>",
                2,0,2,0,""
            ),
            $this->ui->Columns(
                "<span style='padding-left: 30%' onclick='go(\"imprint.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][2]."<span>",
                2,0,2,0,""
            ),
            $this->ui->Columns(
                "<span style='padding-left: 50%' onclick='go(\"customerLogin.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][3]."<span>",
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
                "<span onclick='go(\"cart.php\")'>".$this->Cart($numeroProductosCarrito,$this->idioma[ $idiomaActual ]["MENU"][5])."<span>",
                2,0,2,0,"text-right"
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
        return "<div class='fixed-top' style='padding-top:2vh;padding-bottom:0;padding-left: 2vw;padding-right: 2vw;background-color: $back;'>".
            $this->ui->Row([
                $this->ui->Columns(
                    "<span onclick='go(\"shop.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][0]."$selected[0]<span>",
                    2,0,0,0,""
                ),
                $this->ui->Columns(
                    "<span style='padding-left: 10%' onclick='go(\"archive.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][1]."$selected[1]</span>",
                    2,0,0,0,""
                ),
                $this->ui->Columns(
                    "<span style='padding-left: 30%' onclick='go(\"imprint.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][2]."$selected[2]<span>",
                    2,0,0,0,""
                ),
                $this->ui->Columns(
                    "<span style='padding-left: 50%' onclick='go(\"customerLogin.php\")'>".$this->idioma[ $idiomaActual ]["MENU"][3]."$selected[3]<span>",
                    2,0,2,0,""
                ),
                $this->ui->Columns(
                    $this->FormLink(
                        [
                            $this->ui->Input("language","",$this->idioma[ $idiomaActual ]["MENU"][4],"F",true),
                        ],
                        "",
                        $this->idioma[ $idiomaActual ]["MENU"][4].$selected[4]

                    ),
                    2,0,0,0,""
                ),
                $this->ui->Columns(
                    "<span onclick='go(\"cart.php\")'>".$this->Cart($numeroProductosCarrito,$this->idioma[ $idiomaActual ]["MENU"][5])."$selected[5]<span>",
                    2,0,0,0,"text-right"
                )
            ],"right").$hr.
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
                    <div class="col-sm-12" style="padding-left: 60%">
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


}