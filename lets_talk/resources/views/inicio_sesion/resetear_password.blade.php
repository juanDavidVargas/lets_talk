@extends('layouts.layout')
@section('title', 'Reset Password')
@section('content')

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <form class="login100-form validate-form" method="post" action="{{route('recovery_password')}}">
            @csrf
                <span class="login100-form-title p-b-26">
                    Recovery Password
                </span>

                <div class="wrap-input100 validate-input" data-validate="Username required">
                    <input class="input100" type="text" name="username" id="username">
                    <span class="focus-input100" data-placeholder="Username"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Question Security required">
                    <input class="input100" type="text" name="question" id="question">
                    <span class="focus-input100" data-placeholder="Question Security"></span>
                </div>

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn" type="submit">
                            Send
                        </button>
                    </div>
                </div>

                <div class="text-left p-t-50">
                    <span class="txt1">
                        <a class="txt2 text-white btn btn-primary" href="/login">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back
                        </a>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('scripts')
<script>

    $( document ).ready(function() {

        $("#username").trigger('focus');
    });

</script>
@endsection
