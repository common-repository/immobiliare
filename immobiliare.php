<?php
/**
 * Plugin Name: Immobiliare
 * Plugin URI: https://www.matteotestoni.it/servizi/consulente-wordpress/plugin-immobiliare-wordpress/
 * Description: gestionale immobiliare per wordpress. Gestisci i tuoi immobili in modo semplice e veloce.
 * Version: 2.8.0
 * Author: Matteo Testoni
 * Author URI: https://www.matteotestoni.it
 * License: GPL2
 */
 
  defined('ABSPATH') or die("No script kiddies please!");
  define( 'Immobiliare_Version', '2.8.0' );
  define( 'Immobiliare_Directory', dirname( plugin_basename( __FILE__ ) ) );
  define( 'Immobiliare_Path', plugin_dir_path( __FILE__ ) );
  define( 'Immobiliare_URL', plugin_dir_url( __FILE__ ) );

  include 'immobiliare_metabox.php';
  include 'immobiliare_pluginaggiuntivi.php';
  include 'immobiliare_opzioni.php';
  include 'immobiliare_tassonomie.php';
  include 'immobiliare_filtri.php';
  include 'immobiliare_widget.php';
  include 'immobiliare_shortcode.php';
  
  load_plugin_textdomain('immobiliare', false, basename( dirname( __FILE__ ) ) . '/lang' );

	function immobili_print(){
		echo rwmb_meta('immobili_arredato');
	}
	
	function immobili_init() {
	  $labels = array(
	    'name' => 'Immobili',
	    'singular_name' => 'Immobile',
	    'add_new' => 'Aggiungi Immobile',
	    'add_new_item' => 'Aggiungi Immobile',
	    'edit_item' => 'Modifica',
	    'new_item' => 'Nuovo Immobile',
	    'all_items' => 'Tutti gli Immobili',
	    'view_item' => 'Vedi la pagina',
	    'search_items' => 'Cerca',
	    'not_found' =>  'Nessun Immobile trovato',
	    'not_found_in_trash' => 'Nessun Immobile trovato nel cestino', 
	    'parent_item_colon' => '',
	    'menu_name' => 'Immobili'
	  );
	
	  $args = array(
	    'labels' => $labels,
	    'public' => true, //se è visibile nel pannello admin
	    'publicly_queryable' => true,
	    'show_ui' => true, //should we display an admin panel for this custom post type
	    'show_in_menu' => true, 
	    'query_var' => true,
  		'menu_icon' => Immobiliare_URL . '/img/immobili.png', //parte dalla cartella dove si trova function
  		'rewrite' => array( 'slug' => 'immobili' ), //modifica il permalink con il nome della sezione (es: servizi) //'rewrite' => true,  // 
	    'capability_type' => 'post', //wordpress deve sapere come comportarsi per leggere, editare e cancellare il post - a livello di permessi
	    'has_archive' => true, 
	    'hierarchical' => false, //gerarchico come le pagine
	    'menu_position' => null, //oppure un numero
	    'supports' => array( 'title', 'excerpt', 'editor', 'thumbnail','page-attributes' ) // quali item sono supportati ed inseriti nella pagina add/edit del pannello wp-admin - 'editor', 'author', 'comments' 
	  ); 
	  register_post_type( 'immobili', $args );
	}
	
    function immobili_css() {
        $plugin_url = plugin_dir_url( __FILE__ );
        wp_enqueue_style( 'style1', $plugin_url . 'css/immobili.css' );
    }
    add_action( 'wp_enqueue_scripts', 'immobili_css' );


	function immobili_updated_messages( $messages ) {
		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );
		$messages['immobili'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Immobile aggiornato.', 'immobiliare' ),
			2  => __( 'Custom field updated.', 'immobiliare' ),
			3  => __( 'Custom field deleted.', 'immobiliare' ),
			4  => __( 'Immobile updated.', 'immobiliare' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Immobile ripristinato alla revisione %s', 'immobiliare' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( 'Immobile pubblicato.', 'immobiliare' ),
			7  => __( 'Immobile salvato.', 'immobiliare' ),
			8  => __( 'Immobile inviato.', 'immobiliare' ),
			9  => sprintf(
				__( 'Immobile schedulato per: <strong>%1$s</strong>.', 'immobiliare' ),
				date_i18n( __( 'M j, Y @ G:i', 'immobiliare' ), strtotime( $post->post_date ) )
			),
			10 => __( 'Bozza immobile aggiornata.', 'immobiliare' )
		);
	
		if ( $post_type_object->publicly_queryable ) {
			$permalink = get_permalink( $post->ID );
			$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'Visualizza immobile', 'immobiliare' ) );
			$messages[ $post_type ][1] .= $view_link;
			$messages[ $post_type ][6] .= $view_link;
			$messages[ $post_type ][9] .= $view_link;
	
			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
			$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Anteprima immobile', 'immobiliare' ) );
			$messages[ $post_type ][8]  .= $preview_link;
			$messages[ $post_type ][10] .= $preview_link;
		}
		return $messages;
	}
	
	function immobili_add_help_text( $contextual_help, $screen_id, $screen ) {
	  if ( 'immobili' == $screen->id ) {
	    $contextual_help =
	      '<p>' . __('Cose da ricordare in modifica di un immobile:', 'immobiliare') . '</p>' .
	      '<ul>' .
	      '<li>' . __('Specifica dettagliatamente in che tipologie può essere inserito.', 'immobiliare') . '</li>' .
	      '<li>' . __('Speicifica nel titolo se in vendita o affitto e la tipologia.', 'immobiliare') . '</li>' .
	      '</ul>' .
	      '<p>' . __('Se vuoi schedulare che un annuncio sia pubblicato nel futuro:', 'immobiliare') . '</p>' .
	      '<ul>' .
	      '<li>' . __('Sotto il modulo di Pubblica, fare clic sul link Modifica accanto a Pubblica.', 'immobiliare') . '</li>' .
	      '<li>' . __('Modificare la data di pubblicazione con una data nel futuro, quindi fare clic su Ok.', 'immobiliare') . '</li>' .
	      '</ul>' .
	      '<p><strong>' . __('Per maggiori informazioni:', 'immobiliare') . '</strong></p>' .
	      '<p>' . __('http://www.matteotestoni.it/servizi/consulente-wordpress/plugin-immobiliare-wordpress/', 'immobiliare') . '</p>' .
	      '<p>' . __('https://wordpress.org/plugins/immobiliare/', 'immobiliare') . '</p>' ;
	  } elseif ( 'edit-immobili' == $screen->id ) {
	    $contextual_help =
	      '<p>' . __('Elenco immobili inseriti con dettaglio di categoria, tipologia, contratto, comune e visualizzazioni.', 'immobiliare') . '</p>' ;
	  }
	  return $contextual_help;
	}
	
	function immobili_aggiungiattributialcontenutolista($content){
		$post = get_post();
        if ((get_post_type($post)=="immobili") && (is_archive()==true)) {
			$immobile_tabellacaratteristiche="<span class=\"blog-tags minor-meta\">";
            if (rwmb_meta('immobili_locali')!="0"){ 
                $immobili_attributo_valore=rwmb_meta('immobili_locali'); 
                $immobile_tabellacaratteristiche.="<div class=\"immobili-attribute-list\"><span class=\"label\">Numero locali:</span> <span class=\"value\">".$immobili_attributo_valore."</span></div>";
            }
			if (rwmb_meta('immobili_mq')!=""){  
    			$immobili_attributo_valore=rwmb_meta('immobili_mq');
    			$immobile_tabellacaratteristiche.="<div class=\"immobili-attribute-list\"><span class=\"label\">Mq:</span> <span class=\"value\">".$immobili_attributo_valore."</span></div>";
            }
			if (rwmb_meta('immobili_bagni')!="0"){ 
                $immobili_attributo_valore=rwmb_meta('immobili_bagni'); 
                $immobile_tabellacaratteristiche.="<div class=\"immobili-attribute-list\"><span class=\"label\">Bagni:</span> <span class=\"value\">".$immobili_attributo_valore."</span></div>";
            }
			if (rwmb_meta('immobili_cameredaletto')!="0"){  
                $immobili_attributo_valore=rwmb_meta('immobili_cameredaletto'); 
  			    $immobile_tabellacaratteristiche.="<div class=\"immobili-attribute-list\"><span class=\"label\">Camere da letto:</span> <span class=\"value\">".$immobili_attributo_valore."</span></div>";
            }
			if (rwmb_meta('immobili_rif')!=""){ 
                $immobili_attributo_valore=rwmb_meta('immobili_rif'); 
      			$immobile_tabellacaratteristiche.="<div class=\"immobili-attribute-list\"><span class=\"label\">Rif.:</span> <span class=\"value\">".$immobili_attributo_valore."</span></div>";
            }                               
            $immobile_tabellacaratteristiche.="</span>";
            $content.=$immobile_tabellacaratteristiche;
        }
		return $content;
    }

	function immobili_aggiungiattributialcontenutoscheda($content){
		$post = get_post();
    if ((get_post_type($post)=="immobili") && (is_single()==true)) {

      if (rwmb_meta('immobili_prezzo')!=""){
        $immobile_prezzo="<div style=\"margin-bottom:2rem\"><h2 style=\"clear:both\">Prezzo: ".number_format(rwmb_meta('immobili_prezzo'),0,",",".")."</h2></div>";
      }else{
        $immobile_prezzo="";
      }
      
      if (rwmb_meta('immobili_video', 'type=oembed')!=""){
        
        $immobile_video="<style type=\"text/css\">.rwmb-oembed-not-available {display: none;}</style>";
        $immobile_video.="<div style=\"margin-bottom:2rem\">".rwmb_meta( 'immobili_video', 'type=oembed' );
        $immobile_video.="</div>";
      }else{
        $immobile_video="";
      }

      if (rwmb_meta('immobili_virtualtour')!=""){
        $immobile_virtualtour="<h2>Virtual Tour</h2><div class=\"virtualtour\">";
        $immobile_virtualtour.="<div style=\"margin-bottom:2rem\">".rwmb_meta( 'immobili_virtualtour' );
        $immobile_virtualtour.="</div>";
      }else{
        $immobile_virtualtour="";
      }
      
			$immobile_listagalleria=rwmb_meta('immobili_galleria', 'type=image' );
      $immobile_galleria=count($immobile_listagalleria);
      if (count($immobile_listagalleria)>0){
        $immobile_galleria="<style type=\"text/css\">";
  			$immobile_galleria.="#gallery-1 { margin: auto;}\n";
  			$immobile_galleria.="#gallery-1 .gallery-item {";
  			$immobile_galleria.="float: left;";
  			$immobile_galleria.="margin-top: 10px;";
  			$immobile_galleria.="text-align: center;";
  			$immobile_galleria.="width: 25%;";
  			$immobile_galleria.="}";
  			$immobile_galleria.="#gallery-1 img {";
  			$immobile_galleria.="border: 2px solid #cfcfcf;";
  			$immobile_galleria.="}";
  			$immobile_galleria.="#gallery-1 .gallery-caption {";
  			$immobile_galleria.="margin-left: 0;";
  			$immobile_galleria.="}";
  			$immobile_galleria.="</style>";
				$immobile_galleria.="<h2>Galleria immagini</h2>";
				$immobile_galleria.="<div id=\"gallery-1\" style=\"margin-bottom:2rem\" class=\"gallery galleryid-9999 gallery-columns-3 gallery-size-thumbnail\">";
				foreach ( $immobile_listagalleria as $image ){
					$immobile_galleria.="<dl class=\"gallery-item\"><dt class=\"gallery-icon landscape\"><a href='{$image['full_url']}' title='{$image['title']}'><img src='{$image['url']}' data-caption='{$image['title']}' alt='{$image['title']}' class=\"attachment-thumbnail size-thumbnail\" /></a></dt></dl>\n";
				}
				$immobile_galleria.="<br style=\"clear: both\">";
				$immobile_galleria.="</div>";
			}else{
        $immobile_galleria="";
      }
      
			$immobile_listaplanimetria=rwmb_meta('immobili_planimetria', 'type=image' );
      $immobile_planimetria=count($immobile_listaplanimetria);
      if (count($immobile_listaplanimetria)>0){
        $immobile_planimetria="<style type=\"text/css\">";
  			$immobile_planimetria.="#planimetria-1 { margin: auto;}\n";
  			$immobile_planimetria.="#planimetria-1 .gallery-item {";
  			$immobile_planimetria.="float: left;";
  			$immobile_planimetria.="margin-top: 10px;";
  			$immobile_planimetria.="text-align: center;";
  			$immobile_planimetria.="width: 25%;";
  			$immobile_planimetria.="}";
  			$immobile_planimetria.="#planimetria-1 img {";
  			$immobile_planimetria.="border: 2px solid #cfcfcf;";
  			$immobile_planimetria.="}";
  			$immobile_planimetria.="#planimetria-1 .gallery-caption {";
  			$immobile_planimetria.="margin-left: 0;";
  			$immobile_planimetria.="}";
  			$immobile_planimetria.="</style>";
				$immobile_planimetria.="<h2>Planimetrie</h2>";
				$immobile_planimetria.="<div id=\"planimetria-1\" style=\"margin-bottom:2rem\" class=\"gallery galleryid-9999 gallery-columns-3 gallery-size-thumbnail\">";
				foreach ( $immobile_listaplanimetria as $image ){
					$immobile_planimetria.="<dl class=\"gallery-item\"><dt class=\"gallery-icon landscape\"><a href='{$image['full_url']}' title='{$image['title']}'><img src='{$image['url']}' data-caption='{$image['title']}' alt='{$image['title']}' class=\"attachment-thumbnail size-thumbnail\" /></a></dt></dl>\n";
				}
				$immobile_planimetria.="<br style=\"clear: both\">";
				$immobile_planimetria.="</div>";
			}else{
        $immobile_planimetria="";
      }

			$immobile_listaallegati=rwmb_meta('immobili_allegati','type=file');
			if (count($immobile_listaallegati)>0){
				$immobile_allegati.="<h2>Allegati</h2>";
		    $immobile_allegati.="<ul class=\"documents\">";
				foreach ( $immobile_listaallegati as $allegato ){
				  $immobile_allegati.="<li><a href='{$allegato['url']}' title='{$allegato['title']}' role='button' target='_blank'><i class=\"fa fa-file-pdf-o fa-lg fa-fw\" style=\"color:#CF1312\"></i>{$allegato['title']}</a></li>";
				}
				$immobile_allegati.="</ul>";
			}else{
				$immobile_allegati="";
			}
	
  		$immobile_tabellacaratteristiche="<h2>Caratteristiche</h2>";
			$immobile_tabellacaratteristiche.="<ul class=\"menu caratteristiche\">";

	
			if (rwmb_meta('immobili_rif')!=""){ 
        $immobili_attributo_valore=rwmb_meta('immobili_rif'); 
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Riferimento:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_vistamare')=="1"){ 
        $immobili_attributo_valore="si"; 
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Vista Mare:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_nocondominio')=="1"){ 
        $immobili_attributo_valore="no"; 
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Condominio:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_tipo')!=""){ 
        $immobili_attributo_valore=rwmb_meta('immobili_tipo'); 
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Tipo:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }

  		$immobile_tabellacaratteristiche.="</ul><h2>Stanze</h2><ul class=\"menu caratteristiche\">";
			if (rwmb_meta('immobili_locali')!="0"){ 
        $immobili_attributo_valore=rwmb_meta('immobili_locali'); 
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Numero locali:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_mq')!=""){  
  			$immobili_attributo_valore=rwmb_meta('immobili_mq');
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Mq:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_bagni')!="0"){ 
        $immobili_attributo_valore=rwmb_meta('immobili_bagni'); 
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Bagni:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_cameredaletto')!="0"){  
        $immobili_attributo_valore=rwmb_meta('immobili_cameredaletto'); 
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Camere da letto:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_ingresso')!=""){  
  			$immobili_attributo_valore=rwmb_meta('immobili_ingresso');
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Ingresso:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_soggiorno')!=""){  
  			$immobili_attributo_valore=rwmb_meta('immobili_soggiorno');
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Soggiorno:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_cucina')!=""){ 
  			$immobili_attributo_valore=rwmb_meta('immobili_cucina');
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Cucina:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_balcone')!=""){  
  			$immobili_attributo_valore=rwmb_meta('immobili_balcone');
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Balcone:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_terrazzo')!=""){  
  			$immobili_attributo_valore=rwmb_meta('immobili_terrazzo');
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Terrazzo:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_cantina')=="1"){ 
        $immobili_attributo_valore="si"; 
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Cantina:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
	
			if (rwmb_meta('immobili_solaio')=="1"){ 
        $immobili_attributo_valore="si"; 
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Solaio:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_portico')!=""){ 
        $immobili_attributo_valore="si"; 
   			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Portico:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_arredato')!=""){ 
        $immobili_attributo_valore=rwmb_meta('immobili_arredato'); 
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Arredato:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			
	
	
  		$immobile_tabellacaratteristiche.="</ul><h2>Parcheggi</h2><ul class=\"menu caratteristiche\">";
			if (rwmb_meta('immobili_postoauto')!=""){  
  			$immobili_attributo_valore=rwmb_meta('immobili_postoauto');
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Posto auto:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_postomotocicli')!=""){  
  			$immobili_attributo_valore=rwmb_meta('immobili_postomotocicli');
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Posto cicli e motocicli:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }

  	    
  
			$speceCondominiali=rwmb_meta('immobili_spese');
			switch ($speceCondominiali){
  			case "0":
  				$immobili_attributo_valore="nessuna";
  				break;
    			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Spese cond.:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
  			case "":
  				$immobili_attributo_valore="-";
  				break;
  			default:
  				$immobili_attributo_valore='&euro; '.rwmb_meta( 'immobili_spese' ).' '.rwmb_meta( 'immobili_spesetipo' ); 
    			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Spese cond.:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
  			}
	

			if (rwmb_meta('immobili_categoriacatastale')!=""){ 
        $immobili_attributo_valore=rwmb_meta('immobili_categoriacatastale'); 
  			$immobile_confort.="<li><span class=\"label\">Categoria Catastale:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_renditacatastale')!=""){ 
        $immobili_attributo_valore=rwmb_meta('immobili_renditacatastale'); 
  			$immobile_confort.="<li><span class=\"label\">Rendita Catastale:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }

			if (rwmb_meta('immobili_piscina')=="1"){ 
        $immobili_attributo_valore="si"; 
  			$immobile_confort.="<li><span class=\"label\">Piscina:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_idromassaggio')=="1"){ 
        $immobili_attributo_valore="si"; 
  			$immobile_confort.="<li><span class=\"label\">Idromassaggio:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_ascensore')=="1"){ 
        $immobili_attributo_valore="si"; 
  			$immobile_confort.="<li><span class=\"label\">Ascensore:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_condizionatore')=="1"){ 
        $immobili_attributo_valore="si"; 
  			$immobile_confort.="<li><span class=\"label\">Condizionatore:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_satellite')=="1"){ 
        $immobili_attributo_valore="si"; 
  			$immobile_confort.="<li><span class=\"label\">Satellite:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_giardino')=="1"){ 
  			$immobili_attributo_valore=rwmb_meta('immobili_giardino');
  			$immobile_confort.="<li><span class=\"label\">Giardino:</span> <span class=\"value\">".$immobili_attributo_valore." di ".rwmb_meta( 'immobili_mqgiardino' )." mq</span></li>";
      }
      if (strlen($immobile_confort)>0){
    		$immobile_confort="<h2>Confort</h2><ul class=\"menu caratteristiche\">".$immobile_confort."</ul>";
        $immobile_tabellacaratteristiche=$immobile_tabellacaratteristiche."</ul>".$immobile_confort."<ul class=\"menu caratteristiche\">";
      }
      

  		$immobile_tabellacaratteristiche.="</ul><h2>Struttura</h2><ul class=\"menu caratteristiche\">";
			if (rwmb_meta('immobili_piano')!=""){  
  			$immobili_attributo_valore=rwmb_meta('immobili_piano');
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Piano:</span> <span class=\"value\">".$immobili_attributo_valore." di ".rwmb_meta( 'immobili_numeropiani' )." piani</span></li>";
      }
			if (rwmb_meta('immobili_stato')!=""){  
  			$immobili_attributo_valore=rwmb_meta('immobili_stato');
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Stato immobile:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_riscaldamento')!=""){ 
  			$immobili_attributo_valore=rwmb_meta('immobili_riscaldamento');
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Riscaldamento:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
			if (rwmb_meta('immobili_tiporiscaldamento')!=""){ 
  			$immobili_attributo_valore=rwmb_meta('immobili_tiporiscaldamento');
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Tipo riscaldamento:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
	    }
			if (rwmb_meta('immobili_ape')!=""){ 
  			$immobili_attributo_valore=rwmb_meta('immobili_ape');
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">APE:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
	    }
			if (rwmb_meta('immobili_anno')!=""){ 
  	    $immobili_attributo_valore=rwmb_meta('immobili_anno');
  			$immobile_tabellacaratteristiche.="<li><span class=\"label\">Anno Costruzione:</span> <span class=\"value\">".$immobili_attributo_valore."</span></li>";
      }
	
	
			$immobile_tabellacaratteristiche.="</ul>";
			
      $immobile_mappa="<h2>Mappa</h2>";
			$args = array(
            'js_options' => array(
                'mapTypeId'   => 'HYBRID',
                'zoomControl' => true,
            ),
      			'type'         => 'HYBRID',
      			'width'        => '100%',
      			'height'       => '400px',
      			'zoom'         => 15, 
      			'marker'       => true,
            'language'     => 'it',
      			'marker_title' => 'immobile',
      			'info_window'  => rwmb_meta( 'immobili_address' ),
      			'api_key'      => get_option('immobiliare_google_api_key')
			);
			$immobile_mappa.=rwmb_meta( 'immobili_loc', $args );
      $content.=$immobile_prezzo.$immobile_video.$immobile_virtualtour.$immobile_galleria.$immobile_planimetria.$immobile_allegati.$immobile_tabellacaratteristiche.$immobile_mappa;
		}
		return $content;
	}

	add_action('init', 'immobili_init' );
	add_action('contextual_help', 'immobili_add_help_text', 10, 3 );		
	add_filter('post_updated_messages', 'immobili_updated_messages' );
	//add_action('pre_get_posts', 'immobili_pre_get_posts');				
 	
	$immobiliare_metanotincontent=get_option('immobiliare_metanotincontent');
    if (get_option('immobiliare_metanotincontent')!="1"){
        add_filter('the_content', 'immobili_aggiungiattributialcontenutoscheda');
	}

	$immobiliare_metainlist=get_option('immobiliare_metainlist');
    if (get_option('immobiliare_metainlist')=="1"){
        add_filter('the_content', 'immobili_aggiungiattributialcontenutolista');
	}
    
  //filtri di ricerca aggiuntivi
  add_filter( 'pre_get_posts' , 'immobili_add_meta_to_search' );
	function immobili_add_meta_to_search( $query ) {
	if( ($query->is_main_query()) && ($query->get('post_type') == 'immobili')) {
    	$immobili_rif=$_GET["immobili_rif"];
    	$immobili_cameredaletto=$_GET["immobili_cameredaletto"];
    	$immobili_mq=$_GET["immobili_mq"];
    	$immobili_prezzo=htmlspecialchars($_GET["immobili_prezzo"]);
        	if($immobili_rif!=NULL) {
        		$rif_senzaspazi = str_replace(' ', '', $immobili_rif);
        		$rif_trovato=strtolower($rif_senzaspazi);
        		$rif_immobile='immobili_rif';
        		$rif_cercato_senzaspzi=str_replace(' ', '', $rif_immobile);
        		$rif_cercato=strtolower($rif_cercato_senzaspzi);
        		$array_rif=array('key' => $rif_immobile,'value' => $immobili_rif,'compare' => '==','relation' => 'OR');				
        	}else {
        	   $array_rif=null;
        	}
    			
        	if($immobili_bagni!=NULL) {
        		switch ($immobili_bagni) {
        			case ($immobili_bagni=='1'):
        			 $array_camere=array('key' => 'immobili_bagni','value' => '1','compare' => '==','type' => 'NUMERIC');        		
        			break;
        					 
        			case ($immobili_bagni=='2'):
        			 $array_camere=array('key' => 'immobili_bagni','value' => '2','compare' => '==','type' => 'NUMERIC');
        			break;
        
        			case ($immobili_bagni=='3'):
        			 $array_camere=array('key' => 'immobili_bagni','value' => '3','compare' => '>=','type' => 'NUMERIC');
        			break;		
        		}			  
        	}

			if($immobili_cameredaletto!=NULL) {
        		switch ($immobili_cameredaletto) {
        			case ($immobili_cameredaletto=='1'):
        			 $array_camere=array('key' => 'immobili_cameredaletto','value' => '1','compare' => '==','type' => 'NUMERIC');        		
        			break;
        					 
        			case ($immobili_cameredaletto=='2'):
        			 $array_camere=array('key' => 'immobili_cameredaletto','value' => '2','compare' => '==','type' => 'NUMERIC');
        			break;
        
        			case ($immobili_cameredaletto=='3'):
        			 $array_camere=array('key' => 'immobili_cameredaletto','value' => '3','compare' => '==','type' => 'NUMERIC');
        			break;			
        			
        			case ($immobili_cameredaletto=='4'):
        			 $array_camere=array('key' => 'immobili_cameredaletto','value' => '4','compare' => '>=','type' => 'NUMERIC');
        			break;		
        		}			  
        	}
        	
        	if($immobili_mq!=NULL) {
        		switch ($immobili_mq) {
        			case ($immobili_mq=='50'):
        			 $array_mq=array('key' => 'immobili_mq','value' => '50','compare' => '<=','type' => 'NUMERIC');
        		
        			break;
        					 
        			case ($immobili_mq=='50_70'):
        			$array_mq=array('key' => 'immobili_mq','value' => array('50','70'),'compare' => 'between','type' => 'NUMERIC');
        			break;
        
        			case ($immobili_mq=='70_100'):
        			$array_mq=array('key' => 'immobili_mq','value' => array('80','100'),'compare' => 'between','type' => 'NUMERIC');
        			break;			
        			
        			case ($immobili_mq=='100_150'):
        			$array_mq=array('key' => 'immobili_mq','value' => array('100','150'),'compare' => 'between','type' => 'NUMERIC');
        			break;		
        			
        			case ($immobili_mq=='150_200'):
        			$array_mq=array('key' => 'immobili_mq','value' => array('150','200'),'compare' => 'between','type' => 'NUMERIC');
        			break;
        			
        			case ($immobili_mq=='200'):
        			$array_mq=array('key' => 'immobili_mq','value' => '200','compare' => '=>','type' => 'NUMERIC');
        			break;				
        		}			  
        	}		
    	
          	if($immobili_prezzo!=NULL) {
          		switch ($immobili_prezzo) {
          			case ($immobili_prezzo=='1'):
          			 $array_prezzo=array('key' => 'immobili_prezzo','value' => '150000','compare' => '>','type' => 'NUMERIC');
          			$array_prezzo2=array('key' => 'immobili_prezzo-precedente','value' => '150000','compare' => '>','type' => 'NUMERIC');
          					
          			break;
          					 
          			case ($immobili_prezzo=='50000'):
          			$array_prezzo= array('meta_query' => array('relation' => 'JOIN',array('key' => 'immobili_prezzo','value' => '50000','compare' => '<=','type' => 'NUMERIC'),));
          			break;
          			
          			case ($immobili_prezzo=='100000'):
          			$array_prezzo=array('key' => 'immobili_prezzo','value' => '100000','compare' => '<=','type' => 'NUMERIC');
          			break;
          			
          			case ($immobili_prezzo=='150000'):
          			$array_prezzo=array('key' => 'immobili_prezzo','value' => '150000','compare' => '<=','type' => 'NUMERIC');
          			break;
          			
          			case ($immobili_prezzo=='1'):
          			$array_prezzo=array('key' => 'immobili_prezzo','value' => '150000','compare' => '>','type' => 'NUMERIC');
          			break;
          		}			  
          	}		
    						
    			$query->set( 'meta_query', 
    			array(
    			'relation' => 'AND',$array_rif,$array_prezzo,$array_camere,$array_mq
    	
    		)); 
    	}
    
    	return $query;
    }
      

