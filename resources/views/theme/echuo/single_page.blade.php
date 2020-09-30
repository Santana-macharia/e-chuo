@extends('theme.echuo.layout.main')

@section('main')



    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page_wrapper page-{{ $page->id }}">
                    {!! $page->post_content !!}

                </div>
            </div>
        </div>
    </div>


@endsection

@section('page-js')

@endsection
