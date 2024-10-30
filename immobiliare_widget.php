<?php
class Immobiliare_Widget extends WP_Widget {

	function __construct() {
		parent::__construct('immobiliare_widget', __('Immobiliare Widget', 'immobiliare_domain'), array( 'description' => __( 'Widget per form di ricerca immobili del Plugin Immobiliare', 'immobiliare_domain' ), ) );
	}

	function form($instance) {
		if( $instance) {
		  $title = esc_attr($instance['title']);
		} else {
		  $title = '';
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titolo ricerca', 'immobiliare_domain'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>		
		<?php
		echo __( '<p>');
		echo __( 'Widget per form di ricerca immobili del Plugin Immobiliare', 'immobiliare_domain' );
		echo __( '</p>');
	}
	
	function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
	  return $instance;
	}

	function widget($args, $instance) {
	   extract( $args );
	   $title = apply_filters('widget_title', $instance['title']);
	   echo $before_widget;
	   echo '<div class="widget-text wp_widget_plugin_box">';
	   ?>
     <form method="get" name="cercaimmobili" class="formcercaimmobili" action="<?php echo get_site_url(); ?>/immobili/">
     	<h5>
    	   <?php
    		 if ( $title ) {
    	      echo $before_title . $title . $after_title;
    	   }else{
    	      echo $before_title . 'Ricerca Immobili' . $after_title;
    		 }?>
    	 </h5>
	      	
		 <?php
			 $taxonomy = "comuni";
			 $terms = get_terms($taxonomy, array('orderby' => 'name','hide_empty' => 1));
			 if ( !empty( $terms ) && !is_wp_error( $terms ) ){
		     echo "<label for=\"comuni\">Comune <select name=\"comuni\" id=\"comuni\"><option value=\"\">Comune o Zona</option>";
         foreach ( $terms as $term ) {
		       echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
		        
		     }
         echo "</select></label>";
			 }
       ?>

      <!--<label for="categoria">
        Categoria
	      <select name="categoria" id="categoria">
	      <option value="">Scegli una categoria</option>
					 <?php
					 $taxonomy = "categoria";
                     $terms = get_terms($taxonomy, array('orderby' => 'name','hide_empty' => 1));
					 if ( !empty( $terms ) && !is_wp_error( $terms ) ){
  				     foreach ( $terms as $term ) {
  				       echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
  				        
  				     }
					 }
	         ?>
	      </select>
      </label>-->
      
        
		 <?php
				$i=0;
				$list_of_terms="";
				$taxonomy = "tipologia";
				$current_selected = "";
				$terms = get_terms($taxonomy, array('orderby' => 'name','hide_empty' => 1));
        if ( !empty( $terms ) && !is_wp_error( $terms ) ){
						$list_of_terms.="<label for=\"tipologia\">Tipologia ";
            
            $list_of_terms .= '<select name="tipologia" id="tipologia" style="width:100%;"><option value="">Scegli una tipologia</option>';
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
						echo $list_of_terms;
		 }
		 ?>
    
          
    <label for="immobili_cameredaletto">
      Camere da letto
      <select name="immobili_cameredaletto" id="immobili_cameredaletto" style="width:100%;">
      	<option value="">Camere da letto</option>
      	<option value="1">1</option>
      	<option value="2">2</option>
      	<option value="3">3</option>
      	<option value="4">4 o più</option>					
      </select>
    </label> 

	<label for="immobili_bagni">
      Bagni
      <select name="immobili_bagni" id="immobili_bagni" style="width:100%;">
      	<option value="">Bagni</option>
      	<option value="1">1</option>
      	<option value="2">2</option>
      	<option value="3">3 o più</option>				
      </select>
    </label> 
    
    <label for="immobili_mq">
	Superficie
    	<select name="immobili_mq" id="immobili_mq" style="width:100%;">
    		<option value="">Superficie</option>
    		<option value="50">fino a 50 mq</option>
    		<option value="50_70">da 50 mq a 70 mq</option>
    		<option value="70_100">da 70 mq a 100 mq</option>
    		<option value="100_150">da 100 mq a 150 mq</option>
    		<option value="150_200">da 150 mq a 200 mq</option>
    		<option value="200">oltre i 200 mq</option>
    	</select>
    </label>    
    <label for="immobili_prezzo">
      Prezzo
      <select name="immobili_prezzo" id="immobili_prezzo" style="width:100%;">
      	<option value="">Prezzo</option>
      	<option value="50000"> fino a &euro; 50.000 </option>
      	<option value="100000"> fino a &euro; 100.000 </option>
      	<option value="150000">fino a &euro; 150.000</option>
      	<option value="1">oltre &euro; 150.000</option> 
      </select>
    </label>    
         
      <div class="row">
    	<div class="large-12 medium-12 small-12 columns">
        <input type="radio" name="contratto" value="Vendita" id="contattoVendita"><label class="radio" for="contattoVendita">Vendita</label>
			</div>
    	<div class="large-12 medium-12 small-12 columns">
        <input type="radio" name="contratto" value="Affitto" id="contrattoAffitto"><label class="radio" for="contrattoAffitto">Affitto</label>
			</div>
    	<div class="large-12 medium-12 small-12 columns">
    			<button type="submit" class="button btn btn-ricerca"><i class="fa fa-search"></i>Cerca</button>
			</div>
		</div>
	 </form>
     <?php
	   echo '</div>';
	   echo $after_widget;
	}
}


function immobiliare_widget ()
{
    return register_widget('immobiliare_widget');
}
add_action ('widgets_init', 'immobiliare_widget');
