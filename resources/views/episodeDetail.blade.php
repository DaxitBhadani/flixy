@extends('layouts.app')
@section('content')

    <input type="hidden" name="series_id" class="series_id" id="series_id" value="{{ $data->season_id }}">
    <input type="hidden" name="episode_id" class="episode_id" id="episode_id" value="{{ $data->id }}">

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
                                <h4 class="fw-normal m-0">Episode Source List </h4>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#addEpisodeSourceModal"
                                    class="btn theme-bg text-light px-4">
                                    Add Episode Source
                                </button>
                            </div>
                            <div class="card-body px-0">
                                <table class="table" id="episodeSourceTable">
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
                                <h4 class="fw-normal m-0">Episode Subtitle List</h4>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#addEpisodeSubtitleModal"
                                    class="btn theme-bg text-light px-4">
                                    Add Episode Subtitle
                                </button>
                            </div>
                            <div class="card-body px-0">
                                <table class="table" id="episodeSubtitleTable">
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

    <!-- Source Modal -->
    <div class="modal fade" id="addEpisodeSourceModal" tabindex="-1" aria-labelledby="addEpisodeSourceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-normal m-0">Add Episode Source</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addEpisodeSourceForm" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="episode_id" id="seriesCurrentUrlId" class="episode_id"
                            value="{{ $data->id }}">
                        <div class="mb-3">
                            <label for="title" class="form-label">Source Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="quality" class="form-label">Source Quality</label>
                            <input type="text" name="quality" class="form-control" id="quality" required>
                        </div>
                        <div class="mb-3">
                            <label for="size" class="form-label">Source Size</label>
                            <input type="text" name="size" class="form-control" id="size" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="download_type" name="download_type">
                            <label class="form-check-label" for="download_type">Downloadable Or not</label>
                        </div>

                        <div class="mb-3">
                            <label for="source_type" class="form-label">Select Source Type</label>
                            <select name="source_type" class="form-control" id="source_type" aria-invalid="false"
                                required="required">
                                <option value="" disabled selected>Select Option</option>
                                <option value="1">Youtube Id</option>
                                <option value="2">M3u8 Url</option>
                                <option value="3">Mov Url</option>
                                <option value="4">Mp4 Url</option>
                                <option value="5">Mkv Url</option>
                                <option value="6">Webm Url</option>
                                <option class="otherSelect" value="7">File Upload (Mp4, Mov, Mkv, Webm)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="sourceFile">
                                <label for="source_file" class="form-label">Source File</label>
                                <input type="file" name="source_file" class="form-control" id="source_file"
                                    aria-describedby="sourceFile" accept="video/mp4,video/x-m4v,video/*">
                            </div>
                            <div class="sourceURL">
                                <label for="sourceURL" class="form-label">source URL</label>
                                <input type="text" name="source_url" class="form-control" id="sourceURL"
                                    aria-describedby="sourceURL">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="access_type" class="form-label">Select Access Type</label>
                            <select name="access_type" id="access_type" class="form-control" required>
                                <option value="1">Free</option>
                                <option value="2">Paid</option>
                                <option value="3">Unlock With Video Ads</option>
                            </select>
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

    <!-- Edit Source Modal -->
    <div class="modal fade" id="editEpisodeSourceModal" tabindex="-1" aria-labelledby="editEpisodeSourceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-normal m-0">Edit Episode Source</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="edit_new_source" id="editEpisodeSourceForm" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="editSource" class="editSource" id="editSource" value="">
                        <div class="mb-3">
                            <label for="title" class="form-label">Source Title</label>
                            <input type="text" class="form-control" id="editTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="quality" class="form-label">Source Quality</label>
                            <input type="text" name="quality" class="form-control" id="editQuality" required>
                        </div>
                        <div class="mb-3">
                            <label for="size" class="form-label">Source Size</label>
                            <input type="text" name="size" class="form-control" id="editSize" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="editDownload_type" name="download_type">
                            <label class="form-check-label" for="download_type">Downloadable Or not</label>
                        </div>
                        <div class="mb-3">
                            <label for="source_type" class="form-label">Select Source Type</label>
                            <select name="source_type" class="form-control" id="editSource_type" aria-invalid="false"
                                required="required">
                                <option value="" disabled selected>Select Option</option>
                                <option value="1">Youtube Id</option>
                                <option value="2">M3u8 Url</option>
                                <option value="3">Mov Url</option>
                                <option value="4">Mp4 Url</option>
                                <option value="5">Mkv Url</option>
                                <option value="6">Webm Url</option>
                                <option class="otherSelect" value="7">File Upload (Mp4, Mov, Mkv, Webm)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="sourceFile">
                                <label for="source_file" class="form-label">Source File</label>
                                <input type="file" name="source_file" class="form-control" id="editSource_file"
                                    aria-describedby="sourceFile" accept="video/mp4,video/x-m4v,video/*">
                            </div>
                            <div class="sourceURL">
                                <label for="sourceURL" class="form-label">source URL</label>
                                <input type="text" name="source_url" class="form-control" id="editSourceURL"
                                    aria-describedby="sourceURL">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="access_type" class="form-label">Select Access Type</label>
                            <select name="access_type" id="editAccess_type" class="form-control" required>
                                <option value="1">Free</option>
                                <option value="2">Paid</option>
                                <option value="3">Unlock With Video Ads</option>
                            </select>
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

    {{-- View Video Modal --}}
    <div class="modal fade text-left" id="viewVideoModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Video </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <video id="show_video" width="100%" height="500" controls autoplay src=""></video>
                </div>
            </div>
        </div>
    </div>

    {{-- Subtitle Modal --}}
    <div class="modal fade" id="addEpisodeSubtitleModal" tabindex="-1" aria-labelledby="addEpisodeSubtitleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-normal m-0">Add Episode Subtitle</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addEpisodeSubtitleForm" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="episode_id" id="subtitleSeriesCurrentUrlId" class="episode_id"
                        value="{{ $data->id }}">
                        <div class="mb-3">
                            <label for="selectLang" class="form-label">Select Language</label>
                            <select name="title" class="form-control" id="selectLangModal" aria-invalid="false">
                                <option value="" disabled selected>Select Language</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}">{{ $language->languageName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="subtitle" class="form-label">Subtitle File</label>
                            <input type="file" name="subtitle" id="subtitle" class="subtitle form-control" required
                                accept=".srt">
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
    <script src="{{ asset('assets/js/episode_detail_page.js') }}"></script>
@endsection


@endsection
