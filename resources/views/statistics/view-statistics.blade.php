@extends('layouts.app')

@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
  <div id="statistics-view">
    <div class = "container">
      <a href="{{ route('statistics-excel')}}">
        <button class="btn btn-default" style="float: right">Export Statistics to Excel</button>
      </a>
    </div>

        <div class = "container">
          <h2 class="col-md-12" style="padding-left:10%; padding-bottom:20px;"> Statistics of Application </h2>
          <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">
            <!-- Total Number of users -->
            <div class="col-sm-4">
            	<div class="well" style="background: rgb(103,194,220);">
                <h3 class="text-center">All App Users</h3>
                <h1 class="text-center">{{ $users }}</h1>
            	</div>
           </div>
           <!-- Number of Owners -->
           <div class="col-sm-4">
            <div class="well" style="background: rgb(253,192,47);">
               <h3 class="text-center">Number of Owners</h3>
               <h1 class="text-center">{{ $owners }}</h1>
            </div>
          </div>
          <!-- Number of Tenants -->
          <div class="col-sm-4">
           <div class="well" style="background: rgb(246,109,110);">
              <h3 class="text-center">Number of Tenants</h3>
              <h1 class="text-center">{{ $tenants }}</h1>
           </div>
         </div>
       </div>
     </div>

     <div class = "container">
       <h2 class="col-md-12" style="padding-left:10%; padding-bottom:20px;"> Statistics of Posts </h2>
       <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">
         <!-- Total Number of Apartments -->
         <div class="col-sm-4">
          <div class="well" style="background: rgb(103,194,220);">
             <h3 class="text-center">Apartment Posts</h3>
             <h1 class="text-center">{{ $houses }}</h1>
          </div>
          <div>Total Apartment Visitors: {{ $house_visitors }}</div>
        </div>
        <!-- Number of Trades -->
        <div class="col-sm-4">
         <div class="well" style="background: rgb(253,192,47);">
            <h3 class="text-center">Trade Posts</h3>
            <h1 class="text-center">{{ $trades }}</h1>
         </div>
         <div>Total Trade Visitors: {{ $trade_visitors }}</div>
       </div>
       <!-- Number of Blogs -->
       <div class="col-sm-4">
        <div class="well" style="background: rgb(246,109,110);">
           <h3 class="text-center">Blog Posts</h3>
           <h1 class="text-center">{{ $blogs }}</h1>
        </div>
      </div>
    </div>
  </div>

     <div class="container">
       <h2 class="col-md-12" style="padding-left:10%; padding-bottom:20px;"> Tenant Statistics </h2>
       <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">
         <div><h4><i class="fas fa-male" style=" padding-right: 5px;"></i> {{ $males_percent }}% Male (tenants)</h4></div>
          <div class="progress">
            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:{{ $males_percent  }}%"></div>
         </div>
      </div>

      <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">
         <div><h4><i class="fas fa-female" style=" padding-right: 5px;"></i> {{ $females_percent }}% Female (tenants)</h4></div>
          <div class="progress">
            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:{{ $females_percent }}% "></div>
         </div>
      </div>

    </div>

</div>
@endsection
