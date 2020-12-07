<?php

namespace Administracion;


use mysql_xdevapi\Exception;
include_once ("VistasHtml.php");

class VistasMenu extends VistasHtml{
    public function __construct()
    {
        parent::__construct();
    }

    public function HeadMenu(){
        return $this->Head("Administración de Tiempos Shop",
            $this->Meta("utf-8","Tienda Online","Egil Ordoñez"),
            $this->LoadStyles([
                "vendor/fontawesome-free/css/all.min.css",
                "https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i","css/sb-admin-2.min.css"
            ]),
            $this->styles,
            $this->scripts
        );


    }

    public function BodyMenu(){
        $body= $this->SideBar("Admin TShop","administracion.php");
        $body.=$this->ContentWrapper(
            $this->TopBar().
            $this->Content().
            $this->Footer("Tiempos Shop")
        );
        $body.= $this->Wrapper();
        return $body;
    }

    public function Wrapper(){
        $html=$this->ScrollToTopButton();
        $html.=$this->LogOutModal();
        $html.=$this->Scripts();
        return $html;
    }

    public function PageWrapper($content){
        $html= '<!-- Page Wrapper -->
        <body id="page-top">
            <div id="wrapper">';

        $html.=$content;

        $html.= '<!-- End Page Wrapper -->
            </div>
        </body>';

        return $html;
    }

    public function ContentWrapper($content){
        $html= '
                    <!-- Content Wrapper -->
                    <div id="content-wrapper" class="d-flex flex-column">
                        <!-- Main Content -->
                        <div id="content">';

        $html.=$content;

        $html.= '
                    </div>
                    <!-- End of Content Wrapper -->
                </div>
                <!-- End of Page Wrapper -->';

        return $html;
    }

    public function ScrollToTopButton(){
        return '
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
        ';
    }

    public function LogOutModal(){
        $titulo="¿Seguro que quieres abandonar tu sesión?";
        $body="Confirme con el boton 'desconectarme' para abandonar la sesión.";
        $botonSalir="Salir";
        $botonAccion="Desconectarme";
        $urlAccion="login.html";

        return $this->Modal($titulo,$body,$botonSalir,$botonAccion,$urlAccion);

    }

    public function Modal($titulo,$body,$botonSalir,$botonAccion,$urlAccion){
        return '
          <!-- Logout Modal-->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">'.$titulo.'</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">'.$body.'</div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">'.$botonSalir.'</button>
                  <a class="btn btn-primary" href="'.$urlAccion.'">'.$botonAccion.'</a>
                </div>
              </div>
            </div>
          </div>    
        ';
    }

    public function Scripts(){
        return '
            <!-- Bootstrap core JavaScript-->
              <script src="vendor/jquery/jquery.min.js"></script>
              <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            
              <!-- Core plugin JavaScript-->
              <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
            
              <!-- Custom scripts for all pages-->
              <script src="js/sb-admin-2.min.js"></script>
            
              <!-- Page level plugins -->
              <script src="vendor/chart.js/Chart.min.js"></script>
            
              <!-- Page level custom scripts -->
              <script src="js/demo/chart-area-demo.js"></script>
              <script src="js/demo/chart-pie-demo.js"></script>
        ';
    }

