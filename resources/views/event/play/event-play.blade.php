@extends('layout.large-external')
@section('content')
<style>
    @if($design != null)
        .limiter{
            background-image: url("{{ $design != null ? $design->background_url : '' }}");
            background-size: cover;
        }
        .container-login100 {
            align-items: end !important;
            background-color: transparent !important;
            align-items: end !important;
        }

        
        
    @else
        .container-login100{
            background-color: #f8f9fa;
        }
    @endif
</style>
	<form id="form" class="login100-form validate-form">
        <div class="row">
            <div class="col-6">
                <a id="btn-stop" title="Presiona aqui para parar la espera de participantes y puedas empezar a jugar" onclick="finishInscription = true; $('#btn-stop').fadeOut(); $('#btn-start').fadeIn()" class="hand"><img src="{{asset('images/stop.svg')}}" width="20" height="20"></a>
            </div>
            <div class="col-6">
                <a onclick="$('#dialog-play').modal('show');" class="pull-right hand"><img src="{{asset('images/config.svg')}}" width="20" height="20"></a>
            </div>
        </div>
		<center>
            <span class="login100-form-title p-b-10" id="text-winner">
                ¿Quién ganará?
            </span>
            <h5>Participantes: <b id="num-players"></b></h5>

            <div class="container-login100-form-btn m-t-23 hide" id="btn-start">
                <div class="wrap-login100-form-btn">
                    <div class="login100-form-bgbtn"></div>
                    <button type="button" onclick="start()" class="login100-form-btn">
                        Jugar
                    </button>
                </div>
            </div>

            <div class="container-login100-form-btn m-t-23 hide" id="btn-reset">
                <div class="wrap-login100-form-btn">
                    <div class="login100-form-bgbtn"></div>
                    <button type="button" onclick="restart()" class="login100-form-btn">
                        Reiniciar
                    </button>
                </div>
            </div>
        </center>
	</form>

    <div class="modal fade" id="dialog-play" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Configuración para jugar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 mt-2">
                        <div class="form-check">
                            <input type="hidden" class="property" id="check_only_news">
                            <input class="form-check-input" type="checkbox" value="" id="in-check-only-news" name="in-check-only-news">
                            <label class="form-check-label" for="in-check-only-news">
                                ¿Solo nuevos?
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 mt-2">
                        <div class="form-check">
                            <input type="hidden" class="property" id="check_only_attend">
                            <input class="form-check-input" type="checkbox" value="" id="in-check-only-attend" name="in-check-only-news">
                            <label class="form-check-label" for="in-check-only-attend">
                                ¿Solo los que asistieron al evento?
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 mt-2">
                        <div class="form-check">
                            <input type="hidden" class="property" id="check_winner_not_repeat">
                            <input class="form-check-input" checked type="checkbox" value="" id="in-check-winner-not-repeat" name="in-check-only-news">
                            <label class="form-check-label" for="in-check-winner-not-repeat">
                                ¿Permitir que gane una misma persona siempre?
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 mt-2">
                        <div class="form-check">
                            <label>Segungos del conteo regresivo</label>
                            <input class="form-control" type="number" value="10" id="countdown">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="$('#dialog-play').modal('hide');">Cancelar</button>
                <button type="button" class="btn btn-primary btn-loading" onclick="configure()">Guardar</button>
            </div>
            </div>
        </div>
    </div>
    {{ view('event.play.event-play-script', compact('event')) }}
@endsection