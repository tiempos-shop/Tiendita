<?php

namespace Administracion;

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
        $html='
          <!-- Logout Modal-->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">¿Seguro que quieres abandonar tu sesión?</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">Confirme con el boton \'desconectarme\' para abandonar la sesión.</div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Salir</button>
                  <a class="btn btn-primary" href="login.html">Desconectarme</a>
                </div>
              </div>
            </div>
          </div>    
        ';
        return $html;

    }

    public function Scripts(){
        $html='
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

        return $html;
    }
}