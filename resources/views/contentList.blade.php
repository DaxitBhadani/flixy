@extends('layouts.app')
@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-xl-3 col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4>{{ $movie + $series }}</h4>
                        <div class="card-text badge badge-glow theme-bg fw-normal px-3 py-2">
                            All
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4>{{ $movie }}</h4>
                        <div class="card-text badge badge-glow theme-bg fw-normal px-3 py-2">
                            Movies
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4>{{ $series }}</h4>
                        <div class="card-text badge badge-glow theme-bg fw-normal px-3 py-2">
                            Series
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <section class="content_list">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="movie-tab" data-bs-toggle="tab"
                                data-bs-target="#movie-tab-pane" type="button" role="tab"
                                aria-controls="movie-tab-pane" aria-selected="true">Movie</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="series-tab" data-bs-toggle="tab" data-bs-target="#series-tab-pane"
                                type="button" role="tab" aria-controls="series-tab-pane"
                                aria-selected="false">Series</button>
                        </li>
                    </ul>
                    <div class="">
                        <button type="button" class="btn theme-bg text-light px-4" data-bs-toggle="modal"
                            data-bs-target="#addContentModal">
                            Add Content
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane show active" id="movie-tab-pane" role="tabpanel" aria-labelledby="movie-tab"
                            tabindex="0">
                            {{-- contentTable --}}
                            <table class="table" id="contentTable">
                                <thead>
                                    <tr>
                                        <th width="80px">Verticle </th>
                                        <th width="80px">Horizontal</th>
                                        <th> Title </th>
                                        <th> Rating </th>
                                        <th> Release Year </th>
                                        <th> Language </th>
                                        <th> Is Featured </th>
                                        <th width="100px" style="text-align: right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="series-tab-pane" role="tabpanel" aria-labelledby="series-tab"
                            tabindex="0">
                            <table class="table" id="contentSeriesTable">
                                <thead>
                                    <tr>
                                        <th width="80px">Verticle </th>
                                        <th width="80px">Horizontal</th>
                                        <th> Title </th>
                                        <th> Rating </th>
                                        <th> Release Year </th>
                                        <th> Language </th>
                                        <th> Is Featured </th>
                                        <th width="100px" style="text-align: right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    {{-- Add Content Modal --}}
    <div class="modal fade" id="addContentModal" tabindex="-1" aria-labelledby="addContentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="addContentModalLabel">Add New Content</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="add_new_content" id="addNewContentForm" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <label for="title" class="form-label">Content Title</label>
                                <input type="text" class="form-control" name="title" id="contentTitle"
                                    aria-describedby="title" required="">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <label for="type" class="form-label">Select Content Type</label>
                                <select name="content_type" id="content_type" class="form-control" required="">
                                    <option value="" disabled="">Select Content Type</option>
                                    <option value="1">Movie</option>
                                    <option value="2">Series</option>
                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <label for="desc" class="form-label">Description</label>
                                <textarea name="desc" id="desc" rows="2" class="form-control" required=""></textarea>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                        <label for="duration" class="form-label">Duration</label>
                                        <input type="text" name="duration" class="form-control" id="duration"
                                            aria-describedby="duration" required="">
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                        <label for="releaseYear" class="form-label">Release Year</label>
                                        <input type="number" name="year" class="form-control" id="releaseYear"
                                            aria-describedby="releaseYear" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <label for="rating" class="form-label">Rating</label>
                                <input type="number" step=any name="rating" class="form-control" id="rating"
                                    aria-describedby="rating" required="">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <label for="selectLang" class="form-label">Select Language</label>
                                <select name="language" id="selectLang" class="form-control" required="">
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}">{{ $language->languageName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <label for="selectGenre" class="form-label">Select Genre(multiple) - Min 2</label>

                                <select name="genres[]" class="form-control select2 " multiple="multiple" required=""
                                    tabindex="-1" aria-hidden="true">
                                    <option value="" disabled>Select Option</option>
                                    @foreach ($genres as $genre)
                                        <option value="{{ $genre->id }}">{{ $genre->title }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <label for="trailerId" class="form-label">Youtube Trailer Id</label>
                                <input type="text" name="trailer_id" class="form-control" id="trailerId"
                                    aria-describedby="trailerId" required="">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <div class="form-group">
                                    <label for="verticlePoster" class="form-label">Verticle Poster </label>
                                    <input type="file" accept="image/*" onchange="loadFile(event)"
                                        name="verticle_poster" id="verticlePoster" class="verticlePoster form-control"
                                        required="">
                                </div>
                                <img id="verticlePosterImg" class="custom_img" height="220" width="140"
                                    src="http://localhost/_flixy/public/assets/img/image.svg">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <div class="form-group">
                                    <label for="horizontalPoster" class="form-label">Horizontal Poster </label>
                                    <input type="file" accept="image/*" onchange="loadFile1(event)"
                                        name="horizontal_poster" id="horizontalPoster"
                                        class="horizontalPoster form-control" required="">
                                </div>
                                <img id="horizontalPosterImg" class="custom_img" height="220" width="400"
                                    src="http://localhost/_flixy/public/assets/img/image.svg">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex align-items-center justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn theme-bg text-light px-4">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Content Modal --}}
    <div class="modal fade" id="editContentModal" tabindex="-1" aria-labelledby="editContentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="editContentModalLabel">Edit Content</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="edit_new_content" id="editContentForm" method="POST">
                    <input type="hidden" name="content_id" id="content_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <label for="title" class="form-label">Content Title</label>
                                <input type="text" class="form-control" name="title" id="editContentTitle"
                                    aria-describedby="title" required="">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <label for="type" class="form-label">Select Content Type</label>
                                <select name="content_type" id="editContent_type" class="form-control" required="">
                                    <option value="" disabled="">Select Content Type</option>
                                    <option value="1">Movie</option>
                                    <option value="2">Series</option>
                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <label for="desc" class="form-label">Description</label>
                                <textarea name="desc" id="editDesc" rows="2" class="form-control" required=""></textarea>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                        <label for="duration" class="form-label">Duration</label>
                                        <input type="text" name="duration" class="form-control" id="editDuration"
                                            aria-describedby="duration" required="">
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                        <label for="releaseYear" class="form-label">Release Year</label>
                                        <input type="number" name="year" class="form-control" id="editReleaseYear"
                                            aria-describedby="releaseYear" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <label for="rating" class="form-label">Rating</label>
                                <input type="number" step=any name="rating" class="form-control" id="editRating"
                                    aria-describedby="rating" required="">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <label for="selectLang" class="form-label">Select Language</label>
                                <select name="language" id="editSelectLang" class="form-control" required="">
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}">{{ $language->languageName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <label for="selectGenre" class="form-label">Select Genre(multiple) - Min 2</label>

                                <select name="genres[]" class="form-control select2 " multiple="multiple" required=""
                                    tabindex="-1" aria-hidden="true" id="editGenres">
                                    <option value="" disabled>Select Option</option>
                                    @foreach ($genres as $genre)
                                        <option value="{{ $genre->id }}">{{ $genre->title }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <label for="trailerId" class="form-label">Youtube Trailer Id</label>
                                <input type="text" name="trailer_id" class="form-control" id="editTrailerId"
                                    aria-describedby="trailerId" required="">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <div class="form-group">
                                    <label for="verticlePoster" class="form-label">Verticle Poster </label>
                                    <input type="file" accept="image/*" onchange="loadFileEdit(event)"
                                        name="verticle_poster" id="editVerticlePoster" class="verticlePoster form-control"
                                        >
                                </div>
                                <img id="editVerticlePosterImg" class="custom_img" height="220" width="140"
                                    src="http://localhost/_flixy/public/assets/img/image.svg">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                                <div class="form-group">
                                    <label for="horizontalPoster" class="form-label">Horizontal Poster </label>
                                    <input type="file" accept="image/*" onchange="loadFileEdit1(event)"
                                        name="horizontal_poster" id="editHorizontalPoster"
                                        class="horizontalPoster form-control">
                                </div>
                                <img id="editHorizontalPosterImg" class="custom_img" height="220" width="400"
                                    src="http://localhost/_flixy/public/assets/img/image.svg">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex align-items-center justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn theme-bg text-light px-4">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <form action="">
        <input type="hidden" id="user_type" value="1">
    </form>

@section('scripts')
    <script src="{{ asset('assets/js/content_page.js') }}"></script>
    <script src="{{ asset('assets/js/series_detail_page.js') }}"></script>
    <script>
        // image Preview JS
        var loadFile = function(event) {
            var output = document.getElementById('verticlePosterImg');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
        };

        var loadFile1 = function(event) {
            var output = document.getElementById('horizontalPosterImg');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
        };
        var loadFileEdit = function(event) {
            var output = document.getElementById('editVerticlePosterImg');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
        };

        var loadFileEdit1 = function(event) {
            var output = document.getElementById('editHorizontalPosterImg');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
        };

        var user_type = 1;
    </script>
@endsection
@endsection
