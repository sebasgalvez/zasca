<?php
/** 
 * AQ_Page_Builder class
 *
 * The core class that generates the functionalities for the
 * Aqua Page Builder. Almost nothing inside in the class should
 * be overridden by theme authors
 *
 * @since forever
 **/
 
if(!class_exists('AQ_Page_Builder')) {
	class AQ_Page_Builder {
		
		public $url = AQPB_DIR;
		public $config = array();
		private $admin_notices;
		
		
		/**
		 * Stores public queryable vars
		 */
		function __construct( $config = array()) {
			
			$defaults['menu_title'] = __('PMC Page Builder', 'pmc-themes');
			$defaults['page_title'] = __('PMC Page Builder', 'pmc-themes');
			$defaults['page_slug'] = __('aq-page-builder', 'pmc-themes');
			$defaults['debug'] = false;
			
			$this->args = wp_parse_args($config, $defaults);
			
			$this->args['page_url'] = esc_url(add_query_arg(
				array('page' => $this->args['page_slug']),
				admin_url( 'admin.php' )
			));
			
		}
		
		/**
		 * Initialise Page Builder page and its settings
		 *
		 * @since 1.0.0
		 */
		function init() {
		
			add_action('admin_menu', array(&$this, 'admin_pages'));
			add_action('init', array(&$this, 'register_template_post_type'));
			add_action('init', array(&$this, 'add_shortcode'));
			add_action('template_redirect', array(&$this, 'preview_template'));
			add_filter('contextual_help', array(&$this, 'contextual_help'));
			if(!is_admin()) add_action('init', array(&$this, 'view_enqueue'));
			add_action('admin_bar_menu', array(&$this, 'add_admin_bar'), 1000);
			add_action('admin_footer', array(&$this, 'add_media_display') );
			
		}
		
		/** 
		 * Create Admin Pages
		 *
		 * @since 1.0.0
		 */
		function admin_pages() {
			
			$this->page = add_menu_page( $this->args['page_title'], 'PMC Themes', 'manage_options', $this->args['page_slug'] , array(&$this, 'builder_page_show'),'dashicons-tagcloud');
			$this->page1 = add_submenu_page( $this->args['page_slug'] , $this->args['page_title'], $this->args['menu_title'], 'manage_options', $this->args['page_slug'], array(&$this, 'builder_page_show'));
			$this->page2 =		add_submenu_page( $this->args['page_slug'], 'PMC Theme Options', 'PMC Theme Options', 'manage_options', 'optionsframework', 'optionsframework_options_page');
			$this->page3 =		add_submenu_page( $this->args['page_slug'], 'PMC Import', 'PMC Import', 'manage_options', 'pmc_importer', 'pmc_importer');			
			//enqueueu styles/scripts on the builder page
			add_action('admin_print_styles-'.$this->page, array(&$this, 'admin_enqueue'));
			add_action('admin_print_styles-'.$this->page, array(&$this, 'admin_enqueue'));
			
			add_action("admin_print_scripts-".$this->page2, 'of_load_only');
			add_action("admin_print_styles-".$this->page2,'of_style_only');
			add_action( "admin_print_scripts-$".$this->page3, 'pmc-import.js', 0 );	
	
			
		}
		
		/**
		 * Add shortcut to Admin Bar menu
		 *
		 * @since 1.0.4
		 */
		function add_admin_bar(){
			global $wp_admin_bar;
			$wp_admin_bar->add_menu( array( 'id' => 'aq-page-builder', 'parent' => 'appearance', 'title' => 'PMC Page Builder', 'href' => admin_url('admin.php?page='.$this->args['page_slug']) ) );
			
		}
		
		/**
		 * Register and enqueueu styles/scripts
		 *
		 * @since 1.0.0
		 * @todo min versions
		 */
		function admin_enqueue() {
			
		
			// Register 'em
			wp_register_style( 'aqpb-css', $this->url.'assets/css/aqpb.css', array(), time(), 'all');
			wp_register_style( 'aqpb-blocks-css', $this->url.'assets/css/aqpb_blocks.css', array(), time(), 'all');
			wp_register_style( 'aqpb-css', $this->url.'assets/css/aqpb-custom.css', array(), time(), 'all');	
			
			wp_register_script('pmc_tinymce', $this->url . 'assets/js/tinymce/tinymce.min.js', array('jquery'), time(), false); 
			wp_register_script('aqpb-js', $this->url . 'assets/js/aqpb.js', array('jquery'), time(), true);
	
			
			// Enqueue 'em
			wp_enqueue_script('aqpb-js');
			wp_enqueue_script('aqpb-fields-js');			
			wp_enqueue_script('pmc_tinymce');
			wp_enqueue_style('aqpb-css');
			wp_enqueue_style('aqpb-blocks-css');
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('jquery-ui-resizable');
			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_script('jquery-ui-droppable');
			wp_enqueue_script('iris');
			
			// Media library uploader
			wp_enqueue_script('thickbox');  
	        wp_enqueue_style('thickbox');  
	        wp_enqueue_script('media-upload');
	        wp_enqueue_media();
			
			// Hook to register custom style/scripts
			do_action('aq-page-builder-admin-enqueue');

			
		}
		

		
		/**
		 * Register and enqueueu styles/scripts on front-end
		 *
		 * @since 1.0.0
		 * @todo min versions
		 */
		function view_enqueue() {
			
			// front-end css
			
			wp_register_style( 'aqpb-view-css', $this->url.'assets/css/aqpb-view.css', array(), time(), 'all');
			wp_enqueue_style('aqpb-view-css');
			wp_enqueue_style( 'custom-theme', $this->url.'assets/css/custom-theme.css', array(), time(), 'all');			
			// front-end js
			wp_enqueue_style('icons');
			
			wp_register_script('aqpb-view-js', $this->url . 'assets/js/aqpb-view.js', array('jquery'), time(), true);
			wp_enqueue_script('aqpb-view-js');
			wp_register_script('lazyload', $this->url . 'assets/js/pmc_infinity.js', array('jquery'), time(), true);
			wp_enqueue_script('lazyload');			
			wp_register_script('pmc_isotope', $this->url . 'assets/js/jquery.isotope.min.js', array('jquery'),true,true);				
			wp_enqueue_script('pmc_isotop');
			//hook to register custom styles/scripts
			do_action('aq-page-builder-view-enqueue');
			
		}
		
		/**
		 * Register template post type
		 *
		 * @uses register_post_type
		 * @since 1.0.0
		 */
		function register_template_post_type() {
		
			if(!post_type_exists('template')) {
			
				$template_args = array(
					'labels' => array(
						'name' => 'Templates',
					),
					'public' => true,
					'show_ui' => true,
					'capability_type' => 'page',
					'hierarchical' => true,
					'rewrite' => false,
					'supports' => array( 'title', 'editor' ), 
					'query_var' => false,
					'can_export' => true,
					'show_in_nav_menus' => true,
					'menu_name' => 'Template'
				);
				
				if($this->args['debug'] == true && WP_DEBUG == true) {
					$template_args['public'] = true;
					$template_args['show_ui'] = true;
				}
				
				register_post_type( 'template', $template_args);
				
			} else {
				add_action('admin_notices', create_function('', "echo '<div id=\"message\" class=\"error\"><p><strong>Aqua Page Builder notice: </strong>'. __('The \"template\" post type already exists, possibly added by the theme or other plugins. Please consult with theme author to consult with this issue', 'pmc-themes') .'</p></div>';"));
			}
			
		}
		
		/**
		 * Checks if template with given id exists
		 *
		 * @since 1.0.0
		 */
		function is_template($template_id) {
		
			$template = get_post($template_id);
			
			if($template) {
				if($template->post_type != 'template' || $template->post_status != 'publish') return false;
			} else {
				return false;
			}
			
			return true;
			
		}
		
		/**
		 * Retrieve all blocks from template id
		 *
		 * @return	array - $blocks
		 * @since	1.0.0
		 */
		function get_blocks($template_id) {
		
			//verify template
			if(!$template_id) return;
			if(!$this->is_template($template_id)) return;
			
			//filter post meta to get only blocks data
			$blocks = array();
			$all = get_post_custom($template_id);
			foreach($all as $key => $block) {
				if(substr($key, 0, 9) == 'aq_block_') {
					$block_instance = get_post_meta($template_id, $key, true);
					if(is_array($block_instance)) $blocks[$key] = $block_instance;
				}
			}
			
			//sort by order
			$sort = array();
			foreach($blocks as $block) {
				if(isset($block['order'])){
					$sort[] = $block['order'];
				}
				else{$sort[] = 1;}
			}
			array_multisort($sort, SORT_NUMERIC, $blocks);
			
			return $blocks;
			
		}
		
		/**
		 * Display blocks archive
		 *
		 * @since	1.0.0
		 */
		function blocks_archive() {
		
			global $aq_registered_blocks;
			$categorie  =  Array();
			$i = 0;
			foreach($aq_registered_blocks as $block){ 
				
				if((isset($block->category)) && $block->category != ''){
					$category_explode = explode(" ",$block->category);
					foreach($category_explode as $category){
						if(!in_array($category, $categorie)){
							$categorie[$i] = $category;
							$i++;
				
						}
					}
				}
										
			}
			?>
			<div id="remove" class="builderremove" data-option-key="filter">
				<a class="catlink" href="#filter" data-option-value="*">Show All <span> </span></a>
				<?php
				foreach ($categorie as $category) {
					echo '<a class="catlink" href="#filter" data-option-value=".'.$category .'" >'.$category.'</a>';
				}
				?>
			</div>	
			
			<?php 
			
?>
			
		<script>
				jQuery(function(){
				  
				  var $container = jQuery('#blocks-archive');
				  $container.isotope({
					itemSelector : '.block'
				  });
				  
				  
				  var $optionSets = jQuery('#remove'),
					  $optionLinks = $optionSets.find('a');
				  $optionLinks.click(function(){
					var $this = jQuery(this);
					// don't proceed if already selected
					if ( $this.hasClass('selected') ) {
					  return false;
					}
					var $optionSet = $this.parents('#remove');
					$optionSet.find('.selected').removeClass('selected');
					$this.addClass('selected');
			  
					// make option object dynamically, i.e. { filter: '.my-filter-class' }
					var options = {},
						key = $optionSet.attr('data-option-key'),
						value = $this.attr('data-option-value');
					// parse 'false' as false boolean
					value = value === 'false' ? false : value;
					options[ key ] = value;
					if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
					  // changes in layout modes need extra logic
					  changeLayoutMode( $this, options )
					} else {
					  // otherwise, apply new options
					  $container.isotope( options );
					}
					
					return false;
				  });
				jQuery(window).on('load', function(){
			
						$container.isotope('reLayout');
						
				});
				  
				jQuery( window ).resize(function() {
					$container.isotope('reLayout');
				});
				jQuery(document).ready(function($){
					jQuery('.builder-button').click(function() {
						$container.isotope('reLayout');
					});
					jQuery( window ).scroll(function() {
					if(jQuery(this).scrollTop() < 700 ){ 
					
						$container.isotope('reLayout');
					
					}
					});					
				});
				});
			</script>
			
			<div class="help-iniside">
				<i class="fa fa-times-circle"></i>
				<div class="help-iniside-text"></div>
			</div>
			
			<ul id="blocks-archive" class="cf">		
			
				<?php
				
				foreach($aq_registered_blocks as $block) {
					$block->form_callback();
				}
				
				?>
			</ul>
			
			<?php
		}
		
		/**
		 * Display template blocks
		 *
		 * @since	1.0.0
		 */
		function display_blocks( $template_id ) {
			
			//verify template
			if(!$template_id) return;
			if(!$this->is_template($template_id)) return;
			
			$blocks = $this->get_blocks($template_id);
			$blocks = is_array($blocks) ? $blocks : array();
			
			//return early if no blocks
			if(empty($blocks)) {
				echo '<p class="empty-template">';
				echo __('Drag block items from the left into this area to begin building your template.', 'pmc-themes');
				echo '</p>';
				return;
				
			} else {
				//outputs the blocks
				foreach($blocks as $key => $instance) {
					global $aq_registered_blocks;
					extract($instance);
					if(isset($id_base)){
						$id_base = $id_base;
					} else {
						$id_base = 'new';
					}
					if(isset($aq_registered_blocks[$id_base])) {
						//get the block object
						$block = $aq_registered_blocks[$id_base];
						
						//insert template_id into $instance
						$instance['template_id'] = $template_id;
						
						//display the block
						if($parent == 0) {
							$block->form_callback($instance);
						}
					}
				}
				
			}
			
		}
		
		/**
		 * Get all saved templates
		 *
		 * @since	1.0.0
		 */
		function get_templates() {
		
			$args = array (
				'nopaging' => true,
				'post_type' => 'template',
				'status' => 'publish',
				'orderby' => 'title',
				'order' => 'ASC',
			);
			
			$templates = get_posts($args);
			
			return $templates;
			
		}
		
		/**
		 * Creates a new template
		 *
		 * @since	1.0.0
		 */
		function create_template($title) {
		
			//wp security layer
			check_admin_referer( 'create-template', 'create-template-nonce' );
			
			//create new template only if title don't yet exist
			if(!get_page_by_title( $title, 'OBJECT', 'template' )) {
				//set up template name
				$template = array(
					'post_title' => wp_strip_all_tags($title),
					'post_type' => 'template',
					'post_status' => 'publish',
				);
				
				//create the template
				$template_id = wp_insert_post($template);
				
			} else {
				return new WP_Error('duplicate_template', 'Template names must be unique, try a different name');
			}
			
			//return the new id of the template
			return $template_id;
			
		}
		
		/**
		 * Function to update templates
		 * 
		 * @since	1.0.0
		**/
		function update_template($template_id, $blocks, $title) {
			
			//first let's check if template id is valid
			if(!$this->is_template($template_id)) wp_die('Error : Template id is not valid');
			
			//wp security layer
			check_admin_referer( 'update-template', 'update-template-nonce' );
			
			//update the title
			$template = array('ID' => $template_id, 'post_title'=> $title);
			wp_update_post( $template );
			
			//now let's save our blocks & prepare haystack
			$blocks = is_array($blocks) ? $blocks : array();
			$haystack = array();
			$template_transient_data = array();
			$i = 1;
			
			foreach ($blocks as $new_instance) {
				global $aq_registered_blocks;
				
				$old_key = isset($new_instance['number']) ? 'aq_block_' . $new_instance['number'] : 'aq_block_0';
				$new_key = isset($new_instance['number']) ? 'aq_block_' . $i : 'aq_block_0';
				
				$old_instance = get_post_meta($template_id, $old_key, true);
				
				extract($new_instance);
				
				if(class_exists($id_base)) {
					//get the block object
					$block = $aq_registered_blocks[$id_base];
					
					//insert template_id into $instance
					$new_instance['template_id'] = $template_id;
					
					//sanitize instance with AQ_Block::update()
					$new_instance = $block->update($new_instance, $old_instance);
				}
				
				// sanitize from all occurrences of "\r\n" - see bit.ly/Ajav2a
				$new_instance = str_replace("\r\n", "\n", $new_instance);
				//update block
				update_post_meta($template_id, $new_key, $new_instance);
				//store instance into $template_transient_data
				$template_transient_data[$new_key] = $new_instance;
				//prepare haystack
				$haystack[] = $new_key;
				$i++;
			}
			
			//update transient
			$template_transient = 'aq_template_' . $template_id;
			set_transient( $template_transient, $template_transient_data );
			
			//use haystack to check for deleted blocks
			$curr_blocks = $this->get_blocks($template_id);
			$curr_blocks = is_array($curr_blocks) ? $curr_blocks : array();
			foreach($curr_blocks as $key => $block){
				if(!in_array($key, $haystack))
					delete_post_meta($template_id, $key);
			}
			
		}
		
		
		/**
		 * Function to update templates
		 * 
		 * @since	1.0.0
		**/
		function duplicate_template($template_id, $blocks, $title) {
			
			//first let's check if template id is valid
			if(!$this->is_template($template_id)) wp_die('Error : Template id is not valid');
			
			//check_admin_referer( 'duplicate_template-nonce', 'duplicate_template-nonce' );
			
			$title = $title . ' Copy';
			//set up template name
			$template = array(
				'post_title' => $title,
				'post_type' => 'template',
				'post_status' => 'publish',
			);
			
			//create the template
			$template_id = wp_insert_post($template);
			
			//return the new id of the template
					
			
			//now let's save our blocks & prepare haystack
			$blocks = is_array($blocks) ? $blocks : array();
			$haystack = array();
			$template_transient_data = array();
			$i = 1;
			
			foreach ($blocks as $new_instance) {
				global $aq_registered_blocks;
				
				$old_key = isset($new_instance['number']) ? 'aq_block_' . $new_instance['number'] : 'aq_block_0';
				$new_key = isset($new_instance['number']) ? 'aq_block_' . $i : 'aq_block_0';
				
				$old_instance = get_post_meta($template_id, $old_key, true);
				
				extract($new_instance);
				
				if(class_exists($id_base)) {
					//get the block object
					$block = $aq_registered_blocks[$id_base];
					
					//insert template_id into $instance
					$new_instance['template_id'] = $template_id;
					
					//sanitize instance with AQ_Block::update()
					$new_instance = $block->update($new_instance, $old_instance);
				}
				
				// sanitize from all occurrences of "\r\n" - see bit.ly/Ajav2a
				$new_instance = str_replace("\r\n", "\n", $new_instance);
				//update block
				update_post_meta($template_id, $new_key, $new_instance);
				//store instance into $template_transient_data
				$template_transient_data[$new_key] = $new_instance;
				//prepare haystack
				$haystack[] = $new_key;
				$i++;
			}
			
			//update transient
			$template_transient = 'aq_template_' . $template_id;
			set_transient( $template_transient, $template_transient_data );
			
			//use haystack to check for deleted blocks
			$curr_blocks = $this->get_blocks($template_id);
			$curr_blocks = is_array($curr_blocks) ? $curr_blocks : array();
			foreach($curr_blocks as $key => $block){
				if(!in_array($key, $haystack))
					delete_post_meta($template_id, $key);
			}
			
			return $template_id;
			
		}		
		
		/**
		 * Delete page template
		 *
		 * @since	1.0.0
		**/
		function delete_template($template_id) {
			
			//first let's check if template id is valid
			if(!$this->is_template($template_id)) return false;
			
			//wp security layer
			check_admin_referer( 'delete-template', '_wpnonce' );
			
			//delete template, hard!
			wp_delete_post( $template_id, true );
			
			//delete template transient
			$template_transient = 'aq_template_' . $template_id;
			delete_transient( $template_transient );
			
		}
		
		/**
		 * Preview template
		 *
		 * Theme authors should attempt to make the preview
		 * layout to be consistent with their themes by using
		 * the filter provided in the function
		 *
		 * @since	1.0.0
		 */
		function preview_template() {
		
			global $wp_query, $aq_page_builder;
			$post_type = $wp_query->query_vars['post_type'];
			
			if($post_type == 'template') {
				get_header();
				?>
					<div id="main" class="cf">
						<div id="content" class="cf">
							<?php $this->display_template(get_the_ID()); ?>
							<?php if($this->args['debug'] == true) print_r(aq_get_blocks(get_the_ID())) //for debugging ?>
						</div>
					</div>
				<?php
				get_footer();
				exit;
			}
			
		}
		
		/**
		 * Display the template on the front end
		 *
		 * @since	1.0.0
		**/
		function display_template($template_id) {
		
			//verify template
			if(!$template_id) return;
			if(!$this->is_template($template_id)) return;
			
			//get transient if available
			$template_transient = 'aq_template_' . $template_id;
			$template_transient_data = get_transient($template_transient);
			
			if($template_transient_data == false) {
				$blocks = $this->get_blocks($template_id);
			} else {
				$blocks = $template_transient_data;
			}
			
			$blocks = is_array($blocks) ? $blocks : array();
			
			//return early if no blocks
			if(empty($blocks)) {
			
				echo '<p class="empty-template">';
				echo __('This template is empty', 'pmc-themes');
				echo '</p>';
				
			} else {
				//template wrapper
				echo '<div id="aq-template-wrapper-'.$template_id.'" class="aq-template-wrapper aq_row">';
				
				$overgrid = 0; $span = 0; $first = false;
				
				//outputs the blocks
				foreach($blocks as $key => $instance) {
					global $aq_registered_blocks;
					extract($instance);
					
					if(class_exists($id_base)) {
						//get the block object
						$block = $aq_registered_blocks[$id_base];
						
						//insert template_id into $instance
						$instance['template_id'] = $template_id;
						
						//display the block
						if($parent == 0) {
							
							$col_size = absint(preg_replace("/[^0-9]/", '', $size));
							
							$overgrid = $span + $col_size;
							
							if($overgrid > 12 || $span == 12 || $span == 0) {
								$span = 0;
								$first = true;
							}
							
							if($first == true) {
								$instance['first'] = true;
							}
							
							$block->block_callback($instance);
							
							$span = $span + $col_size;
							
							$overgrid = 0; //reset $overgrid
							$first = false; //reset $first
						}
					}
				}
				
				//close template wrapper
				echo '</div>';
			}
			
		}
		
		/**
		 * Add the [template] shortcode
		 *
		 * @since 1.0.0
		 */
		function add_shortcode() {
		
			global $shortcode_tags;
			if ( !array_key_exists( 'template', $shortcode_tags ) ) {
				add_shortcode( 'template', array(&$this, 'do_shortcode') );
			} else {
				add_action('admin_notices', create_function('', "echo '<div id=\"message\" class=\"error\"><p><strong>Aqua Page Builder notice: </strong>'. __('The \"[template]\" shortcode already exists, possibly added by the theme or other plugins. Please consult with the theme author to consult with this issue', 'pmc-themes') .'</p></div>';"));
			}
			
		}
		
		/**
		 * Shortcode function
		 *
		 * @since 1.0.0
		 */
		function do_shortcode($atts, $content = null) {
		
			$defaults = array('id' => 0);
			extract( shortcode_atts( $defaults, $atts ) );
			
			//capture template output into string
			ob_start();
				$this->display_template($id);
				$template = ob_get_contents();
			ob_end_clean();
			
			return $template;
			
		}
		/**
		 * Media button shortcode
		 *
		 * @since 1.0.6
		 */
		function add_media_button( $button ) {
			global $pagenow, $wp_version;
			$output = '';
			if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) {
				if ( version_compare( $wp_version, '3.5', '<' ) ) {
					$img 	= '<img src="' . AQPB_DIR . '/assets/images/aqua-media-button.png" width="16px" height="16px" alt="' . esc_attr__( 'Add Page Template', 'pmc-themes' )  . '" />';
					$output = '<a href="#TB_inline?width=640&inlineId=aqpb-iframe-container" class="thickbox" title="' . esc_attr__( 'Add Page Template', 'pmc-themes' )  . '">' . $img . '</a>';
				} else {
					$img 	= '<span class="wp-media-buttons-icon" style="background-image: url(' . AQPB_DIR . '/assets/images/aqua-media-button.png ); margin-top: -1px;"></span>';
					$output = '<a href="#TB_inline?width=640&inlineId=aqpb-iframe-container" class="thickbox button" title="' . esc_attr__( 'Add Page Template', 'pmc-themes' ) . '" style="padding-left: .4em;">' . $img . ' ' . esc_attr__( 'Add Template', 'pmc-themes' ) . '</a>';
				}
				
			}
			return $button . $output;
		}
		/**
		 * Media button display
		 *
		 * @since 1.0.6
		 */
		function add_media_display() {
			global $pagenow;
			/** Only run in post/page new and edit */
			if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) {
				/** Get all published templates */
				$templates = get_posts( array( 
					'post_type' 		=> 'template', 
					'posts_per_page'	=> -1,
					'post_status' 		=> 'publish',
					'order'				=> 'ASC',
					'orderby'			=> 'title'
		    		)
				);
				?>
				<script type="text/javascript">
					function insertTemplate() {
						var id = jQuery( '#select-aqpb-template' ).val();
						/** Alert user if there is no template selected */
						if ( '' == id ) {
							alert("<?php echo esc_js( __( 'Please select your template first!', 'pmc-themes' ) ); ?>");
							return;
						}
						/** Send shortcode to editor */
						window.send_to_editor('[template id="' + id + '"]');
					}
				</script>
				<div id="aqpb-iframe-container" style="display: none;">
					<div class="wrap" style="padding: 1em">
						<?php do_action( 'aqpb_before_iframe_display', $templates ); ?>	
						<?php
						/** If there is no template created yet */
						if ( empty( $templates ) ) {
							echo sprintf( __( 'You don\'t have any template yet. Let\'s %s create %s one!', 'pmc-themes' ), '<a href="' .admin_url().'themes.php?page=aq-page-builder">', '</a>' );
							return;
						}
						?>						
						<h3><?php _e( 'Choose Your Page Template', 'pmc-themes' ); ?></h3><br />
						<select id="select-aqpb-template" style="clear: both; min-width:200px; display: inline-block; margin-right: 3em;">
						<?php
							foreach ( $templates as $template )
								echo '<option value="' . absint( $template->ID ) . '">' . esc_attr( $template->post_title ) . '</option>';
						?>
						</select>
						<input type="button" id="aqpb-insert-template" class="button-primary" value="<?php echo esc_attr__( 'Insert Template', 'pmc-themes' ); ?>" onclick="insertTemplate();" />
						<a id="aqpb-cancel-template" class="button-secondary" onclick="tb_remove();" title="<?php echo esc_attr__( 'Cancel', 'pmc-themes' ); ?>"><?php echo esc_attr__( 'Cancel', 'pmc-themes' ); ?></a>
						<?php do_action( 'aqpb_after_iframe_display', $templates ); ?>
					</div>
				</div>
				<?php
			} /** End Coditional Statement for post, page, new and edit post */
		}
		
		/**
		 * Contextual help tabs
		 *
		 * @since 1.0.0
		 */
		function contextual_help() {
		
			$screen = get_current_screen();
			$contextual_helps = apply_filters('aqpb_contextual_helps', array());
			
			if($screen->id == $this->page) {
				// Help tab sidebar
				$screen->set_help_sidebar(
					'<p><strong>' . __('For more information:') . '</strong></p>' .
					'<p>' . __('<a href="http://aquagraphite.com/api/documentation/aqua-page-builder" target="_blank">Documentation</a>') . '</p>' .
					'<p>' . __('<a href="http://aquagraphite.com/api/changelog/aqua-page-builder" target="_blank">Changelog</a>') . '</p>'
				);
				
				// Main overview tab
				$screen->add_help_tab( array(
				'id'		=> 'overview',
				'title'		=> __('Overview'),
				'content'	=> $this->args['contextual_help'],
				) );
				
				/** Additional help tabs */
				if(!empty($contextual_helps)) {
					foreach($contextual_helps as $help) {
						$screen->add_help_tab($help);
					}
				}
				
			}
			
		}
		
		/**
		 * Main page builder page display
		 *
		 * @since	1.0.0
		 */
		function builder_page_show(){
			
			require_once(AQPB_PATH . 'view/view-builder-page.php');
			
		}
		
		
	}
}
// not much to say when you're high above the mucky-muck
