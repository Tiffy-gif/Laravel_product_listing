@extends('layouts.template')

@section('headerBlock')
<link rel="stylesheet" href="{{ URL::asset('css/form.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/show.css') }}">

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

/* Modal styles */
.modal-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.6);
  justify-content: center;
  align-items: center;
  z-index: 1500;
}

.modal-box {
  background: #2b2b3c;
  padding: 25px 30px;
  border-radius: 10px;
  color: #f1f1f1;
  width: 320px;
  text-align: center;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);
}

.modal-box h3 {
  margin-bottom: 12px;
  font-weight: 600;
  font-size: 20px;
}

.modal-box p {
  margin-bottom: 20px;
  font-size: 15px;
  color: #ccc;
}

.modal-actions {
  display: flex;
  justify-content: space-between;
  gap: 12px;
}

.modal-btn {
  flex: 1;
  padding: 10px 0;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  font-weight: 600;
  font-size: 15px;
  transition: background 0.3s ease, transform 0.2s ease;
}

.modal-btn.cancel {
  background: #6c63ff;
  color: #fff;
}

.modal-btn.cancel:hover {
  background: #3f3fff;
  transform: scale(1.05);
}

.modal-btn.delete {
  background: #e74c3c;
  color: #fff;
}

.modal-btn.delete:hover {
  background: #c0392b;
  transform: scale(1.05);
}

/* Buttons side by side equal width */
.form-buttons {
  display: flex;
  gap: 15px;
  margin-top: 20px;
}

.form-buttons>* {
  flex: 1;
}

.btn-update {
  padding: 12px 0;
  font-size: 16px;
  font-weight: 600;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  background: linear-gradient(90deg, #3f3fff, #6c63ff);
  color: #fff;
  transition: background 0.3s ease, transform 0.2s ease;
}

.btn-update:hover {
  background: linear-gradient(90deg, #6c63ff, #3f3fff);
  transform: scale(1.03);
}

.btn-delete {
  padding: 12px 0;
  font-size: 16px;
  font-weight: 600;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  background: linear-gradient(90deg, #e74c3c, #c0392b);
  color: #fff;
  transition: background 0.3s ease, transform 0.2s ease;
}

.btn-delete:hover {
  background: linear-gradient(90deg, #c0392b, #e74c3c);
  transform: scale(1.03);
}
</style>
@endsection

@section('pageTitle')
Product Details - Edit Product
@endsection

@section('rightTitle')
Product Details - Edit Product
@endsection

@section('content')

{{-- Success Message --}}
@if(session('success'))
<div class="alert success">
  {{ session('success') }}
</div>
@endif

{{-- Validation Errors --}}
@if ($errors->any())
<div class="alert error">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

{{-- Product Edit Form --}}
<form id="productForm" action="{{ route('products.update', $product->id) }}" method="POST">
  @csrf
  @method('PUT')

  <div class="field">
    <label for="productName">Product Name</label>
    <input type="text" name="productName" id="productName" value="{{ old('productName', $product->productName) }}">
    @error('productName')
    <span class="error-text">{{ $message }}</span>
    @enderror
  </div>

  <div class="field">
    <label for="category_id">Category</label>
    <select name="category_id" id="category_id">
      <option value="">-- Select Category --</option>
      @foreach ($categories as $category)
      <option value="{{ $category->id }}"
        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
        {{ $category->categoryName }}
      </option>
      @endforeach
    </select>
    @error('category_id')
    <span class="error-text">{{ $message }}</span>
    @enderror
  </div>

  <div class="field">
    <label for="price">Price</label>
    <input type="text" name="price" id="price" value="{{ old('price', $product->price) }}">
    @error('price')
    <span class="error-text">{{ $message }}</span>
    @enderror
  </div>

  <div class="field">
    <label for="quantity">Quantity</label>
    <input type="text" name="quantity" id="quantity" value="{{ old('quantity', $product->quantity) }}">
    @error('quantity')
    <span class="error-text">{{ $message }}</span>
    @enderror
  </div>

  <div class="field">
    <label for="warranty">Warranty</label>
    <input type="text" name="warranty" id="warranty" value="{{ old('warranty', $product->warranty) }}">
    @error('warranty')
    <span class="error-text">{{ $message }}</span>
    @enderror
  </div>

  <div class="field">
    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30"
      rows="10">{{ old('description', $product->description) }}</textarea>
    @error('description')
    <span class="error-text">{{ $message }}</span>
    @enderror
  </div>

  <div class="field form-buttons">
    <input type="submit" value="Update Product" class="btn-update" />
    <button type="button" class="btn-delete" onclick="openDeleteModal('{{ $product->id }}')">Delete</button>
  </div>
</form>

{{-- Hidden Delete Form used by Modal --}}
<form id="deleteForm" method="POST" style="display:none;">
  @csrf
  @method('DELETE')
</form>

{{-- Delete Confirmation Modal --}}
<div class="modal-overlay" id="deleteModal">
  <div class="modal-box">
    <h3>Are you sure?</h3>
    <p>This action cannot be undone. Delete the item?</p>
    <div class="modal-actions">
      <button type="button" class="modal-btn cancel" onclick="closeDeleteModal()">Cancel</button>
      <button type="button" class="modal-btn delete" onclick="submitDeleteForm()">Yes, Delete</button>
    </div>
  </div>
</div>

<script>
function openDeleteModal(productId) {
  const modal = document.getElementById('deleteModal');
  const deleteForm = document.getElementById('deleteForm');
  deleteForm.action = `/products/${productId}`;
  modal.style.display = 'flex';
}

function closeDeleteModal() {
  const modal = document.getElementById('deleteModal');
  modal.style.display = 'none';
}

function submitDeleteForm() {
  const deleteForm = document.getElementById('deleteForm');
  deleteForm.submit();
}
</script>

@endsection