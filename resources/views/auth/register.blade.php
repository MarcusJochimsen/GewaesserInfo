@extends('common.base')

@section('head')
    <!-- NProgress -->
{{--    <link href="{{ asset('css/nprogress.css') }}" rel="stylesheet">--}}
    <!-- Animate.css -->
{{--    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">--}}

    <!-- Custom Theme Style -->
{{--    <link href="{{ asset('css/gentelella-custom.css') }}" rel="stylesheet">--}}
@endsection

@section('bottomScripts')
@endsection

@section('main')
    <div class="login">
        <div>
            <div class="login_wrapper">
                <div class="form">
                    <section class="login_content">
                        {{ Form::model('', ['url' => 'register']) }}
                            <h1>Create Account</h1>
                            <div>
                                <input type="text" name="name" class="form-control" placeholder="Name" required=""/>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div>
                                <input type="email" name="email" class="form-control" placeholder="Email" required=""/>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div>
                                <input type="password" name="password" class="form-control" placeholder="Password" required=""/>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Password repeat" required=""/>
                            </div>
                            <div>
                                {{ Form::submit('Submit', ['class' => 'btn btn-default submit']) }}
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <p class="change_link">Already a member ?
                                    <a href="{{ route('login') }}" class="to_register"> Log in </a>
                                </p>
                            </div>
                        {{ Form::close() }}
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
