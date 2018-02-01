@extends('layouts.app_client')

@section('content')
<!-- Portfolio Grid Section -->
    <section id="portfolio">
        <div class="container">
            <table class="table table-striped" style="border: 1px; border-color: #7C7E80;">
                <thead>
                      <th bgcolor="#000" align="center" style="padding: 5px; width: 100%; color: #fff;" class="col-lg-12 col-md-12">Your Exam data has been saved successfully</th>
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
                        <td>Score%</td>
                        <td>{{$percent}}</td>
                        
                    </tr>   
                </tbody>
            </table> 
            <a href="{{route('client.logout')}}" class="btn btn-primary col-lg-12">Logout</a>
            </div>
        </div>

            </div>
        </div>


    </section>