<!-- exam_user =>info.blade.php -->
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="well" style="">
                <p class="text-center">
                    Name: <b>{{$exam->exam_name}}</b>
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

<!-- exam_user => test.blade.php -->
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <div id="clock"></div>
            <div class="panel panel-default">
                <div class="panel-heading">Exam</div>
                <div class="panel-body">
                    <div class="">
                        <!--<a href="{{route('client.logout')}}">Logout</a>
                        <b>The name of the Test</b>-->

                        <form action="{{route('client.result')}}" id="test_form" method="post" role="form">
                        {{csrf_field()}}
                        <input type="hidden" name="exam_id" value="{{$exam->id}}">

                        <?php $counter = 1; ?>
                        @foreach ($questions as $question)
                        <div id="quest_tab_{{$counter}}" 
                        @if($counter != 1) 
                            style="display: none;" 
                        @endif
                        >
                            <input type="hidden" name="question_{{$question->id_ans}}">
                            <b><u>Question #{{$counter}}</u></b>
                            {!!$question->question!!}<br>
                            <input type="radio" name="question_{{$question->id}}" value="a"> {{$question->option_a}}<br>
                            <input type="radio" name="question_{{$question->id}}" value="b"> {{$question->option_b}}<br>
                            <input type="radio" name="question_{{$question->id}}" value="c"> {{$question->option_c}}<br>
                            <input type="radio" name="question_{{$question->id}}" value="d"> {{$question->option_d}}
                        </div>
                        <?php $counter++; ?>
                        @endforeach

                    </div>

                    <div id="tally" style="padding-top: 10px; color: #888;">
                    </div>

                    <div style="padding-bottom: 10px;">
                        <a href="#" id="prev_btn" class="btn btn-info"> <span class="fa fa-arrow-left"></span> Prev </a>
                        <a href="#" id="next_btn" class="btn btn-info">Next <span class="fa fa-arrow-right"></span> </a>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">I'm Done, Submit Test</button>
                    <p class="text-center">
                        Do not go to any other page or close current tab while taking exams. Your data may be lost.
                    </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- exam_user => results.blade.php -->
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            
        <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              Your Exam data has been saved successfully.
        </div>

        <p class="text-center">
            <h3>Thank you for taking the exams.</h3>
        </p>

        <table class="table">
            <tr>
                <td>Total Question:</td>
                <td>{{$tot_quests}}</td>
            </tr>

            <tr>
                <td>Correct Answers:</td>
                <td>{{$score}}</td>
            </tr>

            <tr>
                <td>Time Taken:</td>
                <td></td>
            </tr>

            <tr>
                <td>Score%:</td>
                <td>{{$percent}}</td>
            </tr>
        </table>
        <a href="{{route('client.logout')}}" class="btn btn-default btn-block">Logout</a>
        </div>
    </div>
</div>
