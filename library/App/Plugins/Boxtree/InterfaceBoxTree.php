<?php

/**
 * Arquivo de interface para box em arvores
 * @author guarient
 *
 */
interface App_Plugins_Boxtree_InterfaceBoxTree
{
	/**
	 * Método para renderizar toda a estrutura de checkbox
	 * @param array $dados -> array simples que contém 
	 * 				['client_id'] -> interger
	 * 				[chave] ->interger
	 * 				[[chave2] -> interger]
	 * @return html
	 */
	public function renderCheck ($dados = null);
	
	/**
	 * Metodo para renderizar os componentes raizes
	 * @param array $rsComp
	 * @param string $html
	 * @param array $dados
	 * @return string
	 */	
	public function renderComponentRoot($rsComp, $html, $dados = null);

	/**
	 * Metodo para retornar todos dependetes para a arvore de seleção
	 * @param int $id
	*/
	public function getDependente($id);
	
	/**
	 * Método para retornar o titulo de um component
	 * @param interger $id
	 * @return string
	 */
	public function find ($id);
	
}