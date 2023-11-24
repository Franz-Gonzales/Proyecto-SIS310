
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

            cargarContenido('./Public/semanal.php');
            
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


//? FETCH
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
      .then((data) => (contenido.innerHTML = data));
}




























function mostrarProvinciasCreando() {
    var departamento = document.getElementById("departamento").value;

    fetch("provincias.php?id_departamento=" + departamento)
      .then(response => response.text())
      .then(data => {
        var objeto = JSON.parse(data);
        document.getElementById("provincia").innerHTML = "";

        for (var i = 0; i < objeto.length; i++) {
          const elemento = document.createElement("option");
          elemento.value = objeto[i].id;
          elemento.innerHTML = objeto[i].provincia;
          document.getElementById("provincia").appendChild(elemento);
        }
      });
  }



  function mostrarLibros() {

    var fotografia = document.getElementById("fotografia");
    var option = fotografia.value;

    // console.log(fotografia.innerHTML);
    fetch("./Ejercicio5/datos.php")
        .then(response => response.text())
        .then(data => {

            var objeto = JSON.parse(data);
            var select = `<option value="seleccionar">Seleccionar</option>`;
            // var select = `<option value="seleccionar">Seleccionar</option>`;

            for (var i = 0; i < objeto.length; i++) {
                
                select += `<option value="${objeto[i].imagen}">${objeto[i].titulo}</option>`;
                // let img = document.createElement('img');
                // img.src = objeto[i].titulo;
                // img.with = "200px"
            }
            fotografia.innerHTML = select;
            fotografia.value = option;

        });

}
function mostrarFotoLibros(){

    var imagen = document.getElementById("fotografia").value;
    var fotos_libros = document.getElementById("fotos-libros");
    
    // console.log(imagen.value);
    var img =`<img src="./Ejercicio5/img/${imagen}" alt="${imagen}" width="400">`;

    fotos_libros.innerHTML = img;

    document.getElementById("fotografia").value = imagen;
    // imagen.value = img;

}


















var mes1 = 0;
var mes2 = 0;
var inventario_inicial = 0;
var cantidad_lote = 0;
function generarValores(){
    var mesInicio = document.getElementById('mes1');
    var mesFin = document.getElementById('mes2');
    var inventarioInicial = document.getElementById('inventarioInicial').value;
    var lote = document.getElementById('lote').value;
    // document.getElementById('form-datos').innerHTML = '';

    mes1 = mesInicio.value;
    mes2 = mesFin.value;
    inventario_inicial = inventarioInicial;
    cantidad_lote = lote;

    document.getElementById('tabla-datos').innerHTML = '';
    var container = document.getElementById('container');

    var meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    
    // console.log(mesInicio.innerHTML + mesFin.innerHTML);
    // console.log(mesInicio.value + mesFin.value + inventarioInicial + lote);

    var html = `
        <h1>Ingreso los Pronósticos y Pedidos para los Mesese</h1>
        <table border="1">
            <tr>
                <th></th>`;
                for(let i = mesInicio.value-1; i <= mesFin.value-1; i++){

                    html += `<th>${meses[i]}</th>`;
                }
                html += `
            </tr>
            <tr>
                <td>Pronósticos</td>`;
                for(let i = mesInicio.value-1; i <= mesFin.value-1; i++){

                    html += `<td><input type="number" id="${i}" name="pronosticos" style="width: 65px;"></td>`;
                }
                html += `
            </tr>
            <tr>
                <td>Pedidos</td>`;
                for(let i = mesInicio.value-1; i <= mesFin.value-1; i++){

                    html += `<td><input type="number" id="${i}" name="pedidos" style="width: 65px;"></td>`;
                }
                html += `
            </tr>
        </table>
        <br>
        <a href="#"><button onclick="tablaResultado()">Calcular Plan Maestro</button></a>
    `;

    container.innerHTML = html;
}




function tablaResultado(){

    // console.log(mes1+'  '+mes2+' '+inventario_inicial+' '+cantidad_lote);
    var pronosticos = document.getElementsByName('pronosticos');
    var pedidos = document.getElementsByName('pedidos');

    console.log(pronosticos);


    var container = document.getElementById('container');
    var meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    
    // console.log(mesInicio.innerHTML + mesFin.innerHTML);
    // console.log(mesInicio.value + mesFin.value + inventarioInicial + lote);

    var html = `
        <h1>Resultado Plan Maestro</h1>
        <table border="1">
            <tr>
                <th>Periodo</th>`;
                for(let i = mes1-1; i <= mes2-1; i++){

                    html += `<th>${meses[i]}</th>`;
                }
                html += `
            </tr>
            <tr>
                <td>Inventario Inicial</td>`;
                // var inventario = [inventario_inicial, ]
                for(let i = mes1-1; i <= mes2-1; i++){

                    html += `<td>${inventario_inicial}</td>`;
                }
                html += `
            </tr>
            <tr>
                <td>Pronósticos</td>`;
                for(let i = mes1-1; i <= mes2-1; i++){

                    html += `<td>${i}</td>`;
                }
                html += `
            </tr>
            <tr>
                <td>Pedidos</td>`;
                for(let i = mes1-1; i <= mes2-1; i++){

                    html += `<td>${i}</td>`;
                }
                html += `
            </tr>
            <tr>
                <td>MPS/PMP</td>`;
                for(let i = mes1-1; i <= mes2-1; i++){

                    html += `<td>${i}</td>`;
                }
                html += `
            </tr>
            <tr>
                <td>Inventario Final</td>`;
                for(let i = mes1-1; i <= mes2-1; i++){

                    html += `<td>${i}</td>`;
                }
                html += `
            </tr>
            <tr>
                <td>DPP</td>`;
                for(let i = mes1-1; i <= mes2-1; i++){

                    html += `<td>${i}</td>`;
                }
                html += `
            </tr>
        </table>
        <br>
    `;

    container.innerHTML += html;

}




