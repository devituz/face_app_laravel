<x-filament::page xmlns:x-filament="http://www.w3.org/1999/html">
    <div class="overflow-hidden bg-white shadow sm:rounded-lg max-w-full ml-0 p-4">
        <div class="flex items-center px-6 py-3 text-left text-sm font-medium text-gray-500">
            <!-- Delete Button with Counter -->
            <x-filament::icon-button
                icon="heroicon-m-trash"
                id="deleteButton"
                onclick="showDeleteConfirmationModal()"
                class="hidden"
            />
            <span id="selectedCount" class="ml-4 hidden text-gray-500">0 selected</span>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <!-- Table Header -->
            <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                    <x-filament::input.checkbox id="select-all" onclick="toggleSelectAll()" class="rounded-md"/>
                </th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">ID</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Name</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Phone</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Email</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Image</th>
            </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($admins as $admin)
                <tr>
                    <!-- Checkbox for Each Row -->
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                        <x-filament::input.checkbox class="admin-checkbox" data-id="{{ $admin->id }}" onchange="toggleDeleteIcon()" />
                    </td>

                    <!-- Admin Data -->
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $admin->id }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $admin->name }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $admin->phone }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $admin->email }}</td>

                    <!-- Admin Image -->
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                        <img src="{{ asset('storage/' . $admin->image) }}" alt="Admin Image" class="w-10 h-10 rounded-full border border-gray-200">
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmationModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-gray-200 p-6 rounded-md shadow-lg text-center max-w-sm w-full transform scale-95 transition-transform duration-300">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Confirm Delete</h2>
            <p class="text-gray-700">Are you sure you want to delete the selected admins?</p>
            <div class="mt-6 flex justify-center space-x-4">
                <button onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded-md">Yes</button>
                <button onclick="closeDeleteConfirmationModal()" class="px-4 py-2 bg-gray-300 rounded-md">No</button>
            </div>
        </div>
    </div>
    <!-- JavaScript for Select All, Delete Button Visibility, and Counter -->
    <script>
        const djangoUrl = 'http://172.24.25.141:5000/api/user_delete/';
        let selectedIds = [];

        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.admin-checkbox');
            checkboxes.forEach((checkbox) => {
                checkbox.checked = selectAllCheckbox.checked;
            });

            toggleDeleteIcon();
        }

        function toggleDeleteIcon() {
            const checkboxes = document.querySelectorAll('.admin-checkbox');
            const deleteButton = document.getElementById('deleteButton');
            const selectedCountElement = document.getElementById('selectedCount');

            selectedIds = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.getAttribute('data-id'));

            const selectedCount = selectedIds.length;

            if (selectedCount > 0) {
                deleteButton.classList.remove('hidden');
                selectedCountElement.classList.remove('hidden');
                selectedCountElement.textContent = `${selectedCount} selected`;
            } else {
                deleteButton.classList.add('hidden');
                selectedCountElement.classList.add('hidden');
                selectedCountElement.textContent = "0 selected";
            }
        }

        function showDeleteConfirmationModal() {
            if (selectedIds.length > 0) {
                const modal = document.getElementById('deleteConfirmationModal');
                modal.classList.remove('hidden');
                modal.classList.add('opacity-100', 'scale-100');
            }
        }

        function closeDeleteConfirmationModal() {
            const modal = document.getElementById('deleteConfirmationModal');
            modal.classList.add('opacity-0', 'scale-95');
            setTimeout(() => modal.classList.add('hidden'), 300); // Hide after the animation
        }

        function confirmDelete() {
            sendDeleteRequest(selectedIds);
            closeDeleteConfirmationModal();
        }

        function sendDeleteRequest(ids) {
            fetch(djangoUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ scan_ids: ids }),
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Response:', data);
                    // Optionally refresh the page or update the UI after deletion
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>

</x-filament::page>
