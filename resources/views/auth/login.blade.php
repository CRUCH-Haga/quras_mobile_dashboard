@extends('layouts.app')

@section('content')
<section id="content" class="parallax-section">
    <form method="post" id="signin-form" action="{{ route('login') }}">
        <div class="container">
            <div class="row">
                <div id="contect-box">
                    <h3>{{trans('login.page-title')}}</h3>
                    <hr align="left">
                    <p>{{trans('login.warning')}}</p>
                    <div class="main-content">
                        <div class="col-lg-8 row">
                            {{ csrf_field() }}
                            <input name="email" type="email" class="form-control" id="email" placeholder="{{ trans('login.email-input') }}" value="{{old('email')}}">
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                            <input name="password" type="password" class="form-control" id="password" placeholder="{{ trans('login.password-input') }}" value="">
                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                       </div>
                    </div>
                    <div class="explain">
                        <!--<p>{{trans('login.description-04')}}</p>-->
                        <a href="https://ico.quras.io/password/reset">{{trans('login.forgot_password') }}</a>
                    </div>
                    <div class="button-row">
                        <div class="buttons">
                            <input type="hidden" name="remember" value="1">
                            <button type="submit" class="btn btn-danger" id="signin-btn">{{trans('buttons.signin')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
