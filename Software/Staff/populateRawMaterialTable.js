// Function to fetch data and populate the table
function populateRawMaterialTable() {
    // Fetch raw material data from the server
    fetch('fetch_raw_material.php')
        .then(response => response.json())
        .then(data => {
            // Clear the existing table rows
            const tableBody = document.querySelector('.product-table tbody');
            tableBody.innerHTML = '';

            // Populate the table with the fetched data
            data.forEach(row => {
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td><img src="${row.image}" alt="Product Image"></td>
                    <td>${row.raw_material_name}</td>
                    <td>${row.stock}</td>
                    <td>${row.description}</td>
                    <td>${row.created_at}</td>
                    <td>${row.updated_at}</td>
                    <td>
                        <button class="edit-btn" data-id="${row.id}"><i class="fas fa-edit"></i>Edit</button>
                        <button class="delete-btn" data-id="${row.id}"><i class="fas fa-trash-alt"></i>Delete</button>
                    </td>
                `;
                tableBody.appendChild(newRow);
            });

            // Add event listeners for edit and delete buttons
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', handleEditButtonClick);
            });

            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', handleDeleteButtonClick);
            });
        })
        .catch(error => {
            console.error('Error fetching raw material data:', error);
        });
}

// Function to handle edit button click
function handleEditButtonClick(event) {
    const row = event.target.closest('tr');
    const rawMaterialId = row.dataset.id; // Assuming you have a data-id attribute on the <tr> containing the raw material id

    // Redirect to the edit page with the raw material id
    window.location.href = `edit_raw_material.php?id=${rawMaterialId}`;
}

// Function to handle delete button click
function handleDeleteButtonClick(event) {
    const row = event.target.closest('tr');
    const rawMaterialId = row.dataset.id; // Assuming you have a data-id attribute on the <tr> containing the raw material id

    // Confirm deletion
    if (confirm('Are you sure you want to delete this raw material?')) {
        // Send an AJAX request to delete the raw material
        fetch(`delete_raw_material.php?id=${rawMaterialId}`, { method: 'DELETE' })
            .then(response => {
                if (response.ok) {
                    // Remove the row from the table
                    row.remove();
                } else {
                    console.error('Failed to delete raw material:', response.statusText);
                }
            })
            .catch(error => {
                console.error('Error deleting raw material:', error);
            });
    }
}

// Add event listeners for edit and delete buttons
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', handleEditButtonClick);
});

document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', handleDeleteButtonClick);
});


// Populate the table when the page loads
document.addEventListener('DOMContentLoaded', populateRawMaterialTable);
