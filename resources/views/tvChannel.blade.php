@extends('layouts.app')
@section('content')
    <div class="page-content">
        <section class="actor_list">
            <div class="card">
                <div class="card-header card-header-border">
                    <h4 class="fw-normal m-0">Add Live TV Channel [ {{ $tvChannelCount }} ] </h4>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addTvChannelModal"
                        class="btn theme-bg text-light px-4">
                        Add TV Channel
                    </button>
                </div>
                <div class="card-body">
                    <table class="table" id="tvChannelTable">
                        <thead>
                            <tr>
                                <th width="70px">icon</th>
                                <th> Name </th>
                                <th> Category </th>
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

    {{-- Add Tv Channel Modal --}}
    <div class="modal fade" id="addTvChannelModal" tabindex="-1" aria-labelledby="addTvChannelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="addChannelModalLabel">Add Live Tv Channel</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addTvChannelForm" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tvChannel" class="form-label">Tv Channel Name</label>
                                    <input type="text" class="form-control" name="title" id="tvChannelName"
                                        aria-describedby="title" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Select Access Type</label>
                                    <select name="access_type" id="access_type" class="form-control" required>
                                        <option value="" disabled selected>Select Option</option>
                                        <option value="1">Free</option>
                                        <option value="2">Paid</option>
                                        <option value="3">Unlock with video Ads</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group position-relative">
                                    <label class="form-label">Tv Channel Category: </label>
                                    <select name="category_ids[]" id="category_ids" class="form-control select2" required
                                        multiple="multiple">
                                        <option value="" disabled>Select Option</option>
                                        @foreach ($tvCategories as $tvCategory)
                                            <option value="{{ $tvCategory->id }}">{{ $tvCategory->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Select Source Type</label>
                                    <select name="source_type" id="source_type" class="form-control" required>
                                        <option value="" disabled selected>Select Option</option>
                                        <option value="1">Youtube Id</option>
                                        <option value="2">Video Id</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="source_url" class="form-label">Source URL</label>
                                    <input type="text" class="form-control" name="source_url" id="sourceURL"
                                        aria-describedby="title" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tvChannelImage" class="form-label w-100">TV Channel Image</label>
                                    <input type="file" accept="image/*" onchange="loadFile(event)" name="image"
                                        id="tvChannelImageFile" class="form-control" required>
                                    <img id="tvChannelImage" class="custom_img mt-3" height="100" width="100"
                                        src="{{ asset('assets/img/package.svg') }}" />
                                </div>
                            </div>
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

    {{-- Edit Tv Channel Modal --}}
    <div class="modal fade" id="editTvChannelModal" tabindex="-1" aria-labelledby="editTvChannelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="addChannelModalLabel">Add Live Tv Channel</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTvChannelForm" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="channel_id" id="channel_id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tvChannel" class="form-label">Tv Channel Name</label>
                                    <input type="text" class="form-control" name="title" id="editTvChannelName"
                                        aria-describedby="title" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Select Access Type</label>
                                    <select name="access_type" id="editAccessType" class="form-control" required>
                                        <option value="" disabled selected>Select Option</option>
                                        <option value="1">Free</option>
                                        <option value="2">Paid</option>
                                        <option value="3">Unlock with video Ads</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group position-relative">
                                    <label class="form-label">Tv Channel Category: </label>
                                    <select name="category_ids[]" id="editCategory_ids" class="form-control select2" required
                                        multiple="multiple">
                                        <option value="" disabled>Select Option</option>
                                        @foreach ($tvCategories as $tvCategory)
                                            <option value="{{ $tvCategory->id }}">{{ $tvCategory->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Select Source Type</label>
                                    <select name="source_type" id="editSourceType" class="form-control" >
                                        <option value="" disabled selected>Select Option</option>
                                        <option value="1">Youtube Id</option>
                                        <option value="2">Video Id</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="source_url" class="form-label">Source URL</label>
                                    <input type="text" class="form-control" name="source_url" id="editSourceURL"
                                        aria-describedby="title" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tvChannelImage" class="form-label w-100">TV Channel Image</label>
                                    <input type="file" accept="image/*" onchange="loadFile(event)" name="image"
                                        id="editTvChannelImageFile" class="form-control">
                                    <img src="" id="editTvChannelImage" class="custom_img mt-3" height="100"
                                        width="100" />
                                </div>
                            </div>
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
    <script src="{{ asset('assets/js/tvchannel_page.js') }}"></script>

    <script>
        // image Preview JS
        var loadFile = function(event) {
            var output = document.getElementById('tvChannelImage');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
        };

        // Edit image Preview JS
        var loadFile1 = function(event) {
            var output = document.getElementById('editTvChannelImage');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
        };
        
    </script>
@endsection


@endsection
