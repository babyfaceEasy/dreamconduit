@extends('layouts.app_client')

@section('content')
    <!-- Portfolio Grid Section -->
<section id="portfolio" style="margin-top: 80px;">
    <div class="container">
         <div class="row">
            <div class="col-md-1"></div>
                <div class="col-md-9">
                    <div class="well" style="padding:10px">
                        <p class="text-center"  style="padding: 5px;">
                            Name: <b>{{ Auth::user()->name }}</b><br>
                            Time: <b>{{ $exam_data->time }} Mins</b>
                        </p>
                        
                            <!-- <b style="padding: 5px; padding-bottom: 10px;">ATTENTION! ATTENTION!! ATTENTION!!!</b><br>

                            Please read the below instructions and guidelines before starting the test.
                            <br> -->
                            <!-- This is where the instructions go -->
                            <!--<div class="panel panel-default">
                            	<div class="panel-body"> -->
                            	{!! $exam_data->instruction !!}
                            	<!-- </div>
                            </div>-->

                        
                        <a href="{{route('candidate.exam.questions')}}" class="btn btn-success btn-block" style="margin-bottom: 10px;">START EXAM</a>
                        <a href="{{ url('/candidate/logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();" class="btn btn-default btn-block">Logout</a> 
                    <button class="btn btn-default" style="margin-top: 10px; background-color:#423562; color: #fff;"><a href="#" style="color: #fff">Back</a></button>
                    </div>
                </div>
                <div class="col-md-2"></div>
            
        </div>
    </div>
</section>

@endsection
