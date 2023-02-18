@extends('layouts.app')
@section('content')
    {{-- <div class="page-heading">
        <h2 class="m-0">Dashboard</h2>
    </div> --}}
   
    <div class="page-content dashboard-page">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body d-flex">
                                <div class="card-left">
                                    <div class="card-top">
                                        <h4 class="font-semibold">Movies</h4>
                                        <h5 class="font-semibold">{{$movie}}</h5>
                                    </div>
                                    <div class="card-bottom">
                                        <a href="{{ url('contentList') }}" class="btn theme-bg text-white border-0 px-3 mt-2">View More</a>
                                    </div>
                                </div>
                                <div class="card-right">
                                    <div class="stats-icon">
                                        <i class="bi bi-chat-right-quote-fill fs-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body d-flex">
                                <div class="card-left">
                                    <div class="card-top">
                                        <h4 class="font-semibold"> Series </h4>
                                        <h5 class="font-semibold">{{$series}}</h5>
                                    </div>
                                    <div class="card-bottom">
                                        <a href="{{ url('contentList') }}" class="btn theme-bg text-white border-0 px-3 mt-2">View More</a>
                                    </div>
                                </div>
                                <div class="card-right">
                                    <div class="stats-icon">
                                        <i class="bi bi-bookmark-star-fill fs-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body d-flex">
                                <div class="card-left">
                                    <div class="card-top">
                                        <h4 class="font-semibold">TV Category</h4>
                                        <h5 class="font-semibold"> {{$tvCategory}} </h5>
                                    </div>
                                    <div class="card-bottom">
                                        <a href="{{ url('tvCategory') }}" class="btn theme-bg text-white border-0 px-3 mt-2">View More</a>
                                    </div>
                                </div>
                                <div class="card-right">
                                    <div class="stats-icon">
                                        <i class="bi bi-music-note-beamed fs-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body d-flex">
                                <div class="card-left">
                                    <div class="card-top">
                                        <h4 class="font-semibold">TV Channel</h4>
                                        <h5 class="font-semibold">{{$tvChannel}}</h5>
                                    </div>
                                    <div class="card-bottom">
                                        <a href="{{ url('tvChannel') }}" class="btn theme-bg text-white border-0 px-3 mt-2">View More</a>
                                    </div>
                                </div>
                                <div class="card-right">
                                    <div class="stats-icon">
                                        <i class="bi bi-youtube fs-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body d-flex">
                                <div class="card-left">
                                    <div class="card-top">
                                        <h4 class="font-semibold">Genre</h4>
                                        <h5 class="font-semibold"> {{ $genre }} </h5>
                                    </div>
                                    <div class="card-bottom">
                                        <a href="{{ url('genre') }}" class="btn theme-bg text-white border-0 px-3 mt-2">View More</a>
                                    </div>
                                </div>
                                <div class="card-right">
                                    <div class="stats-icon">
                                        <i class="bi bi-people-fill fs-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body d-flex">
                                <div class="card-left">
                                    <div class="card-top">
                                        <h4 class="font-semibold">Language</h4>
                                        <h5 class="font-semibold"> {{ $language }} </h5>
                                    </div>
                                    <div class="card-bottom">
                                        <a href="{{ url('language') }}" class="btn theme-bg text-white border-0 px-3 mt-2">View More</a>
                                    </div>
                                </div>
                                <div class="card-right">
                                    <div class="stats-icon">
                                        <i class="bi bi-people-fill fs-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body d-flex">
                                <div class="card-left">
                                    <div class="card-top">
                                        <h4 class="font-semibold">Actor</h4>
                                        <h5 class="font-semibold"> {{ $actor }} </h5>
                                    </div>
                                    <div class="card-bottom">
                                        <a href="{{ url('actors') }}" class="btn theme-bg text-white border-0 px-3 mt-2">View More</a>
                                    </div>
                                </div>
                                <div class="card-right">
                                    <div class="stats-icon">
                                        <i class="bi bi-people-fill fs-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body d-flex">
                                <div class="card-left">
                                    <div class="card-top">
                                        <h4 class="font-semibold">Users</h4>
                                        <h5 class="font-semibold">{{ $user }}</h5>
                                    </div>
                                    <div class="card-bottom">
                                        <a href="{{ url('user') }}" class="btn theme-bg text-white border-0 px-3 mt-2">View More</a>
                                    </div>
                                </div>
                                <div class="card-right">
                                    <div class="stats-icon">
                                        <i class="bi bi-people-fill fs-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
