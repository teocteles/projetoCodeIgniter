<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $titulo ?> </title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<style>
		.erro {
			color: #f00;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1 class="text-center"><?= $titulo ?></h1>
		<div class="col-md-6 col-md-offset-3">
			<div class="row">
				<?= form_open('cadastroAgendamento/store')  ?>
					
				<div class="form-group">
						<label for="date_time">Data</label><span class="erro"><?php echo form_error('data_agendamento') ?  : ''; ?></span>
						<input type="text" name="data_agendamento" id="date_time" class="form-control date_time" value="<?= set_value('data_agendamento') ? : (isset($data_agendamento) ? $data_agendamento : '') ; ?>" require >
					</div>

    			   <div class="form-group">
					<label for="pacientes">Pacientes:</label> <span class="erro"><?php echo form_error('codigo_paciente') ?  : ''; ?></span>
					<select class="form-control" id="pacientes" name="codigo_paciente" require>
						<option></option>
						<?php foreach($pacientes -> result() as $paciente): ?>
							<option value="<?= set_value('codigo_paciente') ? : (isset($paciente->codigo) ? $paciente->codigo : '') ; ?> "> <?= $paciente->nome ?> </option>
						<?php endforeach; ?>	
					</select>
					</div>

					<div class="form-group">
					<label for="codigo_medico">Médicos:</label> <span class="erro"><?php echo form_error('codigo_medico') ?  : ''; ?></span>
					<select class="form-control" id="codigo_medico" name="codigo_medico" require>
						<option></option>
						<?php foreach($medicos -> result() as $medico): ?>
							<option value="<?= set_value('codigo_medico') ? : (isset($medico->codigo) ? $medico->codigo : '') ; ?> "> <?= $medico->nome ?> </option>
						<?php endforeach; ?>	
					</select>
					</div>

				
				<div class="form-group text-right">
						<input type="submit" value="Salvar" class="btn btn-success" />
				</div>
				<input type='hidden' name="codigo" value="<?= set_value('codigo') ? : (isset($codigo) ? $codigo : ''); ?>">

				<?= form_close(); ?>

				
			</div>
			<div class="row"><hr></div>
			<div class="row">
				<?= anchor('', 'Página Inicial') ?>
			</div>
		</div>	
	</div>
</body>
</html>
