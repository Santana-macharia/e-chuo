@extends('layout.main')

@section('main')

    <div class="container">

    <div id="wrapper">

        @include('admin.sidebar_menu')

        <div id="page-wrapper">

            @if(session('error'))
                <div class="row">
                    <div class="col-lg-12">
                        <br />
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@lang('app.dashboard')</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="huge">{{ $approved_ads }}</div>
                                    <div>@lang('app.approved_ads')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="huge">{{ $pending_ads }}</div>
                                    <div>@lang('app.pending_ads')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="huge">{{ $blocked_ads }}</div>
                                    <div>@lang('app.blocked_ads')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($ten_contact_messages)
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="huge">{{ $total_users }}</div>
                                    <div>@lang('app.users')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

           <!--      <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="huge">{{ $total_reports }}</div>
                                    <div>@lang('app.reports')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
 -->
           <!--      <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="huge">{{ $total_payments }}</div>
                                    <div>@lang('app.success_payments')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
<!-- 
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="huge">  {{ $total_payments_amount }} <sup>{{ get_option('currency_sign') }}</sup></div>
                                    <div>@lang('app.total_payment')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                @endif

            </div>
            <!-- /.row -->

                @if($lUser->is_admin())
            <div class="row">
                @if($ten_contact_messages)
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            @lang('app.latest_ten_contact_messages')
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>@lang('app.sender')</th>
                                    <th>@lang('app.message')</th>
                                </tr>

                                @foreach($ten_contact_messages as $message)
                                    <tr>
                                        <td>
                                            <i class="fa fa-user"></i> {{ $message->name }} <br />
                                            <i class="fa fa-envelope-o"></i> {{ $message->email }} <br />
                                            <i class="fa fa-clock-o"></i> {{ $message->created_at->diffForHumans() }}
                                        </td>
                                        <td>{{ $message->message }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                @endif

          
            </div>
            @endif



        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    </div> <!-- /#container -->
@endsection