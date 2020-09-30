@extends('theme.echuo.layout.main')
@section('page-css')

@endsection
@section('main')


<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
  <h3>{{ str_limit($ad->name, 40) }}</h1>
  <p class="lead">Motto: {{ $ad->motto }}</p>
</div>
  <?php
  $counties = \App\County::select('name')->whereId($ad->county)->get();
  $categories = \App\Category::select('category_name')->whereId($ad->category)->get();
  $genders = \App\Gender::select('name')->whereId($ad->gender)->get();
  $accomodations = \App\Accomodation::select('name')->whereId($ad->accomodation)->get();
  $religions = \App\Religion::select('name')->whereId($ad->religion)->get();
  $special_needs = \App\Special_need::select('name')->whereId($ad->needs)->get();
  $sponsorships = \App\Sponsorship::select('name')->whereId($ad->sponsorship)->get();
  $curriculums = \App\Curriculum::select('name')->whereId($ad->curriculum)->get();


  ?>
<div class="container">
  <div class="card-deck mb-3 text-center">
      <div class="card mb-4 shadow-sm">
          <div class="card-header">
            <img style="width:200px;" src="{{ media_url($ad->feature_img) }}" alt="School Logo">
            <h4 class="my-0 font-weight-normal">School Description</h4>
        </div>
        <div class="card-body">

         
          <p><b>Category: </b> @foreach($categories as $category)
              {{ $category->category_name }} 
          @endforeach</p> 
      </div>
  </div>


  <div class="card mb-4 shadow-sm">
      <div class="card-header">

        <h4 class="my-0 font-weight-normal">School Info</h4>
    </div>
    <div class="card-body">

        <ul class="list-unstyled mt-3 mb-4">
          
                <p><b>Gender: </b>@foreach($genders as $gender) {{ $gender->name }}  @endforeach </p> 
                <p><b>Year of Establishment: </b> {{ $ad->yoe }}</p> 
           
                           
          <p><b>Accomodation: </b>@foreach($accomodations as $accomodation)
              {{ $accomodation->name }} 
          @endforeach</p>            
          <p><b>Religion: </b>@foreach($religions as $religion)
              {{ $religion->name }} 
          @endforeach</p>            
          <p><b>Special Needs: </b>@foreach($special_needs as $special_need)
              {{ $special_need->name }} 
          @endforeach</p>  
          <p><b>Sponsorship: </b>@foreach($sponsorships as $sponsorship)
              {{ $sponsorship->name }} 
          @endforeach</p></p>         
          <p><b>Curriculum: </b>@foreach($categories as $category)
              {{ $category->category_name }} 
          @endforeach</p></p> 

            <p><b>Average School Fees per term: </b> {{ $ad->fees }}</p> 
      </ul>

  </div>
</div>
<div class="card mb-4 shadow-sm">
  <div class="card-header">
    <h4 class="my-0 font-weight-normal">Contact Info</h4>
</div>
<div class="card-body">

    <ul class="list-unstyled mt-3 mb-4">
           <p><b>Postal Address: </b> {{ $ad->address  }}</p>  
           <p><b>Postal Code: </b> {{ $ad->code }}</p>    
           <p><b>County: </b> @foreach($counties as $category) {{ $category->name }}  @endforeach}</p>         
           <p><b>Town/Estate: </b> {{ $ad->town }}</p> 
           <p><b>Directions: </b> {{ $ad->description }}</p>      
       <p><b>Contact Mobile 1: </b> {{ $ad->phone }}</p> 
        <p><b>Contact Mobile 2: </b> {{ $ad->phone1 }}</p> 
         <p><b>Contact Email 1: </b> {{ $ad->email }}</p> 
          <p><b>Contact Email 2: </b> {{ $ad->email1 }}</p> 
           <p><b>School Website:: </b> {{ $ad->website  }}</p> 
   <!--  <p><b>Directions: </b>{{ $ad->address }} {{ $ad->code }}, {{ $ad->town }}, @foreach($counties as $category)
          {{ $category->name }} 
      @endforeach
    </p>  -->

  </ul>
  <a href="{{ route('home') }}" type="button" class="btn btn-lg btn-block btn-outline-primary">New Search</a>
</div>
</div>

</div>




</div>

<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">

  <div class="modern-social-share-btn-group">
    <h4>@lang('app.share_this_ad')</h4>
    <a href="javascript:;" class="btn btn-default shareEmbedded"  data-toggle="modal" data-target="#shareEmbedded"><i class="fa fa-code"></i> </a>
    <a href="#" class="btn btn-default share s_facebook"><i class="fab fa-facebook-f"></i>  <img src="https://simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" /></a>
    <a href="#" class="btn btn-default share s_twitter"><i class="fa fa-twitter"></i>  <img src="https://simplesharebuttons.com/images/somacro/twitter.png" alt="Twitter" /></a>
    <a href="#" class="btn btn-default share s_linkedin"><i class="fa fa-linkedin"></i> <img src="https://simplesharebuttons.com/images/somacro/linkedin.png" alt="LinkedIn" /></a>
</div>


</div>
<!--Facebook-->






@endsection

@section('page-js')

