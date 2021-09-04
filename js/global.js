var ServeApi = "http://127.0.0.1:8000/";

var nombreServidor = location.href;
var esProduction = nombreServidor.toString().indexOf("localhost");

console.log("server",nombreServidor);
console.log("es production", esProduction);

if (String().indexOf("localhost")==0)
{
  ServeApi = "http://softquimia.com/adminshop/public/";
}

var idMoneda = 1;
var siglasMoneda = "MXN";
var totalEnCarrito = 1;
var idCliente = 1;


const cantidadCarrito = Vue.observable({ cantidadCarrito: {} })


Object.defineProperty(Vue.prototype, '$cantidadCarrito', {
  get () {
    return cantidadCarrito.cantidadCarrito
  },
  
  set (value) {
    cantidadCarrito.cantidadCarrito = value
  }
})

cantidadCarrito.cantidadCarrito = 0;