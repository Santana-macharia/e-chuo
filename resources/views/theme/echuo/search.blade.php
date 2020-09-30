@extends('theme.echuo.layout.main2')

@section('main')
       
          <div class="breadcrumb-wrapper content_above">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1 class="page-title">Total Listing Found: {{ $ads->total() }}</h1>
                           
                    </div>
                </div>
            </div>
        </div><!-- ends: .breadcrumb-wrapper -->
    </section>
    <section class="all-listing-wrapper section-bg">
        <div class="container">
            <div class="row">
             
                <div class="col-lg-12 listing-items">
                    <div class="row">
                        <div class="col-lg-4 order-1 order-lg-0 mt-5 mt-lg-0">
                            <div class="listings-sidebar">
                                <div class="search-area default-ad-search">
                                    <form action="{{ route('search') }}" method="get">
                                        <div class="form-group">
                                            <input type="text" name="q" value="{{ request('q') }}" placeholder="What are you looking for?" class="form-control">
                                        </div><!-- ends: .form-group -->
                                        <div class="form-group">
                                            <div class="select-basic">
                                                <select name="category" class="form-control ad_search_category">
                                                    <option>Select Category</option>
                                                    @foreach($categories as $category)
                                                <option value="{{ $category->category_name }}" {{ request('category') == $category->id ? 'selected' :'' }}>{{ $category->category_name }}</option>
                                        @endforeach
                                                </select>
                                            </div>
                                        </div><!-- ends: .form-group -->
                                        <div class="form-group">
                                            <div class="position-relative">
                                                <select class="search_fields" name="county" id="at_biz_dir-location">
                                            <option value="">@lang('app.select_a_country')</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{ request('country') == $country->id ? 'selected' :'' }}>{{ $country->country_name }}</option>
                                            @endforeach
                                        </select>
                                            </div>
                                        </div><!-- ends: .form-group -->
                                        <!-- ends: .form-group -->
                                   
                              
                               
                                        <button type="submit" class="btn btn-gradient btn-gradient-two btn-block btn-icon icon-right m-top-40">Search Filter <span class="la la-long-arrow-right"></span></button> 
                                    </form><!-- ends: form -->
                                </div><!-- ends: .default-ad-search -->
                            </div>
                        </div><!-- ends: .col-lg-4 -->
                        <div class="col-lg-8 order-0 order-lg-1">
                            <div class="row">
                                <div class="col-lg-12">
                                       @foreach($ads as $ad)
                           <div class="atbd_single_listing atbd_listing_list">
                                        <article class="atbd_single_listing_wrapper">
                                            <figure class="atbd_listing_thumbnail_area">
                                                <div class="atbd_listing_image">
                                                    <a href="">
                                                        <img src="{{ media_url($ad->feature_img) }}" alt="listing image">
                                                    </a>
                                                </div><!-- ends: .atbd_listing_image -->
                                                <div class="atbd_thumbnail_overlay_content">
                                                    <ul class="atbd_upper_badge">
                                                        <li>
                                                             @if($ad->purpose)
                                                <span class="atbd_badge atbd_badge_featured"> {{ ucfirst($ad->purpose) }}</span>
                                            @endif

                                                           </li>
                                                    </ul><!-- ends .atbd_upper_badge -->
                                                </div><!-- ends: .atbd_thumbnail_overlay_content -->
                                            </figure><!-- ends: .atbd_listing_thumbnail_area -->
                                            <div class="atbd_listing_info">
                                                <div class="atbd_content_upper">
                                                    <h4 class="atbd_listing_title">
                                                        <a href="{{ route('single_school', $ad->slug) }}">{{ str_limit($ad->title, 40) }}</a>
                                                    </h4>
                                                    <p>
                                                        {{ str_limit(strip_tags($ad->description ), 80) }}
                                                    </p>
                                                    <div class="atbd_listing_meta">
                                                        <p><span class="la la-map-marker"></span>{{ $ad->city->city_name }} </p>
                                                        
                                                         <span class="atbd_meta atbd_badge_open"><p><span class="la la-calendar-check-o"></span> {{ $ad->created_at->diffForHumans() }} </p></span>
                                                       
                                                        <span class="atbd_meta atbd_listing_rating">View more</span>
                                                            
                                                      
                                                       
                                                    </div><!-- End atbd listing meta -->
                                                
                                                </div><!-- end .atbd_content_upper -->
                                           
                                            </div><!-- ends: .atbd_listing_info -->
                                        </article><!-- atbd_single_listing_wrapper -->
                                    </div>
                        @endforeach
                                </div><!-- ends: .col-lg-12 -->


                               
                             
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <nav class="navigation pagination d-flex justify-content-end" role="navigation">
                                        <div class="nav-links">
                                           
                                       
                                          
                                                {{ $ads->appends(request()->input())->links() }}

                                     
                                          

                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div><!-- ends: .col-lg-8 -->
                    </div>
                </div><!-- ends: .listing-items -->
            </div>
        </div>
    </section><!-- ends: .all-listing-wrapper -->

 
@endsection

@section('page-js')
  
@endsection