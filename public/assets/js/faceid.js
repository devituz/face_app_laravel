
// Create Face id Modal
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('imagePreview');
        output.src = reader.result;
        output.style.display = 'block'; // Show the image preview
    };
    reader.readAsDataURL(event.target.files[0]); // Read the image file
}
// Create Face id Modal







