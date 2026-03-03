@extends('layouts.template')

@section('headerBlock')
    <link rel="stylesheet" href="{{ URL::asset('css/category.css') }}">
@endsection

@section('pageTitle')
    Categories List
@endsection

@section('rightTitle')
    Categories List
@endsection

@section('content')
    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Message --}}
    @if (session('error'))
        <div class="alert error">
            {{ session('error') }}
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

    <table class="category-table" border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Category Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->categoryName }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        <button class="btn-edit" data-id="{{ $category->id }}" data-name="{{ $category->categoryName }}"
                            data-description="{{ $category->description }}">
                            Edit
                        </button> |

                        <button class="btn-delete-trigger" data-id="{{ $category->id }}"
                            data-name="{{ $category->categoryName }}">
                            Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Add New Category Button -->
    <div>
        <button id="openModalBtn" class="btn-primary">Add New Category</button>
    </div>

    <!-- Add/Edit Modal -->
    <div id="categoryModal" class="modal">
        <div class="modal-content">
            <span id="closeModalBtn" class="close">&times;</span>

            <h2 id="modalTitle">Creating New Category</h2>

            <form method="post" id="categoryForm" action="{{ route('categories.store') }}">
                @csrf
                @method('POST')

                <input type="hidden" name="category_id" id="category_id">

                <div class="field">
                    <label for="categoryName">Category Name</label>
                    <input type="text" name="categoryName" id="categoryName" value="{{ old('categoryName') }}">
                    <span class="error-text" id="errorCategoryName"></span>
                </div>

                <div class="field">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="5">{{ old('description') }}</textarea>
                    <span class="error-text" id="errorDescription"></span>
                </div>

                <div class="field">
                    <input type="submit" value="SUBMIT">
                    <input type="reset" value="RESET">
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmModal" class="modal">
        <div class="modal-content">
            <h3>Confirm Deletion</h3>
            <p>Are you sure you want to delete the category "<span id="deleteCategoryName"></span>"? This action cannot be
                undone.</p>

            <form id="deleteCategoryForm" method="POST" action="">
                @csrf
                @method('DELETE')

                <div class="modal-actions" style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" id="cancelDeleteBtn" class="btn-cancel">Cancel</button>
                    <button type="submit" class="btn-delete-confirm">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements for add/edit modal
            const modal = document.getElementById('categoryModal');
            const openBtn = document.getElementById('openModalBtn');
            const closeBtn = document.getElementById('closeModalBtn');
            const form = document.getElementById('categoryForm');
            const modalTitle = document.getElementById('modalTitle');

            const categoryIdInput = document.getElementById('category_id');
            const categoryNameInput = document.getElementById('categoryName');
            const descriptionInput = document.getElementById('description');

            // Elements for delete modal
            const deleteModal = document.getElementById('deleteConfirmModal');
            const deleteCategoryNameSpan = document.getElementById('deleteCategoryName');
            const deleteCategoryForm = document.getElementById('deleteCategoryForm');
            const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

            // Open modal for new category
            openBtn.addEventListener('click', () => {
                modal.classList.add('show');
                modalTitle.textContent = 'Creating New Category';
                form.action = "{{ route('categories.store') }}";
                form.method = 'POST';

                categoryIdInput.value = '';
                categoryNameInput.value = '';
                descriptionInput.value = '';

                // Remove PUT method override if exists
                const methodInput = form.querySelector('input[name="_method"]');
                if (methodInput) {
                    methodInput.remove();
                }

                clearErrors();
            });

            // Close add/edit modal
            closeBtn.addEventListener('click', () => {
                modal.classList.remove('show');
            });

            // Close add/edit modal clicking outside content
            window.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('show');
                }
                if (e.target === deleteModal) {
                    deleteModal.classList.remove('show');
                }
            });

            // Edit buttons
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', () => {
                    modal.classList.add('show');
                    modalTitle.textContent = 'Editing Category';

                    const id = button.dataset.id;
                    const name = button.dataset.name;
                    const description = button.dataset.description;

                    categoryIdInput.value = id;
                    categoryNameInput.value = name;
                    descriptionInput.value = description;

                    form.action = `/categories/${id}`;
                    form.method = 'POST';

                    // Append hidden _method input for PUT
                    let methodInput = form.querySelector('input[name="_method"]');
                    if (!methodInput) {
                        methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        form.appendChild(methodInput);
                    }
                    methodInput.value = 'PUT';

                    clearErrors();
                });
            });

            // Reset form and clear errors on reset button click
            form.querySelector('input[type="reset"]').addEventListener('click', (e) => {
                e.preventDefault();
                categoryIdInput.value = '';
                categoryNameInput.value = '';
                descriptionInput.value = '';
                clearErrors();
            });

            function clearErrors() {
                document.getElementById('errorCategoryName').textContent = '';
                document.getElementById('errorDescription').textContent = '';
            }

            // Delete button triggers
            document.querySelectorAll('.btn-delete-trigger').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.dataset.id;
                    const name = button.dataset.name;

                    deleteCategoryNameSpan.textContent = name;
                    deleteCategoryForm.action = `/categories/${id}`;
                    deleteModal.classList.add('show');
                });
            });

            // Cancel delete
            cancelDeleteBtn.addEventListener('click', () => {
                deleteModal.classList.remove('show');
            });
        });
    </script>
@endsection
