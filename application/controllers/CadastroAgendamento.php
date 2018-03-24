<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CadastroAgendamento extends CI_Controller {

	public $tabela = "agendamento";

	/**
	 * Carrega o formulário para novo cadastro de um paciente
	 * @param nenhum
	 * @return view
	 */
	public function create()
	{
		$variaveis['titulo'] = 'Cadastrar Agendamento';
		$variaveis['pacientes'] = $this->getPacientes();
		$variaveis['medicos'] = $this->getMedicos();
		
		$this->load->view('v_cadastro_agendamento', $variaveis);
	}
	/**
	 * Salva o registro no banco de dados.
	 * Caso venha o valor id, indica uma edição, caso contrário, um insert.
	 * @param campos do formulário
	 * @return view
	 */
	public function store(){
		
		$this->load->library('form_validation');
		
		$regras = array(
				array(
					'field' => 'codigo_paciente',
					'label' => 'Pacientes',
					'rules' => 'required'
				),
		        array(
					'field' => 'codigo_medico',
					'label' => 'Medicos',
					'rules' => 'required'
				),
				array(
					'field' => 'data_agendamento',
					'label' => 'Data',
					'rules' => 'required'
				)
				
		);
		
		$this->form_validation->set_rules($regras);

		if ($this->form_validation->run() == FALSE) {
			$variaveis['titulo'] = 'Novo Registro';
			$variaveis['pacientes'] = $this->getPacientes();
			$variaveis['medicos'] = $this->getMedicos();
			
			$this->load->view('v_cadastro_agendamento', $variaveis);
		} else {
			
			$codigo = $this->input->post('codigo');
			$data  =  $this->input->post('data_agendamento');

			$data_time = explode(' ',$data);
			$data_somente = explode('/',$data_time[0]);

			$data_format = $data_somente[2].'-'.$data_somente[1].'-'.$data_somente[0].' '.$data_time[1];

			$dados = array(
			
				"codigo_medico" => $this->input->post('codigo_medico'),
				"codigo_paciente" => $this->input->post('codigo_paciente'),
				"data_agendamento" =>  $data_format
			
			);

			if ($this->m_cadastros->store($dados, $codigo, $this->tabela)) {
				$variaveis['mensagem'] = "Dados gravados com sucesso!";
				$this->load->view('v_sucesso', $variaveis);
			} else {
				$variaveis['mensagem'] = "Ocorreu um erro. Por favor, tente novamente.";
				$this->load->view('errors/html/v_erro', $variaveis);
			}
				
		}
	}
	/**
	 * Chama o formulário com os campos preenchidos pelo registro selecioando.
	 * @param $id do registro
	 * @return view
	 */
	public function edit($codigo = null){
		
		if ($icodigod) {
			
			$cadastros = $this->m_cadastros->get($codigo, $this->tabela);
			
			if ($cadastros->num_rows() > 0 ) {
				$variaveis['titulo'] = 'Edição de Paciente';
				$variaveis['codigo'] = $cadastros->row()->codigo;
				$variaveis['nome'] = $cadastros->row()->nome;
				$this->load->view('v_cadastro_agendamento', $variaveis);

			} else {
				$variaveis['mensagem'] = "Registro não encontrado." ;
				$this->load->view('errors/html/v_erro', $variaveis);
			}
			
		}
		
	}

	public function getPacientes() {
		return $this->db->get('paciente');
	}

	public function getMedicos() {
		return $this->db->get('medico');
	}

	/**
	 * Função que exclui o registro através do id.
	 * @param $id do registro a ser excluído.
	 * @return boolean;
	 */
	public function delete($codigo = null) {
		if ($this->m_cadastros->delete($codigo, $this->tabela)) {
			$variaveis['mensagem'] = "Registro excluído com sucesso!";
			$this->load->view('v_sucesso', $variaveis);
		}
	}
}
