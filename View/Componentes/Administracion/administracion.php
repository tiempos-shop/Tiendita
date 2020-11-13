

<?php
    $html='<!DOCTYPE html>
        <html lang="es">';
    echo $html;
    include_once ("VistasMenu.php");
    $vistaMenu=new \Administracion\VistasMenu();
    include_once ("VistaPrincipal.php");
    $vistaPrincipal=new \Administracion\VistaPrincipal();

    echo $vistaMenu->Head();

    echo '<!-- Page Wrapper -->
        <body id="page-top">';
    echo '<div id="wrapper">';
    echo $vistaMenu->SideBar("Admin TShop","administracion.php");
        ?>


          <?php
                echo '
                    <!-- Content Wrapper -->
                    <div id="content-wrapper" class="d-flex flex-column">
                        <!-- Main Content -->
                        <div id="content">';
                echo $vistaMenu->TopBar();

                echo $vistaPrincipal->Content();

          ?>




        <?php
            echo $vistaMenu->Footer("Tiempos Shop");
            echo '
                    </div>
                    <!-- End of Content Wrapper -->
                </div>
                <!-- End of Page Wrapper -->';
        ?>



  <?php
    echo $vistaMenu->Wrapper();
    echo '
    </body>
</html>';
  ?>







