@extends('layouts.template')

@section('pageTitle')
User Listing
@endsection

@section('rightTitle')
User Listing
@endsection

@section('headerBlock')
<link rel="stylesheet" href="{{ URL::asset('css/product.css') }}">

<style>
/* ========================= */
/* Success Popup */
/* ========================= */
.success-popup {
  position: fixed;
  top: 20px;
  right: 20px;
  background: #2b2b3c;
  color: #f1f1f1;
  border: 1px solid #3f3fff;
  padding: 12px 18px;
  border-radius: 8px;
  font-family: 'Inter', sans-serif;
  font-size: 14px;
  z-index: 1000;
  opacity: 0;
  transform: translateY(-10px);
  transition: opacity 0.4s ease, transform 0.4s ease;
}

.success-popup.show {
  opacity: 1;
  transform: translateY(0);
}

/* Button styling for edit/delete */
.btn-edit {
  background-color: #6c63ff;
  color: white;
  padding: 6px 12px;
  border-radius: 5px;
  font-weight: 600;
  transition: background-color 0.3s ease;
  font-size: 14px;
  margin-right: 6px;
  cursor: pointer;
  border: none;
}

.btn-edit:hover {
  background-color: #3f3fff;
  color: #fff;
}

.btn-delete {
  background-color: #ff4e50;
  color: white;
  padding: 6px 12px;
  border: none;
  border-radius: 5px;
  font-weight: 600;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.3s ease;
}

.btn-delete:hover {
  background-color: #ff1c68;
}

/* Modal overlay and box styles */
.modal-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.7);
  z-index: 9999;
  justify-content: center;
  align-items: center;
  animation: fadeIn 0.3s ease;
}

.modal-box {
  background: #2b2b3c;
  color: #f1f1f1;
  padding: 25px 20px;
  border-radius: 10px;
  width: 340px;
  max-width: 90%;
  text-align: center;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
  animation: slideUp 0.3s ease;
  font-family: 'Inter', sans-serif;
}

.modal-box h3 {
  font-size: 20px;
  margin-bottom: 10px;
  color: #ff4e50;
}

.modal-box p {
  font-size: 14px;
  color: #ccc;
  margin-bottom: 20px;
}

.modal-actions {
  display: flex;
  justify-content: space-around;
  margin-top: 15px;
  gap: 10px;
  width: 100%;
}

.modal-btn {
  padding: 10px 18px;
  font-weight: 600;
  border: none;
  border-radius: 6px;
  font-size: 14px;
  cursor: pointer;
  transition: background 0.3s ease;
  flex: 1;
  /* equal width */
}

.modal-btn.cancel {
  background: #6c63ff;
  color: #fff;
}

.modal-btn.cancel:hover {
  background: #3f3fff;
}

.modal-btn.delete {
  background: #ff4e50;
  color: #fff;
}

.modal-btn.delete:hover {
  background: #ff1c68;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }

  to {
    opacity: 1;
  }
}

@keyframes slideUp {
  from {
    transform: translateY(30px);
    opacity: 0;
  }

  to {
    transform: translateY(0);
    opacity: 1;
  }
}
</style>
@endsection

@section('content')

<!-- Success Popup -->
@if(session('success'))
<div id="successPopup" class="success-popup">
  <p>{{ session('success') }}</p>
</div>
@endif

<table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse: collapse;">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Email</th>
      <th>Actions</th> <!-- Add actions column -->
    </tr>
  </thead>
  <tbody>
    @forelse ($users as $index => $user)
    <tr>
      <td data-label="#"> {{ $index + 1 }}</td>
      <td data-label="Name">{{ $user->name }}</td>
      <td data-label="Email">{{ $user->email }}</td>
      <td data-label="Actions">
        <button type="button" class="btn-edit"
          onclick="openEditModal('{{ $user->id }}', '{{ addslashes($user->name) }}')">Edit</button>
        <button type="button" class="btn-delete" onclick="openDeleteModal('{{ $user->id }}')">Delete</button>
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="4" style="text-align:center;">No users available.</td>
    </tr>
    @endforelse
  </tbody>
</table>

<!-- Delete Confirmation Modal -->
<div class="modal-overlay" id="deleteModal">
  <div class="modal-box">
    <h3>Are you sure?</h3>
    <p>This action cannot be undone. Delete user?</p>
    <form id="deleteForm" method="POST" action="">
      @csrf
      @method('DELETE')
      <div class="modal-actions">
        <button type="button" class="modal-btn cancel" onclick="closeDeleteModal()">Cancel</button>
        <button type="submit" class="modal-btn delete">Yes, Delete</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit User Modal -->
<div class="modal-overlay" id="editModal">
  <div class="modal-box">
    <h3>Edit User</h3>
    <form id="editForm" method="POST" action="">
      @csrf
      @method('PUT')
      <label for="editName" style="display:block; text-align:left; margin-bottom:8px;">Name</label>
      <input type="text" id="editName" name="name" required
        style="width: 100%; padding: 8px; margin-bottom: 12px; border-radius: 5px; border: 1px solid #ccc;">
      <div class="modal-actions">
        <button type="button" class="modal-btn cancel" onclick="closeEditModal()">Cancel</button>
        <button type="submit" class="modal-btn delete">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<script>
// Open delete modal
function openDeleteModal(userId) {
  const modal = document.getElementById('deleteModal');
  const form = document.getElementById('deleteForm');
  form.action = '/users/' + userId; // Adjust if route differs
  modal.style.display = 'flex';
}

// Close delete modal
function closeDeleteModal() {
  document.getElementById('deleteModal').style.display = 'none';
}

// Open edit modal and prefill the current name
function openEditModal(userId, userName) {
  const modal = document.getElementById('editModal');
  const form = document.getElementById('editForm');
  const inputName = document.getElementById('editName');

  form.action = '/users/' + userId; // Adjust if route differs
  inputName.value = userName;

  modal.style.display = 'flex';
}

// Close edit modal
function closeEditModal() {
  document.getElementById('editModal').style.display = 'none';
}

// Success popup auto-hide
document.addEventListener('DOMContentLoaded', function() {
  const popup = document.getElementById('successPopup');
  if (popup) {
    setTimeout(() => {
      popup.classList.add('show');
    }, 100);

    setTimeout(() => {
      popup.classList.remove('show');
    }, 3000);
  }
});
</script>

@endsection