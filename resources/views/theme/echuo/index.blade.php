@extends('theme.echuo.layout.main')

@section('main')

<div class="container">
  <div class="">

    <div class="px-5 m-1">




   <!--    <h1 style="font-family:'Brush Script MT'; color:#040c7a;">{{ get_option('modern_home_left_title') }}</h1> -->
        <p>{{ get_option('modern_home_left_content') }}</p>
    </div>


    <!-- Design search bar -->
    <div class="row px-5">
      <div class="col-md-4">
        <form action="{{ route('search') }}" method="GET">
          <div class="row">
            <div class="col-md-8">
              <input type="text" class="form-control w-100 m-1" name="q" placeholder="Search school here" />
            </div>

               <div class="col-md-4">
              <input type="submit" class="btn btn-theme w-100 text-white m-1"  value="Submit">
            </div>


        
          </div>
        </form>
    
      </div>





      <div class="col-md-8">
       <form action="{{ route('search') }}" method="GET">
          <!-- category -->
          <div class="row">


           <div class="col-md-4">
            <!-- county -->
              <select name="category" class="form-control w-100 m-1">
               <option value="">Category</option>
               @foreach($categories as $category)
               <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' :'' }}>{{ $category->category_name }}</option>
               @endforeach
             </select>
          </div>



          
           <div class="col-md-4">
            <!-- county -->
            <select name="sponsorship" class="form-control w-100 m-1">
              <option value="">Sponsorship</option>
              @foreach($sponsorships as $sponsorship)
              <option value="{{ $sponsorship->id }}" {{ request('sponsorship') == $sponsorship->id ? 'selected' :'' }}>{{ $sponsorship->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-4">
            <!-- county -->
            <select name="county" class="form-control w-100 m-1">
              <option value="">County</option>
              @foreach($counties as $county)
              <option value="{{ $county->id }}" {{ request('counties') == $county->id ? 'selected' :'' }}>{{ $county->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <span id="hideForm">
          <div class="row">
            <div class="col-md-4">
              <select name="special_needs" class="form-control w-100 m-1">
                <option value="">Special Need</option>
                <option value="1">None</option>
                <option value="2">Sensory impared</option>
                <option value="3">Developmental</option>
                <option value="4">Physical</option>
                <option value="5">Behaviorial/emotional</option>
              </select>
            </div>
            <div class="col-md-4">
              <select name="accomodation" class="form-control w-100 m-1">
                <option value="">Accomodation</option>
                <option value="1">Day</option>
                <option value="2">Boarding</option>
                <option value="3">Both</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <select name="gender" class="form-control w-100 m-1">
                <option value="">Gender</option>
                <option value="1">Mixed</option>
                <option value="2">Male</option>
                <option value="3">Female</option>
              </select>
            </div>
            <div class="col-md-4">
              <!-- county -->
              <select name="religion" class="form-control w-100 m-1">
                <option value="">Religious Affiliation</option>
                <option value="1">None</option>
                <option value="2">Christianity</option>
                <option value="3">Islam</option>
                <option value="4">Hinduism</option>
                <option value="5">Sikhism</option>
                <option value="6">Buddhism</option>
                <option value="7">Judaism</option>
                <option value="8">Other</option>
              </select>
            </div>
          </div>
        </span>
        <div class="row">
          <div class="col-md-4">
            <p id='More' class="btn btn-warning w-100 m-1" onclick="return display_adv();">Advanced Search</p>
            <p id='Less' class="btn btn-warning w-100 m-1" onclick="return hide_adv();">Hide</p>
          </div>
          <div class="col-md-4">
            <input type="submit" class="btn btn-theme w-100 text-white m-1" name='adv-search' value="FIND">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<hr>

   <div class="listingTopFilterBar">

                            <span class="totalFoundListingTop">{{ $title}}<!--  >> @lang('app.total') <strong>{{ $ads->total() }}</strong> @lang('app.ads_founds') --> 



 @if($cat){{$cat}}@endif
 @if($sponsor), {{$sponsor}}@endif
 @if($county_name), {{$county_name}}@endif
 @if($needs), {{$needs}}@endif
 @if($accomodation), {{$accomodation}}@endif
 @if($gender), {{$gender}}@endif
 @if($religion), {{$religion}}@endif

                            </span>

                         
                        </div>

   @if($ads->total() > 0)





@foreach($ads as $ad)
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

<div class="row mx-3 my-5">
  <div class="col-md-10 mx-auto">
    <a href="{{ route('single_school', $ad->id) }}">  <h5 class="cap"><img style="width:60px;" src="{{ media_url($ad->feature_img) }}" alt="School Logo"> {{ str_limit($ad->name, 40) }}</h5></a>
    <i style="font-size:16px;">{{ $ad->motto }}</i>
    <p class="cap">
      <!-- Address -->

      <b>P.O BOX:</b> {{ $ad->address }} {{ $ad->code }}, {{ $ad->town }},  @foreach($counties as $county)
      {{ $county->name }} 
      @endforeach.

      <!-- Gender -->
      @if($ad->gender)
      <b>Gender:</b> @foreach($genders as $gender)
      {{ $gender->name }} 
      @endforeach,
      @endif

     

      <!-- Accomodation -->
      <b>Accomodation:</b> @foreach($accomodations as $accomodation)
      {{ $accomodation->name }} 
      @endforeach,

      <!-- Religious Affiliation-->
      <b>Religious Affiliation:</b> @foreach($religions as $religion)
      {{ $religion->name }} 
      @endforeach,                    
      <!-- Special Needs -->
      <b>Special Needs:</b> @foreach($special_needs as $special_need)
      {{ $special_need->name }} 
      @endforeach,                     
      <!-- Contacts -->
      <b>Contacts:</b> {{ $ad->phone  }}, {{ $ad->phone1 }},

      <!-- Email -->
      <b>Email: </b> {{ $ad->email  }}                    
     
      <!-- Website -->
      
      @if($ad->website)
      <b>Website:</b> <a href="{{ $ad->website  }}" target="_blank">{{ $ad->website  }}</a>,
      @endif
     

      <!-- Fees -->

      <!-- Sponsorship -->
      <b>Sponsorship:</b> @foreach($sponsorships as $sponsorship)
      {{ $sponsorship->name }} 
      @endforeach,

      <!-- Category -->
     

        @if($ad->category)
     <!-- Category -->
      <b>Category:</b> @foreach($categories as $category)
      {{ $category->category_name }} 
      @endforeach,
      @endif

      <!-- Curriculumn -->
     

       @if($ad->curriculum)
      <b>Curriculum:</b> @foreach($curriculums as $curriculum)
      {{ $curriculum->name }} 
      @endforeach
      @endif

    .</p>
    <a style="width:10%;" class="btn-secondary my-2 p-2 rounded text-white" href="{{ route('single_school', $ad->id) }}">View More</a>
  </div>
</div>                
@endforeach
<hr>

<div class="row mx-3 my-5">
  <div class="col-md-10 mx-auto">
   <ul class="pagination mx-3">
    {{ $ads->appends(request()->input())->links() }}
  </ul>    
</div>
</div>  



                    @else
                        <div class="alert alert-warning">
                            <h2><i class="fa fa-info-circle"></i> @lang('app.search_not_found') </h2>
                        </div>
                    @endif



</div>


@endsection

@section('page-js')

@endsection
