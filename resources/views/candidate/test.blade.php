@extends('layouts.app_client')

@section('content')
    <!-- Portfolio Grid Section -->
    <section id="portfolio" style="margin-top: 80px;">
        <div class="container">
            <div class="col-md-4"></div>
            <div class="col-md-4" style="margin-bottom: 10px; ">
                <div id="far" align="center" style="height: 50px; padding: 10px;font-size: 17px; background-color: #423562; color: #fff;">
                    <span id="clock"></span>
                    <span style="font-size: 10px">Minutes Left</span>
                </div>
            </div>
            <div class="col-md-4"></div>
            <div class="clearfix"></div>
            <div class="panel panel-default">
                <div class="panel-heading">Exam</div>
                <div class="panel-body">
                    <div class="">
                    <!--<a href="{{-- route('client.logout') --}}">Logout</a>
                        <b>The name of the Test</b>-->

                        <form action="{{route('candidate.exam.results')}}" id="test_form" method="post" role="form">
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
                    <button type="button" onclick="if(confirm('Are you sure you want to submit?')) {document.getElementById('test_form').submit();}" class="btn btn-default btn-block" style=" background-color:#423562; color:#fff; ">I'm Done, Submit Test</button>
                    <p class="text-center">
                        Do not go to any other page or close current tab while taking exams. Your data may be lost.
                    </p>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>

@endsection

@push('scripts')
<script src="{{URL::asset('js/jquery.countdown.min.js')}}"></script>
<script type="text/javascript">

    $.fn.extend({
        disable: function(state){
            alert('state');
            return this.each(function(){
                this.disabled = state;
            });
        }
    });

    function enablePrevBtn(val){
        if(val == 1){
            $('#prev_btn').attr("disabled", "disabled");
        }else{
            $('#prev_btn').removeAttr("disabled");
        }
    }

    function enableNxtBtn(val){
        if (val == 1) {
            $('#next_btn').attr("disabled", "disabled");
        }else{
            $('#next_btn').removeAttr("disabled");
        }
    }

    function updateTally(counter, max)
    {
        $('#tally').html('<i>Question: ' + counter + ' of ' + max
            + '</i>');
    }

    function createCookie(name, value, days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            var expires = "; expires=" + date.toGMTString();
        } else var expires = "";
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function eraseCookie(name) {
        createCookie(name, "", -1);
    }

    $(function(){


        //$('#')


        var counter = 1;
        var max = {!! $counter !!} - 1;

        //this handles the tallying field.
        updateTally(counter, max);

        $('#next_btn').click(function(e){
            e.preventDefault();
            if(counter == max){
                return;
            }

            var name_holder = "quest_tab_" + counter;
            $('#'+name_holder).hide();
            counter++;
            name_holder = "quest_tab_" + counter;
            $('#'+name_holder).show();
            updateTally(counter, max);
        });

        $('#prev_btn').click(function (e){

            if (counter == 1) {
                return;
            }
            e.preventDefault();
            var name_holder = "quest_tab_" + counter;
            $('#'+name_holder).hide();
            counter--;
            name_holder = "quest_tab_" + counter;
            $('#'+name_holder).show();
            updateTally(counter, max);
        });
        //timer
        /*var countDownDate = new Date("").getTime();
         $('#clock').countdown(countDownDate, function(event) {
         $(this).html(event.strftime('%H:%M:%S'));
         }).on('finish.countdown', function(event){
         //alert('kunle');
         eraseCookie('countdowntimer');
         $('#test_form').submit();
         }).on('update.countdown', function(event){
         console.log(new Date().getMonth());

         });*/

//var countDownDate = new Date("Mar 10, 2017 17:00:00").getTime();
        var countDownDate = new Date("{!! Session::get('countdown_timer') !!}").getTime();

// Update the count down every 1 second
        var x = setInterval(function() {

            // Get todays date and time
            var now = new Date().getTime();

            // Find the distance between now an the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("clock").innerHTML = days + "d " + hours + "h "
                + minutes + "m " + seconds + "s ";

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("clock").innerHTML = "EXPIRED";
                $('#test_form').submit();
            }
        }, 1000);
    });
</script>
@endpush

