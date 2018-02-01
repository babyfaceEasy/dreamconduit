@extends('layouts.app_client')

@section('content')
<!-- Portfolio Grid Section -->
<section id="portfolio" style="margin-top: 100px;">
        <div class="container">
        <div class="col-lg-3"></div>
        <div class="panel panel-primary col-lg-6" style="padding: 0px;">
        <div class="panel-heading col-lg-12" style="background-color:#423562; color: #fff; font-size: 16px; padding-left: 10px;width: 100%;">
             Your Exam data has been saved successfully
        </div>
            <table class="table table-striped" style="border: 1px; border-color: #7C7E80;">
                <thead >
                      
                    <tr>
                      
                          <td align="center"> Thank you for taking this exams</td>
                       
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Questions </td>
                        <td>{{$tot_quests}}</td>
                        
                    </tr>
                    <tr>
                        <td>Correct answers</td>
                        <td>{{$score}}</td>
                        
                    </tr>
                    <tr>
                        <td>Time taken</td>
                        <td></td>
                        
                    </tr>
                    <tr>
                        <td>Score in Percentage (%)</td>
                        <td>{{$percent}}</td>
                        
                    </tr>   
                </tbody>
            </table>
            </div>
            <div class="col-lg-3"></div>

            <div class="clearfix"></div>
            <div class="col-lg-3"></div>
             <div class="col-lg-6" style="padding:0px;">
                <a href="{{ url('candidate/home') }}" class="btn btn-primary col-md-12 col-sm-12 col-xs-12" style="height: 35px;">Home</a><br/><br/>
                <a href="{{ url('/candidate/logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();" class="btn btn-info  col-md-12 col-sm-12 col-xs-12" style="margin-top: 6px; height: 35px;">Logout</a> 
        </div>
                    <div class="col-lg-3"></div>



 </div>
            

    </section>