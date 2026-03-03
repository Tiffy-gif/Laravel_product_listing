@extends('layouts.template')

@section('pageTitle', 'Product Listing')
@section('rightTitle', 'Product Listing')

@section('headerBlock')
    <link rel="stylesheet" href="{{ URL::asset('css/product.css') }}">
@endsection

@section('content')
    <!-- Success Popup -->
    @if (session('success'))
        <div id="successPopup" class="success-popup">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Filter & Search Form -->
    <form method="GET" action="{{ route('products.index') }}" class="filter-search-form">
        <div class="form-group">
            <label for="category_id">Filter by Category:</label>
            <select name="category_id" id="category_id" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->categoryName }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group search-group">
            <label for="search">Search Products:</label>
            <div class="search-wrapper">
                <input type="text" name="search" id="search" placeholder="Search by name..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn-filter">Search</button>
            </div>
        </div>
    </form>

    <!-- Scrollable Table -->
    <div class="table-container" id="tableContainer">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Warranty</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="productBody">
                @foreach ($products as $index => $product)
                    <tr>
                        <td data-label="#"> {{ $index + 1 }} </td>
                        <td data-label="Name">{{ $product->productName ?? $product->name }}</td>
                        <td data-label="Category">{{ $product->category->categoryName ?? 'Uncategorized' }}</td>
                        <td data-label="Price">${{ number_format($product->price, 2) }}</td>
                        <td data-label="Quantity">{{ $product->quantity }}</td>
                        <td data-label="Warranty">{{ $product->warranty }}</td>
                        <td data-label="Actions">
                            <a href="{{ route('products.show', $product->id) }}" class="btn-edit">Edit</a>
                            <button type="button" class="btn-delete"
                                onclick="openDeleteModal('{{ $product->id }}')">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div id="loading" style="display:none;text-align:center;padding:10px;color:#fff;">Loading...</div>
    </div>

    <!-- Delete Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <h3>Are you sure?</h3>
            <p>This action cannot be undone. Delete the item?</p>
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

    <script>
        function openDeleteModal(productId) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = '/products/' + productId;
            modal.classList.add('show');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('show');
        }
    </script>
@endsection

@section('footerBlock')
    <script>
        // Success popup
        document.addEventListener('DOMContentLoaded', function() {
            const popup = document.getElementById('successPopup');
            if (popup) {
                setTimeout(() => popup.classList.add('show'), 100);
                setTimeout(() => popup.classList.remove('show'), 3000);
            }
        });

        // Infinite scroll
        let page = 1;
        let loading = false;
        const container = document.getElementById('tableContainer');
        container.addEventListener('scroll', function() {
            if (loading) return;
            if (container.scrollTop + container.clientHeight >= container.scrollHeight - 10) {
                loading = true;
                page++;
                document.getElementById('loading').style.display = 'block';

                let params = new URLSearchParams(window.location.search);
                fetch(`{{ route('products.index') }}?${params}&page=${page}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.text())
                    .then(data => {
                        const parser = new DOMParser();
                        const html = parser.parseFromString(data, 'text/html');
                        const rows = html.querySelectorAll('#productBody tr');
                        if (rows.length) {
                            rows.forEach(r => document.getElementById('productBody').appendChild(r));
                            loading = false;
                            document.getElementById('loading').style.display = 'none';
                        } else {
                            document.getElementById('loading').innerText = 'No more products';
                        }
                    })
                    .catch(e => console.error(e));
            }
        });
    </script>
@endsection
