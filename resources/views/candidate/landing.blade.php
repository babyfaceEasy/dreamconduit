<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    
    <!-- Theme CSS -->
    <link href="{{asset('css/style_fred.css')}}" rel="stylesheet">
  
    <!-- jquery data -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Theme JavaScript -->
    <script src="{{asset('js/jquery-1.3.2.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.backgroundPosition.js')}}"></script>
    
    
    <script type="text/javascript">
        $(function(){


        
          $('#midground').css({backgroundPosition: '0px 0px'});
          $('#foreground').css({backgroundPosition: '0px 0px'});
          $('#background').css({backgroundPosition: '0px 0px'});
        

            $('#midground').animate({
                backgroundPosition:"(-10000px -2000px)"
            }, 240000, 'linear');


            $('#foreground').animate({
                backgroundPosition:"(-10000px -2000px)"
            }, 120000, 'linear');
            
            $('#background').animate({
                backgroundPosition:"(-10000px -2000px)"
            }, 480000, 'linear');
            
        });
    </script>
    
</head>

<body>

    <div id="background"></div>
    
    <div id="page-wrap">
        

        
        
        
        <div id="main-content">

                            <div align="center" style="padding-top: 75px;"><img src="{{asset('img/logo.png')}}"/></div>
                          

                          
    
    <a href="{{url('candidate/login')}}"><div style="padding-top: 15%; "><h1 align="center"><button class="btn btn-default" style="background: rgba(255, 255, 255, 0.2);"><h1 style="padding: 7px 25px 0px 25px; font-size: 22px; line-height: 25px;">Start Exam</h1></button></h1></div></a>
                

                </div>
        
        </div>
    
    </div>

</body>

</html>