<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
?>

<div class="cookies-and-content-security-policy-help">
	<?php
	echo '<p>';
		_e( 'You don\'t have to fill out this form, the plugin comes with default design. But if you want to change the design, this is it.', 'cookies-and-content-security-policy' );
	echo '</p>';
	?>
</div>
<?php
$cacsp_option_banner = get_cacsp_options( 'cacsp_option_banner', false, '', true );
$cacsp_option_banner_float = get_cacsp_options( 'cacsp_option_banner_float', false, '', true );
$cacsp_option_banner_float_small = get_cacsp_options( 'cacsp_option_banner_float_small', false, '', true );
$cacsp_option_allow_use_site = get_cacsp_options( 'cacsp_option_allow_use_site', false, '', true );
$cacsp_option_hide_unused_settings_row = get_cacsp_options( 'cacsp_option_hide_unused_settings_row', false, '', true );
$cacsp_option_grandma = get_cacsp_options( 'cacsp_option_grandma', false, '', true );
$cacsp_option_show_refuse_button = get_cacsp_options( 'cacsp_option_show_refuse_button', false, '', true );
$cacsp_option_settings_close_button = get_cacsp_options( 'cacsp_option_settings_close_button', false, '', true );
$cacsp_option_dark_mode = get_cacsp_options( 'cacsp_option_dark_mode', false, '', true );
?>
<h2><?php esc_html_e( 'Design', 'cookies-and-content-security-policy' ); ?></h2>
<table class="form-table">
	<tr>
		<th scope="row">
			<?php esc_html_e( 'Size and position', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<fieldset>
				<label for="cacsp_option_banner">
					<?php if ( $cacsp_option_banner ) {
						$checked = ' checked';
					} else {
						$checked = '';
					} ?>
					<input type="checkbox" name="cacsp_option_banner" id="cacsp_option_banner" value="1"<?php echo $checked; ?>> 
						<?php esc_html_e( 'Do not use a modal, I want a banner.', 'cookies-and-content-security-policy' ); ?>
				</label>
				<br>
				<label for="cacsp_option_banner_float">
					<?php if ( $cacsp_option_banner_float ) {
						$checked = ' checked';
					} else {
						$checked = '';
					} ?>
					<input type="checkbox" name="cacsp_option_banner_float" id="cacsp_option_banner_float" value="1"<?php echo $checked; ?>> 
						<?php esc_html_e( 'Floating banner.', 'cookies-and-content-security-policy' ); ?>
						<br>
						<small><?php esc_html_e( 'Floating banner with rounded edges and drop shadow.', 'cookies-and-content-security-policy' ); ?></small>
				</label>
				<br>
				<label for="cacsp_option_banner_float_small">
					<?php if ( $cacsp_option_banner_float_small ) {
						$checked = ' checked';
					} else {
						$checked = '';
					} ?>
					<input type="checkbox" name="cacsp_option_banner_float_small" id="cacsp_option_banner_float_small" value="1"<?php echo $checked; ?>> 
						<?php esc_html_e( 'Small floating banner.', 'cookies-and-content-security-policy' ); ?>
						<br>
						<small><?php esc_html_e( 'Small banner in the left bottom corner with rounded edges and drop shadow.', 'cookies-and-content-security-policy' ); ?></small>
				</label>
				<br>
				<label for="cacsp_option_dark_mode">
					<?php if ( $cacsp_option_dark_mode ) {
						$checked = ' checked';
					} else {
						$checked = '';
					} ?>
					<input type="checkbox" name="cacsp_option_dark_mode" id="cacsp_option_dark_mode" value="1"<?php echo $checked; ?>> 
						<?php esc_html_e( 'Dark mode.', 'cookies-and-content-security-policy' ); ?>
						<br>
						<small><?php esc_html_e( 'Resaves some colors in Colors tab if checked while saving.', 'cookies-and-content-security-policy' ); ?></small>
				</label>
			</fieldset>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<?php esc_html_e( 'Misc', 'cookies-and-content-security-policy' ); ?>
		</th>
		<td>
			<fieldset>
				<label for="cacsp_option_allow_use_site">
					<?php if ( $cacsp_option_allow_use_site ) {
						$checked = ' checked';
					} else {
						$checked = '';
					} ?>
					<input type="checkbox" name="cacsp_option_allow_use_site" id="cacsp_option_allow_use_site" value="1"<?php echo $checked; ?>> 
						<?php esc_html_e( 'Allow user to access site without saving settings.', 'cookies-and-content-security-policy' ); ?>
						<br>
						<small><?php esc_html_e( 'Only works with banner.', 'cookies-and-content-security-policy' ); ?></small>
				</label>
				<br>
				<label for="cacsp_option_hide_unused_settings_row">
					<?php if ( $cacsp_option_hide_unused_settings_row ) {
						$checked = ' checked';
					} else {
						$checked = '';
					} ?>
					<input type="checkbox" name="cacsp_option_hide_unused_settings_row" id="cacsp_option_hide_unused_settings_row" value="1"<?php echo $checked; ?>> 
						<?php esc_html_e( 'Hide unused sections in Settings.', 'cookies-and-content-security-policy' ); ?>
						<br>
						<small><?php esc_html_e( 'Example: If you don\'t have any domains specified for Marketing, that setting won\'t show for the visitor.', 'cookies-and-content-security-policy' ); ?></small>
				</label>
				<br>
				<label for="cacsp_option_grandma">
					<?php if ( $cacsp_option_grandma ) {
						$checked = ' checked';
					} else {
						$checked = '';
					} ?>
					<input type="checkbox" name="cacsp_option_grandma" id="cacsp_option_grandma" value="1"<?php echo $checked; ?>> 
						<?php esc_html_e( 'Grandma mode.', 'cookies-and-content-security-policy' ); ?>
						<br>
						<small><?php esc_html_e( 'Add grandma with milk and cookies.', 'cookies-and-content-security-policy' ); ?></small>
				</label>
				<br>
				<label for="cacsp_option_show_refuse_button">
					<?php if ( $cacsp_option_show_refuse_button ) {
						$checked = ' checked';
					} else {
						$checked = '';
					} ?>
					<input type="checkbox" name="cacsp_option_show_refuse_button" id="cacsp_option_show_refuse_button" value="1"<?php echo $checked; ?>> 
						<?php esc_html_e( 'Show refuse cookies button.', 'cookies-and-content-security-policy' ); ?>
				</label>
				<br>
				<label for="cacsp_option_settings_close_button">
					<?php if ( $cacsp_option_settings_close_button ) {
						$checked = ' checked';
					} else {
						$checked = '';
					} ?>
					<input type="checkbox" name="cacsp_option_settings_close_button" id="cacsp_option_settings_close_button" value="1"<?php echo $checked; ?>> 
						<?php esc_html_e( 'Show close button (&times;).', 'cookies-and-content-security-policy' ); ?>
				</label>
				<br>
			</fieldset>
		</td>
	</tr>
</table>

<div class="submit">
	<input type="submit" name="save_cacsp_settings_design" value="<?php esc_html_e( 'Save Settings' , 'cookies-and-content-security-policy' ); ?>" class="button-primary" />
</div>

<script>
	jQuery(function($) {

		function updateDesignVisibility() {
			const banner = $('#cacsp_option_banner').is(':checked');
			const floating = $('#cacsp_option_banner_float').is(':checked');

			// Floating banner depends on banner
			if (banner) {
				$('label[for="cacsp_option_banner_float"]').show().next('br').show();
				$('label[for="cacsp_option_allow_use_site"]').show().next('br').show();
			} else {
				$('label[for="cacsp_option_banner_float"]').hide().next('br').hide();
				$('label[for="cacsp_option_allow_use_site"]').hide().next('br').hide();
			}

			// Small floating banner depends on floating banner
			if (banner && floating) {
				$('label[for="cacsp_option_banner_float_small"]').show().next('br').show();
			} else {
				$('label[for="cacsp_option_banner_float_small"]').hide().next('br').hide();
			}
		}

		// Initial state
		updateDesignVisibility();

		// React to changes
		$('#cacsp_option_banner, #cacsp_option_banner_float').on('change', updateDesignVisibility);

	});
</script>
