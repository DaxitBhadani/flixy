@extends('layouts.app')

@section('content')
    <div class="page-content">
        <section class="actor_list">
            <div class="card">
                <div class="card-header card-header-border">
                    <h4 class="fw-normal m-0">User List [ {{ $user }} ] </h4>
                </div>
                <div class="card-body">
                    <table class="table" id="userTable">
                        <thead>
                            <tr>
                                <th width="70px">Profile</th>
                                <th> Name </th>
                                <th> Email </th>
                                <th> Totle Purchase </th>
                                <th> Status </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

 
 


@section('scripts')
    <script src="{{ asset('assets/js/user_page.js') }}"></script>
@endsection


@endsection
