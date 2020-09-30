@extends('theme.echuo.layout.main')

@section('main')

   <div class="container">
     


    <div class="row">
        <div class="col-md-7 mx-auto p-0 rounded  m-4 bg-white">
            <div class="text-black  w-100 py-1 px-3"> 
                <h1>Sign Up</h1>
            </div>
            <div class="p-3">
                <!-- Design sign up form -->
           @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                  <form action="{{route('user.store')}}" method="post" role="form"> @csrf
                        <hr />
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group {{ $errors->has('first_name')? 'has-error':'' }} ">
                                    <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" placeholder="First Name" tabindex="1">

                                    {!! $errors->has('first_name')? '<p class="help-block">'.$errors->first('first_name').'</p>':'' !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group {{ $errors->has('last_name')? 'has-error':'' }} ">
                                    <input type="text" name="last_name" id="last_name" class="form-control"  value="{{ old('last_name') }}" placeholder="Last Name" tabindex="2">
                                    {!! $errors->has('last_name')? '<p class="help-block">'.$errors->first('last_name').'</p>':'' !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('email')? 'has-error':'' }} ">
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="Email Address" tabindex="4">
                            {!! $errors->has('email')? '<p class="help-block">'.$errors->first('email').'</p>':'' !!}

                        </div>

                        <div class="form-group {{ $errors->has('phone')? 'has-error':'' }}">
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="Phone Number" tabindex="3">
                            {!! $errors->has('phone')? '<p class="help-block">'.$errors->first('phone').'</p>':'' !!}
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                 <div class="form-group {{ $errors->has('gender')? 'has-error':'' }}">
                                    <select id="gender" name="gender" class="form-control">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Fe-Male</option>
                                        <option value="third_gender">Third Gender</option>
                                    </select>
                                    {!! $errors->has('gender')? '<p class="help-block">'.$errors->first('gender').'</p>':'' !!}

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                               
                                <div class="form-group {{ $errors->has('country')? 'has-error':'' }}">
                                    <select id="country" name="country" class="form-control">
                                        <option value="">Select Designation</option>
                                        @foreach($designations as $designation)
                                            <option value="{{ $designation->id }}" {{ old('country') == $designation->id ? 'selected' :'' }}>{{ $designation->name }}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->has('country')? '<p class="help-block">'.$errors->first('country').'</p>':'' !!}
                                </div>
                            </div>
                        </div>


                     
                             
                       

                     
                       

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group {{ $errors->has('password')? 'has-error':'' }}">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" tabindex="5">
                                    {!! $errors->has('password')? '<p class="help-block">'.$errors->first('password').'</p>':'' !!}

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group {{ $errors->has('password_confirmation')? 'has-error':'' }}">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password" tabindex="6">
                                    {!! $errors->has('password_confirmation')? '<p class="help-block">'.$errors->first('password_confirmation').'</p>':'' !!}

                                </div>
                            </div>
                        </div>
                        <div class="row  {{ $errors->has('password')? 'has-error':'' }}">
                            <div class="col-xs-4 col-sm-3 col-md-3">
                    <span class="button-checkbox">
                        <label><input type="checkbox" name="agree" value="1" /> I Agree </label>
                    </span>
                            </div>
                            <div class="col-xs-8 col-sm-9 col-md-9">
                                By clicking <strong class="label label-primary">Register</strong>, you agree to the <a href="{{ route('single_page', 'terms-and-condition') }}" target="_blank">Terms and Conditions</a> set out by this site, including our Cookie Use.
                            </div>

                            <div class="col-sm-12">
                                {!! $errors->has('password')? '<p class="help-block">You must agree with terms and condition</p>':'' !!}
                            </div>
                        </div>

                        <hr />
                        <div class="row">
                            <div class="col-xs-12"><input type="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page-js')

@endsection
