@extends('theme.echuo.layout.main')

@section('main')

   <div class="container">
        <div class="row">
        <div class="col-md-7 mx-auto p-0 rounded  m-4 bg-white">
            <div class="text-black  w-100 py-1 px-3"> 
                <h1>Login</h1>
            </div>
            <div class="p-3">
                <!-- Design login form -->
               @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                      @if(session('registration_success'))
                        <div class="alert alert-success">{!! session('registration_success') !!}</div>
                    @endif
<br>
             

                  <form action="" class="loginForm" method="post" autocomplete="off"> @csrf

                                <div class="input-group {{ $errors->has('email')? 'has-error':'' }}">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="email address">

                                </div>
                                {!! $errors->has('email')? '<p class="help-block">'.$errors->first('email').'</p>':'' !!}
                                <span class="help-block"></span>
<br>
                                <div class="input-group {{ $errors->has('password')? 'has-error':'' }}">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input  type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                                {!! $errors->has('password')? '<p class="help-block">'.$errors->first('password').'</p>':'' !!}
<br>
                                <span class="help-block"></span>
                                <button class="btn-theme p-2 text-white rounded w-100" type="submit">Login</button>
                            </form>

                            <br>
                    <p>New here? <a href="{{ route('user.create') }}"> Create an account</a></p>

                    <p>Forgot password? <a id="forgotPasswordEmail" href="#"> Click here</a></p>
                   
            </div>
        </div>
    </div>



    <div class="modal fade" id="forgotPasswordEmail" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form action="{{route('send_reset_link')}}" method="post"> @csrf

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">@lang('app.enter_email_to_reset_password')</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="email" class="control-label">@lang('app.email'):</label>
                            <input type="text" class="form-control" id="email" name="email">
                            <div id="email_info"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
                        <button type="submit" class="btn btn-primary" id="send_reset_link">@lang('app.send_reset_link')</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection

@section('page-js')

@endsection
