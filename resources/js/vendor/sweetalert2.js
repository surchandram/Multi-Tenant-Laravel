// import SweetAlert2
import Swal from 'sweetalert2';

window.Swal = Swal

/* Swal with Bootstrap Buttons Mixin */
const swalWithBootstrapButtons = window.swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-primary mx-1',
        cancelButton: 'btn btn-danger mx-1'
    },
    buttonsStyling: false
});

/* Swal Toast */
const Toast = window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000
});

/* Swal Timer */
const FlashMessage = window.FlashMessage = Swal.mixin({
    showConfirmButton: false,
    timer: 5000,
    animation: false
});

/* Swal Custom Confirm Options */
const swalCustomConfirmOptions = window.swalCustomConfirmOptions = {
    showCancelButton: true,
    confirmButtonText: 'Yes!',
    cancelButtonText: 'No, cancel!',
    reverseButtons: true
};
