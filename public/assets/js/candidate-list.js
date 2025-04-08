document.addEventListener('DOMContentLoaded', function() {

    // Har bir checkboxni tekshirish
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (checkbox.checked) {
                selectedIds.push(checkbox.getAttribute('data-id'));
            } else {
                selectedIds = selectedIds.filter(id => id !== checkbox.getAttribute('data-id'));
            }

            console.log('Selected IDs: ', selectedIds);
        });
    });

    // Bulk delete tugmasi bosilganda
    deleteBtn.addEventListener('click', function() {
        if (selectedIds.length > 0) {
            // SweetAlert2 bilan tasdiqlash oynasini chiqarish
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to delete the selected candidate list?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete them!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Agar foydalanuvchi "Yes" ni bossa, o'chirishni amalga oshirish
                    fetch(url, {  // URLni dinamik ravishda olish
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({ ids: selectedIds })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // O'chirilganidan keyin sahifani yangilash
                                Swal.fire(
                                    'Deleted!',
                                    'The selected candidate list have been deleted.',
                                    'success'
                                );
                                location.reload();
                            }
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    // Agar foydalanuvchi "No" ni bossa, tasdiqlash oynasi yopiladi
                    Swal.fire(
                        'Cancelled',
                        'No candidate list were deleted.',
                        'info'
                    );
                }
            });
        } else {
            // Agar tanlangan adminlar bo'lmasa
            alert('Please select at least one admin to delete.');
        }
    });
});
