<?php

namespace Administracion;

use mysql_xdevapi\Exception;

class VistasMenu
{


    public function __construct()
    {
    }

    public function Wrapper(){
        $html=$this->ScrollToTopButton();
        $html.=$this->LogOutModal();
        $html.=$this->Scripts();
        return $html;
    }

    public function ScrollToTopButton(){
        $html='
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
        ';

        return $html;
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
        $html='
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
        return $html;
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
         $html=$this->SideBarBrand($titulo,$url);
         $html.=$this->Divider();
         $html.=$this->NavItemDashboard();
         $html.=$this->Divider();
         $html.=$this->Heading("Administración");

         $elementos=["buttons.html"=>"Altas" , "cards.html"=>"Modificación", ""=>"Datos VIP",];
         $html.=$this->NavItemCollapse("id1","Clientes","Gestion Clientes",$elementos);

        $elementos=["buttons.html"=>"Altas" ,""=>"Bajas", "cards.html"=>"Cambios"];
        $html.=$this->NavItemCollapse("id2","Usuarios","Gestion Usuarios",$elementos);

        $elementos=["utilities-color.html"=>"Captura Individual" , "utilities-border.html"=>"Captura Masiva", "utilities-animation.html"=>"Circulacion de Inventario"];
        $html.=$this->NavItemCollapse("id3","Inventarios","Inventarios",$elementos);

        $elementos=["utilities-color.html"=>"Reporte Financiero" , "utilities-border.html"=>"Reporte de Pedidos", "utilities-animation.html"=>"Reporte de Devoluciones"];
        $html.=$this->NavItemCollapse("id4","Reportes","Reportes",$elementos);

        $html.=$this->Divider();
        $html.=$this->Heading("Configuración");

        $html.=$this->NavItem("Aplicacion","AplConf.php","fas fa-fw fa-chart-area");
        $html.=$this->NavItem("Tablas","tables.html","fas fa-fw fa-table");




         return $html;
    }

    public function SideBarBrand($titulo,$url,$icon="fas fa-shopping-basket"){
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

    public function Divider(){
        return '
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            ';

    }

    public function NavItemDashboard(){
        $titulo="Panel Control";
        $url="administracion.php";
        $icon="fas fa-fw fa-tachometer-alt";
        return $this->NavItem($titulo,$url,$icon);

    }

    public function NavItem($titulo,$url,$icon){
        return '
            <!-- Nav Item - Dashboard -->
              <li class="nav-item active">
                <a class="nav-link" href="'.$url.'">
                  <i class="'.$icon.'"></i>
                  <span>'.$titulo.'</span></a>
              </li>
        ';
    }

    public function Heading($titulo){
        return '<!-- Heading -->
      <div class="sidebar-heading">
        '.$titulo.'
      </div>';
    }

    public function NavItemCollapse($id,$titulo,$subtitulo,$items){
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




}