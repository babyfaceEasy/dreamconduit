@extends('layouts.app_client')

@section('content')
<section id="portfolio" style="margin-top: 80px;">
<div class="container">
    <div class="row">
<div class="col-md-2"></div>
        <div class="col-md-8" >
                                     <h3 align="center"><i class="fa-fa-user"></i></h3>

            <div class="panel panel-default" style="background: rgba(255, 255, 255, 0.5);">
                <div class="panel-heading" style="background-color: #ccc; padding-left: 31px; color: #000;font-size: 17px;">Dream Mesh Recruitment Portal</div>
                <div class="panel-body">
                    <form class="form-horizontal col-md-12 col-lg-12 col-sm-12"  role="form" method="POST" action="{{ url('/candidate/login') }}">
                        {{ csrf_field() }}
                    <div style="padding: 0 0px; margin-top: 10px; ">
                         <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="email" type="text" class="form-control" name="email" placeholder="Username or Email" value="{{ old('email') }}" style="height: 40px;">

                             @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                         </div> <br/>
                    </div>
                       
                        <div style="padding: 0 0px; "> 
                            <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password" style="height: 40px;">
                            @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                            </div><br/>
                        </div>
                        
                             
                                <button type="submit" class="btn btn-block btn-primary col-lg-12 col-sm-12 col-md-12 col-xs-12" style="padding: 8px 10px; background-color: #32205a;">
                                    Login
                                </button>


                           

                        <div class="form-group">
                                    <div class="col-md-12 col-md-offset " style="padding-top:10px; ">
                                                                                                    <hr style="margin-bottom: 10px;" />

                                        <div class="checkbox col-lg-5 col-md-5 col-sm-5 col-xs-5">

                                            <label>
                                                <input type="checkbox" name="remember" > Remember Me
                                            </label>

                                        </div>
                                        <a class="btn btn-link" href="{{ url('/candidate/password/reset') }}" style="color: #32205a;">
                                    Forgot Your Password?
                                </a>
                                        
                                    </div>
                             </div>
                        </div>

                        


                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>

    </div>
</div>
</section>
@endsection