    public function SideBar($titulo,$url){

        $html='
            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        ';
        $html.=$this->SideBarBrand($titulo,$url);

        $html.=$this->Divider();
        $html.=$this->NavItemDashboard();

        $html.=$this->Divider();
        $html.=$this->Heading("Administración");

        $html.=$this->NavItem("Estadisticas","administracion.php","fas fa-fw fa-chart-area");


        $html.=$this->NavItemCollapse("idUsers","Usuarios","Gestion Usuarios",
            ["usuarios.php"=>"Listar" ,"usuariosEdit.php"=>"Editar"]
        );

        $elementos=["utilities-color.html"=>"Captura Individual" , "utilities-border.html"=>"Captura Masiva", "utilities-animation.html"=>"Circulacion de Inventario"];
        $html.=$this->NavItemCollapse("id3","Inventarios","Inventarios",$elementos);

        $elementos=["utilities-color.html"=>"Pedidos" , "utilities-border.html"=>"Devoluciones", "utilities-animation.html"=>"Envios"];
        $html.=$this->NavItemCollapse("id5","Ventas","Ventas",$elementos);

        $elementos=["utilities-color.html"=>"Reporte Financiero" , "utilities-border.html"=>"Reporte de Pedidos", "utilities-animation.html"=>"Reporte de Devoluciones"];
        $html.=$this->NavItemCollapse("id4","Reportes","Reportes",$elementos);

        $html.=$this->Divider();
        $html.=$this->Heading("Catalogos");

        $html.=$this->NavItemCollapse("idTipoMovimientos","Tipo Movimientos","Catalogo Tipo Movimientos",
            ["tipoMovimientos.php"=>"Listar" ,"tipoMovimientosEdit.php"=>"Editar"]
        );

        $html.=$this->Divider();
        $html.=$this->Heading("Configuración");

        $html.=$this->NavItem("Aplicacion","Configuracion.php","fas fa-fw fa-chart-area");
        $html.=$this->NavItem("Tablas","tables.html","fas fa-fw fa-table");

        $html.=$this->FinalDivider();
        $html.=$this->SidebarToggler();

        $html.='
            </ul>
            <!-- End of Sidebar -->
        ';

        return $html;
    }

    private function SideBarBrand($titulo,$url,$icon="fas fa-shopping-basket"){
        return '
            <!-- Sidebar - Brand -->
              <a class="sidebar-brand d-flex align-items-center justify-content-center" href="'.$url.'">
                <div class="sidebar-brand-icon rotate-n-15">
                  <i class="'.$icon.'"></i>
                </div>
                <div class="sidebar-brand-text mx-3">'.$titulo.'<sup>mr</sup></div>
              </a>
        ';
    }

    private function Divider(){
        return '
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            ';

    }

    private function FinalDivider(){
        return '
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
      ';
    }

    private function NavItemDashboard(){
        $titulo="Panel Control";
        $url="administracion.php";
        $icon="fas fa-fw fa-tachometer-alt";
        return $this->NavItem($titulo,$url,$icon);

    }

    private function NavItem($titulo,$url,$icon){
        return '
            <!-- Nav Item - Dashboard -->
              <li class="nav-item active">
                <a class="nav-link" href="'.$url.'">
                  <i class="'.$icon.'"></i>
                  <span>'.$titulo.'</span></a>
              </li>
        ';
    }

    private function Heading($titulo){
        return '<!-- Heading -->
      <div class="sidebar-heading">
        '.$titulo.'
      </div>';
    }

    private function NavItemCollapse($id,$titulo,$subtitulo,$items){
        if(!is_array($items)){
            throw new Exception("Se requiere un arrglo para los menus, URL y titulo");
        }
        $html_inicio='
        <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#'.$id.'" aria-expanded="true" aria-controls="'.$id.'">
          <i class="fas fa-fw fa-cog"></i>
          <span>'.$titulo.'</span>
        </a>
        <div id="'.$id.'" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">'.$subtitulo.':</h6>
            ';

        $html_menu="";
        foreach ($items as $url=>$titulo){
            $html_menu.='
            <a class="collapse-item" href="'.$url.'">'.$titulo.'</a>
            ';
        }

        $html_fin='
          </div>
        </div>
      </li>
        ';
        return $html_inicio.$html_menu.$html_fin;
    }

    private function SidebarToggler(){
        return '<!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>';
    }

    public function Footer($empresa){
        return '
          <!-- Footer -->
          <footer class="sticky-footer bg-white">
            <div class="container my-auto">
              <div class="copyright text-center my-auto">
                <span>Copyright &copy; '.$empresa.' 2020</span>
              </div>
            </div>
          </footer>
          <!-- End of Footer -->
        ';
    }

    public function TopBar(){
        $html='<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">';
        $html.=$this->TopBarToggle();
        $html.=$this->TopBarSearch();
        $html.=$this->TopbarNavbar();

        $html.='</nav>
        <!-- End of Topbar -->';
        return $html;
    }

    private function TopBarToggle(){
        return '<!-- Topbar Toggle -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>';
    }

