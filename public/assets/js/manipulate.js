// Merubah nama di kanan atas navbar menjadi singkatan
let nama_awal = document.getElementById("nav-name");
// Jika nama_awal tidak null
if (nama_awal !== null) {
    // Jika panjang username lebih dari 15 karakter
    if (nama_awal.textContent.length > 15) {
        manipulateName(nama_awal.textContent);
        // Fungsi untuk memanipulasi nama
        function manipulateName(nama) {
            nama_awal.innerText = nama.slice(0, 15) + '...';
        }
    }
}
