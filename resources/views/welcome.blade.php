@extends('layouts.app_client')

@section('content')
<!-- Portfolio Grid Section -->
    <section id="portfolio" style="margin-top: 80px;">
        <div class="container">
                   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>

                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    @include('includes.flash')
                    <form method="post" class="form" action="{{route('client.login') }}" role="form">
                    {{ csrf_field() }}
                      <h3 align="center"><i class="fa fa-user"></i></h3>
                      <h2>Fred no believe me</h2>
                      <input type="email" name="email" required="true" class="form-control"><br/>
                      <button type="submit" class="btn btn-primary col-md-12 col-sm-12 col-xs-12 col-lg-12"> Start Exam</button>
                    </form>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
            </div>
        </div>
    </section>
@endsection
