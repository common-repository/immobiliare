<?php
	function immobiliare_menu() {
		add_options_page('Immobiliare pagina', 'Immobiliare', 'manage_options', 'immobiliare', 'immobiliare_opzioni');
	}
	
	function immobiliare_opzioni_validate() {
		return true;
	}

  function immobiliare_registraopzioni() { // whitelist options
	  register_setting( 'immobiliare_opzioni', 'immobiliare_metanotincontent' );
	  register_setting( 'immobiliare_opzioni', 'immobiliare_metainlist' );
	  register_setting( 'immobiliare_opzioni', 'immobiliare_azienda_nome' );
	  register_setting( 'immobiliare_opzioni', 'immobiliare_azienda_indirizzo' );
	  register_setting( 'immobiliare_opzioni', 'immobiliare_azienda_comune' );
	  register_setting( 'immobiliare_opzioni', 'immobiliare_azienda_provincia' );
	  register_setting( 'immobiliare_opzioni', 'immobiliare_azienda_partitaiva' );
	  register_setting( 'immobiliare_opzioni', 'immobiliare_azienda_rea' );
	  register_setting( 'immobiliare_opzioni', 'immobiliare_azienda_telefono' );
	  register_setting( 'immobiliare_opzioni', 'immobiliare_azienda_email' );
	  register_setting( 'immobiliare_opzioni', 'immobiliare_azienda_logo' );
	  register_setting( 'immobiliare_opzioni', 'immobiliare_azienda_colore' );
	  register_setting( 'immobiliare_opzioni', 'immobiliare_google_api_key' );
	  register_setting( 'immobiliare_opzioni', 'immobiliare_azienda_facebook' );
	  register_setting( 'immobiliare_opzioni', 'immobiliare_azienda_youtube' );
	  register_setting( 'immobiliare_opzioni', 'immobiliare_azienda_twitter' );
	  register_setting( 'immobiliare_opzioni', 'immobiliare_azienda_instagram' );
	}
	
	function immobiliare_opzioni() {
		global $immobiliare_opzioni;
		?>
		<div class="wrap">
		<div class="icon32" id="icon-tools"><br /></div>
		<h2>Opzioni plugin immobiliare</h2>
		<p>Inserisci i dati dell'agenzia immobiliare o dell'impresa edile.</p>
		<form method="post" action="options.php" enctype="multipart/form-data">
			<?php settings_fields('immobiliare_opzioni'); ?>
			<?php do_settings_sections('immobiliare'); ?>
			<table class="optiontable form-table">
			<tr valign="top">
				<th scope="row" colspan="2"><hr><strong>Configurazioni plugin</strong></th>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="immobiliare_metaincontent">Nascondi i dati nella scheda immobile</label></th>
				<td align="left">
				<input name="immobiliare_metanotincontent" type="checkbox" id="immobiliare_metanotincontent" value="1" class="regular-checkbox" <?php if (get_option('immobiliare_metanotincontent')=='1'){ echo "checked"; } ?> />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="immobiliare_metanotinlist">Visualizza i dati nella lista immobili</label></th>
				<td align="left">
				<input name="immobiliare_metainlist" type="checkbox" id="immobiliare_metainlist" value="1" class="regular-checkbox" <?php if (get_option('immobiliare_metainlist')=='1'){ echo "checked"; } ?> />
				</td>
			</tr>
			<tr valign="top">
				<td colspan="2">
					<span class="description">Se attivo i campi NON saranno visualizzati nella descrizione e si proceder&agrave; a personalizzare il tema</span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" colspan="2"><hr><strong>Anagrafica azienda</strong></th>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="immobiliare_azienda_nome">Nome azienda</label></th>
				<td><input name="immobiliare_azienda_nome" type="text" id="immobiliare_azienda_nome" value="<?php print(get_option('immobiliare_azienda_nome')); ?>" size="40" class="regular-text" />
				<span class="description">Nome azienda</span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="immobiliare_azienda_indirizzo">Indirizzo azienda</label></th>
				<td><input name="immobiliare_azienda_indirizzo" type="text" id="immobiliare_azienda_indirizzo" value="<?php print(get_option('immobiliare_azienda_indirizzo')); ?>" size="40" class="regular-text" />
				<span class="description">Indirizzo azienda</span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="immobiliare_azienda_comune">Comune azienda</label></th>
				<td><input name="immobiliare_azienda_comune" type="text" id="immobiliare_azienda_comune" value="<?php print(get_option('immobiliare_azienda_comune')); ?>" size="40" class="regular-text" />
				<span class="description">Comune azienda</span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="immobiliare_azienda_provincia">Provincia azienda</label></th>
				<td><input name="immobiliare_azienda_provincia" type="text" id="immobiliare_azienda_provincia" value="<?php print(get_option('immobiliare_azienda_provincia')); ?>" size="40" class="regular-text" />
				<span class="description">Provincia azienda</span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="immobiliare_azienda_partitaiva">Partita IVA azienda</label></th>
				<td><input name="immobiliare_azienda_partitaiva" type="text" id="immobiliare_azienda_provincia" value="<?php print(get_option('immobiliare_azienda_partitaiva')); ?>" size="40" class="regular-text" />
				<span class="description">Partita IVA azienda</span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="immobiliare_azienda_rea">REA azienda</label></th>
				<td><input name="immobiliare_azienda_rea" type="text" id="immobiliare_azienda_provincia" value="<?php print(get_option('immobiliare_azienda_rea')); ?>" size="40" class="regular-text" />
				<span class="description">REA azienda</span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="immobiliare_azienda_telefono">Telefono azienda</label></th>
				<td><input name="immobiliare_azienda_telefono" type="text" id="immobiliare_azienda_telefono" value="<?php print(get_option('immobiliare_azienda_telefono')); ?>" size="40" class="regular-text" />
				<span class="description">Telefono azienda</span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="immobiliare_azienda_email">Email azienda</label></th>
				<td><input name="immobiliare_azienda_email" type="text" id="immobiliare_azienda_email" value="<?php print(get_option('immobiliare_azienda_email')); ?>" size="40" class="regular-text" />
				<span class="description">Email azienda</span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="immobiliare_azienda_logo">Logo azienda</label></th>
				<td><input name="immobiliare_azienda_logo" type="text" id="immobiliare_azienda_Logo" value="<?php print(get_option('immobiliare_azienda_logo')); ?>" size="40" class="regular-text" />
				<span class="description">Logo azienda. Carica un files nella sezione media e metti il link al logo</span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="immobiliare_azienda_colore">Colore sociale azienda</label></th>
				<td><input name="immobiliare_azienda_colore" type="text" id="immobiliare_azienda_colore" value="<?php print(get_option('immobiliare_azienda_colore')); ?>" size="40" class="regular-text" />
				<span class="description">Colore sociale azienda (es #ff0000)</span></td>
			</tr>
			<tr valign="top">
				<th scope="row" colspan="2"><hr><strong>Google Maps JavaScript API </strong></th>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="immobiliare_google_api_key">Google API key (chiave)</label></th>
				<td><input name="immobiliare_google_api_key" type="text" id="immobiliare_google_api_key" value="<?php print(get_option('immobiliare_google_api_key')); ?>" size="40" class="regular-text" />
				<span class="description">Google API key (chiave) <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">ottieni chiave</a></span></td>
			</tr>
			<tr valign="top">
				<th scope="row" colspan="2"><hr><div id="icon-link-manager" class="icon32"></div><strong>Social</strong></th>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="immobiliare_azienda_facebook">Indirizzo Facebook</label></th>
				<td><input name="immobiliare_azienda_facebook" type="text" id="immobiliare_azienda_facebook" value="<?php print(get_option('immobiliare_azienda_facebook')); ?>" size="40" class="regular-text" />
				<span class="description">Indirizzo del profilo o della pagina FB</span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="immobiliare_azienda_youtube">Indirizzo YouTube</label></th>
				<td><input name="immobiliare_azienda_youtube" type="text" id="immobiliare_azienda_youtube" value="<?php print(get_option('immobiliare_azienda_youtube')); ?>" size="40" class="regular-text" />
				<span class="description">Indirizzo canale YouTube</span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="immobiliare_azienda_twitter">Indirizzo Twitter</label></th>
				<td><input name="immobiliare_azienda_twitter" type="text" id="immobiliare_azienda_twitter" value="<?php print(get_option('immobiliare_azienda_twitter')); ?>" size="40" class="regular-text" />
				<span class="description">Indirizzo del profilo Twitter</span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="immobiliare_azienda_instagram">Indirizzo Instagram</label></th>
				<td><input name="immobiliare_azienda_instagram" type="text" id="immobiliare_azienda_instagram" value="<?php print(get_option('immobiliare_azienda_instagram')); ?>" size="40" class="regular-text" />
				<span class="description">Indirizzo del profilo o della pagina Instagram</span></td>
			</tr>
			</table>
			<?php submit_button(); ?>
		</form>
		</div>
		<?php
	}

	if ( is_admin() ){ // admin actions
  	add_action( 'admin_menu', 'immobiliare_menu' );
	  add_action( 'admin_init', 'immobiliare_registraopzioni' );
	}
