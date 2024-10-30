<?php
	/* tipologia e contratto immobili*/
	function immobili_tassonomia_tipologia() {
		$labels = array(
			'name'              => __( 'Tipologie', 'taxonomy general name' ),
			'singular_name'     => __( 'Tipologia', 'taxonomy singular name' ),
			'search_items'      => __( 'Cerca tipologia' ),
			'all_items'         => __( 'Tutte le tipologie' ),
			'parent_item'       => __( 'Tipologia padre' ),
			'parent_item_colon' => __( 'Tipologia padre:' ),
			'edit_item'         => __( 'Modifica tipologia' ), 
			'update_item'       => __( 'Aggiorna tipologia' ),
			'add_new_item'      => __( 'Aggiungi nuova tipologia' ),
			'new_item_name'     => __( 'Nome della nuova tipologia' ),
			'menu_name'         => __( 'Tipologie' ),
		);
		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'show_in_nav_menus'     => true,
		);
		register_taxonomy( 'tipologia', 'immobili', $args );
	}
	add_action( 'init', 'immobili_tassonomia_tipologia', 0 );

  /* categorie: residenziale commerciale*/
	function immobili_tassonomia_categoria() {
		$labels = array(
			'name'              => __( 'Categorie', 'taxonomy general name' ),
			'singular_name'     => __( 'Categorie', 'taxonomy singular name' ),
			'search_items'      => __( 'Cerca categoria' ),
			'all_items'         => __( 'Tutte le categorie' ),
			'parent_item'       => __( 'Categoria padre' ),
			'parent_item_colon' => __( 'Categoria padre:' ),
			'edit_item'         => __( 'Modifica categoria' ), 
			'update_item'       => __( 'Aggiorna categoria' ),
			'add_new_item'      => __( 'Aggiungi nuova categoria' ),
			'new_item_name'     => __( 'Nome della nuova categoria' ),
			'menu_name'         => __( 'Categorie' ),
		);
		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'show_in_nav_menus'     => true,
		);
		register_taxonomy( 'categoria', 'immobili', $args );
	}
	add_action( 'init', 'immobili_tassonomia_categoria', 0 );

 	function immobili_tassonomia_tag() {
		$labels = array(
			'name'              => __( 'Tag', 'taxonomy general name' ),
			'singular_name'     => __( 'Tag', 'taxonomy singular name' ),
			'search_items'      => __( 'Cerca tag' ),
			'all_items'         => __( 'Tutte i tag' ),
			'parent_item'       => __( 'Tag padre' ),
			'parent_item_colon' => __( 'Tag padre:' ),
			'edit_item'         => __( 'Modifica tag' ), 
			'update_item'       => __( 'Aggiorna tag' ),
			'add_new_item'      => __( 'Aggiungi nuovo tag' ),
			'new_item_name'     => __( 'Nome del tag' ),
			'menu_name'         => __( 'Tag' ),
			'not_found'         => __( 'Nessun Tag Prodotto trovato' ),
		);
		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'show_in_nav_menus'     => true,
		);
		register_taxonomy( 'immobili_tag', 'immobili', $args );
	}
	add_action( 'init', 'immobili_tassonomia_tag', 0 );
 
	function immobili_tassonomia_contratto() {
		$labels = array(
			'name'              => _x( 'Contratto', 'taxonomy general name' ),
			'singular_name'     => _x( 'Contratto', 'taxonomy singular name' ),
			'search_items'      => __( 'Cerca Contratto' ),
			'all_items'         => __( 'Tutti i contratti' ),
			'parent_item'       => __( 'Contratto padre' ),
			'parent_item_colon' => __( 'Contratto padre:' ),
			'edit_item'         => __( 'Modifica Contratto' ), 
			'update_item'       => __( 'Aggiorna Contratto' ),
			'add_new_item'      => __( 'Aggiungi nuovo Contratto' ),
			'new_item_name'     => __( 'Nome del nuovo Contratto' ),
			'menu_name'         => __( 'Contratti' ),
		);
		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'show_in_nav_menus'     => true,
		);
		register_taxonomy( 'contratto', 'immobili', $args );
	}
	add_action( 'init', 'immobili_tassonomia_contratto', 0 );

	function immobili_tassonomia_comune() {
		$labels = array(
			'name'              => _x( 'Comune', 'taxonomy general name' ),
			'singular_name'     => _x( 'Localit&agrave;', 'taxonomy singular name' ),
			'search_items'      => __( 'Cerca Localit&agrave;' ),
			'all_items'         => __( 'Tutti le localit&agrave;' ),
			'parent_item'       => __( 'Localit&agrave; padre' ),
			'parent_item_colon' => __( 'Localit&agrave; padre:' ),
			'edit_item'         => __( 'Modifica Localit&agrave;' ), 
			'update_item'       => __( 'Aggiorna Localit&agrave;' ),
			'add_new_item'      => __( 'Aggiungi nuova Localit&agrave;' ),
			'new_item_name'     => __( 'Nome della nuova Localit&agrave;' ),
			'menu_name'         => __( 'Localit&agrave;' ),
		);
		$args = array(
			'labels' 			=> $labels,
			'hierarchical' 		=> true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
		);
		register_taxonomy( 'comuni', 'immobili', $args );
	}
	add_action( 'init', 'immobili_tassonomia_comune', 0 );