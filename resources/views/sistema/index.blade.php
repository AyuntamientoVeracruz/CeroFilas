@extends('layouts.headerauth')

@section('content')
  <style type="text/css">
      .timerarea:before{ font-size:8px;}
      .timerarea:before{content:"{{ __('lblIndex22') }}" !important; color: #999;
  position: absolute; width: 120px; text-align: center; font-size: 9px;
  font-weight: normal; left: calc(50% - 60px); background: #fff;
  top: -10px; height: 20px; line-height: 20px; text-transform: uppercase}
  </style>    
  <!-- Main content -->
  <main class="main">

    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <div class="container-fluid">

      <div class="animated fadeIn cards">

        
          <div class="col-lg-3 col-md-4">
            <div class="card cardswitch">  
              <div class="card-header">
                <i class="fa fa-check-square-o"></i>{{ __('lblIndexBlade1') }}
              </div>
              <div class="card-body">
                <span class="mask hide"></span>
                <div class="switchcontainer">
                  <form id="form-availability">
                    <label class="switch">
                      <input type="checkbox" id="availability" name="availability" @if($data['disponibilidad']=='si') checked @endif>
                      <span class="slider round"></span>
                    </label>
                  </form>
                  @if($data['disponibilidad']=='si')<small class="blueish"> {{ __('lblIndexBlade2') }} </small>@else <small> {{ __('lblIndexBlade3') }} </small> @endif
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-9 col-md-8 " id="info-empty">
            <div>
              <span><i class="fa fa-exclamation-triangle"></i><span>{{ __('lblIndexBlade4') }}</span></span>
            </div>
          </div>

          <div class="col-lg-9 col-md-8 hide" id="info-turno">
            <div class="card non-cardswitch">  
              <div class="card-header">
                <span data-summary="turno"><i class="far fa-calendar"></i> {{ __('lblIndexBlade5') }} <b></b></span>
                <span href="#" class="badge badge-secondary ml10" data-toggle="popover" id="cita"> {{ __('lblIndexBlade6') }}</span>
                <a href="#" data-toggle="modal" data-target="#myModal" class="float-right" id="historial">{{ __('lblIndexBlade7') }}</a>                
              </div>
              <div class="card-body">
                <div class="switchcontainer">
                  <div class="summary" data-summary="tramite">
                    <div class="image"><i class="far fa-file-alt"></i></div>
                    <p class="text sel-service">{{ __('lblIndexBlade8') }}  <b></b></p>
                  </div>
                  <div class="summary" data-summary="nombre">
                    <div class="image"><i class="far fa-user"></i></div>
                    <p class="text sel-service">{{ __('lblIndexBlade9') }} <b></b></p>
                  </div>
                  <div class="summary summaryhour" data-summary="hora" >
                    <div class="image"><i class="far fa-clock"></i></div>
                    <p class="text sel-service">{{ __('lblIndexBlade10') }}<b></b></p>
                    <div class="timerareacontainer"></div>   
                  </div>

                </div>
              </div>
            </div>
          </div>

          <form id="form-response" class="w100 hide">
            <input type="hidden" name="turno" id="turno"> 
            <input type="hidden" name="confirmarypausar" id="confirmarypausar">   
            <div class="col-lg-12 col-md-12">            
              <label class="w100"><b>{{ __('lblIndexBlade11') }}</b> <small class="float-right">{{ __('lblIndexBlade12') }}</small></label>
              <textarea class="form-control" placeholder="{{ __('lblIndexBlade13') }}" rows="5" required name="observaciones"
              id="observaciones"></textarea>            
            </div>
            <div class="col-lg-6 col-md-12 mt20">              
              <div class="input-prepend input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text bgtrb0 pl0">{{ __('lblIndexBlade14') }}</span>
                </div>
                <input type="text" class="form-control br text-uppercase" placeholder="{{ __('lblIndexBlade15') }}" name="curp" id="curp" >  
              </div>
              <quote>{{ __('lblIndexBlade16') }} <a href="https://www.gob.mx/curp/" target="_blank" rel="noopener noreferrer">{{ __('lblIndexBlade17') }}.</a></quote>
            </div>

            <div class="col-lg-6 col-md-12 mt20">              
              <div class="input-prepend input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text bgtrb0 pl0">{{ __('lblIndexBlade18') }} </span>
                </div>
                <input type="email" class="form-control br" placeholder="{{ __('lblIndexBlade19') }}" name="email" id="email" >  
              </div>              
            </div>  

            <div style="float: left; width: 100%">  
              <div class="col-lg-4 col-md-4 col-sm-5 mt20">              
                <div class="input-prepend input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text bgtrb0 pl0">{{ __('lblIndexBlade20') }}</span>
                  </div>
                  <select  name="estatus" required="" id="estatus">
                    <option value="finalizado">{{ __('lblIndexBlade21') }}</option>
                    <option value="cancelado">{{ __('lblIndexBlade22') }}</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 mt20"> 
                <input type="button" class="btn btn-warning br btn-block" value="{{ __('lblIndexBlade23') }}" id="confirmarypausarbutton">
              </div>
              <div class="col-lg-4 col-md-4 col-sm-3 mt20"> 
                <input type="button" class="btn btn-primary br btn-block" value="{{ __('lblIndexBlade24') }}" id="confirmarbutton">
              </div>
            </div>

          </form>  

        

      </div>

    </div>
    
  </main>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{ __('lblIndexBlade25') }}</h4>
          
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          
          <div class="historial-oficina">
            <select name="oficina" id="oficina">
                <option value="">{{ __('lblIndexBlade26') }}</option>
                @if(count($dependenciascombo)> 0 )
                  @foreach($dependenciascombo as $dependencia)                                          
                    @foreach($dependencia->oficinas as $oficina)
                      <option value="{{$oficina->id_oficina}}" @if($data['oficina']==$oficina->id_oficina) selected="" @endif>{{$oficina->nombre_oficina}}</option>
                    @endforeach
                  @endforeach
                @endif  
            </select>
          </div>

          <div class="historial">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('lblIndexBlade27') }}</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

@endsection

@section('page-js-script')
  <script type="text/javascript">
      var setavailabilityurl = "{{route('setavailability', app()->getLocale())}}";
      var getassignmenturl = "{{route('getassignment', app()->getLocale())}}";
      var gethistorialurl = "{{route('gethistorial', app()->getLocale())}}";
      var attendingturnurl = "{{route('attendingturn',app()->getLocale())}}";
      var oficina="{{$data['oficina']}}";
      var sonidonotificacion="{{url('/sis/mp3/notificacion.mp3')}}";

      var lblIndex15="{{ __('lblIndex15') }}"
      var lblIndex16="{{ __('lblIndex16') }}"
      var lblIndex17="{{ __('lblIndex17') }}"
      var lblIndex18="{{ __('lblIndex18') }}"
      var lblIndex19="{{ __('lblIndex19') }}"
      var lblIndex20="{{ __('lblIndex20') }}"
      var lblIndex21="{{ __('lblIndex21') }}"
      var lblIndex23="{{ __('lblIndex23') }}"
  </script>
  <script src="{{url('/sis/js/dashboard.js')}}" type="text/javascript"></script>
@endsection