    private function TopBarSearch($url=""){
        if($url!=""){
            $url='formaction="'.$url.'"';
        }
        return '<!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar por..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button" formmethod="post" '.$url.'>
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>';


    }

    public function TopbarNavbar(){
        $html='<!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">';

        $html.=$this->TopbarNavbarNavItemSearchDropdown();

        $alertas=[ "3 agosto 2020"=>"Se genero una devolucion del cliente Softquimia S.A. de C.V. Pedido 123443","4 agosto 2020"=>"Se dio de alta un cliente VIP 'Luis Miguel'."];
        $html.=$this->TopbarNavbarNavItemAlerts("Alertas","Alertas",$alertas);

        $mensajes=[ "Pablo Urrutia"=>"Necesito ayuda","Jimena Hernández"=>"Yo te puedo apoyar. Te marco"];
        $html.=$this->TopbarNavbarNavItemMessages("Mensaje","Centro de Mensajes",$mensajes);
        $html.=$this->Divisor();
        $html.=$this->TopbarNavbarNavItemUserInformation();

        $html.='</ul>';

        return $html;






    }

    private function TopbarNavbarNavItemSearchDropdown(){
        return '<!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar por..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>';
    }

    private function TopbarNavbarNavItemAlerts($id,$titulo,$alertas){
        return $this->TopbarNavbarNavItemMessages($id,$titulo,$alertas,2);
    }

    private function TopbarNavbarNavItemMessages($id,$titulo,$mensajes,$tipo=1){
        $html= '<!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="'.$id.'" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="'.$id.'">
                <h6 class="dropdown-header">
                  '.$titulo.'
                </h6>';
        if($tipo==1){
            foreach ($mensajes as $usuario=>$mensaje){
                $html.=$this->MesaggeItem($mensaje,$usuario);
            }
        }
        else{
            foreach ($mensajes as $fecha=>$alerta){
                $html.=$this->AlertItem($alerta,$fecha);
            }
        }

        $html.='
              </div>
            </li>';

        return $html;
    }

    private function AlertItem($alert,$date){
        return '<a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">'.$date.'</div>
                    <span class="font-weight-bold">'.$alert.'</span>
                  </div>
                </a>';
    }

    private function MesaggeItem($mensaje,$usuario){
        return '
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">'.$mensaje.'</div>
                    <div class="small text-gray-500">'.$usuario.'</div>
                  </div>
                </a>';
    }

    private function Divisor(){
        return '<div class="topbar-divider d-none d-sm-block"></div>';
    }

    private function TopbarNavbarNavItemUserInformation(){
        return '<!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Egil Ordoñez</span>
                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60" alt="">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Generales
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Configuración
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Lista Actividades
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Salir
                </a>
              </div>
            </li>';
    }



    public function ContentHeader($titulo, $subtitulo){
        return '<!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">'.$titulo.'</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> '.$subtitulo.'</a>
          </div>';
    }

    public function Card($titulo,$monto,$tipo,$icon){
        return '<!-- Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-'.$tipo.' text-uppercase mb-1">'.$titulo.'</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">'.$monto.'</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas '.$icon.' fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>';
    }

    public function CardSlider($titulo,$min,$max,$valor,$etiquetaValor,$tipo,$icon){
        return '<!-- Card Slider -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-'.$tipo.' text-uppercase mb-1">'.$titulo.'</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">'.$etiquetaValor.'</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: '.$valor.'%" aria-valuenow="'.$valor.'" aria-valuemin="'.$min.'" aria-valuemax="'.$max.'"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas '.$icon.' fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>';
    }

    public function AreaChart($id,$title,$datos,$menus=""){
        $etiquetas="[ ";
        $valores="[ ";
        foreach ($datos as $etiqueta=>$valor){
            $etiquetas.='"'.$etiqueta.'",';
            $valores.=$valor.",";
        }
        $etiquetas=trim($etiquetas,",");
        $valores=trim($valores,",");
        $etiquetas.=" ]";
        $valores.=" ]";
        $this->AreaChartScript($id,"Area",$etiquetas,$valores);
        $html= '<!-- Area Chart -->
            <div>
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">'.$title.'</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="'.$id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="'.$id.'">
                      <div class="dropdown-header">Menu:</div>';
        if($menus!=""){
            foreach ($menus as $url=>$menu){
                if($url=="-"){
                    $html.='<div class="dropdown-divider"></div>';
                }
                else{
                    $html.='<a class="dropdown-item" href="'.$url.'">'.$menu.'</a>';
                }

            }
        }

        $html.='    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="'.$id.'AreaChart"></canvas>
                  </div>
                </div>
              </div>
            </div>';
        return $html;
    }

