@extends('layouts.app')



@section('content')
    <input type="hidden" name="movie_id" class="movie_id" id="movie_id1" value="{{ $data->id }}">
    <div class="page-content">
        <section class="detail_list">
            <div class="card">
                <div class="card-header card-header-border">
                    <h4 class="fw-normal m-0"> <span class="theme-bg px-3 py-2">{{ $data->title }} </span> -- Edit Series
                        Content </h4>
                    <div class="">
                        <p class="btn border text-light px-4 m-0">
                            <i data-feather="eye"></i>
                            <span class="ms-2"> {{ $data->view_count }} Views </span>
                        </p>
                        <p class="btn border text-light px-4 mb-0 ms-1">
                            <i data-feather="share-2"></i>
                            <span class="ms-2"> {{ $data->share_count }} Shares </span>
                        </p>
                        <p class="btn border text-light px-4 mb-0 ms-1">
                            <i data-feather="download"></i>
                            <span class="ms-2"> {{ $data->download_count }} Downloads </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card">

                <div class="card-body">

                    <div class="tab-content">
                        <div class="tab-pane active" id="addSeason" aria-labelledby="addSeasonTab" role="tabpanel">
                            <div class="card">
                                <div class="card-header card-header-border px-0 pt-0 pb-3">

                                    <div class="">
                                        <h4 class="fw-normal">Season List</h4>
                                        <div class="d-flex align-items-end" style="width: 400px;">
                                            <div class="form-group w-100 m-0 me-2">
                                                {{-- <label for="type" class="form-label">Series Season List</label> --}}
                                                <select name="season_list" id="season_list" class="form-control"
                                                    required="">
                                                    @foreach ($seasons as $season)
                                                        <option value="{{ $season->id }}"
                                                            data-trailer_id="{{ $season->trailer_id }}">
                                                            {{ $season->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="season_action" class="w-auto">
                                                <div class="text-end d-flex">
                                                    <div class="edit btn btn-primary px-3 me-2" id="edit_season"
                                                        rel="{{ $season->id }}">
                                                        <i data-feather="edit"></i>
                                                    </div>
                                                    <div class="delete btn btn-danger px-3" id="delete_season"
                                                        rel="{{ $season->id }}">
                                                        <i data-feather="trash-2"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#addSeasonModal"
                                        class="btn theme-bg text-light px-4 ms-2">
                                        Add Season
                                    </button>
                                </div>
                                <div class="container-fluid">
                                    <div class="row align-items-end justify-content-between">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 my-3">
                                            {{-- <div class="d-flex align-items-end">
                                                <div class="form-group w-100 m-0 me-2">
                                                    <label for="type" class="form-label">Series Season List</label>
                                                    <select name="season_list" id="season_list" class="form-control"
                                                        required="">
                                                        @foreach ($seasons as $season)
                                                            <option value="{{ $season->id }}"
                                                                data-trailer_id="{{ $season->trailer_id }}">
                                                                {{ $season->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div id="season_action" class="w-auto">
                                                    <div class="text-end d-flex">
                                                        <div class="edit btn btn-primary px-3 me-2" id="edit_season" rel="{{ $season->id }}">
                                                            <i data-feather="edit"></i>
                                                        </div>
                                                        <div class="delete btn btn-danger px-3" id="delete_season" rel="{{ $season->id }}">
                                                            <i data-feather="trash-2"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 my-3">
                                            <div class="text-end">
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#addEpisodeModal"
                                                    class="addEpisodeModal btn theme-bg text-light px-4" rel="">
                                                    <i data-feather="plus"></i>
                                                    New Episode
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body px-0">
                                    <table class="table" id="seasonTable">
                                        <thead>
                                            <tr>
                                                <th width="140px"> Episode Thumb </th>
                                                <th> Title </th>
                                                <th> Description </th>
                                                <th width="250px" style="text-align: right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    {{-- Add Series Modal --}}
    <div class="modal fade" id="addSeasonModal" tabindex="-1" aria-labelledby="addSeasonModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-normal m-0">Add Series Season</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="add_new_series" id="addSeasonForm" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="series_id" class="series_id" id="series_id"
                            value="{{ $data->id }}">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Season Title</label>
                            <input type="text" name="title" class="form-control" id="exampleInputEmail1" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Youtube trailer id</label>
                            <input type="text" name="trailer_id" class="form-control" id="exampleInputEmail1"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn theme-bg text-light px-4">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Series Modal --}}
    <div class="modal fade" id="editSeasonModal" tabindex="-1" aria-labelledby="editSeasonModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-normal m-0">edit Series Season</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="add_new_series" id="editSeasonForm" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="series_id" class="series_id" id="series_id"
                            value="{{ $data->id }}">
                        <input type="hidden" name="season_id" class="season_id" id="season_id" value="">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Season Title</label>
                            <input type="text" name="title" class="form-control" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Youtube trailer id</label>
                            <input type="text" name="trailer_id" class="form-control" id="trailer_id" required>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn theme-bg text-light px-4">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Episode Modal --}}
    <div class="modal fade" id="addEpisodeModal" tabindex="-1" aria-labelledby="addEpisodeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-normal m-0">Add Episode</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addEpisodeForm" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="season_id" class="season_id" id="season_id" value="">
                        <div class="mb-3">
                            <label for="episodeTitle" class="form-label">Episode Title</label>
                            <input type="text" name="title" class="form-control" id="episodeTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Duration</label>
                            <input type="text" name="duration" class="form-control" id="exampleInputEmail1" required>
                        </div>
                        <div class="mb-3">
                            <label for="access_type" class="form-label">Select Access Type</label>
                            <select name="access_type" id="access_type" class="form-control" required>
                                <option value="1">Free</option>
                                <option value="2">Paid</option>
                                <option value="3">Unlock With Video Ads</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="desc" class="form-label">Description</label>
                            <input type="text" name="desc" class="form-control" id="desc"
                                aria-describedby="desc" required="">
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="image" class="form-label">Horizontal Poster </label>
                                <input type="file" accept="image/*" onchange="loadFile(event)"
                                    name="image" id="image"
                                    class="horizontalPoster form-control">
                            </div>
                            <img id="episodeThumb" class="custom_img" height="220" width="400"
                                src="http://localhost/_flixy/public/assets/img/image.svg">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn theme-bg text-light px-4">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@section('scripts')
    <script src="{{ asset('assets/js/series_detail_page.js') }}"></script>
    <script>
         // image Preview JS
         var loadFile = function(event) {
            var output = document.getElementById('episodeThumb');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
        };
    </script>
@endsection

@endsection
