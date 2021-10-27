@extends('layouts.app')

@section('page-style-files')
    <!--main booking-->
    <link rel="stylesheet" href="{{url('/css/app.css')}}" type="text/css" media="all">
    <style type="text/css">
        .headerwrapper .textcontainer{ text-align: center}
        .main-primary {
            box-shadow: 0 4px 4px #ccc;
            background: #fff;
        }
        .main-primary h3.header3 {
            margin-bottom: 20px;
            margin-left: -15px;
            margin-right: -15px;
            width: calc(100% + 30px);
            padding-top: 0px;
        }
        div.radio{ float: left; width: 100% }
        .stars{ float: left; width: 100%; height: auto; text-align: center; margin-bottom: 10px; position: relative}
            .stars.withopaque:before{ position: absolute; left: 0px; width: 100%; height: 100%; top:0px; z-index: 2; content:"";}
        .titlesection span{ text-transform: none }
        textarea{color:#333;}
            textarea::placeholder{color:#ccc}

        .starrr {
          display: inline-block; position: relative;}
          .starrr a {
            font-size: 25px;
            padding: 0 3px;
            cursor: pointer;
            color: #FFD119;
            text-decoration: none; position: relative; z-index: 1}   
            .your-choice-was{ margin-top: 10px; float: left; text-align: center; width: 100%; margin-bottom: 0px;display: none; } 
            #star2_input{ position: absolute; left: 0px; width: 100%; height: 1px; bottom:0px; opacity:0; z-index: 0}
        @media only screen and (max-width: 490px){
            .titlesection span{ font-size: 12px; line-height: 20px }
            .stars{ margin-bottom: 20px }
        }
        .mt-45{ margin-top: -45px; z-index: 2; height: auto; float: left; width: 100%; position: relative}
        .errored{ width: 100%; text-align: center; width: 100%; color:#cc0000; margin-bottom: 20px; margin-top: 20px; font-size: 13px}
        .descriptionsection {color:#222;}
        .descriptionsection2{margin-left: 40px; margin-top: -10px; float: left; margin-bottom: 40px; font-size:14px}        
            .descriptionsection2:last-child{ margin-bottom: 20px }
        .megaquote{ background: #eee; padding:15px; border-radius:4px; text-align: center}
    </style>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-155250227-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-155250227-1');
</script>

@endsection

@section('initlink')
<a href="{{route('/', app()->getLocale())}}" class="small">{{ __('btn1') }}</a>
@endsection

@section('titlebig')
<h5>Cero Filas</h5>
<h1>FAQ</h1>
@endsection

@section('content')
    <div class="loading-main">
        <div class="loader">{{ __('lblLoading') }}</div>
    </div>

    <div class="responsemessage"></div>

    <div class="requisitoscontainer-holder">
        <div class="requisitoscontainer">
        </div>
    </div>

    <div class="wrappercontainer">
        
        <div class="container">

            
            
            <div class="mt-45">
                
                <div class="main-primary col-sm-8 col-md-8 col-xs-12 br-5 p15 mb-30 col-sm-offset-2">
                   <h3 class="header3">{{ __('lblfaq1') }}</h3>                                        
                    <p class="descriptionsection megaquote">{{ __('lblfaq2') }}</p>
                    
                    <label class="titlesection"><b>1</b><span> {{ __('lblfaq3') }}</span></label>
                    <span class="descriptionsection2">{{ __('lblfaq4') }} <a href="{{route('/', app()->getLocale())}}"> [https://cerofilas.veracruzmunicipio.gob.mx]</a> {{ __('lblfaq5') }}</span>    
                    
                     <label class="titlesection"><b>2</b><span> {{ __('lblfaq6') }}</span></label>
                    <span class="descriptionsection2">{{ __('lblfaq7') }}</span> 

                    <label class="titlesection"><b>3</b><span> {{ __('lblfaq8') }}</span></label>
                    <span class="descriptionsection2">{{ __('lblfaq9') }}</span>    

                    <label class="titlesection"><b>4</b><span> {{ __('lblfaq10') }}<</span></label>
                    <span class="descriptionsection2"> {{ __('lblfaq11') }}</span>

                    <label class="titlesection"><b>5</b><span> {{ __('lblfaq12') }}</span></label>
                    <span class="descriptionsection2">{{ __('lblfaq13') }}</span> 

                    <label class="titlesection"><b>6</b><span> {{ __('lblfaq14') }}</span></label>
                    <span class="descriptionsection2">{{ __('lblfaq15') }}</span>

                    <label class="titlesection"><b>7</b><span> {{ __('lblfaq16') }}</span></label>
                    <span class="descriptionsection2">{{ __('lblfaq17') }}</span>   

                    <label class="titlesection"><b>8</b><span> {{ __('lblfaq18') }}</span></label>
                    <span class="descriptionsection2">{{ __('lblfaq19') }}</span>

                    <label class="titlesection"><b>9</b><span>{{ __('lblfaq20') }}</span></label>
                    <span class="descriptionsection2">{{ __('lblfaq21') }}</span>

                    <label class="titlesection"><b>10</b><span> {{ __('lblfaq22') }}</span></label>
                    <span class="descriptionsection2">{{ __('lblfaq23') }}</span>

                    <label class="titlesection"><b>11</b><span> {{ __('lblfaq24') }}</span></label>
                    <span class="descriptionsection2">{{ __('lblfaq25') }}</span>

                    <label class="titlesection"><b>12</b><span> {{ __('lblfaq26') }}</span></label>
                    <span class="descriptionsection2">{{ __('lblfaq27') }}</span>

                    <label class="titlesection"><b>13</b><span> {{ __('lblfaq28') }}</span></label>
                    <span class="descriptionsection2">{{ __('lblfaq29') }} <a href="{{route('/', app()->getLocale())}}">{{ __('lblfaq30') }}</a>.</span>

                    <label class="titlesection"><b>14</b><span>{{ __('lblfaq31') }}</span></label>
                    <span class="descriptionsection2">{{ __('lblfaq32') }}</span>
                     -->
                </div>
            </div> 
            
                    
        </div>
    </div>
@endsection

@section('page-js-script')
  <script>
    $(document).ready(function(){
      $(".loading-main").fadeOut();      
    });
  </script>
@endsection

