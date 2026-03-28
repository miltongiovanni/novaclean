import select2 from 'select2';
import 'select2/dist/css/select2.min.css';
select2();
let select2_es = {
    errorLoading: function() {
        return "No se pudieron cargar los resultados"
    },
    inputTooLong: function(e) {
        var n = e.input.length - e.maximum
            , r = "Por favor, elimine " + n + " car";
        return r += 1 == n ? "ácter" : "acteres"
    },
    inputTooShort: function(e) {
        var n = e.minimum - e.input.length
            , r = "Por favor, introduzca " + n + " car";
        return r += 1 == n ? "ácter" : "acteres"
    },
    loadingMore: function() {
        return "Cargando más resultados…"
    },
    maximumSelected: function(e) {
        var n = "Sólo puede seleccionar " + e.maximum + " elemento";
        return 1 != e.maximum && (n += "s"),
            n
    },
    noResults: function() {
        return "No se encontraron resultados"
    },
    searching: function() {
        return "Buscando…"
    }
};

$(document).ready(function () {
    $('#cliente_id').select2(
        {
            placeholder: 'Seleccione un cliente',
            allowClear: true,
        }
    );
    $('#supervisor_id').select2(
        {
            placeholder: 'Escoja el/la supervisor(a)',
            allowClear: true,
        }
    );
});
$(document).on('click', '#agregar_personal', function () {
    $('#titleModalPersonalContrato').html('Agregar personal');
});

$(document).on('click', '#editar_personal_contrato', function () {
    $('#titleModalPersonalContrato').html('Editar personal');
    $('#search_personal').parent().parent().addClass('d-none');
    $('#personal_name').val($(this).data('nombreCompleto'));
    $('#tipo_nomina').val($(this).data('tipoNominaId'))
    $('#fecha_ingreso').val($(this).data('fechaIngreso'));
    $('#personal_id_edit').val($(this).data('id')).parent().parent().removeClass('d-none');
    $('#salario_basico').val($(this).data('salario'));
    $('#bono').val($(this).data('bono'));
});