import 'select2/dist/js/select2.full.min';
import 'select2/dist/css/select2.min.css';
import 'select2/dist/js/i18n/es';

$(document).ready(function () {
    $('.select2-personal').select2(
        {
            placeholder: 'Seleccione un empleado',
            allowClear: true,
            dropdownParent: $('#personalContratoModal'),
            ajax: {
                url: '/buscar-personal',
                type: 'post',
                lenguage: 'es',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term, // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true,
                minimumInputLength: 1,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            }
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