<script src="https://maps.googleapis.com/maps/api/js?key={{get_option('google_map_api_key')}}&libraries=places&callback=initMap" async defer></script>
<script type="text/javascript">
    function initMap() {
        var myLatLng = {lat: {{$ad->latitude}}, lng: {{$ad->longitude}} };

        var map = new google.maps.Map(document.getElementById('dvMap'), {
            center: myLatLng,
            zoom: 15
        });
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: '{{$ad->title}}'
        });
        marker.setMap(map);
    }

</script>

<script src="{{ asset('assets/plugins/fotorama-4.6.4/fotorama.js') }}"></script>
<script src="{{ asset('assets/plugins/SocialShare/SocialShare.js') }}"></script>
<script src="{{ asset('assets/plugins/form-validator/form-validator.min.js') }}"></script>

<script>
    $('.share').ShareLink({
            title: '{{ $ad->title }}', // title for share message
            text: '{{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags($ad->description) )),0,160) }}', // text for share message

            @if($ad->media_img->first())
            image: '{{ media_url($ad->media_img->first(), true) }}', // optional image for share message (not for all networks)
            @else
            image: '{{ asset('uploads/placeholder.png') }}', // optional image for share message (not for all networks)
            @endif
            url: '{{ route('single_ad', $ad->slug) }}', // link on shared page
            class_prefix: 's_', // optional class prefix for share elements (buttons or links or everything), default: 's_'
            width: 640, // optional popup initial width
            height: 480 // optional popup initial height
        })
    </script>
    <script>
        $.validate();
    </script>

    <script>
        $(function(){
            $('#onClickShowPhone').click(function(){
                $('#ShowPhoneWrap').html('<i class="fa fa-phone"></i> {{ $ad->seller_phone }}');
            });

            $('#save_as_favorite').click(function(){
                var selector = $(this);
                var slug = selector.data('slug');

                $.ajax({
                    type : 'POST',
                    url : '{{ route('save_ad_as_favorite') }}',
                    data : { slug : slug, action: 'add',  _token : '{{ csrf_token() }}' },
                    success : function (data) {
                        if (data.status == 1){
                            selector.html(data.msg);
                        }else {
                            if (data.redirect_url){
                                location.href= data.redirect_url;
                            }
                        }
                    }
                });
            });

            $('button#report_ad').click(function(){
                var reason = $('[name="reason"]').val();
                var email = $('[name="email"]').val();
                var message = $('[name="message"]').val();
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

                var error = 0;
                if(reason.length < 1){
                    $('#reason_info').html('<p class="text-danger">Reason required</p>');
                    error++;
                }else {
                    $('#reason_info').html('');
                }
                if(email.length < 1){
                    $('#email_info').html('<p class="text-danger">Email required</p>');
                    error++;
                }else {
                    if ( ! regex.test(email)){
                        $('#email_info').html('<p class="text-danger">Valid email required</p>');
                        error++;
                    }else {
                        $('#email_info').html('');
                    }
                }
                if(message.length < 1){
                    $('#message_info').html('<p class="text-danger">Message required</p>');
                    error++;
                }else {
                    $('#message_info').html('');
                }

                if (error < 1){
                    $('#loadingOverlay').show();
                    $.ajax({
                        type : 'POST',
                        url : '{{ route('report_ads_pos') }}',
                        data : { reason : reason, email: email,message:message, slug:'{{ $ad->slug }}',  _token : '{{ csrf_token() }}' },
                        success : function (data) {
                            if (data.status == 1){
                                toastr.success(data.msg, '@lang('app.success')', toastr_options);
                            }else {
                                toastr.error(data.msg, '@lang('app.error')', toastr_options);
                            }
                            $('#reportAdModal').modal('hide');
                            $('#loadingOverlay').hide();
                        }
                    });
                }
            });

            $('#replyByEmailForm').submit(function(e){
                e.preventDefault();
                var reply_email_form_data = $(this).serialize();

                $('#loadingOverlay').show();
                $.ajax({
                    type : 'POST',
                    url : '{{ route('reply_by_email_post') }}',
                    data : reply_email_form_data,
                    success : function (data) {
                        if (data.status == 1){
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        }else {
                            toastr.error(data.msg, '@lang('app.error')', toastr_options);
                        }
                        $('#replyByEmail').modal('hide');
                        $('#loadingOverlay').hide();
                    }
                });
            });

            $(document).on('change past keyup', '#embedded_width', function(){
                var width = $(this).val();
                var height = $('#embedded_height').val();
                $('iframe').css('width', width+'px');

                var iframe_code = '<iframe src="http://localhost/real-estate/source/embedded/2-beds-nice-apertment-in-ny-united-states" style="border:0;width:'+width+'px;height:'+height+'px;"></iframe> ';

                $('#embedded_code').val(iframe_code);
            });
            $(document).on('change past keyup', '#embedded_height', function(){
                var height = $(this).val();
                var width = $('#embedded_width').val();
                $('iframe').css('height', height+'px');

                var iframe_code = '<iframe src="http://localhost/real-estate/source/embedded/2-beds-nice-apertment-in-ny-united-states" style="border:0;width:'+width+'px;height:'+height+'px;"></iframe> ';

                $('#embedded_code').val(iframe_code);
            });

        });
    </script>
    @endsection