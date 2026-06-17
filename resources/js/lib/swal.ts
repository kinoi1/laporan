import Swal from 'sweetalert2';

export const confirmDelete = () => {
    return Swal.fire({
        title: 'Hapus Data?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
    });
};

export const successAlert = (message) => {
    return Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: message,
        timer: 1500,
        showConfirmButton: false,
    });
};

export const errorAlert = (message) => {
    return Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: message,
    });
};