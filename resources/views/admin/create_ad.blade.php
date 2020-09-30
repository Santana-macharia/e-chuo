@extends('layout.main')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('main')

    <div class="container">

        <div id="wrapper">

            @include('admin.sidebar_menu')

            <div id="page-wrapper">
                @if( ! empty($title))
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header"> {{ $title }}  </h1>
                        </div> <!-- /.col-lg-12 -->
                    </div> <!-- /.row -->
                @endif

                @include('admin.flash_msg')

                <div class="row">
                    <div class="col-md-10 col-xs-12">

                        <form action="" id="adsPostForm" class="form-horizontal" method="post" enctype="multipart/form-data"> @csrf

                     

                        <div class="form-group {{ $errors->has('ad_title')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label">School Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="ad_title" value="{{ old('ad_title') }}" name="ad_title" placeholder="@lang('app.property_name')">
                                {!! $errors->has('ad_title')? '<p class="help-block">'.$errors->first('ad_title').'</p>':'' !!}
                                <p class="text-info"> @lang('app.great_title_info')</p>
                            </div>
                        </div>

                         <div class="form-group {{ $errors->has('ad_title')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label">School Motto</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="ad_title" value="{{ old('motto') }}" name="motto" placeholder="School Motto">
                                {!! $errors->has('ad_title')? '<p class="help-block">'.$errors->first('ad_title').'</p>':'' !!}
                             
                            </div>
                        </div>


                        <div class="form-group {{ $errors->has('ad_description')? 'has-error':'' }}">
                            <label for="ad_description" class="col-sm-4 control-label">Location description</label>
                            <div class="col-sm-8">
                                <textarea name="ad_description" class="form-control" rows="8">{{ old('ad_description') }}</textarea>
                                {!! $errors->has('ad_description')? '<p class="help-block">'.$errors->first('ad_description').'</p>':'' !!}
                                <p class="text-info"> @lang('app.ad_description_info_text')</p>
                            </div>
                        </div>



                        <div class="form-group required {{ $errors->has('type')? 'has-error':'' }}">
                            <label class="col-md-4 control-label">Gender </label>
                            <div class="col-md-8">

                              

                                 @if($categories->count() > 0)
                                    @foreach($genders as $category)
                                        <label for="gender" class="radio-inline">
                                    <input type="radio" value="{{ $category->id}}"  name="gender" >
                                    {{ $category->name}}
                                </label>
                                    @endforeach
                                @endif

                             


                                {!! $errors->has('type')? '<p class="help-block">'.$errors->first('type').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('purpose')? 'has-error':'' }}">
                            <label for="c" class="col-sm-4 control-label">Sponsorship</label>
                            <div class="col-sm-8">
                                <select class="form-control select2NoSearch" name="sponsorship" id="sponsorship">
                                    @foreach($sponsorships as $category)
                                        <option value="{{ $category->id}}">{{ $category->name}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->has('sponsorship')? '<p class="help-block">'.$errors->first('sponsorship').'</p>':'' !!}
                            </div>
                        </div>

                         <div class="form-group {{ $errors->has('purpose')? 'has-error':'' }}">
                            <label for="c" class="col-sm-4 control-label">Accomadations</label>
                            <div class="col-sm-8">
                                <select class="form-control select2NoSearch" name="accomodation" id="sponsorship">
                                    @foreach($accomadations as $category)
                                        <option value="{{ $category->id}}">{{ $category->name}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->has('accomadation')? '<p class="help-block">'.$errors->first('accomadation').'</p>':'' !!}
                            </div>
                        </div>

                          <div class="form-group {{ $errors->has('purpose')? 'has-error':'' }}">
                            <label for="c" class="col-sm-4 control-label">Religious Affiliation</label>
                            <div class="col-sm-8">
                                <select class="form-control select2NoSearch" name="religion" id="sponsorship">
                                    @foreach($religions as $category)
                                        <option value="{{ $category->id}}">{{ $category->name}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->has('accomadation')? '<p class="help-block">'.$errors->first('religion').'</p>':'' !!}
                            </div>
                        </div>


                          <div class="form-group {{ $errors->has('purpose')? 'has-error':'' }}">
                            <label for="c" class="col-sm-4 control-label">Special Needs</label>
                            <div class="col-sm-8">
                                <select class="form-control select2NoSearch" name="needs" id="needs">
                                    @foreach($needs as $category)
                                        <option value="{{ $category->id}}">{{ $category->name}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->has('accomadation')? '<p class="help-block">'.$errors->first('needs').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('purpose')? 'has-error':'' }}">
                            <label for="c" class="col-sm-4 control-label">Curriculum</label>
                            <div class="col-sm-8">


                                <input type="text" class="form-control" id="ad_title" value="{{ old('curriculum') }}" name="curriculum" placeholder="Enter curriculum">
                                {!! $errors->has('ad_title')? '<p class="help-block">'.$errors->first('ad_title').'</p>':'' !!}
                           


                           

                            </div>
                        </div>

                          <div class="form-group {{ $errors->has('purpose')? 'has-error':'' }}">
                            <label for="c" class="col-sm-4 control-label">Category</label>
                            <div class="col-sm-8">
                                <select class="form-control select2NoSearch" name="category" id="category">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id}}">{{ $category->category_name}}</option>
                                    @endforeach
                                </select>
                                {!! $errors->has('category')? '<p class="help-block">'.$errors->first('category').'</p>':'' !!}
                            </div>
                        </div>

                          <div class="form-group {{ $errors->has('ad_title')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label">Average School Fees per term:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="ad_title" value="{{ old('ad_title') }}" name="fees" placeholder="School fees">
                                {!! $errors->has('ad_title')? '<p class="help-block">'.$errors->first('fees').'</p>':'' !!}
                            
                            </div>
                        </div>

                               <div class="form-group {{ $errors->has('ad_title')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label">Year of Establishment: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="ad_title" value="{{ old('yoe') }}" name="yoe" placeholder="Year of Establishment">
                                {!! $errors->has('yoe')? '<p class="help-block">'.$errors->first('yoe').'</p>':'' !!}
                                <p class="text-info"> e.g 2012</p>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('ad_title')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label">School mean: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="ad_title" value="{{ old('school_mean') }}" name="school_mean" placeholder="Year of Establishment">
                                {!! $errors->has('yoe')? '<p class="help-block">'.$errors->first('school_mean').'</p>':'' !!}
                                <p class="text-info"> e.g 2012</p>
                            </div>
                        </div>

                   
 <!-- 
                        <legend>@lang('app.amenities')</legend>

                        <div class="form-group type_checkbox">
                            <div class="col-sm-12">
                                @if($categories->count() > 0)
                                    @foreach($categories as $category)
                                        <label> <input type="checkbox" value="{{ $category->id }}" name="amenities[{{$category->id}}]"> {{ $category->category_name }} </label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
 -->

                       


                        <legend>Upload school logo</legend>

                        <div class="form-group {{ $errors->has('images')? 'has-error':'' }}">
                            <div class="col-sm-12">

                                <div id="uploaded-ads-image-wrap">

                                    @if($ads_images->count() > 0)
                                        @foreach($ads_images as $img)
                                            <div class="creating-ads-img-wrap">
                                                <img src="{{ media_url($img, false) }}" class="img-responsive" />
                                                <div class="img-action-wrap" id="{{ $img->id }}">
                                                    <a href="javascript:;" class="imgDeleteBtn"><i class="fa fa-trash-o"></i> </a>
                                                    <a href="javascript:;" class="imgFeatureBtn"><i class="fa fa-star{{ $img->is_feature ==1 ? '':'-o' }}"></i> </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>

                                <div class="file-upload-wrap">
                                    <label>
                                        <input type="file" name="images" id="images" style="display: none;" />
                                        <i class="fa fa-cloud-upload"></i>
                                        <p>@lang('app.upload_image')</p>

                                        <div class="progress" style="display: none;"></div>

                                    </label>
                                </div>
                                {!! $errors->has('images')? '<p class="help-block">'.$errors->first('images').'</p>':'' !!}
                                
                            </div>
                             <p class="text-info"> (Formats accepted are jpeg & png, image should not more than 4kbs)</p>
                        </div>




                        <legend>Location Info</legend>

                        <div class="form-group  {{ $errors->has('country')? 'has-error':'' }}">
                            <label for="category_name" class="col-sm-4 control-label">@lang('app.country')</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="county">
                                    <option value="">@lang('app.select_a_country')</option>

                                    @foreach($counties as $county)
                                        <option value="{{ $county->id }}" {{ old('county') == $county->id ? 'selected' :'' }}>{{ $county->name }}</option>
                                    @endforeach
                                </select>
                                {!! $errors->has('county')? '<p class="help-block">'.$errors->first('county').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group  {{ $errors->has('town')? 'has-error':'' }}">
                            <label for="category_name" class="col-sm-4 control-label">Town</label>
                            <div class="col-sm-8">
                                <input type="text"  class="form-control select2" id="town" name="town">
                                
                             
                            </div>
                        </div>

                           <div class="form-group {{ $errors->has('address')? 'has-error':'' }}">
                            <label for="address" class="col-sm-4 control-label">Postal code</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="address" name="code" placeholder="Postal code">
                                {!! $errors->has('address')? '<p class="help-block">'.$errors->first('address').'</p>':'' !!}
                          
                            </div>
                        </div>

                           <div class="form-group {{ $errors->has('address')? 'has-error':'' }}">
                            <label for="address" class="col-sm-4 control-label">@lang('app.address')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="address"  name="address" placeholder="@lang('app.address')">
                                {!! $errors->has('address')? '<p class="help-block">'.$errors->first('address').'</p>':'' !!}
                            
                            </div>
                        </div>

                    

                    

                       


                        <legend>@lang('app.seller_info')</legend>

                        <div style="display: none;" class="form-group {{ $errors->has('seller_name')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label">@lang('app.seller_name')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="seller_name" value="{{ old('seller_name')? old('seller_name') : $lUser->name }}" name="seller_name" placeholder="@lang('app.seller_name')">
                                {!! $errors->has('seller_name')? '<p class="help-block">'.$errors->first('seller_name').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('seller_email')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="email" value="{{ old('seller_email')? old('seller_email') : $lUser->email }}" name="email" placeholder="@lang('app.seller_email')">
                                {!! $errors->has('seller_email')? '<p class="help-block">'.$errors->first('seller_email').'</p>':'' !!}
                            </div>
                        </div>

                          <div class="form-group {{ $errors->has('seller_email')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label">Alternative Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="seller_email" value="" name="email1" placeholder="Alternative Email">
                                {!! $errors->has('seller_email')? '<p class="help-block">'.$errors->first('seller_email').'</p>':'' !!}
                            </div>
                        </div>


                        <div class="form-group {{ $errors->has('seller_phone')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label">Phone</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="seller_phone" value="{{ old('seller_phone') ? old('seller_phone') : $lUser->phone }}" name="seller_phone" placeholder="Alternative Email">
                                {!! $errors->has('seller_phone')? '<p class="help-block">'.$errors->first('seller_phone').'</p>':'' !!}
                            </div>
                        </div>

                           <div class="form-group {{ $errors->has('seller_phone')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label">Alternative Phone</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="seller_phone"  name="phone1" placeholder="Alternative Phone">
                                {!! $errors->has('phone1')? '<p class="help-block">'.$errors->first('seller_phone').'</p>':'' !!}
                            </div>
                        </div>

                          <div class="form-group {{ $errors->has('seller_phone')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label">Website</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="website"  name="website" placeholder="School Website">
                                {!! $errors->has('phone1')? '<p class="help-block">'.$errors->first('seller_phone').'</p>':'' !!}
                            </div>
                        </div>


                     



                        @if(get_option('ads_price_plan') != 'all_ads_free')



                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">@lang('app.payment_info')</h3>
                                </div>
                                <div class="panel-body">




                                    <div class="form-group {{ $errors->has('price_plan')? 'has-error':'' }}">
                                        <label for="price_plan" class="col-sm-4 control-label">@lang('app.price_plan')</label>
                                        <div class="col-sm-8">

                                            <div class="price_input_group">

                                                <label><input type="radio" value="regular" name="price_plan" data-price="{{ get_ads_price() }}"  />@lang('app.regular') </label> <br />

                                                <label><input type="radio" value="premium" name="price_plan" data-price="{{ get_ads_price('premium') }}" />@lang('app.premium') </label>

                                                <hr />
                                                <div class="addon-ad-charge">
                                                    <label><input type="checkbox" class="mark_ad_urgent" name="mark_ad_urgent" value="1" data-price="{{ get_option('urgent_ads_price')  }}" /> @lang('app.mark_as_urgent') </label>
                                                </div>

                                                <div class="well" id="price_summery" style="display: none;">
                                                    @lang('app.payable_amount') :
                                                    <span id="payable_amount">{{ get_option('regular_ads_price') }}</span>
                                                </div>


                                                {!! $errors->has('price_plan')? '<p class="help-block">'.$errors->first('price_plan').'</p>':'' !!}

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('payment_method')? 'has-error':'' }}">
                                        <label for="payment_method" class="col-sm-4 control-label">@lang('app.payment_method')</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2NoSearch" name="payment_method" id="payment_method">
                                                @if(get_option('enable_paypal') == 1)
                                                    <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected':'' }}>@lang('app.paypal')</option>
                                                @endif
                                                @if(get_option('enable_stripe') == 1)
                                                    <option value="stripe" {{ old('payment_method') == 'stripe' ? 'selected':'' }}>@lang('app.stripe')</option>
                                                @endif
                                            </select>
                                            {!! $errors->has('payment_method')? '<p class="help-block">'.$errors->first('payment_method').'</p>':'' !!}
                                        </div>
                                    </div>

                                </div>
                            </div>


                        @endif



                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-primary">@lang('app.save_new_ad')</button>
                            </div>
                        </div>
                        </form>

                    </div>

                </div>

            </div>   <!-- /#page-wrapper -->

        </div>   <!-- /#wrapper -->


    </div> <!-- /#container -->

