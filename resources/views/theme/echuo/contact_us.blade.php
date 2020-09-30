@extends('theme.echuo.layout.main')

@section('main')

   <div class="container">
     
  @include('admin.flash_msg')

    <div class="row">
        <div class="col-md-8 mx-auto p-0 rounded border-theme m-4 bg-white">
            <div class="text-black w-100 py-1 px-3"> 
                <h4>Contact Us</h4>
            </div>
         

              <form class="p-3" action="" method="post"> @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('name')? 'has-error':'' }}">
                                    <label for="name">@lang('app.name')</label>
                                    <input type="text" class="form-control w-100 mb-4 py-4" id="name" name="name" placeholder="@lang('app.enter_name')" value="{{ old('name') }}" required="required" />
                                    {!! $errors->has('name')? '<p class="help-block">'.$errors->first('name').'</p>':'' !!}
                                </div>
                                <div class="form-group {{ $errors->has('email')? 'has-error':'' }}">
                                    <label for="email">@lang('app.email_address')</label>
                                    <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-envelope"></span>
                                </span>
                                        <input type="email" class="form-control w-100 mb-4 py-4" id="email" placeholder="@lang('app.enter_email_address')" name="email" value="{{ old('email') }}" required="required" />
                                    </div>
                                    {!! $errors->has('email')? '<p class="help-block">'.$errors->first('email').'</p>':'' !!}

                                </div>

                                <div class="form-group {{ $errors->has('message')? 'has-error':'' }}">
                                    <label for="name">@lang('app.message')</label>
                                    <textarea name="message" id="message" class="form-control w-100 mb-4 py-4" required="required" placeholder="@lang('app.message')">{{ old('message') }}</textarea>
                                    {!! $errors->has('message')? '<p class="help-block">'.$errors->first('message').'</p>':'' !!}
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary pull-right" id="btnContactUs"> @lang('app.send_message')</button>
                            </div>
                        </div>
                    </form>
        </div>
    </div>
</div>

@endsection

@section('page-js')


    <script>
        @if(session('success'))
        toastr.success('{{ session('success') }}', '<?php echo trans('app.success') ?>', toastr_options);
        @endif
    </script>
@endsection
