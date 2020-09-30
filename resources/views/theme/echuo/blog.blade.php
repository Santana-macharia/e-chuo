@extends('theme.echuo.layout.main')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('main')



       <div class="container">
   

 

     

      <div class="row mb-2">

      
      

         @foreach($posts as $post)


           <div class="col-md-6">
          <div class="card flex-md-row mb-4 shadow-sm h-md-250">
            <div class="card-body d-flex flex-column align-items-start">
              <strong class="d-inline-block mb-2 text-success"> @if($post->author)
                                            <p class="author-category"  itemprop="author" itemscope itemtype="https://schema.org/Person">By <a href="{{ route('author_blog_posts', $post->author->id) }}"  itemprop="name">{{ $post->author->name }}</a></p>
                                        @endif</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="{{ route('blog_single', $post->slug) }}">{{ $post->title }}</a>
              </h3>
              <div class="mb-1 text-muted">{{ $post->created_at_datetime() }}</div>
              <p class="card-text mb-auto">{{ str_limit(strip_tags($post->post_content), 250) }}</p>
              <a href="{{ route('blog_single', $post->slug) }}">Continue reading</a>
            </div>
           
             @if($post->feature_img)
                                                <img class="card-img-right flex-auto d-none d-lg-block" alt="{{ $post->title }}" data-src="{{ media_url($post->feature_img) }}">
                                            @else
                                                <img class="card-img-right flex-auto d-none d-lg-block" alt="{{ $post->title }}" data-src="{{ asset('uploads/placeholder.png') }}">
                                            @endif
          </div>
        </div>



                  
                @endforeach


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