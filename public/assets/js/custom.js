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


document.getElementById('close-btn').addEventListener('click', function () {
    window.history.back();
});



document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.avatar').forEach(function(avatar) {
        avatar.addEventListener('click', function() {
            var imageUrl = avatar.getAttribute('data-image');
            document.getElementById('modalImage').src = imageUrl;
        });
    });
});
