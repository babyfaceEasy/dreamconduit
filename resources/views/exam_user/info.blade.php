@extends('layouts.app_client')

@section('content')
<!-- Portfolio Grid Section -->
    <section id="portfolio">
        <div class="container">
            <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="well" style="">
                <p class="text-center">
                    Name: <b>{{$candidate->name}}</b>
                </p>
                <div>
                    <b>ATTENTION! ATTENTION!! ATTENTION!!!</b><br>
 
                    Please read the below instructions and guidelines before starting the test.

                    <br>
                    <b>Before beginning the exam.</b>

                    <ol>
                        <li>
                            Make sure you have a good internet connection. If you do not have a strong internet connection kindly logout and take the test on a system that has a strong internet connection.
                        </li>
                        <li>
                            This test should be taken on a desktop/laptop/iMac/MacBook. Mobile devices (such as smartphones, tablets etc.) are not optimized for this test. If you are using a mobile device please logout and access on a computer system.
                        </li>
                        <li>
                            This test is better optimized for Firefox and Chrome browsers.
                        </li>
                        <li>
                            Ensure that there multiple tabs are not opened in your browser.
                        </li>
                        <li>
                            Maximize your browser window before starting the test.
                        </li>
                        <li>
                            If you are taking the test late in the day, it is recommended that you reboot your computer before beginning to fee up memory resources from other programs on your computer.
                        </li>
                        <li>After reading all instructions please click “Start Exam” once to proceed to the test.</li>
                        <li>Please note that once you click start you cannot go back or logout in order to complete the test later.
                        </li>
                    </ol>



                <b>During the exam.</b><br>

                <ol>
                    <li>Do not close tab or go to another tab during the test.</li>
                    <li>
                        Never click the “Back” button on the browser. This will take you of the test and prevent your selected answers from being answered.
                    </li>
                    <li>
                        If you are done before the expiration of the time allowed Click “I am done, submit test” button to submit your exam. Do not press “Enter” on the keyboard to submit the exam.
                    </li>
                </ol>

                </div>
                <a href="{{route('client.questions')}}" class="btn btn-success btn-block">START EXAM</a>
                <a href="{{route('client.logout')}}" class="btn btn-default btn-block">Logout</a>
            </div>
        </div>
    </div>
            </div>
        </div>
    </section>

@endsection