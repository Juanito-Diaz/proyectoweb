function llamarClientes() {
    console.log("Cargando clientes...");
    
    // Feedback visual en el menú
    $(".nav-link").removeClass("active");
    if(event) $(event.currentTarget).addClass("active");

    $("#cuerpo").fadeOut(200, function() {
        $.ajax({
            url: "clientes.php",
            type: "GET",
            success: function(data) {
                $("#cuerpo").html(data).fadeIn(300);
                console.log("Clientes cargados con éxito");
            },
            error: function() {
                $("#cuerpo").html("<div class='alert alert-danger'>Error al conectar con el servidor.</div>").fadeIn(300);
            }
        });
    });
}

function guardarNuevoCliente() {
    var datos = $("#formCliente").serialize();
    $.ajax({
        url: "guardar_cliente.php",
        type: "POST",
        data: datos,
        success: function(response) {
            bootstrap.Modal.getInstance(document.getElementById('modalNuevoCliente')).hide();
            llamarClientes();
            mostrarNotificacion("Cliente guardado correctamente", "success");
        }
    });
}

function eliminarCliente(id) {
    const modal = new bootstrap.Modal(document.getElementById('modalConfirmarEliminacion'));
    const btnConfirmar = document.getElementById('btnConfirmarBorrado');
    
    btnConfirmar.onclick = function() {
        $.ajax({
            url: "eliminar_cliente.php",
            type: "POST",
            data: { id: id },
            success: function() {
                modal.hide();
                llamarClientes();
                mostrarNotificacion("Cliente eliminado", "warning");
            }
        });
    };
    modal.show();
}

function cargarDatosClienteE(id, nombre, ap_paterno, ap_materno, rfc) {
    $("#upd_cliente_id").val(id);
    $("#upd_cliente_nombre").val(nombre);
    $("#upd_cliente_ap_paterno").val(ap_paterno);
    $("#upd_cliente_ap_materno").val(ap_materno);
    $("#upd_cliente_rfc").val(rfc);
}

function guardarActualizacionCliente() {
    var datos = $("#formActualizarCliente").serialize();
    $.ajax({
        url: "actualizar_cliente.php",
        type: "POST",
        data: datos,
        success: function() {
            bootstrap.Modal.getInstance(document.getElementById('modalActualizarCliente')).hide();
            llamarClientes();
            mostrarNotificacion("Datos actualizados", "success");
        }
    });
}

// PRODUCTOS
function llamarProducto() { 
    $(".nav-link").removeClass("active");
    if(event) $(event.currentTarget).addClass("active");

    $("#cuerpo").fadeOut(200, function() {
        $.ajax({
            url: "productos.php",
            type: "GET",
            success: function(data) {
                $("#cuerpo").html(data).fadeIn(300);
            }
        });
    });
}

function guardarNuevoProducto() {
    var datos = $("#formProducto").serialize();
    $.ajax({
        url: "guardar_producto.php",
        type: "POST",
        data: datos,
        success: function() {
            bootstrap.Modal.getInstance(document.getElementById('modalNuevoProducto')).hide();
            llamarProducto();
            mostrarNotificacion("Producto registrado", "success");
        }
    });
}

function eliminarProducto(id) {
    const modal = new bootstrap.Modal(document.getElementById('modalConfirmarEliminacion'));
    const btnConfirmar = document.getElementById('btnConfirmarBorrado');
    
    btnConfirmar.onclick = function() {
        $.ajax({
            url: "eliminar_producto.php",
            type: "POST",
            data: { id: id },
            success: function() {
                modal.hide();
                llamarProducto();
                mostrarNotificacion("Producto eliminado", "warning");
            }
        });
    };
    modal.show();
}

function cargarDatosProductoE(id, nombre, categoria, cantidad, precio) {
    $("#upd_producto_id").val(id);
    $("#upd_producto_nombre").val(nombre);
    $("#upd_producto_categoria").val(categoria);
    $("#upd_producto_cantidad").val(cantidad);
    $("#upd_producto_precio").val(precio);
}

function guardarActualizacionProducto() {
    var datos = $("#formActualizarProducto").serialize();
    $.ajax({
        url: "actualizar_producto.php",
        type: "POST",
        data: datos,
        success: function() {
            bootstrap.Modal.getInstance(document.getElementById('modalActualizarProducto')).hide();
            llamarProducto();
            mostrarNotificacion("Producto actualizado", "success");
        }
    });
}

// DOCUMENTOS
function llamarDocumentos() {
    $(".nav-link").removeClass("active");
    if(event) $(event.currentTarget).addClass("active");

    $("#cuerpo").fadeOut(200, function() {
        $.ajax({
            url: "documentos.php",
            type: "GET",
            success: function(data) {
                $("#cuerpo").html(data).fadeIn(300);
            }
        });
    });
}

function subirDocumento() {
    var formData = new FormData($('#formDocumento')[0]);
    $.ajax({
        url: "procesar_documento.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.status === 'success') {
                mostrarNotificacion("Archivo subido", "success");
                llamarDocumentos();
            } else {
                mostrarNotificacion(response.message, "danger");
            }
        }
    });
}

function eliminarDocumento(id) {
    const modal = new bootstrap.Modal(document.getElementById('modalConfirmarEliminacion'));
    const btnConfirmar = document.getElementById('btnConfirmarBorrado');
    
    btnConfirmar.onclick = function() {
        $.ajax({
            url: "eliminar_documento.php",
            type: "POST",
            data: { id: id },
            success: function() {
                modal.hide();
                llamarDocumentos();
                mostrarNotificacion("Archivo eliminado", "warning");
            }
        });
    };
    modal.show();
}

function mostrarNotificacion(mensaje, tipo = 'success') {
    const toastEl = document.getElementById('liveToast');
    const toastBody = document.getElementById('toastMessage');
    toastEl.className = `toast align-items-center border-0 text-white bg-${tipo}`;
    toastBody.textContent = mensaje;
    new bootstrap.Toast(toastEl).show();
}

function descargarReporte(tipo) {
    console.log("Generando reporte de " + tipo + "...");
    window.location.href = "descargar_reporte.php?tipo=" + tipo;
}