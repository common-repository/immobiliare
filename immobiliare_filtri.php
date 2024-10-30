<?php
add_action( 'restrict_manage_posts', 'restrict_manage_posts_immobiliare' );
function restrict_manage_posts_immobiliare(){
    $type = 'post';
    if (isset($_GET['post_type'])) {
      $type = $_GET['post_type'];
    }
    if ('immobili' == $type){
        ?>
        <select name="comuni">
        <option value=""><?php _e('Filtra per comune', 'immobiliare'); ?></option>
        <?php
           $current_v = isset($_GET['comuni'])? $_GET['comuni']:'';
					 $terms = get_terms("comuni","orderby=name&hide_empty=0");
					 if ( !empty( $terms ) && !is_wp_error( $terms ) ){
				     foreach ( $terms as $term ) {
				      if ($current_v==$term->slug){
							  echo '<option value="' . $term->slug . '" selected>' . $term->name . '</option>';
							}else{
							  echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
							}
				     }
					 }
        ?>
        </select>
        <!--<select name="categoria">
        <option value=""><?php _e('Filtra per categoria', 'immobiliare'); ?></option>
        <?php
           $current_v = isset($_GET['categoria'])? $_GET['categoria']:'';
					 $terms = get_terms("categoria","orderby=name&hide_empty=0");
					 if ( !empty( $terms ) && !is_wp_error( $terms ) ){
				     foreach ( $terms as $term ) {
				      if ($current_v==$term->slug){
							  echo '<option value="' . $term->slug . '" selected>' . $term->name . '</option>';
							}else{
							  echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
							}
				     }
					 }
        ?>
        </select>-->
        <select name="tipologia">
        <option value=""><?php _e('Filtra per tipologia', 'immobiliare'); ?></option>
        <?php
           $current_v = isset($_GET['tipologia'])? $_GET['tipologia']:'';
					 $terms = get_terms("tipologia","orderby=name&hide_empty=0");
					 if ( !empty( $terms ) && !is_wp_error( $terms ) ){
				     foreach ( $terms as $term ) {
				      if ($current_v==$term->slug){
							  echo '<option value="' . $term->slug . '" selected>' . $term->name . '</option>';
							}else{
							  echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
							}
				     }
					 }
        ?>
        </select>
        <select name="contratto">
        <option value=""><?php _e('Filtra per contratto', 'immobiliare'); ?></option>
        <?php
           $current_v = isset($_GET['contratto'])? $_GET['contratto']:'';
					 $terms = get_terms("contratto","orderby=name&hide_empty=0");
					 if ( !empty( $terms ) && !is_wp_error( $terms ) ){
				     foreach ( $terms as $term ) {
				      if ($current_v==$term->slug){
							  echo '<option value="' . $term->slug . '" selected>' . $term->name . '</option>';
							}else{
							  echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
							}
				     }
					 }
        ?>
        </select>
        <select name="immobili_tag">
        <option value=""><?php _e('Filtra per tag', 'immobiliare'); ?></option>
        <?php
           $current_v = isset($_GET['immobili_tag'])? $_GET['immobili_tag']:'';
					 $terms = get_terms("immobili_tag","orderby=name&hide_empty=0");
					 if ( !empty( $terms ) && !is_wp_error( $terms ) ){
				     foreach ( $terms as $term ) {
				      if ($current_v==$term->slug){
							  echo '<option value="' . $term->slug . '" selected>' . $term->name . '</option>';
							}else{
							  echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
							}
				     }
					 }
        ?>
        </select>
        <?php
    }
}


add_filter( 'parse_query', 'parse_query_immobiliare' );
function parse_query_immobiliare( $query ){
    global $pagenow;
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
    if ( 'immobili' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['ADMIN_FILTER_FIELD_VALUE']) && $_GET['ADMIN_FILTER_FIELD_VALUE'] != '') {
        $query->query_vars['meta_key'] = 'META_KEY';
        $query->query_vars['meta_value'] = $_GET['ADMIN_FILTER_FIELD_VALUE'];
    }
}