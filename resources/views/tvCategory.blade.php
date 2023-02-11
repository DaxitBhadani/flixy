@extends('layouts.app')
@section('content')
    <div class="page-content">
        <section class="category_list">
            <div class="card">
                <div class="card-header card-header-border">
                    <h4 class="fw-normal m-0">Add Live TV Category [ {{ $tvCategoryCount }} ]</h4>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addTvCategoryModal"
                        class="btn theme-bg text-light px-4">
                        Add TV Category
                    </button>
                </div>
                <div class="card-body">
                    <table class="table" id="tvCategoryTable">
                        <thead>
                            <tr>
                                <th width="70px">image</th>
                                <th>Category Name</th>
                                <th width="200px" style="text-align: right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    {{-- Add Tv Category Modal --}}
    <div class="modal fade" id="addTvCategoryModal" tabindex="-1" aria-labelledby="addTvCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="addCategoryModalLabel">Add Live Tv Category</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addTvCategoryForm" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tvCategory" class="form-label">Tv Category Name</label>
                            <input type="text" class="form-control" name="tvCategory" id="tvCategoryName"
                                aria-describedby="title" required="">
                        </div>
                        <div class="form-group">
                            <label for="tvCategoryImage" class="form-label w-100">TV Category Image</label>
                            <input type="file" accept="image/*" onchange="loadFile(event)" name="image"
                                id="tvCategoryImageFile" class="form-control" required>
                            <img id="tvCategoryImage" class="custom_img mt-3 bg-white" height="100" width="100"
                                src="{{ asset('assets/img/package.svg') }}" />
                        </div>
                    </div>
                    <div class="modal-footer d-flex align-items-center justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn theme-bg text-light px-4">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Edit Tv Category Modal --}}
    <div class="modal fade" id="editTvCategoryModal" tabindex="-1" aria-labelledby="editTvCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="editChannelModalLabel">Edit Live Tv Category</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTvCategoryForm" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="category_id" id="category_id">
                        <div class="form-group">
                            <img id="editTvCategoryImage" class="custom_img mb-3 bg-white" height="100" width="100"
                                src="{{ asset('assets/img/user.svg') }}"  />
                            <label for="tvCategoryImage" class="form-label w-100">TV Category Image</label>
                            <input type="file" accept="image/*" onchange="loadFile1(event)" name="image"
                                id="editTvCategoryImageFile" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="tvCategory" class="form-label">Tv Category Name</label>
                            <input type="text" class="form-control" name="tvCategory" id="editTvCategoryName"
                                aria-describedby="title" required="">
                        </div>
                    </div>
                    <div class="modal-footer d-flex align-items-center justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn theme-bg text-light px-4">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



@section('scripts')
    <script src="{{ asset('assets/js/tvcategory_page.js') }}"></script>

    <script>
        // image Preview JS
        var loadFile = function(event) {
            var output = document.getElementById('tvCategoryImage');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
        };

        // Edit image Preview JS
        var loadFile1 = function(event) {
            var output = document.getElementById('editTvCategoryImage');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
        };
    </script>

@endsection


@endsection
