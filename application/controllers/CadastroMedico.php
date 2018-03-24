<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CadastroMedico extends CI_Controller {

	public $tabela = "medico";

	/**
	 * Carrega o formulário para novo cadastro de um paciente
	 * @param nenhum
	 * @return view
	 */
	public function create()
	{
		$variaveis['titulo'] = 'Cadastrar Médico';
		$this->load->view('v_cadastro_medico', $variaveis);
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
		                'field' => 'nome',
		                'label' => 'Nome',
		                'rules' => 'required'
		        )
		);
		
		$this->form_validation->set_rules($regras);

		if ($this->form_validation->run() == FALSE) {
			$variaveis['titulo'] = 'Novo Registro';
			$this->load->view('v_cadastro_medico', $variaveis);
		} else {
			
			$codigo = $this->input->post('codigo');
			$dados = array(
				"nome" => $this->input->post('nome')
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
				$variaveis['titulo'] = 'Edição de Médico';
				$variaveis['codigo'] = $cadastros->row()->codigo;
				$variaveis['nome'] = $cadastros->row()->nome;
				$this->load->view('v_cadastro_medico', $variaveis);

			} else {
				$variaveis['mensagem'] = "Registro não encontrado." ;
				$this->load->view('errors/html/v_erro', $variaveis);
			}
			
		}
		
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
