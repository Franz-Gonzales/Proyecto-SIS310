
function cargarContenido(abrir) {
    var contenedor;
    contenedor = document.getElementById("contenido");
    fetch(abrir)
      .then((response) => response.text())
      .then((data) => (contenedor.innerHTML = data));

    //   tipoPeriodo();
  }


function tipoPeriodo(){
    var periodo = document.getElementById('periodo');

    switch(periodo.value){
        case 'semanal':
            var semanas = parseInt(prompt('Introduzca el número de semanas: '));
            if(semanas != null){
                cargarContenido('./Public/semanal.php?semanas=' + semanas);
            }else{
                alert('Introduzca un valor numerico');
            }
            
            break;
        case 'quincenal':
            cargarContenido('./Public/quincenal.php')
            
            break;
        case 'mensual':
            cargarContenido('./Public/mensual.php');

            break;
        case 'trimestral':
            cargarContenido('./Public/trimestral.php');
            
            break;
        case 'semestral':
            cargarContenido('./Public/semestral.php');

            break;
        case 'anual':
            cargarContenido('./Public/anual.php');

            break;
        default:
            break;
    }
}



//? PARA PERIODOS MENSUALES
function validar() {

    var inventarioInicial = document.getElementById('inventarioInicial').value;
    var lote = document.getElementById('lote').value;

    inventarioInicial = parseInt(inventarioInicial);
    lote = parseInt(lote);

    if (lote > inventarioInicial) {
        llenarDatos();
    } else {
        alert("El lote debe ser mayor al inventario Inicial");
    }
}


function llenarDatos() {
    var contenido = document.getElementById("contenido");
    var formulario = document.getElementById("form-datos");
    var parametros = new FormData(formulario);

    fetch("./Public/form_datos.php", { method: "POST", body: parametros })
    .then((response) => response.text())
    .then((data) => (contenido.innerHTML = data));
}



function calcularResultado() {
    var contenido = document.getElementById("contenido");
    var formulario = document.getElementById("formulario-datos");
    var parametros = new FormData(formulario);

    fetch("./Public/tabla_resultado.php", { method: "POST", body: parametros })
      .then((response) => response.text())
      .then((data) => {
        contenido.innerHTML = data;
        contenido.style.padding = "30px";
        contenido.style.borderRadius = "10px";
        contenido.style.backgroundColor = "rgba(208, 253, 253, 0.349)";
      });
}



//? PARA PERIODOS SEMANALES

// function validarSemanas() {
//     // var semanas = document.getElementById('semanas').value;
//     var inventarioInicial = document.getElementById('inventarioInicial').value;
//     var lote = document.getElementById('lote').value;

//     inventarioInicial = parseInt(inventarioInicial);
//     lote = parseInt(lote);

//     if (lote > inventarioInicial) {
//         llenarDatos();
//     } else {
//         alert("El lote debe ser mayor al inventario Inicial");
//     }
// }


// function obtenerSemanas() {
//     var contenido = document.getElementById("contenido");
//     var formulario = document.getElementById("form-datos");
//     var parametros = new FormData(formulario);

//     fetch("./Public/form_datos.php", { method: "POST", body: parametros })
//     .then((response) => response.text())
//     .then((data) => (contenido.innerHTML = data));
// }