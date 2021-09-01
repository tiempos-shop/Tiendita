<div class="fixed-top" id="menu"
    style="padding-top:2vh;padding-bottom:0;padding-left: 2vw;padding-right: 2vw;background-color: white;">
    <div class="row right">
        <div class="  col-md-2  " >
            <span @click="irAlUrl('shoptienda.php')">{{elemento.shop}} </span>
        </div>
        <div class="  col-md-2  " >
            <span style="padding-left: 5%" >ARCHIVE</span>
        </div>
        <div class="  col-md-2  " >
            <span style="padding-left: 20%" >IMPRINT</span>
        </div>
        <div class=" col-sm-2 col-md-2  " >
            <label style="padding-left: 35%">LOGIN</label>
        </div>
        <div class="  col-md-2  adjust" >
            <label style="padding-left: 35%">ESPAÑOL</label>
        </div>
        <div class="  col-md-2  " >
            <span style="right: 2%;position: absolute" @click="irAlUrl('carttienda.php')">CART({{$cantidadCarrito}})</span>
        </div>
    </div>
    <hr style="margin: 1em -3vw 0px -2vw;opacity: 1;" />
</div>

<script src="js/menuVue.js"></script>