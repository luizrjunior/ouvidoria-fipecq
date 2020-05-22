@extends('layouts.app')

@section('javascript')
<script>
	function Avancar(tipo_ouvidoria_id) {
		$('#carregando').show();
		$('#tipo_ouvidoria_id').val(tipo_ouvidoria_id);
		$("#formFaleComOuvidor").submit();
	}
</script>
@endsection

@section('content')

	@if (Session('message'))
	<!-- Alert -->
	<div id="_sent_ok_" class="alert alert-warning alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4><i class="icon fa fa-check"></i> Alerta!</h4>
		<span id="_msg_txt_">{{ Session('message') }}</span>
	</div>
	<!-- /Alert -->
	@endif

	@if (Session('success'))
	<!-- Alert -->
	<div id="_sent_ok_" class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4><i class="icon fa fa-check"></i> Alerta!</h4>
		<span id="_msg_txt_">{!! Session('success') !!}</span>
	</div>
	<!-- /Alert -->
	@endif

    <h5>
		<center style="font-weight:bold; color:#006699">
			Quando devo utilizar a ouvidoria?
		</center>
	</h5>
  
	<p>&nbsp;</p>
  
	<style>
		#tableDif tr td {padding:5px; border-bottom:1px solid #ffffff; border-left:1px solid #ffffff; text-align:center; font-size:14px; }
		#tableDif .negrito {font-weight:bold; background-color:#365F91; color:#FFFFFF }
	</style>
  
	<table id="tableDif" cellspacing="0" cellpadding="0" width="100%">
		<tr bgcolor="#A3C8DA">
			<td width="288">OUVIDORIA</td>
			<td width="288">FALE CONOSCO*</td>
		</tr>
		<tr bgcolor="#E8F1F6">
			<td width="288">Lida com a exceção</td>
			<td width="288">Lida com a rotina</td>
		</tr>
		<tr bgcolor="#E8F1F6">
			<td width="288">Atua estrategicamente</td>
			<td width="288">Atua operacionalmente</td>
		</tr>
		<tr bgcolor="#E8F1F6">
			<td width="288">Atende em última instância</td>
			<td width="288">Atende situações rotineiras</td>
		</tr>
		<tr bgcolor="#E8F1F6">
			<td width="288">Atende personalizadamente</td>
			<td width="288">Atende personalizadamente*</td>
		</tr>
		<tr bgcolor="#E8F1F6">
			<td width="288">Atua na mediação de conflitos</td>
			<td width="288">Atua apenas no atendimento de rotina</td>
		</tr>
	</table>

	<p>&nbsp;</p>

	<h5>
		<center style="font-weight:bold; color:#006699;">
			Deseja acionar a ouvidoria? Selecione uma das opções abaixo:
		</center>
	</h5>

	<p>&nbsp;</p>

	<style>
		#saibaOuvir tr td {padding:10px; border-left:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF }
	</style>

	<form id="formFaleComOuvidor" action="{{ route('ouvidoria.create') }}" method="post" autocomplete="off">
		@csrf
		<input type="hidden" id="tipo_ouvidoria_id" name="tipo_ouvidoria_id" value="">

		<table id="saibaOuvir" cellspacing="0" cellpadding="0" width="90%" align="center">
			<tr style="text-align:center; color:#FFFFFF;">

				@if (count($tiposOuvidorias) > 0)
					@foreach ($tiposOuvidorias as $tipoOuvidoria)
					<td class="bg-{{ $tipoOuvidoria->cor }}" width="20%" valign="top" 
						style="cursor: pointer;" title="Registrar {{ $tipoOuvidoria->nome }}" 
						onclick="Avancar({{ $tipoOuvidoria->id }})">
						<br />
						<i class="{{ $tipoOuvidoria->icone }}" style="font-size: 48px;"></i>
						<br /><br />
						<b>{{ $tipoOuvidoria->nome }}</b>
						<br />
					</td>
					@endforeach
				@endif

			</tr>
			<tr style="text-align:center; color:#FFFFFF;">

				@if (count($tiposOuvidorias) > 0)
					@foreach ($tiposOuvidorias as $tipoOuvidoria)
					<td class="text-{{ $tipoOuvidoria->cor }}" 
						style="cursor: pointer;" title="Registrar {{ $tipoOuvidoria->nome }}" 
						onclick="Avancar({{ $tipoOuvidoria->id }})">
						<br />
						<b>{{ $tipoOuvidoria->descricao }}</b>
						<br />&nbsp;
					</td>
					@endforeach
				@endif

			</tr>

		</table>

	</form>
  
	<center>
		<sup style="font-weight:bold; color:#006699;">
			E-mail de contato com o Fale Conosco:
		</sup>
	</center>
	<center>
		<sup style="font-weight:bold; color:#C00000;">
			faleconosco@fipecqvida.org.br
		</sup>
	</center>
  
@endsection
