

<?php
    include_once ("VistaPrincipal.php");
    $vistaPrincipal=new \Administracion\VistaPrincipal();

    $body= $vistaPrincipal->SideBar("Admin TShop","administracion.php");
    $body.=$vistaPrincipal->ContentWrapper(
        $vistaPrincipal->TopBar().
        $vistaPrincipal->Content().
        $vistaPrincipal->Footer("Tiempos Shop")
    );
    $body.= $vistaPrincipal->Wrapper();

    $html=$vistaPrincipal->Html5(
        $vistaPrincipal->HeadMenu(),
        $vistaPrincipal->PageWrapper($body)
    );

    echo $html;








