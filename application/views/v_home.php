<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pacientes</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

</head>
<body>

	<div class="container">
		<h1 class="text-center">Entrevista - Teógenes Teles</h1>
		<div class="col-md-12">
			<div class="row">
				<?= anchor('CadastroMedico/create', 'Novo Médico', array('class' => 'btn btn-success')); ?>
				<?= anchor('CadastroPaciente/create', 'Novo Paciente', array('class' => 'btn btn-success')); ?>
				<?= anchor('CadastroAgendamento/create', 'Novo Agendamento', array('class' => 'btn btn-success')); ?>
			</div>

				<div class="row">
				<?= form_open('home/buscar')  ?>
							<div class="form-group">
								<div class="col-md-6">
									<label for="dtInicio">Data Início</label><span class="erro"><?php echo form_error('dataInicio') ?  : ''; ?></span>
									<input type="date" class="form-control" name="dataInicio" id="dtInicio" value="<?= set_value('dataInicio') ? : (isset($dataInicio) ? $dataInicio : '') ; ?>">
								</div>
		
								<div class="col-md-6" style="">
									<label for="dtFim">Data Fim</label><span class="erro"><?php echo form_error('dataFim') ?  : ''; ?></span>
									<input type="date" class="form-control" id="dtFim" name="dataFim" value="<?= set_value('dataFim') ? : (isset($dataFim) ? $dataFim : '') ; ?>">
								</div>
							</div>
							<button type="submit" class="btn btn-primary pull-right" style="margin: 10px 0;">Buscar</button>
				<?= form_close(); ?>		
				</div>

			<div class="row">
			</div>
			<div class="row">
			<?php if (isset($agendamentos)): ?>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Código</th>
							<th>Nome Paciente</th>
							<th>Nome Médico</th>
							<th>Data Agendamento</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($agendamentos -> result() as $agendamento): ?>
						<tr>
							<td><?= $agendamento->codigo_agendamento ?></td>
							<td><?= $agendamento->nome_paciente ?></td>
							<td><?= $agendamento->nome_medico ?></td>
							<td><?= date('d/m/Y H:i', strtotime($agendamento->data_agendamento)); ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<?php 
					else:
				?>
					<h4>Nenhum registro encontrado.</h4>
				<?php endif; ?>
			</div>
		</div>	
	</div>
<div class="modal fade" id="modal_confirmation">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Confirmação de Exclusão</h4>
      </div>
      <div class="modal-body">
        <p>Deseja realmente excluir o registro <strong><span id="nome_exclusao"></span></strong>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Agora não</button>
        <button type="button" class="btn btn-danger" id="btn_excluir">Sim. Acabe com ele</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Latest compiled and minified JavaScript -->
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


	<script>
	
		var base_url = "<?= base_url(); ?>";
	
		$(function(){
			$('.confirma_exclusao').on('click', function(e) {
			    e.preventDefault();
			    
			    var nome = $(this).data('nome');
			    var id = $(this).data('id');
			    
			    $('#modal_confirmation').data('nome', nome);
			    $('#modal_confirmation').data('id', id);
			    $('#modal_confirmation').modal('show');
			});
			
			$('#modal_confirmation').on('show.bs.modal', function () {
			  var nome = $(this).data('nome');
			  $('#nome_exclusao').text(nome);
			});	
			
			$('#btn_excluir').click(function(){
				var id = $('#modal_confirmation').data('id');
				document.location.href = base_url + "index.php/cadastro/delete/"+id;
			});					
		});
	</script>
	
</body>
</html>
