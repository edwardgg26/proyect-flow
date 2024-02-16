(   function(){

        obtenerTareas();
        let tareas = [];
        let filtradas = [];
        let usuarioPermitido = false;

        const botonFormulario = document.querySelector(".btnFormulario");
        botonFormulario.addEventListener("click",function(){
            validarCampos(botonFormulario.id);
        });

        const filtros = document.querySelectorAll("#filtros input");
        filtros.forEach(filtro => {
            filtro.addEventListener("input", filtrarTareas);
        });

        let idTareaEditar = null;
        let estadoAEditar = "";

        const tarea = document.querySelector("#tarea");
        tarea.addEventListener("input",(e)=>{
            removerAlerta(tarea);
        });

        const fechaInicio = document.querySelector("#fechaInicio");
        fechaInicio.addEventListener("input",(e)=>{
            removerAlerta(fechaInicio);
        });
        const fechaFin = document.querySelector("#fechaFin");
        fechaFin.addEventListener("input",(e)=>{
            removerAlerta(fechaFin);
        });

        const modalTarea = document.getElementById('modalTarea');
            if (modalTarea) {
                modalTarea.addEventListener('show.bs.modal', event => {
                    // Button that triggered the modal
                    document.querySelector("#contenedorAlertas").innerHTML = "";
                    const button = event.relatedTarget
                    // Extract info from data-bs-* attributes
                    const recipient = button.getAttribute('data-bs-whatever')

                    // Update the modal's content.
                    const modalTitle = modalTarea.querySelector('.modal-title')
                    modalTitle.textContent = recipient;

                    //Crear un nuevo id para el boton
                    const idBoton = recipient.replace(/ /g, "").toLowerCase();

                    const botonFormulario = modalTarea.querySelector(".btnFormulario");
                    botonFormulario.id = idBoton;

                    if(idBoton == "agregartarea"){
                        idTareaEditar = null;
                        tarea.value = "";
                        fechaInicio.value = "";
                        fechaFin.value = "";
                    }else{
                        const idTarea = button.getAttribute('data-tarea-id');
                        const tareaAEditar = tareas.filter(tareaMemoria => tareaMemoria.id == idTarea)[0];
                        tarea.value = tareaAEditar.tarea;
                        fechaInicio.value = tareaAEditar.fechaInicio;
                        fechaFin.value = tareaAEditar.fechaFin;
                        idTareaEditar = idTarea;
                        estadoAEditar = tareaAEditar.estado;
                    }
            })
        }

        function filtrarTareas(e){
            const filtro = e.target.value;

            if(filtro != ""){
                filtradas = tareas.filter(tarea => tarea.estado === filtro);
            }else{
                filtradas = [];
            }

            mostrarTareas();
        }

        function validarCampos(idBotonFormulario){
            let error = false;

            //Validar tarea
            if(!tarea.value.trim()){
                error = true;
                const campo = document.querySelector("#campoTarea");
                crearAlerta("Debe ingresar el nombre de la tarea", true , "danger" ,campo, tarea);
            }

            //Validar fecha de inicio
            if(!fechaInicio.value){
                error = true;
                const campo = document.querySelector("#campoFechaIni");
                crearAlerta("Debe ingresar una fecha de inicio", true, "danger" , campo, fechaInicio);
            }

            //Validar fecha de fin
            if(Date.parse(fechaFin.value) < Date.parse(fechaInicio.value)){
                error = true;
                const campo = document.querySelector("#campoFechaFin");
                crearAlerta("La fecha de finalizacion debe ser mayor o igual a la fecha de inicio.", true, "danger" ,campo, fechaFin);
            }

            if(error === false){
                if(idBotonFormulario == "agregartarea"){
                    agregarTarea();
                }else{
                    const parametros = {
                        id: idTareaEditar,
                        tarea: tarea.value,
                        estado: estadoAEditar,
                        fechaInicio: fechaInicio.value,
                        fechaFin: fechaFin.value
                    };
                    actualizarTarea(parametros);
                }
            }
        }

        async function agregarTarea(){
            const datos = new FormData();
            datos.append("tarea",tarea.value.trim());
            datos.append("fechaInicio",fechaInicio.value.trim());
            datos.append("fechaFin",fechaFin.value.trim());
            datos.append("id_proyecto", getProyecto());

            try {
                const url = "http://localhost:3000/api/tarea";
                const respuesta = await fetch(url, {
                    method: "POST",
                    body: datos
                });
                
                const resultado = await respuesta.json();
                crearAlerta(resultado.mensaje, false , resultado.tipo , document.querySelector("#contenedorAlertas"));
                if(resultado.tipo == "success"){
                    const tareaObj = {
                        id: String(resultado.id),
                        tarea: tarea.value,
                        estado: "0",
                        fechaInicio: fechaInicio.value,
                        fechaFin: fechaFin.value,
                        id_proyecto: resultado.id_proyecto
                    }

                    tareas = [...tareas, tareaObj];
                    tarea.value = "";
                    fechaInicio.value = "";
                    fechaFin.value = "";
                    mostrarTareas();
                }
            } catch (error) {
                crearAlerta(error.message, false , "danger" , document.querySelector("#contenedorAlertas"));
            }
        }

        async function obtenerTareas(){
            try {
                const id = getProyecto();
                const url = `/api/tareas?id=${id}`;
                const respuesta = await fetch(url);
                const resultado = await respuesta.json();
                tareas = resultado.tareas;
                usuarioPermitido = resultado.usuarioPermitido;
                mostrarTareas();
            } catch (error) {
                crearAlerta(error.message, false , "danger" , document.querySelector("#contenedorAlertasVentana"));
            }
        }

        function mostrarTareas(){
            limpiarTareas();
            totalPendientes();
            totalCompletas();
            const arrayTareas = filtradas.length ? filtradas : tareas;

            if(arrayTareas.length !== 0){
                const contenedorTareas = document.querySelector("#listado-tareas");
                const estados = {
                    0: {
                        estilo: "warning",
                        texto: "Pendiente"
                    },
                    1: {
                        estilo: "success",
                        texto: "Completada"
                    }
                }

                arrayTareas.forEach(etarea => {
                    const elementoTarea = document.createElement("LI");
                    elementoTarea.classList.add("list-group-item","d-flex");
                    elementoTarea.dataset.tareaId = etarea.id;

                    const contenedorInformacionTarea = document.createElement("DIV");
                    contenedorInformacionTarea.classList.add("d-flex","w-100", "justify-content-between","align-items-center");

                    const contenedorInfo = document.createElement("DIV");
                    contenedorInfo.innerHTML = `<p class="h5">${etarea.tarea}</p>
                                                <p class="m-0">Fecha de Inicio: ${etarea.fechaInicio}</p>`;

                    if(etarea.fechaFin != "0000-00-00" && etarea.fechaFin != ""){
                        contenedorInfo.innerHTML += `<p class="m-0">Fecha de Fin: ${etarea.fechaFin}</p>`;
                    }

                    const contenedorBotones = document.createElement("DIV");
                    contenedorBotones.classList.add("d-flex","flex-column","gap-1", "d-sm-block");

                    const botonEstado = document.createElement("BUTTON");
                    botonEstado.classList.add("btn", "btn-"+estados[etarea.estado].estilo, "ms-1");
                    botonEstado.textContent = estados[etarea.estado].texto;
                    botonEstado.dataset.estadoTarea = etarea.estado;
                    botonEstado.onclick = function () {
                        cambiarEstadoTarea({...etarea});
                    }
                    if(usuarioPermitido === false) botonEstado.disabled = true;

                    const botonEliminar = document.createElement("BUTTON");
                    botonEliminar.classList.add("btn", "btn-danger", "ms-1");
                    botonEliminar.textContent = "Eliminar";
                    botonEliminar.onclick = function (){
                        eliminarTarea({...etarea});
                    }

                    const botonEditar = document.createElement("BUTTON");
                    botonEditar.classList.add("btn", "btn-primary", "ms-1");
                    botonEditar.textContent = "Editar";
                    botonEditar.dataset.bsToggle = "modal";
                    botonEditar.dataset.bsTarget = "#modalTarea";
                    botonEditar.dataset.bsWhatever = "Editar Tarea";
                    botonEditar.dataset.tareaId = etarea.id;
                    contenedorBotones.appendChild(botonEstado);
                    if(usuarioPermitido === true){
                        contenedorBotones.appendChild(botonEditar);
                        contenedorBotones.appendChild(botonEliminar);
                    }

                    contenedorInformacionTarea.appendChild(contenedorInfo);
                    contenedorInformacionTarea.appendChild(contenedorBotones);

                    elementoTarea.appendChild(contenedorInformacionTarea);
                    contenedorTareas.appendChild(elementoTarea);
                });
            }
        }

        function totalPendientes(){
            const totalPendientes = tareas.filter(tarea => tarea.estado === "0");
            const pendientesRadio = document.querySelector("#pendientes");

            if(totalPendientes.length == 0){
                pendientesRadio.disabled = true;
            }else{
                pendientesRadio.disabled = false;
            }
        }

        function totalCompletas(){
            const totalCompletas = tareas.filter(tarea => tarea.estado === "1");
            const completasRadio = document.querySelector("#completas");

            if(totalCompletas.length == 0){
                completasRadio.disabled = true;
            }else{
                completasRadio.disabled = false;
            }
        }

        async function eliminarTarea(tareaParam){
            const respuestaUsuario = confirm("¿Estas seguro/a de eliminar esta tarea?");
            if(respuestaUsuario){
                const { estado , id, tarea, fechaInicio, fechaFin } = tareaParam;
                const datos = new FormData();
                datos.append("id", id);
                datos.append("tarea", tarea);
                datos.append("estado", estado);
                datos.append("fechaInicio", fechaInicio);
                datos.append("fechaFin", fechaFin);
                datos.append("id_proyecto",getProyecto());

                try {
                    const url = "http://localhost:3000/api/tarea/eliminar";
                    const respuesta = await fetch(url, {
                        body: datos,
                        method: "POST"
                    })
                    const resultado = await respuesta.json();
                    if(resultado.tipo == "success"){
                        tareas = tareas.filter(tareaMemoria => tareaMemoria.id !== tareaParam.id);
                        mostrarTareas();
                    }
                } catch (error) {
                    crearAlerta(error.message, false , "danger" , document.querySelector("#contenedorAlertas"));
                }
            }
        }

        function cambiarEstadoTarea(tarea){
            const nuevoEstado = tarea.estado === "1" ? "0" : "1";
            tarea.estado = nuevoEstado;
            actualizarTarea(tarea);
        }

        async function actualizarTarea(tareaParam){
            const { estado , id, tarea, fechaInicio, fechaFin } = tareaParam;
            const datos = new FormData();
            datos.append("id", id);
            datos.append("tarea", tarea);
            datos.append("estado", estado);
            datos.append("fechaInicio", fechaInicio);
            datos.append("fechaFin", fechaFin);
            datos.append("id_proyecto",getProyecto());

            try {
                const url = "http://localhost:3000/api/tarea/actualizar";
                const respuesta = await fetch(url, {
                    method: "POST",
                    body: datos
                })

                const resultado = await respuesta.json();
                crearAlerta(resultado.mensaje, false , resultado.tipo , document.querySelector("#contenedorAlertas"));
                if(resultado.tipo == "success"){
                    tareas = tareas.map(tareaMemoria => {
                        if(tareaMemoria.id == id){
                            tareaMemoria.estado = estado;
                            tareaMemoria.tarea = tarea;
                            tareaMemoria.fechaInicio = fechaInicio;
                            tareaMemoria.fechaFin = fechaFin;
                        };
                        return tareaMemoria;
                    })
                    mostrarTareas();
                }
            } catch (error) {
                crearAlerta(error.message, false , "danger" , document.querySelector("#contenedorAlertas"));
            }
        }

        function limpiarTareas(){
            const listadoTareas = document.querySelector("#listado-tareas");
            
            while(listadoTareas.firstChild) listadoTareas.removeChild(listadoTareas.firstChild);
        }

        function crearAlerta(mensaje, alertaCampo, tipo , referencia, campo = null){
            if(alertaCampo){
                if(!campo.classList.contains("is-invalid")) campo.classList.add("is-invalid");
                const validarAlerta = document.querySelector("#alerta"+campo.getAttribute("id"));
                
                if(validarAlerta === null){
                    const alerta = document.createElement("DIV");
                    
                    alerta.classList.add("invalid-feedback");
                    alerta.setAttribute("id","alerta"+campo.getAttribute("id"));
                    alerta.innerHTML = mensaje;
                    referencia.appendChild(alerta);
                }
            }else{
                const alertaSinCampo = document.querySelector(".alertaSinCampo");
                if(!alertaSinCampo){
                    const alerta = document.createElement("DIV");
                    alerta.classList.add("alert","alert-"+tipo ,"alert-dismissible", "fade" , "show", "alertaSinCampo");
                    alerta.setAttribute("role","alert");
                    alerta.setAttribute("tabindex","-1");
                    alerta.textContent = mensaje;
                    
                    const botonCerrar = document.createElement("BUTTON");
                    botonCerrar.setAttribute("type","button");
                    botonCerrar.classList.add("btn-close");
                    botonCerrar.dataset.bsDismiss = "alert";
                    botonCerrar.ariaLabel = "Close";

                    alerta.appendChild(botonCerrar);
                    referencia.appendChild(alerta);
                };
            }
        }

        function removerAlerta(campo){
            campo.classList.remove("is-invalid");
            const alerta = document.querySelector("#alerta"+campo.getAttribute("id"));
            if(alerta !== null) alerta.remove();
        }

        function getProyecto(){
            const proyectoUrl = Object.fromEntries(new URLSearchParams(window.location.search)).id;
            return proyectoUrl;
        }
    }
)();