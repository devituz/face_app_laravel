/* Authda Xatoliklar ko'rsatilganda animatsiya qilish */
window.onload = function() {
    let errorAlert = document.getElementById('error-alert');
    if (errorAlert) {
        // Xatolikni ko'rsatish
        errorAlert.classList.add('show');

        // 5 soniyadan so'ng orqaga qaytish
        setTimeout(function() {
            errorAlert.classList.remove('show');
        }, 5000);
    }
}
/* Authda Xatoliklar ko'rsatilganda animatsiya qilish */



// Create Face id Modal uchun
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('imagePreview');
        output.src = reader.result;
        output.style.display = 'block'; // Show the image preview
    };
    reader.readAsDataURL(event.target.files[0]); // Read the image file
}
// Create Face id Modal uchun
