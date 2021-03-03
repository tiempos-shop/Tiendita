<?php


namespace Tiendita;
include_once "Utilidades.php";

class FrontComponents
{
    protected Utilidades $ui;
    public function __construct()
    {
        $this->ui=new Utilidades();
    }

    public function MenuDorado($idioma, $idiomaActual):string{
        return "<div class='fixed-top' style='padding-top:2vh;padding-bottom:2vh;padding-left: 2vw;padding-right: 2vw'>".
        $this->ui->Row([
            $this->ui->Columns(
                "<span onclick='go(\"shop.php\")'>".$idioma[ $idiomaActual ]["MENU"][0]."<span>",
                3,0,0,0,""
            ),
            $this->ui->Columns(
                "<span>".$idioma[ $idiomaActual ]["MENU"][1]."</span>",
                3,0,0,0,""
            ),
            $this->ui->Columns(
                "<span>".$idioma[ $idiomaActual ]["MENU"][2]."<span>",
                3,0,0,0,""
            ),
            $this->ui->Columns(
                $this->FormLink(
                    [
                        $this->ui->Input("language","",$idioma[ $idiomaActual ]["MENU"][3],"F",true),
                    ],
                    "",
                    $idioma[ $idiomaActual ]["MENU"][3],"#AC9950"

                ),
                2,0,0,0,""
            ),
            $this->ui->Columns(
                "<span>".$this->Cart(4,$idioma[ $idiomaActual ]["MENU"][4])."<span>",
                1,0,0,0,"text-right"
            )
        ],"right").
        "</div>";
    }

    public function Menu($idioma, $idiomaActual):string{
        return "<div class='fixed-top' style='padding-top:2vh;padding-bottom:2vh;padding-left: 2vw;padding-right: 2vw'>".
            $this->ui->Row([
                $this->ui->Columns(
                    "<span onclick='go(\"shop.php\")'>".$idioma[ $idiomaActual ]["MENU"][0]."<span>",
                    3,0,0,0,""
                ),
                $this->ui->Columns(
                    "<span>".$idioma[ $idiomaActual ]["MENU"][1]."</span>",
                    3,0,0,0,""
                ),
                $this->ui->Columns(
                    "<span>".$idioma[ $idiomaActual ]["MENU"][2]."<span>",
                    3,0,0,0,""
                ),
                $this->ui->Columns(
                    $this->FormLink(
                        [
                            $this->ui->Input("language","",$idioma[ $idiomaActual ]["MENU"][3],"F",true),
                        ],
                        "",
                        $idioma[ $idiomaActual ]["MENU"][3]

                    ),
                    2,0,0,0,""
                ),
                $this->ui->Columns(
                    "<span>".$this->Cart(4,$idioma[ $idiomaActual ]["MENU"][4])."<span>",
                    1,0,0,0,"text-right"
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
                    <div class="col-sm-10">
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
        return "<label id='t' onmouseover='tOverMenu();' style='font-family: NHaasGroteskDSPro-55Rg;z-index: 100'>T0000'00</label>".
        "<div style='z-index: 100' onmouseleave='tOffMenu();' id='t-over'>".
            $htmlIds.
        "</div>";
    }


}