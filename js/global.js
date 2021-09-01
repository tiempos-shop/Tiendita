const ServeApi = "http://127.0.0.1:8000/";

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