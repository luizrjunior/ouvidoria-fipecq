@extends('layouts.app')

@section('javascript')
<script type="text/javascript" 
    src="{{ asset('/js/ouvidoria/pesquisa-satisfacao/cad-pesquisa-satisfacao.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card uper">
                <div class="card-header">
                    Pesquisa de Satisfação
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('pesquisa-satisfacao.store') }}" autocomplete="off">
                        @csrf
                        <input type="hidden" id="ouvidoria_id" name="ouvidoria_id" value="{{ $ouvidoria_id }}">
                        <div class="form-group">
                            <label for="resposta_1">A sua demanda foi atendida?</label><div class="form-check">
                                <input class="form-check-input" type="radio" name="resposta_1" id="resposta_1_1" value="1" checked>
                                <label class="form-check-label" for="resposta_1_1">
                                  Sim
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="resposta_1" id="resposta_1_2" value="2">
                                <label class="form-check-label" for="resposta_1_2">
                                  Não
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="resposta_1" id="resposta_1_3" value="3">
                                <label class="form-check-label" for="resposta_1_3">
                                  Parcialmente Atendida
                                </label>
                              </div>
                        </div>
                        <div class="form-group">
                            <label for="resposta_1">Como você avalia o atendimento recebido pela Ouvidoria da FIPECq Vida?</label><div class="form-check">
                                <input class="form-check-input" type="radio" name="resposta_2" id="resposta_2_1" value="1" checked>
                                <label class="form-check-label" for="resposta_2_1">
                                  Satisfeito
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="resposta_2" id="resposta_2_2" value="2">
                                <label class="form-check-label" for="resposta_2_2">
                                  Insatisfeito
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="resposta_2" id="resposta_2_3" value="3">
                                <label class="form-check-label" for="resposta_2_3">
                                  Totalmente Insatisfeito
                                </label>
                              </div>
                        </div>
                        <div class="form-group {{ $errors->has('resposta_3') ? 'text-danger' : '' }}">
                            <label for="resposta_3">Gostaria de deixar alguma sugestão para a melhoria dos serviços da Ouvidoria?</label>
                            <textarea rows="5" id="resposta_3" name="resposta_3" 
                                class="form-control">{{ old('resposta_3') }}</textarea>
                            <span class="text-danger">{{ $errors->first('resposta_3') }}</span>
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">Sua mensagem tem <span class="caracteres">1200</span> caracteres restantes</small>
                        </div>
    
                        <button type="submit" class="btn btn-primary" onclick="return validar()">
                            <i class="fa fa-btn fa-paper-plane"></i> Enviar Pesquisa de Satisfação
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
