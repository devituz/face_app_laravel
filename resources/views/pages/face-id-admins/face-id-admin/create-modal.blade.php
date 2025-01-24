<div class="modal fade" id="modalMembers" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Add a new admin</h5>

            </div>
            <div class="modal-body bg-white">
                <!-- Form contents here -->
                <div class="row">
                    <!-- Full name input -->
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Full name">
                    </div>
                    <!-- Username input -->
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Enter Username">
                    </div>
                    <!-- Phone Number input -->
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" placeholder="Enter Phone Number">
                    </div>
                    <!-- Image Upload -->
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" id="image" accept="image/*" onchange="previewImage(event)">
                        <div class="mt-3">
                            <img id="imagePreview" src="#" alt="Image preview" style="display: none; width: 100%; max-height: 200px; object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