    private function AreaChartScript($id,$titulo,$etiquetas,$valores){
        /** @noinspection JSUnusedAssignment */
        $this->lastScripts.=$this->lastScripts.'
        <script>
            let idAreaChart="'.$id.'AreaChart";
            let titulo="'.$titulo.'";
            let etiquetas='.$etiquetas.';
            let datos='.$valores.';
            ChartArea(titulo,etiquetas,datos);
        </script>
        ';


    }

    public function PieChart($id,$title,$datos,$menus=""){
        $etiquetas="[ ";
        $valores="[ ";
        $colores="[ ";
        $fondos="[ ";
        $htmlEtiquetasFondo="";
        foreach ($datos as $pieChartData){
            $etiquetas.='"'.$pieChartData->Etiqueta.'",';
            $valores.='"'.$pieChartData->Valor.'",';
            $colores.='"'.$pieChartData->Color.'",';
            $fondos.='"'.$pieChartData->Fondo.'",';
            $htmlEtiquetasFondo.=$this->PieChartLabel($pieChartData->Etiqueta,$pieChartData->Color);
        }
        $etiquetas=trim($etiquetas,",");
        $valores=trim($valores,",");
        $colores=trim($colores,",");
        $fondos=trim($fondos,",");
        $etiquetas.=" ]";
        $valores.=" ]";
        $colores.=" ]";
        $fondos.=" ]";
        $this->PieChartScript($id,"Pie",$etiquetas,$valores,$colores,$fondos);

        $html= '<!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">'.$title.'</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Menu:</div>';
        if($menus!=""){
            foreach ($menus as $url=>$menu){
                if($url=="-"){
                    $html.='<div class="dropdown-divider"></div>';
                }
                else{
                    $html.='<a class="dropdown-item" href="'.$url.'">'.$menu.'</a>';
                }
            }
        }
        $html.='      </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="'.$id.'PieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">';
        $html.=$htmlEtiquetasFondo;
        $html.='  </div>
                </div>
              </div>
            </div>
          </div>';
        return $html;
    }

    private function PieChartLabel($label,$color){
        return '
            <span class="mr-2">
              <i class="fas fa-circle" style="color: '.$color.'"></i> '.$label.'
            </span>
        ';

    }

    private function PieChartScript($id,$titulo,$etiquetas,$valores,$colores,$fondos){
        /** @noinspection JSUnusedAssignment */
        $this->lastScripts.=$this->lastScripts.'
        <script>
            let idPieChart="'.$id.'PieChart";
            let tituloPie="'.$titulo.'";
            let etiquetasPie='.$etiquetas.';
            let datosPie='.$valores.';
            let coloresPie='.$colores.';
            let fondosPie='.$fondos.';
            ChartPie(tituloPie,etiquetasPie,datosPie,coloresPie,fondosPie);
        </script>
        ';
    }

    public function ProyectCard(string $htmlContent,$tipo,string $titulo="Proyecto"){
        return '<!-- Project Card -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-'.$tipo.'">'.$titulo.'</h6>
                </div>
                <div class="card-body">
                  '.$htmlContent.'
                </div>
              </div>';
    }

    public function ProyectCardSimpleSlider($titulo,$min,$max,$value,$valueLabel,$tipo){
        return '<h4 class="small font-weight-bold">'.$titulo.' <span class="float-right">'.$valueLabel.'</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-'.$tipo.'" role="progressbar" style="width: '.$value.'%" aria-valuenow="'.$value.'" aria-valuemin="'.$min.'" aria-valuemax="'.$max.'"></div>
                  </div>';
    }

    public function ProyectCardIlustracion($src,$texto){
        return '<div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="'.$src.'" alt="">
                  </div>
                  <p>'.$texto.'</p>';
    }


}