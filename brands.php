<?php 

/*
** Plugin Name:Brands Manager For Woocommerce	 

** Plugin URI: https://www.phoeniixx.com/product/brands-manager-for-woocommerce/

** Description: As we all know that brands attracts the customers. They feel more relaxed and confident if they purchased any products from well known brands. So here it is the simple plugin which helps you to add the brands on your shop and as well as on product page. 

** Version: 2.5

** Author: Phoeniixx

** Text Domain: phoen_woocommerce_brands

** Author URI: http://www.phoeniixx.com/

** License: GPLv2 or later

** License URI: http://www.gnu.org/licenses/gpl-2.0.html

** WC requires at least: 2.6.0

** WC tested up to: 3.9.0

**/  


if ( ! defined( 'ABSPATH' ) ) exit;

	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		
		add_action('admin_menu', 'phoen_brand_menu');
	
		function phoen_brand_menu(){
			
			add_menu_page('phoen_woo_brand',__( 'Phoeniixx', 'phoen_woocommerce_brands' ) ,'nosuchcapability','phoen_woo_brand',NULL, plugin_dir_url(__FILE__).'assets/images/logo.png','23.1');
		
			add_submenu_page( 'phoen_woo_brand', 'Phoeniixx_brand_settings', 'Brands','manage_options', 'Phoeniixx_brand_settings',  'phoen_woo_brand_function' );
		
		}
	
		add_action('admin_head','phoen_brands_scripts');
		
		function phoen_brands_scripts(){
			
			wp_enqueue_script('jquery');
			
			wp_enqueue_media();		
			
		}
	
		function phoen_woo_brand_function(){
			
			$gen_settings = get_option('phoen_brand_ttl');

					?>
				
				<div id="profile-page" class="wrap">
			
					<?php
						
					if(isset($_GET['tab']))
							
					{
						$tab = sanitize_text_field( $_GET['tab'] );
						
					}
					
					else
						
					{
						
						$tab="";
						
					}
					
					?>
					<h2> <?php _e('Settings','phoen_woocommerce_brands'); ?></h2>
					
					<?php $tab = (isset($_GET['tab']))?$_GET['tab']:'';?>
					
					<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
					
						<a class="nav-tab <?php if($tab == 'phoen_woo_brand_setting' ){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=phoen_woo_brand&amp;tab=phoen_woo_brand_setting"><?php _e('Setting','phoen_woocommerce_brands'); ?></a>	
								
					</h2>
					
				</div>
				
				<?php
				
				if($tab=='phoen_woo_brand_setting' || $tab==''){
					
					 include_once(plugin_dir_path(  __FILE__).'includes/brands_setting.php'); 
					 
				}
			
		}
		
		
		
		
			add_action( 'init', 'wpdocs_create_book_taxonomies', 0 ); 
			
			function wpdocs_create_book_taxonomies() {
				
				// Add new taxonomy, make it hierarchical (like categories)
				$labels = array(
					'name'              => _x( 'Brands', 'taxonomy general name', 'textdomain' ),
					'singular_name'     => _x( 'Brands', 'taxonomy singular name', 'textdomain' ),
					'search_items'      => __( 'Search Brands', 'textdomain' ),
					'all_items'         => __( 'All Brands', 'textdomain' ),
					'parent_item'       => __( 'Parent Brands', 'textdomain' ),
					'parent_item_colon' => __( 'Parent Brands:', 'textdomain' ),
					'edit_item'         => __( 'Edit Brands', 'textdomain' ),
					'update_item'       => __( 'Update Brands', 'textdomain' ),
					'add_new_item'      => __( 'Add New Brand', 'textdomain' ),
					'new_item_name'     => __( 'New Brands Name', 'textdomain' ),
					'menu_name'         => __( 'Brands', 'textdomain' ),
				);
			 
				$args = array(
					'hierarchical'      => true,
					'labels'            => $labels,
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => 'brands' ),
				);
			 
				register_taxonomy( 'brands', array( 'product' ), $args );
			
			
			}
			
			function phoen_brand_activate() {

				$gen_settings_enable = get_option('phoen_brand_enable');	
				$gen_custom_ttl_on = get_option('phoen_brand_custom_ttl');	
				$gen_settings = get_option('phoen_brand_ttl');	
				
				if(empty($gen_settings_enable)){
					update_option('phoen_brand_enable',1);
				}
					
				if(empty($gen_custom_ttl_on)){
					update_option('phoen_brand_custom_ttl',0);
				}
					
				if(empty($gen_settings)){
					update_option('phoen_brand_ttl','Brand:');
				}
			}
			
			register_activation_hook( __FILE__, 'phoen_brand_activate' );
			
				function phoen_add_meta_field() {
					// this will add the custom meta field to the add new term page
					?>
					<div class="form-field">
						<label for="phoen_image"><?php _e( 'Thumbnail Image:', 'phoen_woocommerce_brands' ); ?></label>
						<input type="text" name="phoen_image" id="phoen_image[image]" class="series-image" value="<?php echo $seriesimage; ?>">
						<input class="upload_image_button button" name="phoen_add_image" id="phoen_add_image" type="button" value="Select/Upload Image" />
						<script>							
						var custom_uploader;
							var new_url='';	
							var data_id='';	
							jQuery(document).on('click',  '#phoen_add_image', function(e){
								e.preventDefault();
								
								 data_id= jQuery(this).data('id');					
								if (custom_uploader) {
									
									custom_uploader.open();
									
									return;
									
								}
								
								//Extend the wp.media object
								custom_uploader = wp.media.frames.file_frame = wp.media({
									
									title: 'Choose Image',
									button: {
										text: 'Choose Image'
									},
									multiple: false						
								});
									
								custom_uploader.on('select', function() {
							
									var selection = custom_uploader.state().get('selection');
									
									selection.map( function( attachment ) {
										
										attachment = attachment.toJSON();
								
										new_url = attachment.url;		
									
									});
									// alert(new_url);
									jQuery('.series-image').val(new_url);
									// jQuery('#show_gallery_url_'+data_id+'').val(new_url); 
									
								});
								
								
								//Open the uploader dialog
								custom_uploader.open();
						 
							});
						</script>
					</div>
				<?php
				}
					add_action( 'brands_add_form_fields', 'phoen_add_meta_field', 10, 2 );
					

					// Add Upload fields to "Edit Taxonomy" form
					function phoen_edit_meta_field($term) {
					 
						// put the term ID into a variable
						$t_id = $term->term_id;
					 
						// retrieve the existing value(s) for this meta field. This returns an array
						$term_meta = get_option( "brands_$t_id" ); ?>
						
						<tr class="form-field">
						<th scope="row" valign="top"><label for="phoen_add_image"><?php _e( 'Thumbnail Image', 'phoen_woocommerce_brands' ); ?></label></th>
							<td>
								<?php
									$seriesimage = esc_attr( $term_meta) ? esc_attr( $term_meta) : ''; 
									?>
								<input type="text" name="phoen_image" id="phoen_image[image]" class="series-image" value="<?php echo $seriesimage; ?>" />
								<input class="upload_image_button button" name="phoen_add_image" id="phoen_add_image" type="button" value="Select/Upload Image" />
							</td>
						</tr>
						<tr class="form-field">
						<th scope="row" valign="top"></th>
							<td style="height: 150px;">
								<style>
									div.img-wrap {
										background: url('http://placehold.it/960x300') no-repeat center; 
										max-width: 150px; 
										max-height: 150px; 
										width: 100%; 
										height: 100%; 
										overflow:hidden; 
									}
									div.img-wrap img {
										max-width: 250px;
									}
								</style>
								<div class="img-wrap">
									<img src="<?php echo $seriesimage; ?>" id="series-img">
								</div>
									<script>							
										var custom_uploader;
											var new_url='';	
											var data_id='';	
											jQuery(document).on('click',  '#phoen_add_image', function(e){
												e.preventDefault();
												
												 data_id= jQuery(this).data('id');					
												if (custom_uploader) {
													
													custom_uploader.open();
													
													return;
													
												}
												
												//Extend the wp.media object
												custom_uploader = wp.media.frames.file_frame = wp.media({
													
													title: 'Choose Image',
													button: {
														text: 'Choose Image'
													},
													multiple: false						
												});
													
												custom_uploader.on('select', function() {
											
													var selection = custom_uploader.state().get('selection');
													
													selection.map( function( attachment ) {
														
														attachment = attachment.toJSON();
												
														new_url = attachment.url;		
													
													});
													// alert(new_url);
													jQuery('.series-image').val(new_url);
													// jQuery('#show_gallery_url_'+data_id+'').val(new_url); 
													
												});
												
												
												//Open the uploader dialog
												custom_uploader.open();
										 
											});
										</script>
							</td>
						</tr>
					<?php
					
					}
					add_action( 'brands_edit_form_fields', 'phoen_edit_meta_field', 10, 2 );
					function phoen_custom_meta( $term_id ) {
						$data=sanitize_text_field( $_POST['phoen_image'] );
						 if(isset($data)){
							
							$t_id = $term_id;
							
							$term_meta=sanitize_text_field($_POST['phoen_image']);
							
							update_option( "brands_$t_id", $term_meta ); 
							
						}
						
					}  
					add_action( 'edited_brands', 'phoen_custom_meta', 10, 2 );  
					add_action( 'create_brands', 'phoen_custom_meta', 10, 2 );
					
					
					add_action( 'manage_brands_custom_column' , 'phoen_doc_manage_brands_custom_column',10,3);

					function phoen_doc_manage_brands_custom_column($out,$column,$term_id){        //This function is use to get term_id in taxonomy list table
					   
						switch($column){
						   
							case 'image':
						   
								$image=get_option("brands_$term_id"); 
								
								$temp = '<img src="'.$image.'" style="width:65px;height:50px;" />';
							   
								return $temp;
							   
								break;
							   
						}
					   

					}

					add_filter('manage_edit-brands_columns','phoen_doc_manage_edit_brands_columns');
				 
					function phoen_doc_manage_edit_brands_columns($columns){  //This function is use to add new column in taxonomy list table
					   
						$new_columns['cb']          = $columns['cb'];
					   
					   	$new_columns['image']   = ("Image");
						
					   $new_columns['name']        = $columns['name'];
					   
						$new_columns['description']= $columns['description'];	
				   
						$new_columns['slug']        = $columns['slug'];
					   
						$new_columns['posts']       = ("Count");
					   
						return $new_columns;
					   
					}
					
					$gen_settings_enable = get_option('phoen_brand_enable');	
					if($gen_settings_enable == 1){
						add_action('init', function(){
						   remove_action( 'woocommerce_after_shop_loop_item_title', 'phoen_brand_for_shop_page', 10 );
							add_action('woocommerce_after_shop_loop_item', 'phoen_brand_for_shop_page', 7);					
						});
						add_action('woocommerce_after_add_to_cart_form', 'phoen_brand_for_shop_page');			
					}
					function phoen_brand_for_shop_page(){
											
						 $id=get_the_ID();	
						
						$terms = wp_get_post_terms( $id, 'brands');
						$gen_settings = get_option('gen_custom_ttl_on');	
						$phoen_brand_ttl = get_option('phoen_brand_ttl');	
						foreach($terms as $key=>$value){
							$term_id=$value->term_id;
							$term_name=$value->name;
						}
						
						if(!empty($term_id)){
							$data=get_term_link( $term_id, 'brands' );
						}					 
						 if(!empty($data)){
							 $image=get_option("brands_$term_id"); 
							?>
							<div style="display:inline;">
								<b><?php if($gen_settings==1){ echo $phoen_brand_ttl; }else{ echo 'Brand:';}?></b> 
								<a href="<?php echo $data;?>"><?php echo $term_name;?>  </a> 
								<img src="<?php echo $image;?>" style="width:30px;height:30px;" />
								
								
							</div>
							
							<?php 
			
						
						 }
					
					}
					
					add_action( 'admin_footer', 'phoen_js_to_unselect' );
					function phoen_js_to_unselect(){
						?>
						<script>
						
						jQuery("input[name=\"tax_input[brands][]\"]").click(function () {
							selected = jQuery("input[name=\"tax_input[brands][]\"]").filter(":checked").length;
							if (selected > 1){
								jQuery("input[name=\"tax_input[brands][]\"]").each(function () {
										jQuery(this).attr("checked", false);
								});
								jQuery(this).attr("checked", true);
							}
						});
						
						</script>
						
						<?php
						
						
					}
					
					

	}
