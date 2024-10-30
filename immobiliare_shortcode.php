<?php
  function immobili_ultimiinseriti(){
		$immobili_args = array('posts_per_page' =>10,'post_type' => 'immobili');
		$immobili_ultimiimmobiliinseriti = get_posts($immobili_args);
		$immobili_strReturn="<h2>Ultimi immobili inseriti</h2><ul class=\"ultimiimmobiliinseriti\">";
		foreach( $immobili_ultimiimmobiliinseriti as $immobile ){
			$immobili_strReturn.="<li><a href=\"".get_permalink($immobile->ID)."\">".$immobile->post_title."</a></li>";
		}
		$immobili_strReturn.="</ul>";
	
		return $immobili_strReturn;
	}

  function immobili_ultimivendita(){
		$immobili_args = array('posts_per_page' =>10,'post_type' => 'immobili');
		$immobili_ultimiimmobiliinseriti = get_posts($immobili_args);
		$immobili_strReturn="<h2>Ultimi immobili in vendita</h2><ul class=\"ultimiimmobilivendita\">";
		foreach( $immobili_ultimiimmobiliinseriti as $immobile ){
			$immobili_strReturn.="<li><a href=\"".get_permalink($immobile->ID)."\">".$immobile->post_title."</a></li>";
		}
		$immobili_strReturn.="</ul>";
	
		return $immobili_strReturn;
	}

  function immobili_ultimiaffitto(){
		$immobili_args = array('posts_per_page' =>10,'post_type' => 'immobili');
		$immobili_ultimiimmobiliinseriti = get_posts($immobili_args);
		$immobili_strReturn="<h2>Ultimi immobili in affitto</h2><ul class=\"ultimiimmobiliaffitto\">";
		foreach( $immobili_ultimiimmobiliinseriti as $immobile ){
			$immobili_strReturn.="<li><a href=\"".get_permalink($immobile->ID)."\">".$immobile->post_title."</a></li>";
		}
		$immobili_strReturn.="</ul>";
	
		return $immobili_strReturn;
	}

  function immobili_ricerca(){
    $immobili_strReturn="<div>";
    $immobili_strReturn.="<form method=\"get\" name=\"cercaimmobili\" class=\"formcercaimmobili\" action=\"/immobili/\">";
    $immobili_strReturn.="<h3>Ricerca Immobili</h3>";
    $taxonomy = "comuni";
    $terms = get_terms($taxonomy, array('orderby' => 'name','hide_empty' => 1));
    if ( !empty( $terms ) && !is_wp_error( $terms ) ){
      $immobili_strReturn.="<label for=\"comuni\">Localit&agrave; <select name=\"comuni\" id=\"comuni\"><option value=\"\">Scegli una localit&agrave;</option>";
       foreach ( $terms as $term ) {
         $immobili_strReturn.="<option value=\"".$term->slug."\">".$term->name."</option>";
          
       }
	    $immobili_strReturn.="</select></label>";
    }
      
    $taxonomy = "contratto";
    $terms = get_terms($taxonomy, array('orderby' => 'name','hide_empty' => 1));
    if ( !empty( $terms ) && !is_wp_error( $terms ) ){
      $immobili_strReturn.="<label for=\"contratto\">Contratto <select name=\"contratto\" id=\"contratto\"><option value=\"\">Scegli un contratto</option>";
      foreach ( $terms as $term ) {
        $immobili_strReturn.="<option value=\"".$term->slug."\">".$term->name."</option>";
      }
	    $immobili_strReturn.="</select></label>";
    }

		$taxonomy = "categoria";
    $terms = get_terms($taxonomy, array('orderby' => 'name','hide_empty' => 1));
    if ( !empty( $terms ) && !is_wp_error( $terms ) ){
       $immobili_strReturn.="<label for=\"categoria\">Categoria <select name=\"categoria\" id=\"categoria\"><option value=\"\">Scegli una categoria</option>";
       foreach ( $terms as $term ) {
         $immobili_strReturn.="<option value=\"".$term->slug."\">".$term->name."</option>";
       }
	     $immobili_strReturn.="</select></label>";
    }

		$i=0;
		$list_of_terms="";
		$taxonomy = "tipologia";
		$current_selected = "";
		$terms = get_terms($taxonomy, array('orderby' => 'name','hide_empty' => 1));
    if ( !empty( $terms ) && !is_wp_error( $terms ) ){
				$list_of_terms .= "<label for=\"tipologia\">Tipologia ";
				$list_of_terms .= '<select name="tipologia" id="tipologia"><option value="">Scegli una tipologia</option>';
				foreach($terms as $term){
				    $select = ($current_selected == $term->slug) ? "selected" : "";
				    if ($term->parent == 0 ) {
				        $tchildren = get_term_children($term->term_id, $taxonomy);
				        $children = array();
				        foreach ($tchildren as $child) {
				            $cterm = get_term_by( 'id', $child, $taxonomy );
				            $children[$cterm->name] = $cterm;
				        }
				        ksort($children);
				        if (count($children) > 0 ) {
				                 $list_of_terms .= '<optgroup label="'. $term->name .'">';
				                 if ($term->count > 0)
				                 $list_of_terms .= '<option value="'.$term->slug.'" '.$select.'>All '. $term->name .' ('.$term->count.')</option>';
				            } else
				            $list_of_terms .= '<option value="'.$term->slug.'" '.$select.'>'. $term->name .' ('.$term->count.')</option>';
				        $i++;
				        foreach($children as $child) {
				             $select = ($current_selected == $cterm->slug) ? "selected" : "";
				             $list_of_terms .= '<option value="'.$child->slug.'" '.$select.'>'. $child->name.' ('.$child->count.')</option>';
				        }
				        if (count($children) > 0 ) {
				            $list_of_terms .= "</optgroup>";
				        }
				    }
				}
				$list_of_terms .= '</select></label>';
				$immobili_strReturn.=$list_of_terms;
		}

    $immobili_strReturn.="<label for=\"immobili_cameredaletto\">Camere <select name=\"immobili_cameredaletto\" id=\"immobili_cameredaletto\">";
    $immobili_strReturn.="<option value=\"\">Camere</option>";
    $immobili_strReturn.="<option value=\"1\">1</option>";
    $immobili_strReturn.="<option value=\"2\">2</option>";
    $immobili_strReturn.="<option value=\"3\">3</option>";
    $immobili_strReturn.="<option value=\"4\">4</option>";
    $immobili_strReturn.="<option value=\"0\">Pi&ugrave; di 4</option>";					
    $immobili_strReturn.="</select></label>"; 

    $immobili_strReturn.="<label for=\"immobili_mq\">Mq	<select name=\"immobili_mq\" id=\"immobili_mq\">";
    $immobili_strReturn.="<option value=\"\">Superficie</option>";
    $immobili_strReturn.="<option value=\"50\">fino a 50 mq</option>";
    $immobili_strReturn.="<option value=\"50_70\">da 50 mq a 70 mq</option>";
    $immobili_strReturn.="<option value=\"70_100\">da 70 mq a 100 mq</option>";
    $immobili_strReturn.="<option value=\"100_150\">da 100 mq a 150 mq</option>";
    $immobili_strReturn.="<option value=\"150_200\">da 150 mq a 200 mq</option>";
    $immobili_strReturn.="<option value=\"200\">oltre i 200 mq</option>";
    $immobili_strReturn.="</select></label>";    

    $immobili_strReturn.="<label for=\"immobili_prezzo\">Prezzo <select name=\"immobili_prezzo\" id=\"immobili_prezzo\">";
    $immobili_strReturn.="<option value=\"\">Prezzo</option>";
    $immobili_strReturn.="<option value=\"50000\"> fino a &euro; 50.000 </option>";
    $immobili_strReturn.="<option value=\"100000\"> fino a &euro; 100.000 </option>";
    $immobili_strReturn.="<option value=\"150000\">fino a &euro; 150.000</option>";
    $immobili_strReturn.="<option value=\"1\">oltre &euro; 150.000</option>"; 
    $immobili_strReturn.="</select></label>";    
		
    $immobili_strReturn.="<div style=\"margin-top:1rem\"><button type=\"submit\" class=\"button round ricerca expand avia-button avia-size-large avia-position-center\"><i class=\"fa fa-search fa-fw\" style=\"margin:0;\"></i>Cerca</button></div>";
		$immobili_strReturn.="</form>";



    return $immobili_strReturn;
	}

  function immobili_ricerca_enfold(){
    $immobili_strReturn="<div>";
    $immobili_strReturn.="<form method=\"get\" name=\"cercaimmobili\" class=\"formcercaimmobili\" action=\"/immobili/\">";
    $immobili_strReturn.="<h3>Ricerca Immobili</h3>";
    
		$i=0;
		$list_of_terms="";
		$taxonomy = "comuni";
		$current_selected = "";
		$terms = get_terms($taxonomy, array('orderby' => 'name','hide_empty' => 1));
    if ( !empty( $terms ) && !is_wp_error( $terms ) ){
				$list_of_terms .= "<div style=\"float:left;min-width:150px;width:auto;padding:0 10px;\">";
				$list_of_terms .= '<select name="comuni" id="comuni"><option value="">Comune o Zona</option>';
				foreach($terms as $term){
				    $select = ($current_selected == $term->slug) ? "selected" : "";
				    if ($term->parent == 0 ) {
				        $tchildren = get_term_children($term->term_id, $taxonomy);
				        $children = array();
				        foreach ($tchildren as $child) {
				            $cterm = get_term_by( 'id', $child, $taxonomy );
				            $children[$cterm->name] = $cterm;
				        }
				        ksort($children);
				        if (count($children) > 0 ) {
				                 $list_of_terms .= '<optgroup label="'. $term->name .'">';
				                 if ($term->count > 0)
				                 $list_of_terms .= '<option value="'.$term->slug.'" '.$select.'>Tutto '. $term->name .' ('.$term->count.')</option>';
				            } else
				            $list_of_terms .= '<option value="'.$term->slug.'" '.$select.'>'. $term->name .' ('.$term->count.')</option>';
				        $i++;
				        foreach($children as $child) {
				             $select = ($current_selected == $cterm->slug) ? "selected" : "";
				             $list_of_terms .= '<option value="'.$child->slug.'" '.$select.'>'. $child->name.' ('.$child->count.')</option>';
				        }
				        if (count($children) > 0 ) {
				            $list_of_terms .= "</optgroup>";
				        }
				    }
				}
				$list_of_terms .= "</select></label></div>";
				$immobili_strReturn.=$list_of_terms;
		}
          
    $taxonomy = "contratto";
    $terms = get_terms($taxonomy, array('orderby' => 'name','hide_empty' => 1));
    if ( !empty( $terms ) && !is_wp_error( $terms ) ){
      $immobili_strReturn.="<div style=\"float:left;min-width:150px;width:auto;padding:0 10px;\"><select name=\"contratto\" id=\"contratto\"><option value=\"\">Contratto</option>";
      foreach ( $terms as $term ) {
        $immobili_strReturn.="<option value=\"".$term->slug."\">".$term->name."</option>";
      }
	    $immobili_strReturn.="</select></label></div>";
    }

		$taxonomy = "categoria";
    $terms = get_terms($taxonomy, array('orderby' => 'name','hide_empty' => 1));
    if ( !empty( $terms ) && !is_wp_error( $terms ) ){
       $immobili_strReturn.="<div style=\"float:left;min-width:150px;width:auto;padding:0 10px;\"><select name=\"categoria\" id=\"categoria\"><option value=\"\">Categoria</option>";
       foreach ( $terms as $term ) {
         $immobili_strReturn.="<option value=\"".$term->slug."\">".$term->name."</option>";
       }
	     $immobili_strReturn.="</select></label></div>";
    }

		$i=0;
		$list_of_terms="";
		$taxonomy = "tipologia";
		$current_selected = "";
		$terms = get_terms($taxonomy, array('orderby' => 'name','hide_empty' => 1));
    if ( !empty( $terms ) && !is_wp_error( $terms ) ){
				$list_of_terms .= "<div style=\"float:left;min-width:150px;width:auto;padding:0 10px;\">";
				$list_of_terms .= '<select name="tipologia" id="tipologia"><option value="">Tipologia</option>';
				foreach($terms as $term){
				    $select = ($current_selected == $term->slug) ? "selected" : "";
				    if ($term->parent == 0 ) {
				        $tchildren = get_term_children($term->term_id, $taxonomy);
				        $children = array();
				        foreach ($tchildren as $child) {
				            $cterm = get_term_by( 'id', $child, $taxonomy );
				            $children[$cterm->name] = $cterm;
				        }
				        ksort($children);
				        if (count($children) > 0 ) {
				                 $list_of_terms .= '<optgroup label="'. $term->name .'">';
				                 if ($term->count > 0)
				                 $list_of_terms .= '<option value="'.$term->slug.'" '.$select.'>All '. $term->name .' ('.$term->count.')</option>';
				            } else
				            $list_of_terms .= '<option value="'.$term->slug.'" '.$select.'>'. $term->name .' ('.$term->count.')</option>';
				        $i++;
				        foreach($children as $child) {
				             $select = ($current_selected == $cterm->slug) ? "selected" : "";
				             $list_of_terms .= '<option value="'.$child->slug.'" '.$select.'>'. $child->name.' ('.$child->count.')</option>';
				        }
				        if (count($children) > 0 ) {
				            $list_of_terms .= "</optgroup>";
				        }
				    }
				}
				$list_of_terms .= "</select></label></div>";
				$immobili_strReturn.=$list_of_terms;
		}

    $immobili_strReturn.="<div style=\"float:left;min-width:150px;width:auto;padding:0 10px;\"><select name=\"immobili_cameredaletto\" id=\"immobili_cameredaletto\">";
    $immobili_strReturn.="<option value=\"\">Camere</option>";
    $immobili_strReturn.="<option value=\"1\">1</option>";
    $immobili_strReturn.="<option value=\"2\">2</option>";
    $immobili_strReturn.="<option value=\"3\">3</option>";
    $immobili_strReturn.="<option value=\"4\">4</option>";
    $immobili_strReturn.="<option value=\"0\">Pi&ugrave; di 4</option>";					
    $immobili_strReturn.="</select></label></div>"; 

    $immobili_strReturn.="<div style=\"float:left;min-width:150px;width:auto;padding:0 10px;\"><select name=\"immobili_mq\" id=\"immobili_mq\">";
    $immobili_strReturn.="<option value=\"\">Superficie</option>";
    $immobili_strReturn.="<option value=\"50\">fino a 50 mq</option>";
    $immobili_strReturn.="<option value=\"50_70\">da 50 mq a 70 mq</option>";
    $immobili_strReturn.="<option value=\"70_100\">da 70 mq a 100 mq</option>";
    $immobili_strReturn.="<option value=\"100_150\">da 100 mq a 150 mq</option>";
    $immobili_strReturn.="<option value=\"150_200\">da 150 mq a 200 mq</option>";
    $immobili_strReturn.="<option value=\"200\">oltre i 200 mq</option>";
    $immobili_strReturn.="</select></label></div>";    

    $immobili_strReturn.="<div style=\"float:left;min-width:150px;width:auto;padding:0 10px;\"><select name=\"immobili_prezzo\" id=\"immobili_prezzo\">";
    $immobili_strReturn.="<option value=\"\">Prezzo</option>";
    $immobili_strReturn.="<option value=\"50000\"> fino a &euro; 50.000 </option>";
    $immobili_strReturn.="<option value=\"100000\"> fino a &euro; 100.000 </option>";
    $immobili_strReturn.="<option value=\"150000\">fino a &euro; 150.000</option>";
    $immobili_strReturn.="<option value=\"1\">oltre &euro; 150.000</option>"; 
    $immobili_strReturn.="</select></label></div>";    

    $immobili_strReturn.="<div style=\"float:left;min-width:150px;width:auto;padding:0 10px;\"><input type=\"radio\" name=\"contratto\" value=\"Vendita\" id=\"contattoVendita\"><label class=\"radio\" for=\"contattoVendita\">Vendita</label>";
		$immobili_strReturn.="<input type=\"radio\" name=\"contratto\" value=\"Affitto\" id=\"contrattoAffitto\"><label class=\"radio\" for=\"contrattoAffitto\">Affitto</label></div>";
		
    $immobili_strReturn.="<div style=\"float:left;min-width:150px;width:auto;padding:0 10px;\"><button type=\"submit\" class=\"button round ricerca expand avia-button avia-size-large avia-position-center\"><i class=\"fa fa-search fa-fw\" style=\"margin:0;\"></i>Cerca</button></div>";
		$immobili_strReturn.="</form>";



    return $immobili_strReturn;
	}
  
  add_shortcode('immobili_ultimiinseriti', 'immobili_ultimiinseriti' );
  add_shortcode('immobili_ultimivendita', 'immobili_ultimivendita' );
  add_shortcode('immobili_ultimiaffitto', 'immobili_ultimiaffitto' );
  add_shortcode('immobili_ricerca', 'immobili_ricerca' );
  add_shortcode('immobili_ricerca_enfold', 'immobili_ricerca_enfold' );

	