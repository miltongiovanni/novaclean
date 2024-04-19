import Swal from 'sweetalert2';


let deletePersonal = document.getElementById("delete-personal");
if (deletePersonal !== null) {
    deletePersonal.addEventListener("click", (e) => {
        Swal.fire({
            title: 'Confirmación',
            text: "¿Está seguro de borrar el personal?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000066',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deletePersonalForm').submit();
                Swal.fire(
                    'Borrado!',
                    'Personal borrado.',
                    'success'
                )
            }
        })
    })

}