@endsection

@section('page-js')
    <script src="https://maps.googleapis.com/maps/api/js?key={{get_option('google_map_api_key')}}&libraries=places&callback=initAutocomplete" async defer></script>

    <script>
        // This example adds a search box to a map, using the Google Place Autocomplete
        // feature. People can enter geographical searches. The search box will return a
        // pick list containing a mix of places and predicted search terms.

        function initAutocomplete() {
            var map = new google.maps.Map(document.getElementById('dvMap'), {
                center: {lat: {{ (get_option('default_latitude') != 'default_latitude' ) ? get_option('default_latitude') : 40.715 }}, lng: {{ (get_option('default_longitude') != 'default_longitude')? get_option('default_longitude') : -74.009 }} },
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            // Create the search box and link it to the UI element.
            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });

            //Click event for getting lat lng
            google.maps.event.addListener(map, 'click', function (e) {
                $('input#latitude').val(e.latLng.lat());
                $('input#longitude').val(e.latLng.lng());
            });

            var markers = [];
            // [START region_getplaces]
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function() {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    var icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };

                    // Create a marker for each place.
                    markers.push(new google.maps.Marker({
                        map: map,
                        icon: icon,
                        title: place.name,
                        position: place.geometry.location
                    }));

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
            // [END region_getplaces]
        }

    </script>

    <script>
        function generate_option_from_json(jsonData, fromLoad){
            //Load Category Json Data To Brand Select
            if (fromLoad === 'category_to_brand'){
                var option = '';
                if (jsonData.length > 0) {
                    option += '<option value="0" selected> <?php echo trans('app.select_a_brand') ?> </option>';
                    for ( i in jsonData){
                        option += '<option value="'+jsonData[i].id+'"> '+jsonData[i].brand_name +' </option>';
                    }
                    $('#brand_select').html(option);
                    $('#brand_select').select2();
                }else {
                    $('#brand_select').html('');
                    $('#brand_select').select2();
                }
                $('#brand_loader').hide('slow');
            }else if(fromLoad === 'country_to_state'){
                var option = '';
                if (jsonData.length > 0) {
                    option += '<option value="0" selected> @lang('app.select_state') </option>';
                    for ( i in jsonData){
                        option += '<option value="'+jsonData[i].id+'"> '+jsonData[i].state_name +' </option>';
                    }
                    $('#state_select').html(option);
                    $('#state_select').select2();
                }else {
                    $('#state_select').html('');
                    $('#state_select').select2();
                }
                $('#state_loader').hide('slow');

            }else if(fromLoad === 'state_to_city'){
                var option = '';
                if (jsonData.length > 0) {
                    option += '<option value="0" selected> @lang('app.select_city') </option>';
                    for ( i in jsonData){
                        option += '<option value="'+jsonData[i].id+'"> '+jsonData[i].city_name +' </option>';
                    }
                    $('#city_select').html(option);
                    $('#city_select').select2();
                }else {
                    $('#city_select').html('');
                    $('#city_select').select2();
                }
                $('#city_loader').hide('slow');
            }
        }

        $(document).ready(function(){
            $('[name="category"]').change(function(){
                var category_id = $(this).val();
                $('#brand_loader').show();

                $.ajax({
                    type : 'POST',
                    url : '{{ route('get_brand_by_category') }}',
                    data : { category_id : category_id,  _token : '{{ csrf_token() }}' },
                    success : function (data) {
                        generate_option_from_json(data, 'category_to_brand');
                    }
                });

/*                $.ajax({
                    type : 'POST',
                    url : '{{ route('get_category_info') }}',
                    data : { category_id : category_id,  _token : '{{ csrf_token() }}' },
                    success : function (data) {
                        if (data.category_slug == 'jobs'){
                            alert('Jobs');
                        }
                    }
                });
                */
            });


            $('[name="country"]').change(function(){
                var country_id = $(this).val();
                $('#state_loader').show();
                $.ajax({
                    type : 'POST',
                    url : '{{ route('get_state_by_country') }}',
                    data : { country_id : country_id,  _token : '{{ csrf_token() }}' },
                    success : function (data) {
                        generate_option_from_json(data, 'country_to_state');
                    }
                });
            });

            $('[name="state"]').change(function(){
                var state_id = $(this).val();
                $('#city_loader').show();
                $.ajax({
                    type : 'POST',
                    url : '{{ route('get_city_by_state') }}',
                    data : { state_id : state_id,  _token : '{{ csrf_token() }}' },
                    success : function (data) {
                        generate_option_from_json(data, 'state_to_city');
                    }
                });
            });

            $("#images").change(function() {
                var fd = new FormData(document.querySelector("form#adsPostForm"));
                //$('#loadingOverlay').show();
                $('.progress').show();
                $.ajax({
                    url : '{{ route('upload_ads_image') }}',
                    type: "POST",
                    data: fd,

                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                //console.log(percentComplete);

                                var progress_bar = '<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: '+percentComplete+'%">'+percentComplete+'% </div>';

                                if (percentComplete === 100) {
                                    $('.progress').hide();
                                }
                            }
                        }, false);

                        return xhr;
                    },

                    cache: false,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,   // tell jQuery not to set contentType
                    success : function (data) {
                        //$('#loadingOverlay').hide('slow');
                        if (data.success == 1){
                            $('#uploaded-ads-image-wrap').load('{{ route('append_media_image') }}');
                        } else{
                            toastr.error(data.msg, '<?php echo trans('app.error') ?>', toastr_options);
                        }
                    }
                });
            });


            $('body').on('click', '.imgDeleteBtn', function(){
                //Get confirm from user
                if ( ! confirm('{{ trans('app.are_you_sure') }}')){
                    return '';
                }

                var current_selector = $(this);
                var img_id = $(this).closest('.img-action-wrap').attr('id');
                $.ajax({
                    url : '{{ route('delete_media') }}',
                    type: "POST",
                    data: { media_id : img_id, _token : '{{ csrf_token() }}' },
                    success : function (data) {
                        if (data.success == 1){
                            current_selector.closest('.creating-ads-img-wrap').hide('slow');
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        }
                    }
                });
            });
            $('body').on('click', '.imgFeatureBtn', function(){
                var img_id = $(this).closest('.img-action-wrap').attr('id');
                var current_selector = $(this);

                $.ajax({
                    url : '{{ route('feature_media_creating_ads') }}',
                    type: "POST",
                    data: { media_id : img_id, _token : '{{ csrf_token() }}' },
                    success : function (data) {
                        if (data.success == 1){
                            $('.imgFeatureBtn').html('<i class="fa fa-star-o"></i>');
                            current_selector.html('<i class="fa fa-star"></i>');
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        }
                    }
                });
            });

            $(document).on('change', '.price_input_group', function(){
                var price = 0;

                var checkedValues = $('.price_input_group input:checked').map(function() {
                    return $(this).data('price');
                }).get();

                for( var i = 0; i < checkedValues.length; i++ ){
                    price += parseInt( checkedValues[i]); //don't forget to add the base
                }

                $('#payable_amount').text(price);
                $('#price_summery').show('slow');
            });


        });
    </script>


    <script>
        @if(session('success'))
            toastr.success('{{ session('success') }}', '<?php echo trans('app.success') ?>', toastr_options);
        @endif
    </script>
@endsection