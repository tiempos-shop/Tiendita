

<?php
    $html='<!DOCTYPE html>
        <html lang="es">';

    include_once ("VistasMenu.php");
    include_once ("VistaPrincipal.php");
    $vistaPrincipal=new \Administracion\VistaPrincipal();

    $html.=$vistaPrincipal->HeadMenu();

    $html.= '<!-- Page Wrapper -->
        <body id="page-top">';
    $html.= '<div id="wrapper">';
    $html.= $vistaPrincipal->SideBar("Admin TShop","administracion.php");

    $html.= '
                    <!-- Content Wrapper -->
                    <div id="content-wrapper" class="d-flex flex-column">
                        <!-- Main Content -->
                        <div id="content">';
    $html.= $vistaPrincipal->TopBar();

    $html.= $vistaPrincipal->Content();

    $html.= $vistaPrincipal->Footer("Tiempos Shop");
    $html.= '
                    </div>
                    <!-- End of Content Wrapper -->
                </div>
                <!-- End of Page Wrapper -->';

    $html.= $vistaPrincipal->Wrapper();
    $html.= '
        </body>
    </html>';

    echo $html;
  ?>







