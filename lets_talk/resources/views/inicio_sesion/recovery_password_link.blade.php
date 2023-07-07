@extends('layouts.layout')
@section('title', 'Recovery Pass Link')

{{-- =============================== --}}
{{-- =============================== --}}

@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="post" action="{{route('recovery_password_post')}}" autocomplete="off">
                @csrf
                    <span class="login100-form-title p-b-26">
                        Password Recovery Form
                    </span>

                    {{-- ================================== --}}

                    {{-- @php
                        dd($id);
                    @endphp --}}

                    {{-- ================================== --}}

                    
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="new_pass" id="new_pass">
                        <span class="focus-input100" data-placeholder="New Password"></span>
                    </div>
                    
                    {{-- ================================== --}}
                    
                    <div class="wrap-input100 validate-input" data-validate="Confirm Password is required">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="confirm_new_pass" id="confirm_new_pass">
                        <span class="focus-input100" data-placeholder="Confirm New Password"></span>
                    </div>
                    
                    {{-- ================================== --}}

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <button class="login100-form-btn" type="submit">Send</button>
                        </div>
                    </div>

                    {{-- <div class="text-left p-t-50">
                        <span class="txt1">
                            <a class="txt2 text-white btn btn-primary" href="/">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
                            </a>
                        </span>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>
@stop

{{-- =============================== --}}
{{-- =============================== --}}

@section('scripts')
    <script>
        $( document ).ready(function() {
            $("#new_pass").trigger('focus');
        });

        let newPassWord = $('#new_pass').val();
        let confirmNewPassWord = $('#confim_new_pass').val();

        // if (newPassWord != confirmNewPassWord) {
            
        // } else {
            
        // }

        // console.log(newPassWord);
        // console.log(confirmNewPassWord);


    </script>
@endsection
