<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_cadastros extends CI_Model {
	
	/**
	 * Grava os dados na tabela.
	 * @param $dados. Array que contém os campos a serem inseridos
	 * @param Se for passado o $codigo via parâmetro, então atualizo o registro em vez de inseri-lo.
	 * @return boolean
	 */
	public function store($dados = null, $codigo = null, $tabela = "default") {
		
		if ($dados) {
			if ($codigo) {
				$this->db->where('codigo', $codigo);
				if ($this->db->update($tabela, $dados)) {
					return true;
				} else {
					return false;
				}
			} else {
				if ($this->db->insert($tabela, $dados)) {
					return true;
				} else {
					return false;
				}
			}
		}
		
	}
	/**
	 * Recupera o registro do banco de dados
	 * @param $codigo - Se indicado, retorna somente um registro, caso contário, todos os registros.
	 * @return objeto da banco de dados da tabela cadastros
	 */
	public function get($codigo = null, $tabela = "default"){
		
		if ($codigo) {
			$this->db->where('codigo', $codigo);
		}
		$this->db->order_by("codigo", 'desc');
		return $this->db->get($tabela);
	}

	
	/**
	 * Deleta um registro.
	 * @param $id do registro a ser deletado
	 * @return boolean;
	 */
	public function delete($codigo = null, $tabela = "default"){
		if ($codigo) {
			return $this->db->where('codigo', $codigo)->delete($tabela);
		}
	}
}
