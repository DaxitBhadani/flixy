@extends('layouts.app')
@section('content')
    <div class="page-content">
        <section class="language_list">
            <div class="card">
                <div class="card-header card-header-border">
                    <h4 class="fw-normal m-0">Add Language [ {{ $languageCount }} ]</h4>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addLanguageModal"
                        class="btn theme-bg text-light px-4">
                        Add Language
                    </button>
                </div>
                <div class="card-body">
                    <table class="table" id="languageTable">
                        <thead>
                            <tr>
                                <th>Language</th>
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

    {{-- Add Language Modal --}}
    <div class="modal fade" id="addLanguageModal" tabindex="-1" aria-labelledby="addLanguageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="addLanguageModalLabel">Add New Language</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="add_language" id="addLanguageForm" method="POST">
                    <div class="modal-body">
                        <label for="title" class="form-label">Language Name</label>
                        <input type="text" class="form-control" name="languageName" id="languageName"
                            aria-describedby="title" required="">
                    </div>
                    <div class="modal-footer d-flex align-items-center justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn theme-bg text-light px-4">Submite</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Language Modal --}}
    <div class="modal fade text-left" id="editLanguageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Language </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editLanguageform" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <ul class="alert alert-warning d-none" id="update_error"></ul>
                        <input type="hidden" name="Language_id" id="Language_id">

                        <div class="form-group">
                            <label for="editLanguageName" class="form-label">Edit Language Name</label>
                            <input type="text" class="form-control" name="languageName" id="editLanguageName"
                                aria-describedby="title" required="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary theme-bg px-4"> Update Language </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@section('scripts')
    <script src="{{ asset('assets/js/language_page.js') }}"></script>
@endsection

@endsection
