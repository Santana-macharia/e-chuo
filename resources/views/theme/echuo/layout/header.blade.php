<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from www.e-chuo.co.ke/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Jul 2020 17:05:26 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
  <!-- SEO Meta Tags -->

  <meta charset="UTF-8">
  <title>E-Chuo - Kenyan School Search</title>
  <meta name="description" content="Welcome to www.e-chuo.co.ke where you will find details of more than 5,000 Kenyan schools from across all 47 counties. Our aim is to help you choose the right school for your child, or if you are an educational facility, to offer essential information about your schools.">
  <link rel="canonical" href="index.html" />
  <meta name="keywords" content="e-chuo, schools, nursery, kindergarten, high school, kenyan schools, education, system">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CDN LINKS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
 
  <!-- jQuery library -->
  <script src="../ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="{{ asset('assets/echuo1/css/styles.css') }}">
  <script src="{{ asset('assets/echuo1/js/main.js') }}"></script>
  <script src="{{ asset('assets/echuo1/js/script.js') }}"></script>
 <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
     <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/echuo/bootstrap-4.1.3/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/echuo/bootstrap-4.1.3/dist/css/pricing.css') }}" rel="stylesheet">

  <link rel="icon" href="{{ asset('assets/echuo1/images/pngtree-books-logo-image_79985.jpg') }}">
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-167875056-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-167875056-1');
  </script>

</head>

<body>


    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
      <h5 class="my-0 mr-md-auto font-weight-normal">
        
          <a  href="{{ route('home') }}" >
                                            @if(get_option('logo_settings') == 'show_site_name')
                                            {{ get_option('site_name') }}
                                            @else
                                            @if(logo_url())
                                            <img src="{{ logo_url() }}" alt="logo image" class="img-fluid" >
                                            @else
                                            {{ get_option('site_name') }}
                                            @endif
                                            @endif

                                        </a>
      </h5>
      <nav class="my-2 my-md-0 mr-md-3">
       <a class="p-2 text-dark" href="{{ route('home') }}">Search School</a>
         <?php
                $header_menu_pages = \App\Post::whereStatus('1')->where('show_in_header_menu', 1)->get();
                ?>
                @if($header_menu_pages->count() > 0)
                    @foreach($header_menu_pages as $page)
                      <a class="p-2 text-dark" href="{{ route('single_page', $page->slug) }}">{{ $page->title }} </a>
                    @endforeach
                @endif
        <a class="p-2 text-dark" href="{{ route('blog') }}">Blog</a>
        <a class="p-2 text-dark" href="{{ route('contact_us_page') }}">Contact Us</a>
          @if(Auth::check())
             
                            <a class="p-2 text-dark" href="{{ route('dashboard') }}">Dashboard</a>           

                                        @else
                                 <a class="p-2 text-dark" href="{{ route('login') }}">Sign In</a>     
                                        @endif
        
      </nav>
      <a class="btn btn-outline-primary" href="{{ route('create_ad') }}">List School</a>

    
   
                                  
    </div>




 