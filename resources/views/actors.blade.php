@extends('layouts.app')
@section('content')
    <div class="page-content">
        <section class="actor_list">
            <div class="card">
                <div class="card-header card-header-border">
                    <h4 class="fw-normal m-0">Add Actor [ {{ $actorCount }} ]</h4>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addActorModal"
                        class="btn theme-bg text-light px-4">
                        Add Actor
                    </button>
                </div>
                <div class="card-body">
                    <table class="table" id="actorTable">
                        <thead>
                            <tr>
                                <th width="70px">image</th>
                                <th>Actor</th>
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

    {{-- Add Actor Modal --}}
    <div class="modal fade" id="addActorModal" tabindex="-1" aria-labelledby="addActorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="addActorModalLabel">Add New Actor</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="add_actor" id="addActorForm" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="actorImage" class="form-label w-100">Actor Image</label>
                            <img id="actorImage" class="custom_img mb-3 rounded-pill object-cover" height="100" width="100" src="{{ asset('assets/img/user.svg') }}" />
                            <input type="file" accept="image/*" onchange="loadFile(event)" name="image" id="actorImageFile" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="title" class="form-label">Actor Name</label>
                            <input type="text" class="form-control" name="actor" id="actor" aria-describedby="title" required="">
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

      {{-- Edit Actor Modal --}}
      <div class="modal fade" id="editActorModal" tabindex="-1" aria-labelledby="editActorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="editActorModalLabel">Add New Actor</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="edit_actor" id="editActorForm" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="actor_id">
                        <div class="form-group">
                            <label for="editActorImage" class="form-label w-100">Actor Image</label>
                            <img id="editActorImage" class="custom_img mb-3 rounded-pill object-cover" height="100" width="100" src="{{ asset('assets/img/user.svg') }}" />
                            <input type="file" accept="image/*" onchange="loadFile1(event)" name="image" id="editActorImageFile" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="title" class="form-label">Actor Name</label>
                            <input type="text" class="form-control" name="actor" id="editActor" aria-describedby="title" required="">
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
    <script src="{{ asset('assets/js/actor_page.js') }}"></script>

    <script>
        // image Preview JS
        var loadFile = function(event) {
            var output = document.getElementById('actorImage');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
        };

        // edit image Preview JS
        var loadFile1 = function(event) {
            var output = document.getElementById('editActorImage');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
        };
    </script>
@endsection


@endsection
