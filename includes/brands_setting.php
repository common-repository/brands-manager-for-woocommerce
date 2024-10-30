<?php if ( ! defined( 'ABSPATH' ) ) exit;

if ( isset($_POST) && wp_verify_nonce( $_POST['phoe_attachment_action_form_nonce_field'], 'phoe_attachment_form_action' ) ) {

	if(sanitize_text_field( $_POST['disc_submit'] ) == 'Save'){
		
		$brand_enbl=sanitize_text_field($_POST['enable_brand']);
				
		if(!empty($brand_enbl)){
			update_option('phoen_brand_enable',$brand_enbl);
		}else{
			update_option('phoen_brand_enable',0);
		}
		$enable_brand_custom=sanitize_text_field($_POST['enable_brand_custom']);
				
		if(!empty($enable_brand_custom)){
			update_option('phoen_brand_custom_ttl',$enable_brand_custom);
		}else{
			update_option('phoen_brand_custom_ttl',0);
		}
		
		$brand_ttl=sanitize_text_field($_POST['brand_ttl']);
				
		if(!empty($brand_ttl)){
			update_option('phoen_brand_ttl',$brand_ttl);
		}
		
	}
	 
}

	$gen_settings_enable = get_option('phoen_brand_enable');	
	$gen_custom_ttl_on = get_option('phoen_brand_custom_ttl');	
	$gen_settings = get_option('phoen_brand_ttl');			
		
 ?>

	<div id="phoeniixx_phoe_Disc_wrap_profile-page" class=" phoeniixx_phoe_Disc_wrap_profile_div">

		<form method="post" id="phoeniixx_phoe_Disc_wrap_profile_form" action="" >
		
			<?php wp_nonce_field( 'phoe_attachment_form_action', 'phoe_attachment_action_form_nonce_field' ); ?>
			
			<table class="form-table">
				
				<tbody>	
		
					<tr class="phoeniixx_brand_wrap">
				
						<th>
						
							<label>Enable Brand:</label>
							
						</th>
						
						<td>
						
							<input type="checkbox" <?php echo(isset($gen_settings_enable) && $gen_settings_enable ==1)?'checked':'';?>  value="1" id="enable_brand" name="enable_brand" >
							
						</td>
						
					</tr>
					<tr class="phoeniixx_brand_wrap">
				
						<th>
						
							<label>Enable Brand Custom Label:</label>
							
						</th>
						
						<td>
						
							<input type="checkbox" <?php echo(isset($gen_custom_ttl_on) && $gen_custom_ttl_on ==1)?'checked':'';?> value="1" id="enable_brand_custom" name="enable_brand_custom">
							<span class="description"><?php _e(' (Custom Label used for "Brand" link)','phoen_woocommerce_brands'); ?></span> 
							
						</td>
						
					</tr>
		
					<tr class="phoeniixx_phoe_description" style="display:<?php echo(isset($gen_custom_ttl_on) && $gen_custom_ttl_on ==1)?'block':'none';?>;">
				
						<th>
						
							<label><?php _e(' Brand label ','phoen_woocommerce_brands'); ?></label>
							
						</th>
						
						<td>
						
							<input type="text"  name="brand_ttl" placeholder="Brand:"  value="<?php echo(isset($gen_settings))?$gen_settings:'';?>" />
							
						</td>
						
					</tr>
							
					<tr class="phoeniixx_phoe_Disc_wrap">
					
						<td colspan="2">
						
							<input type="submit" value="Save" name="disc_submit" id="submit" class="button button-primary">
							
						</td>
						
					</tr>
		
				</tbody>
				
			</table>
			
		</form>
		
	</div>
	<script>
	jQuery(document).ready(function(){
		jQuery('#enable_brand_custom').click(function(){
			if (jQuery(this).is(":checked")){
				jQuery('.phoeniixx_phoe_description').show();
			}else{
				jQuery('.phoeniixx_phoe_description').hide();
			}
		});
	});
	
	</script>