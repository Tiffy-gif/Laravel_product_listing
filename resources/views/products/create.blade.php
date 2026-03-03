@extends('layouts.template')

@section('headerBlock')
<link rel="stylesheet" href="{{ URL::asset('css/form.css') }}">
@endsection

@section('pageTitle')
Creating New Product
@endsection

@section('rightTitle')
Creating New Product
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

<form action="{{ route('products.store') }}" method="post">
  @csrf

  <div class="field">
    <label for="productName">Product Name</label>
    <input type="text" name="productName" id="productName" value="{{ old('productName') }}">
    @error('productName')
    <span class="error-text">{{ $message }}</span>
    @enderror
  </div>

  <div class="field">
    <label for="category_id">Category</label>
    <select name="category_id" id="category_id">
      <option value="">-- Select Category --</option>
      @foreach ($categories as $category)
      <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
    <input type="text" name="price" id="price" value="{{ old('price') }}">
    @error('price')
    <span class="error-text">{{ $message }}</span>
    @enderror
  </div>

  <div class="field">
    <label for="quantity">Quantity</label>
    <input type="text" name="quantity" id="quantity" value="{{ old('quantity') }}">
    @error('quantity')
    <span class="error-text">{{ $message }}</span>
    @enderror
  </div>

  <div class="field">
    <label for="warranty">Warranty</label>
    <input type="text" name="warranty" id="warranty" value="{{ old('warranty') }}">
    @error('warranty')
    <span class="error-text">{{ $message }}</span>
    @enderror
  </div>

  <div class="field">
    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
    @error('description')
    <span class="error-text">{{ $message }}</span>
    @enderror
  </div>

  <div class="field">
    <input type="submit" value="SUBMIT">
    <input type="reset" value="RESET">
  </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('form');
  const resetBtn = form.querySelector('input[type="reset"]');

  resetBtn.addEventListener('click', function(e) {
    e.preventDefault(); // prevent default reset behavior

    // Clear all input and textarea values
    form.querySelectorAll('input[type="text"], textarea').forEach(el => el.value = '');

    // Remove all inline error messages (.error-text spans)
    form.querySelectorAll('.error-text').forEach(el => el.remove());

    // Remove the top error alert container if exists
    const errorAlert = document.querySelector('.alert.error');
    if (errorAlert) {
      errorAlert.remove();
    }

    // Optionally, remove success alert too if you want:
    // const successAlert = document.querySelector('.alert.success');
    // if (successAlert) {
    //   successAlert.remove();
    // }
  });
});
</script>


@endsection