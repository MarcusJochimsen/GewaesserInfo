@extends('common.base')

@section('head')
    <!-- NProgress -->
{{--    <link href="{{ asset('css/nprogress.css') }}" rel="stylesheet">--}}
    <!-- Animate.css -->
{{--    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">--}}

    <!-- Custom Theme Style -->
{{--    <link href="{{ asset('css/gentelella-custom.css') }}" rel="stylesheet">--}}
@endsection

@section('main')
    <div class="login">
        <div>
            <div class="login_wrapper">
                <div class="form">
                    <section class="login_content">
                        {{ Form::model('', ['url' => 'login']) }}
                            <h1>Login Form</h1>
                            <div>
                                <input type="email" name="email" class="form-control" placeholder="E-Mail" required=""/>
                            </div>
                            <div>
                                <input type="password" name="password" class="form-control" placeholder="Password" required=""/>
                            </div>
                            <div>
                                {{ Form::submit('Log in', ['class' => 'btn btn-default submit']) }}
                                <a class="reset_pass" href="{{ route('password.request') }}">Lost your password?</a>
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <p class="change_link">New to site?
                                    <a href="{{ route('register') }}" class="to_register"> Create Account </a>
                                </p>
                            </div>
                        {{ Form::close() }}
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
