<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Data Produk</h1>
    <button id="addProductButton">Tambah Produk</button>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Aksi</th> <!-- Kolom Aksi -->
            </tr>
        </thead>
        <tbody id="produk-list">
            <!-- Data produk akan dimasukkan ke sini -->
        </tbody>
    </table>

    <!-- Modal untuk Tambah Produk -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" id="addClose">&times;</span>
            <h2>Tambah Produk</h2>
            <form id="addForm">
                <label for="addName">Nama Produk:</label><br>
                <input type="text" id="addName" required><br><br>
                <label for="addPrice">Harga:</label><br>
                <input type="number" id="addPrice" required><br><br>
                <input type="submit" value="Tambah Produk">
            </form>
        </div>
    </div>

    <!-- Modal untuk View Produk -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close" id="viewClose">&times;</span>
            <h2>Detail Produk</h2>
            <!-- <p><strong>ID: </strong><span id="viewId"></span></p> -->
            <p><strong>Nama: </strong><span id="viewName"></span></p>
            <p><strong>Harga: </strong><span id="viewPrice"></span></p>
        </div>
    </div>

    <!-- Modal untuk Edit Produk -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" id="editClose">&times;</span>
            <h2>Edit Produk</h2>
            <form id="editForm">
                <input type="hidden" id="editId">
                <label for="editName">Nama Produk:</label><br>
                <input type="text" id="editName" required><br><br>
                <label for="editPrice">Harga:</label><br>
                <input type="number" id="editPrice" required><br><br>
                <input type="submit" value="Simpan Perubahan">
            </form>
        </div>
    </div>

    <!-- Modal untuk Konfirmasi Delete Produk -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" id="deleteClose">&times;</span>
            <h2>Hapus Produk</h2>
            <p>Apakah Anda yakin ingin menghapus produk ini?</p>
            <button id="confirmDelete">Hapus</button>
            <button id="cancelDelete">Batal</button>
        </div>
    </div>

    <script>
        // Fungsi untuk mengambil data dari API dan menampilkan di tabel
        document.addEventListener('DOMContentLoaded', function() {
            fetch('http://localhost/belajar-api/api_produk.php') // Ganti dengan API yang sesuai
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('produk-list');
                    tbody.innerHTML = '';
                    var i = 1;
                    data.forEach(product => {

                        const tr = document.createElement('tr');

                        // Membuat dan menambahkan sel untuk Nomor
                        const tdNo = document.createElement('td');
                        tdNo.textContent = i++;
                        tr.appendChild(tdNo);

                        const tdName = document.createElement('td');
                        tdName.textContent = product.nama;
                        tr.appendChild(tdName);

                        const tdPrice = document.createElement('td');
                        tdPrice.textContent = product.harga;
                        tr.appendChild(tdPrice);

                        // Kolom aksi
                        const tdAction = document.createElement('td');

                        // View Button
                        const viewButton = document.createElement('button');
                        viewButton.textContent = 'View';
                        viewButton.onclick = function() {
                            showViewModal(product);
                        };
                        tdAction.appendChild(viewButton);

                        // Edit Button
                        const editButton = document.createElement('button');
                        editButton.textContent = 'Edit';
                        editButton.onclick = function() {
                            showEditModal(product);
                        };
                        tdAction.appendChild(editButton);

                        // Delete Button
                        const deleteButton = document.createElement('button');
                        deleteButton.textContent = 'Delete';
                        deleteButton.onclick = function() {
                            showDeleteModal(product.id);
                        };
                        tdAction.appendChild(deleteButton);

                        tr.appendChild(tdAction);
                        tbody.appendChild(tr);
                    });
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
                });
        });

        // Modal View
        const viewModal = document.getElementById('viewModal');
        const viewClose = document.getElementById('viewClose');

        function showViewModal(product) {
            // document.getElementById('viewId').textContent = product.id;
            document.getElementById('viewName').textContent = product.nama;
            document.getElementById('viewPrice').textContent = product.harga;
            viewModal.style.display = 'block';
        }

        viewClose.onclick = function() {
            viewModal.style.display = 'none';
        };

        // Modal Edit
        const editModal = document.getElementById('editModal');
        const editClose = document.getElementById('editClose');

        function showEditModal(product) {
            document.getElementById('editId').value = product.id;
            document.getElementById('editName').value = product.nama;
            document.getElementById('editPrice').value = product.harga;
            editModal.style.display = 'block';
        }

        editClose.onclick = function() {
            editModal.style.display = 'none';
        };

        document.getElementById('editForm').onsubmit = function(event) {
            event.preventDefault();
            const id = document.getElementById('editId').value;
            const name = document.getElementById('editName').value;
            const price = document.getElementById('editPrice').value;

            // Kirim data untuk update produk ke API
            // Misalnya menggunakan fetch PUT
            fetch(`http://localhost/belajar-api/api_produk.php`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: id,
                        nama: name,
                        harga: price
                    })
                })
                .then(response => response.json())
                .then(updatedProduct => {
                    alert('Produk berhasil diperbarui!');
                    editModal.style.display = 'none';
                    location.reload(); // Reload halaman untuk menampilkan data yang baru
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
                });
        };

        // Modal Delete
        const deleteModal = document.getElementById('deleteModal');
        const deleteClose = document.getElementById('deleteClose');
        const confirmDelete = document.getElementById('confirmDelete');
        const cancelDelete = document.getElementById('cancelDelete');
        let productToDelete = null;

        function showDeleteModal(productId) {
            productToDelete = productId;
            deleteModal.style.display = 'block';
        }

        deleteClose.onclick = function() {
            deleteModal.style.display = 'none';
        };

        cancelDelete.onclick = function() {
            deleteModal.style.display = 'none';
        };

        confirmDelete.onclick = function() {
            fetch(`http://localhost/belajar-api/api_produk.php`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: productToDelete
                    })
                })
                .then(response => response.json())
                .then(() => {
                    alert('Produk berhasil dihapus!');
                    deleteModal.style.display = 'none';
                    location.reload(); // Reload halaman untuk memperbarui daftar produk
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
                });
        };

        // Modal Add Product
        const addModal = document.getElementById('addModal');
        const addClose = document.getElementById('addClose');

        // Menampilkan modal untuk menambah produk
        document.getElementById('addProductButton').onclick = function() {
            addModal.style.display = 'block';
        };

        addClose.onclick = function() {
            addModal.style.display = 'none';
        };

        // Menyimpan produk baru
        document.getElementById('addForm').onsubmit = function(event) {
            event.preventDefault();
            const name = document.getElementById('addName').value;
            const price = document.getElementById('addPrice').value;

            // Kirim data untuk tambah produk ke API
            fetch('http://localhost/belajar-api/api_produk.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        nama: name,
                        harga: price
                    })
                })
                .then(response => response.json())
                .then(newProduct => {
                    alert('Produk berhasil ditambahkan!');
                    addModal.style.display = 'none';
                    location.reload(); // Reload halaman untuk menampilkan produk baru
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
                });
        };
    </script>
</body>

</html>