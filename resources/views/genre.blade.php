@extends('layouts.app')
@section('content')
    <div class="page-content">
        <section class="genre_list">
            <div class="card">
                <div class="card-header card-header-border">
                    <h4 class="fw-normal m-0">Add Genre [ {{ $genreCount }} ]</h4>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addGenreModal"
                        class="btn theme-bg text-light px-4">
                        Add Genre
                    </button>
                </div>
                <div class="card-body">
                    <table class="table" id="genreTable">
                        <thead>
                            <tr>
                                <th>Genre</th>
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

    {{-- Add Genre Modal --}}
    <div class="modal fade" id="addGenreModal" tabindex="-1" aria-labelledby="addGenreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="addGenreModalLabel">Add New Genre</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="add_genre" id="addGenreForm" method="POST">
                    <div class="modal-body">
                        <label for="title" class="form-label">Genre Name</label>
                        <input type="text" class="form-control" name="genre" id="genre" aria-describedby="title"
                            required="">
                    </div>
                    <div class="modal-footer d-flex align-items-center justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn theme-bg text-light px-4">Submite</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Genre Modal --}}
    <div class="modal fade" id="editGenreModal" tabindex="-1" aria-labelledby="editGenreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="editGenreModalLabel">edit New Genre</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="edit_genre" id="editGenreForm" method="POST">
                    <input type="hidden" name="genre_id" id="genre_id">
                    <div class="modal-body">
                        <label for="title" class="form-label">Genre Name</label>
                        <input type="text" class="form-control" name="genre" id="editGenre" aria-describedby="title"
                            required="">
                    </div>
                    <div class="modal-footer d-flex align-items-center justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn theme-bg text-light px-4">Submite</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



@section('scripts')
    <script src="{{ asset('assets/js/genre_page.js') }}"></script>
@endsection

@endsection
