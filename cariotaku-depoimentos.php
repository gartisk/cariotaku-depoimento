<?php
/*
  Plugin Name: Cariotaku Depoimentos
  Version: 1.0
  Plugin URI: www.cariotaku.com.br
  Author: Guilherme Rocha Araujo aka Gartisk
  Author URI: gartisk.com
  Description: Este plugin foi criando especificamente para o site www.cariotaku.com.br	e funciona como complemento do Wordpress Form Manager para a exibição de Depoimentos neste site. O objetivo deste plugin é atender unicamente a especificação do site, portanto não foi acrescentado intercionalização nem outras medidas para deixar este mais flexivel ou utilizavel para outros sites.

 */

$table = array(
			'table' => 'wp_fm_data_9'
			,'nome' => 'text-52b96fcaa52ea'
			,'mensagem' => 'textarea-52b96fd6cd7ff'
			,'evento' => 'custom_list-52bc56ff2fc39'
			,'exibir' => 'metatext-52bc5792b3c5d'
			);

class Cariotaku_Depoimentos{
	
	public function __construct(){
		wp_register_script( 'bxslider', plugins_url( 'js/bxSlider/jquery.bxslider.min.js', __FILE__ ), array('jquery'), '4.1.1' );
		wp_register_style( 'bxslider.css', plugins_url( 'js/bxSlider/jquery.bxslider.css', __FILE__ ), null, '4.0' );
		wp_register_style( 'depoimento.css', plugins_url( 'css/depoimento.css', __FILE__ ), null, null );
		wp_register_script( 'cariotaku-depoimento', plugins_url( 'js/cariotaku-depoimento.js', __FILE__ ), null, null );

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
		global $table;
		
		//Busca por todos os depoimentos
		if( empty($evento) ){
			$sql = "SELECT * FROM `{$table['table']}` WHERE `{$table['exibir']}` = %s";
			$prepare = $wpdb->prepare( $sql, 's' );

		//Busca todos os depoimentos de um evento
		}else{
			$sql = "SELECT * FROM `{$table['table']}` WHERE `{$table['exibir']}` = %s AND `{$table['evento']}` = %s;";	
			$prepare = $wpdb->prepare( $sql, 's', $evento );
		}
		
		$result = $wpdb->get_results($prepare, ARRAY_A);
		
		return $result;
	}

	public function depoimento_sc($atts){
		global $table;
		$settings = shortcode_atts(
			array(
				'evento' => '',
				'adaptiveHeight' => false,
				'mode' => 'fade',
				'auto' => true,
				'autoControls' => true),
			$atts
		);
		
		$result = $this->get_depoimentos($settings['evento']);
		
		//retorna false caso não tenha obtido resultado
		if( empty( $result) ){
			return false;
		}
		
		//remove evento do array por não precisar mais utiliza-lo
		unset($settings['evento']);

		//import js e css
		wp_enqueue_script( 'bxslider' );
		wp_localize_script( 'cariotaku-depoimento', 'ctk_settings', $settings );
		wp_enqueue_script( 'cariotaku-depoimento' );
		wp_enqueue_style( 'bxslider.css' );
		wp_enqueue_style( 'depoimento.css' );
		
		$bxslider = "<div class='depoimentos' >";
		$bxslider .= "<h3>Depoimentos</h3>
					<ul class='bxslider'>";
		foreach ($result as $depoimento) {
			$li ="<li>
					<div class='depoimento'>
						<em>".$depoimento[$table['mensagem']]."</em>
						<div class='depoimento-autor' style='text-align: right;'><strong><em>".$depoimento[$table['nome']]."</em></strong></div>
						<div class='caravana-para' style='text-align: right;'><em>Caravana para ".$depoimento[$table['evento']]."</em></div>
					</div>
				</li>";
			$bxslider .= $li;
		}
		$bxslider .= "</ul>";
		$bxslider .= "</div>";
		return $bxslider;
	}
}
$cariotaku_depoimentos = new Cariotaku_Depoimentos();
?>