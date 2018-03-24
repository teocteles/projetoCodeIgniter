<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function index()
	{
		$this->load->view('v_home');
	}


	public function getAgendamentos() {
		$this->db->select('a.codigo codigo_agendamento, a.data_agendamento data_agendamento, m.nome nome_medico, p.nome nome_paciente');
		$this->db->from('agendamento a');
		$this->db->join('medico m', 'a.codigo_medico = m.codigo');
		$this->db->join('paciente p', 'a.codigo_paciente = p.codigo');
		return $this->db->get();
	}


	public function buscar(){

		$dataInicio = $this->input->post('dataInicio');
		$dataFim = $this->input->post('dataFim');
		
		$this->load->library('form_validation');
		$regras = array(
			array(
				'field' => 'dataInicio',
				'label' => 'Data inicio',
				'rules' => 'required'
			),
			array(
				'field' => 'dataFim',
				'label' => 'Data fim',
				'rules' => 'required'
			)
			
		);
		
		$this->form_validation->set_rules($regras);

		if ($this->form_validation->run() == FALSE) {
			$variaveis['titulo'] = $this->getAgendamentos();
			$this->load->view('v_home', $variaveis);
		}else {

			$dtIni  =  $this->input->post('dataInicio');
			$dtFin  =  $this->input->post('dataFim');

			$dataIni = explode('-',$dtIni);
			$periodo_inicio = '\''.$dataIni[0].'-'.$dataIni[1].'-'.$dataIni[2].'\'';
			
			$dataFin = explode('-',$dtFin);
			$periodo_final = '\''.$dataFin[0].'-'.$dataFin[1].'-'.$dataFin[2].'\'';

			$sql = "
			SELECT a.codigo codigo_agendamento, a.data_agendamento data_agendamento, m.nome nome_medico, p.nome nome_paciente FROM agendamento a
			inner join medico m
			on  a.codigo_medico = m.codigo
			inner join paciente p
			on a.codigo_paciente = p.codigo

			where a.data_agendamento >= ".$periodo_inicio." 
			AND a.data_agendamento <= ".$periodo_final;
			
			$variaveis['agendamentos'] = $this->db->query($sql);
			$this->load->view('v_home', $variaveis);

		}



	}





}
