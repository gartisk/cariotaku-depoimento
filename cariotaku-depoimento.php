<?php
/**
 * Plugin Name: Cariotaku Depoimento
 * Version: 0.1
 * Author: Guilherme Rocha Araujo aka Gartisk
 * Author URI: gartisk.com
 * Description: Este plugin funciona como complemento do Wordpress Form Manager para a exibição de depoimentos
 */

//Nome e Campos da Tabela
$dep_table = array(
			'table' => 'wp_fm_data_9'
			,'nome' => 'text-52b96fcaa52ea'
			,'mensagem' => 'textarea-52b96fd6cd7ff'
			,'evento' => 'custom_list-52bc56ff2fc39'
			,'exibir' => 'metatext-52bc5792b3c5d'
		);

class Cariotaku_Depoimento{
	
	public function __construct(){
		wp_register_script( 'bxslider-script', plugins_url( 'bxSlider/jquery.bxslider.min.js', __FILE__ ), array('jquery'), null );
		wp_register_style( 'bxslider-style', plugins_url( 'bxSlider/jquery.bxslider.css', __FILE__ ), null, null );
		wp_register_style( 'depoimento-style', plugins_url( 'depoimento-style.css', __FILE__ ), null, null );
		wp_register_script( 'depoimento-script', plugins_url( 'depoimento-script.js', __FILE__ ), null, null );

		if( !shortcode_exists('depoimento') ){
			add_shortcode( 'depoimento', array( $this, 'depoimento_sc' ) );
		}
	}

	/**
	 * Este metodo tem finalidade de fazer a busca dos depoimentos no banco de dados
	 * @param  string $evento Quando esta variavel vier vazia ou nula este buscará todos os depoimentos recebidos no site.
	 * @return retornará um array com os depoimentos ou falso caso não tenha encontrado.
	 */
	public function get_depoimentos($evento = ''){
		global $wpdb;
		global $dep_table;
		
		//Busca por todos os depoimentos
		if( empty($evento) ){
			$sql = "SELECT * FROM `{$dep_table['table']}` WHERE `{$dep_table['exibir']}` = %s;";
			$prepare = $wpdb->prepare( $sql, 's' );

		//Busca todos os depoimentos de um evento
		}else{
			$sql = "SELECT * FROM `{$dep_table['table']}` WHERE `{$dep_table['exibir']}` = %s AND `{$dep_table['evento']}` = %s;";	
			$prepare = $wpdb->prepare( $sql, 's', $evento );
		}
		
		$result = $wpdb->get_results($prepare, ARRAY_A);
		
		return $result;
	}

	public function depoimento_sc($atts){
		global $dep_table;
		extract( shortcode_atts( array( 'evento' => ''), $atts ) );
		$result = $this->get_depoimentos($evento);
		
		//retorna false caso não tenha obtido resultado
		if( empty( $result) ){
			return false;
		}
		
		//import js e css
		wp_enqueue_script( 'bxslider-script' );
		wp_enqueue_style( 'bxslider-style' );
		wp_enqueue_script( 'depoimento-script' );
		wp_enqueue_style( 'depoimento-style' );
		
		$bxslider = "<h3>Depoimentos</h3>
					<ul class='bxslider'>";
		foreach ($result as $depoimento) {
			$li = "<li>
					<div class='depoimento'>
						<em>".$depoimento[$dep_table['mensagem']]."</em>
						<div class='depoimento-autor' style='text-align: right;'><strong><em>".$depoimento[$dep_table['nome']]."</em></strong></div>
						<div class='caravana-para' style='text-align: right;'><em>Caravana para ".$depoimento[$dep_table['evento']]."</em></div>
					</div>
				</li>";
			$bxslider .= $li;
		}
		$bxslider .= "</ul>";
		return $bxslider;
	}
}
$cariotaku_depoimento = new Cariotaku_Depoimento();
?>