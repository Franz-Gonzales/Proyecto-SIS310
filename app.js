
function cargarContenido(abrir) {
    var contenedor;
    contenedor = document.getElementById("contenido");
    fetch(abrir)
      .then((response) => response.text())
      .then((data) => (contenedor.innerHTML = data));

    //   tipoPeriodo();
  }

var numero_semanas = 0;
function tipoPeriodo(){
    var periodo = document.getElementById('periodo');

    switch(periodo.value){
        case 'semanal':
            var semanas = parseInt(prompt('Introduzca el número de semanas: '));
            if(semanas != null){
                cargarContenido('./Public/Semanal/semanal.php?semanas=' + semanas);
                numero_semanas = semanas;
            }else{
                alert('Introduzca un valor numerico');
            }
            
            break;
        case 'quincenal':
            cargarContenido('./Public/quincenal.php')
            
            break;
        case 'mensual':
            cargarContenido('./Public/Mensual/mensual.php');

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

    fetch("./Public/Mensual/form_datos.php", { method: "POST", body: parametros })
    .then((response) => response.text())
    .then((data) => (contenido.innerHTML = data));
}


function calcularResultado() {
    var contenido = document.getElementById("contenido");
    var formulario = document.getElementById("formulario-datos");
    var parametros = new FormData(formulario);

    fetch("./Public/Mensual/tabla_resultado.php", { method: "POST", body: parametros })
      .then((response) => response.text())
      .then((data) => {
        contenido.innerHTML = data;
        contenido.style.padding = "30px";
        contenido.style.borderRadius = "10px";
        contenido.style.backgroundColor = "rgba(208, 253, 253, 0.349)";
      });
}






















//? PARA PERIODOS SEMANALES

var mesConcluir = 0;
function validarSemanal() {

    var inventarioInicial = document.getElementById('inventarioInicial').value;
    var lote = document.getElementById('lote').value;
    var semanas = document.getElementById('nro_semanas');
    var mes_culminada = document.getElementById('mesCulminada');

    // while (mes_culminada.firstChild) {
    //     mes_culminada.removeChild(mes_culminada.firstChild);
    // }

    inventarioInicial = parseInt(inventarioInicial);
    lote = parseInt(lote);

    if(semanas.innerHTML == '2Semanas' || semanas.innerHTML == '3emanas' || semanas.innerHTML == '4Semanas'){
        
        //para solo un mes de semanas
        var semanaInicio = document.getElementById('semanaInicio').value;
        var semanaFinal = document.getElementById('semanaFinal').value;

        if (lote > inventarioInicial && semanaFinal > semanaInicio && semanaFinal <= 4 && semanaInicio <= 3) {
            llenarDatosSemanal();
        } else {
            alert('No está introduciendo correctamente los valores en el lote o las semanas');
        }
        
    }else{
        //Para varias semanas
        var semanaInicial = document.getElementById('semanaInicio').value;
        // var mesInicio = document.getElementById('mesInicio').value;
        // console.log(mesInicio);
        
        if (lote > inventarioInicial && semanaInicial <= 4) {
            llenarDatosSemanal();
        } else {
            alert('No está introduciendo correctamente los valores en el lote o semana inicial');
        }
        
    }
}




var mes_inicio = 0;
function mostrarMesFinal(){
    var mesInicio = parseInt(document.getElementById('mesInicio').value);
    var semana_inicio = document.getElementById('semanaInicio');


    var meses = { 
        1: "Enero",
        2: "Febrero",
        3: "Marzo",
        4: "Abril",
        5: "Mayo",
        6: "Junio",
        7: "Julio",
        8: "Agosto",
        9: "Septiembre",
        10: "Octubre",
        11: "Noviembre",
        12: "Diciembre"
    }

    var html_options = '';
    for(let i = 1; i <= 4; i++){
        if(i == 1){
            html_options += `<option value="">Seleccione la semana para iniciar del mes ${meses[mesInicio]}:</option>`
        }
        html_options += `<option value="${i}">Semana ${i}</option>`;
    }
    
    semana_inicio.innerHTML = html_options;

    mes_inicio = mesInicio;
}





function mostrarMesAConcluir(){
    var semana_inicio = parseInt(document.getElementById('semanaInicio').value);
    var mes_culminada = document.getElementById('mesCulminada');

    var meses = { 
        1: "Enero",
        2: "Febrero",
        3: "Marzo",
        4: "Abril",
        5: "Mayo",
        6: "Junio",
        7: "Julio",
        8: "Agosto",
        9: "Septiembre",
        10: "Octubre",
        11: "Noviembre",
        12: "Diciembre"
    }

    let mes_req = parseInt(numero_semanas / 4);
    
    //mes_inicio, numero_semanas, semana_inicio
    var mes_concluido = 0;
    let result = 0;
    // var semana_concluido = 0;

    // console.log('mes_req -> ' + mes_req);
    if(numero_semanas % 4 !== 0 && mes_req !== 2){
        if(semana_inicio == 4){
            result = (mes_inicio + semana_inicio) + (mes_req - semana_inicio + 1);
            (numero_semanas == 5) ?  mes_concluido = result - 1: mes_concluido = result;
        }else{
            if(semana_inicio == 3){
                result = (mes_inicio + semana_inicio) + (mes_req - semana_inicio + 1);
                (numero_semanas == 5 || numero_semanas == 6) ?  mes_concluido = result - 1: mes_concluido = result;
            }else{

                mes_concluido = (mes_inicio + semana_inicio) + (mes_req - semana_inicio);
            }
        }
    }else{
        if(semana_inicio == 1 && numero_semanas !== 12){
            result = mes_inicio + (mes_req - semana_inicio);
            (numero_semanas >= 9 && numero_semanas <= 11) ? mes_concluido = result + 1: mes_concluido = result;
        }else{
            if(semana_inicio == 4 && numero_semanas >= 10){
                mes_concluido = (mes_inicio + 1) + (semana_inicio - mes_req);
            }else{
                if(semana_inicio == 3 && numero_semanas >= 10){
                    result = (mes_inicio + 1) + (semana_inicio - mes_req);
                    (numero_semanas == 11)? mes_concluido = result + 1: mes_concluido = result;
                }else{
                    result = (mes_inicio + mes_req - 1) + ((semana_inicio + 1) - semana_inicio);
                    (numero_semanas >= 12)? mes_concluido = result - 1: mes_concluido = result;
                }
            }
        }
    }

    mesConcluir = mes_concluido;

    var mesFinal = document.createElement('p');
    mesFinal.id = 'textMesFinal';
    mesFinal.innerHTML = `La Semanas culminaria hasta el mes de: <strong>${meses[mes_concluido]} </strong>`;

    while (mes_culminada.firstChild) {
        mes_culminada.removeChild(mes_culminada.firstChild);
    }

    mes_culminada.appendChild(mesFinal);
}







function llenarDatosSemanal() {
    var contenido = document.getElementById("contenido");
    var formulario = document.getElementById("form-datos");
    var parametros = new FormData(formulario);

    fetch("./Public/Semanal/form_datos.php?mesConcluir=" + mesConcluir, { method: "POST", body: parametros })
    .then((response) => response.text())
    .then((data) => (contenido.innerHTML = data));
}




function calcularResultadoSemanal() {
    var contenido = document.getElementById("contenido");
    var formulario = document.getElementById("formulario-datos");
    var parametros = new FormData(formulario);

    fetch("./Public/Semanal/tabla_resultado.php", { method: "POST", body: parametros })
      .then((response) => response.text())
      .then((data) => {
        contenido.innerHTML = data;
        contenido.style.padding = "30px";
        contenido.style.borderRadius = "10px";
        contenido.style.backgroundColor = "rgba(208, 253, 253, 0.349)";
      });
}


function calcularResultadoSemanal2() {
    var contenido = document.getElementById("contenido");
    var formulario = document.getElementById("formulario-datos");
    var parametros = new FormData(formulario);

    fetch("./Public/Semanal/tabla_resultado2.php", { method: "POST", body: parametros })
      .then((response) => response.text())
      .then((data) => {
        contenido.innerHTML = data;
        contenido.style.padding = "30px";
        contenido.style.borderRadius = "10px";
        contenido.style.backgroundColor = "rgba(208, 253, 253, 0.349)";
      });
}


function calcularResultadoSemanal3() {
    var contenido = document.getElementById("contenido");
    var formulario = document.getElementById("formulario-datos");
    var parametros = new FormData(formulario);

    fetch("./Public/Semanal/tabla_resultado3.php", { method: "POST", body: parametros })
      .then((response) => response.text())
      .then((data) => {
        contenido.innerHTML = data;
        contenido.style.padding = "30px";
        contenido.style.borderRadius = "10px";
        contenido.style.backgroundColor = "rgba(208, 253, 253, 0.349)";
      });
}