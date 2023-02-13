@extends('layouts.app')
@section('content')
    <input type="hidden" name="movie_id" class="movie_id" id="movie_id1" value="{{ $data->id }}">
    <section class="detail_list">
        <div class="card">
            <div class="card-header card-header-border">
                <h4 class="fw-normal m-0"> <span class="theme-bg px-3 py-2">{{ $data->title }} </span> -- Edit
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

            <div class="card-body">
                <div class="show-hide" id="movieContent" style="display: block">
                    <div class="d-flex justify-content-between">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="addSourceTab" data-bs-toggle="tab" href="#addSource"
                                    aria-controls="addSource" role="tab" aria-selected="true">Source</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="addSubtitleTab" data-bs-toggle="tab" href="#addSubtitle"
                                    aria-controls="addSubtitleTab" role="tab" aria-selected="true">Subtitle</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="addSource" aria-labelledby="addSourceTab" role="tabpanel">
                        <div class="card">
                            <div class="card-header card-header-border px-0">
                                <h4 class="fw-normal m-0">Movie Source List </h4>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#addSourceModal"
                                    class="btn theme-bg text-light px-4">
                                    Add Movie Source
                                </button>
                            </div>
                            <div class="card-body px-0">
                                <table class="table" id="sourceTable">
                                    <thead>
                                        <tr>
                                            <th width="250px"> Source Type </th>
                                            <th> Title </th>
                                            <th> URL </th>
                                            <th width="250px" style="text-align: right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="addSubtitle" aria-labelledby="addSubtitleTab" role="tabpanel">
                        <div class="card">
                            <div class="card-header card-header-border px-0">
                                <h4 class="fw-normal m-0">Movie Subtitle List</h4>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#addSubtitleModal"
                                    class="btn theme-bg text-light px-4">
                                    Add Movie Subtitle
                                </button>
                            </div>
                            <div class="card-body px-0">
                                <table class="table" id="subtitleTable">
                                    <thead>
                                        <tr>
                                            <th> Language Name </th>
                                            <th> Action </th>
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




@section('scripts')
    <script src="{{ asset('assets/js/episode_detail_page.js') }}"></script>
@endsection


@endsection
