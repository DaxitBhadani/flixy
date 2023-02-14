@extends('layouts.app')

@section('content')
    <div class="page-content">
        <section class="actor_list">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <form action="">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                                            <label for="imageUpload">
                                                <i data-feather="edit"></i>
                                            </label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview" style="background-image: url('../assets/img/default.png');"></div>
                                            {{-- <div id="imagePreview" style="background-image: url('../upload/user/{{ $data->image }}');"></div> --}}
                                        </div>
                                    </div>
                                    <button type="button" class="btn theme-bg text-white mt-3">Edit Profile</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>



@section('scripts')
    <script src="{{ asset('assets/js/user_page.js') }}"></script>
@endsection


@endsection
