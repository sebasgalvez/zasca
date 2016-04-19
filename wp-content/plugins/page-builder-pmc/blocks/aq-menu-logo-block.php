<?php/** "Clear" block  *  * Clear the floats vertically * Optional to use horizontal lines/images**/class AQ_Menu_Block extends AQ_Block {		//set and create block	function __construct() {		$block_options = array(			'name' => 'Menu and Logo',			'size' => 'span12',			'icon' => 'fa-th-list',			'icon_color' => 'FFF',			'category' => 'Menu',			'help' => 'Main Menu and Logo are set here. You can choose between all the menus, that you have set in Appearance -> Menus'		);				//create the block		parent::__construct('aq_menu_block', $block_options);		if (pmc_woo() && PMC_SHOP){			$this->cart = new PMC_Woo_Cart_Block();		}						}		function form($instance) {				$defaults = array(							'select_menu_resp' => '',		'select_menu_main' => '',		'select_menu_scroll' => '',			'show_menu_cart' => 0,						'show_logo' => 1,		'menu_left' => 0,		'tran_background_menu' => 0,		'use_scroll_menu' => 0,		'show_social' => 0,			'menu_description' => 0,				'text_color' => '#333333',		'border_color' => '#3d3d3d',				'show_border' => 1,		'menu_top_padding' => 34,			'logo_top_padding' => 17,				'menu_location' => 'right',		'menu_button' => 0,		'menu_button_link' => 'http://premiumcoding.com',		'menu_button_text' => 'Button'		);						$instance = wp_parse_args($instance, $defaults);		extract($instance);		$menus = get_registered_nav_menus();					$text_location = array(			'left' => 'Left',			'right' => 'Right',			'center' => 'Center',			);							?>		<p class="description note">			<?php _e('This block is used to display logo and menu.', 'pmc-themes') ?>		</p>									<p class="description third">			<label for="<?php echo $this->get_field_id('select_menu_mai') ?>">			Main menu for this page<br/>			<?php echo aq_field_select('select_menu_main', $block_id, $menus, $select_menu_main); ?>									</label>		</p>			<p class="description third">			<label for="<?php echo $this->get_field_id('select_menu_resp') ?>">			Responsive menu for this page<br/>			<?php echo aq_field_select('select_menu_resp', $block_id, $menus, $select_menu_resp); ?>									</label>		</p>							<p class="description third last">			<label for="<?php echo $this->get_field_id('select_menu_resp') ?>">			Scroll menu for this page<br/>			<?php echo aq_field_select('select_menu_scroll', $block_id, $menus, $select_menu_scroll); ?>			</label>		</p>			<div class="description third pmc-border-third">			<h3>Menu Options</h3>			<label for="<?php echo $this->get_field_id('show_logo') ?>" style="width:100%;float: left;margin-bottom: 10px;">								<?php echo aq_field_checkbox('show_logo', $block_id, $show_logo); ?>								Show logo in menu?						</label>				<label for="<?php echo $this->get_field_id('use_scroll_menu') ?>" style="width:100%;float: left;margin-bottom: 10px;">				<?php echo aq_field_checkbox('use_scroll_menu', $block_id, $use_scroll_menu); ?>				Show alternative logo for scroll menu (if you are using transparent menu)			</label>						<label for="<?php echo $this->get_field_id('tran_background_menu') ?>" style="width:100%;float: left;margin-bottom: 10px;">				<?php echo aq_field_checkbox('tran_background_menu', $block_id, $tran_background_menu); ?>				Transparent background?			</label>			<div class="social">			<label for="<?php echo $this->get_field_id('show_social') ?>" style="width:100%;float: left;margin-bottom: 10px;">				<?php echo aq_field_checkbox('show_social', $block_id, $show_social); ?>				Show social icons on the right?			</label>				</div>			<?php if(pmc_woo() && PMC_SHOP){ ?>			<div class="cart">				<label for="<?php echo $this->get_field_id('show_menu_cart') ?>" style="width:100%;float: left;margin-bottom: 10px;">					<?php echo aq_field_checkbox('show_menu_cart', $block_id, $show_menu_cart); ?>					Show cart on the right?				</label>			</div>			<?php } ?>			<label for="<?php echo $this->get_field_id('menu_description') ?>" style="width:100%;float: left;margin-bottom: 10px;">				<?php echo aq_field_checkbox('menu_description', $block_id, $menu_description); ?>				Menu description (check if you are using menu description)			</label>				<div class="button-check">			<label for="<?php echo $this->get_field_id('menu_button') ?>" style="width:100%;float: left;margin-bottom: 10px;">				<?php echo aq_field_checkbox('menu_button', $block_id, $menu_button); ?>				Menu button (check if you wish to show button on the right)			</label>				</div>		</div>					<div class="description third pmc-border-third">			<h3>Menu Content Options</h3>					<label for="<?php echo $this->get_field_id('text_color') ?>" style="width:100%;float: left;margin-bottom: 10px;">				Link color<br/>				<?php echo aq_field_color_picker('text_color', $block_id, $text_color, '#333') ?>			</label>			<div class="menu-position">			<label for="<?php echo $this->get_field_id('menu_location') ?>" style="width:100%;float: left;margin-bottom: 10px;">				Menu Text align (not for small header menu)<br/>				<?php echo aq_field_select('menu_location', $block_id, $text_location, $menu_location); ?>			</label>				</div>			<div class="smallheader-menu">			<label for="<?php echo $this->get_field_id('show_border') ?>" style="width:100%;float: left;margin-bottom: 10px;">								<?php echo aq_field_checkbox('show_border', $block_id, $show_border); ?>								Show border between links (only for small header menu)?						</label>			<label for="<?php echo $this->get_field_id('border_color') ?>" style="width:100%;float: left;margin-bottom: 10px;" >				Border color(only for small header menu)<br/>				<?php echo aq_field_color_picker('border_color', $block_id, $border_color, '#3d3d3d') ?>			</label>			</div>			<label for="<?php echo $this->get_field_id('menu_top_padding') ?> " style="width:100%;float: left;margin-bottom: 10px;">				Menu top padding<br/>				<?php echo aq_field_input('menu_top_padding', $block_id, $menu_top_padding) ?>			</label>				<label for="<?php echo $this->get_field_id('logo_top_padding') ?>">				Logo top padding<br/>				<?php echo aq_field_input('logo_top_padding', $block_id, $logo_top_padding) ?>			</label>												</div>				<div class="description third last menu-button pmc-border-third">				<h3>Menu Button Options</h3>			<label for="<?php echo $this->get_field_id('menu_button_text') ?> " style="width:100%;float: left;margin-bottom: 10px;">				Button Text<br/>				<?php echo aq_field_input('menu_button_text', $block_id, $menu_button_text) ?>			</label>				<label for="<?php echo $this->get_field_id('menu_button_link') ?>">				Button Link<br/>				<?php echo aq_field_input('menu_button_link', $block_id, $menu_button_link) ?>			</label>												</div>				<script>			jQuery(document).ready(function() {				jQuery('.smallheader-menu').hide()				jQuery('.menu-button').hide()				jQuery('.custom-class input').each(function(){					if(jQuery(this).attr('value') == 'smallheader'){jQuery('.smallheader-menu').show()};				})								if(jQuery('#<?php echo $block_id ?>_show_social').is(":checked")) { jQuery('.menu-position').hide(); jQuery('.menu-position').hide(); jQuery('.cart').hide();}				if(jQuery('#<?php echo $block_id ?>_menu_button').is(":checked")) { jQuery('.menu-button').show();jQuery('.social').hide(); jQuery('.menu-position').hide();}				if(jQuery('#<?php echo $block_id ?>_show_menu_cart').is(":checked")) { jQuery('.social').hide();}				jQuery('#<?php echo $block_id ?>_show_social').change(function() {					if(jQuery(this).is(":checked")) {						jQuery('.menu-position').hide();						jQuery('.cart').hide(); 						jQuery('#<?php echo $block_id ?>_show_menu_cart').attr('checked', false);						jQuery('#<?php echo $block_id ?>_menu_button').attr('checked', false);						jQuery('.menu-button').hide();								jQuery('.button-check').hide();											}					else{						jQuery('.menu-position').show();						jQuery('.cart').show();						jQuery('.button-check').show();								}									});				jQuery('#<?php echo $block_id ?>_show_menu_cart').change(function() {					if(jQuery(this).is(":checked")) {						jQuery('.menu-position').hide();						jQuery('.social').hide(); 						jQuery('#<?php echo $block_id ?>_show_social').attr('checked', false);						jQuery('#<?php echo $block_id ?>_menu_button').attr('checked', false);						jQuery('.menu-button').hide();						jQuery('.button-check').hide();					}					else{						jQuery('.menu-position').show();						jQuery('.social').show();						jQuery('.button-check').show();						}					 				});				jQuery('#<?php echo $block_id ?>_menu_button').change(function() {					if(jQuery(this).is(":checked")) {						jQuery('.menu-button').show();						jQuery('#<?php echo $block_id ?>_show_social').attr('checked', false);						jQuery('#<?php echo $block_id ?>_show_menu_cart').attr('checked', false);						jQuery('.social').hide(); 						jQuery('.menu-position').hide();					}					else{						jQuery('.menu-button').hide();						jQuery('.social').show();								jQuery('.cart').show();					}					 				});							});				</script>		<?php			}		function block($instance) {		if (pmc_woo() && PMC_SHOP){			$cart = new PMC_Woo_Cart_Block();		}				$defaults = array(					'select_menu_resp' => '',			'select_menu_main' => '',			'select_menu_scroll' => '',				'show_menu_cart' => 0,								'show_logo' => 1,			'menu_left' => 0,						'tran_background_menu' => 0,			'use_scroll_menu' => 0,				'show_social' => 0,				'menu_description' => 0,			'text_color' => '#333333',			'border_color' => '#3d3d3d',					'show_border' => 1,			'menu_top_padding' => 34,			'logo_top_padding' => 17,			'menu_location' => 'right',			'menu_button' => 0,			'menu_button_link' => 'http://premiumcoding.com',			'menu_button_text' => 'Button'							);				$instance = wp_parse_args($instance, $defaults);			extract($instance);		$tran_background_menu_class = $menu_left_class = $border = $custom_color ='';		if($tran_background_menu){			$tran_background_menu_class = 'pmc_menu_transparent';		}		if($menu_left){			$menu_left_class = 'pmc_menu_left';		}				$main_menu_single = 'pmcsinglemenu'; 		$main_menu= 'pmcmainmenu';				$resp_menu = 'pmcrespmenu';		$resp_single_menu = 'pmcrespsinglemenu';		$scroll_menu = 'pmcscrollmenu';		if($select_menu_resp != ''){			$resp_menu = $select_menu_resp;			$resp_single_menu = $select_menu_resp;		}		if($select_menu_main != ''){			$main_menu = $select_menu_main;			$main_menu_single = $select_menu_main;		}				add_option( 'scroll_menu-'.get_the_id(), '' );		add_option( 'menu_button_link'.get_the_id(), '' );		add_option( 'menu_button_text'.get_the_id(), '' );		if($select_menu_scroll != ''){			$scroll_menu = $select_menu_scroll;			update_option( 'scroll_menu-'.get_the_id(), $select_menu_scroll); 		}			if($menu_button != 0){						update_option( 'menu_button_link'.get_the_id(), $menu_button_link );			update_option( 'menu_button_text'.get_the_id(), $menu_button_text );			}							if(isset($show_border) && $show_border == 1){$border = '.smallheader #headerwrap #header ul.menu > li{border-right:1px solid '.$border_color.'} #header ul.menu > li:last-child {border:none !important;}';}		if(isset($text_color) && $text_color != '#333333' ){$custom_color  = '.mainmenu .menu a{color:'.$text_color .' !important;}';}		global $pmc_data;					?>				<style scoped>#header ul.menu > li > a, .pmc-menu-button {padding-bottom: <?php echo $menu_top_padding ?>px; }#logo{margin-top:<?php echo $logo_top_padding ?>px;} #header .mainmenu ul.menu{padding-top:<?php echo $menu_top_padding ?>px;} <?php echo $border ?> <?php echo $custom_color ?> .pagenav {text-align:<?php echo $menu_location ?> !important;} </style>		<header>		<div id="headerwrap" class="<?php echo $tran_background_menu_class ?> <?php if($show_social) { echo 'social-menu'; } ?> <?php echo $menu_left_class ?>">						<!-- logo and main menu -->			<div id="header">				<?php if (isset($show_logo) && $show_logo == 1){ ?>					<div id="logo">					<?php 					if($use_scroll_menu == 1){						if(isset($pmc_data['scroll_logo'])){							$logo = $pmc_data['scroll_logo']; 						} else {							$logo = $pmc_data['logo']; 						}					} else {						$logo = $pmc_data['logo']; 					} 													?>					<a href="<?php echo home_url(); ?>"><img src="<?php if ($logo != '') {?>					<?php echo $logo; ?><?php } else {?><?php get_template_directory_uri(); ?>/images/logo.png<?php }?>" alt="<?php bloginfo('name'); ?> - <?php bloginfo('description') ?>" /></a>				</div>				<?php } ?>				<!-- respoonsive menu main-->				<!-- respoonsive menu no scrool bar -->				<div class="respMenu noscroll">					<div class="resp_menu_button"><i class="fa fa-list-ul fa-2x"></i></div>					<?php 					if(is_front_page()){						if ( has_nav_menu( $resp_menu ) ) {							$menuParameters =  array(							  'theme_location' => $resp_menu, 							  'walker'         => new pmc_Walker_Responsive_Menu(),							  'echo'            => false,							  'items_wrap'     => '<div class="event-type-selector-dropdown">%3$s</div>',							);							echo strip_tags(wp_nav_menu( $menuParameters ), '<a>,<br>,<div>,<i>,<strong>' );						}					}else{						if ( has_nav_menu( $resp_single_menu ) ) {							$menuParameters =  array(							  'theme_location' => $resp_single_menu, 							  'walker'         => new pmc_Walker_Responsive_Menu(),							  'echo'            => false,							  'items_wrap'     => '<div class="event-type-selector-dropdown">%3$s</div>',							);							echo strip_tags(wp_nav_menu( $menuParameters ), '<a>,<br>,<div>,<i>,<strong>' );						}											}										?>					</div>							<!-- main menu -->					<?php 					if(is_front_page()){?>					<div class="pagenav home mainmenu <?php if(isset($menu_description) && $menu_description == 1){ echo ' menu-description';  } ?> <?php if (isset($show_logo) && $show_logo == 1){ echo ' menu-right';  } else { echo ' no-logo'; } ?> <?php if (!isset($show_cart) || $show_cart == 0 && $show_logo == 1){ echo ' menu-right-float'; } else if (!isset($show_cart) || $show_cart == 0 && $show_logo == 0) {echo ' no-cart' ;} ?>"> 					<?php						if ( has_nav_menu( $main_menu ) ) {							 wp_nav_menu( array(							 'container' =>false,							 'container_class' => 'menu-header home',							 'theme_location' => $main_menu,							 'echo' => true,							 'fallback_cb' => 'ideo_fallback_menu',							 'before' => '',							 'after' => '',							 'link_before' => '',							 'link_after' => '',							 'depth' => 0,							 'walker' => new pmc_Walker_Main_Menu())							 ); 						} ?>				<?php if($menu_button) { ?>					<div class="pmc-menu-button">						<a href="<?php echo esc_url($menu_button_link); ?>"><?php echo esc_html($menu_button_text); ?></a>					</div>				<?php  } ?>												</div> <?php					}					else {						if ( has_nav_menu( $main_menu_single ) ) {?>						<div class="pagenav mainmenu <?php if(isset($menu_description) && $menu_description == 1){ echo ' menu-description';  } ?> <?php if (isset($show_logo) && $show_logo == 1){ echo ' menu-right';  } else { echo ' no-logo'; } ?> <?php if (!isset($show_cart) || $show_cart == 0 && $show_logo == 1){ echo ' menu-right-float';  } else if (!isset($show_cart) || $show_cart == 0 && $show_logo == 0) {echo ' no-cart' ;} ?>"> 						<?php													 wp_nav_menu( array(							 'container' =>false,							 'container_class' => 'menu-header',							 'theme_location' => $main_menu_single,							 'echo' => true,							 'fallback_cb' => 'ideo_fallback_menu',							 'before' => '',							 'after' => '',							 'link_before' => '',							 'link_after' => '',							 'depth' => 0,							 'walker' => new pmc_Walker_Main_Menu())							 ); 					} ?>				<?php if($menu_button) { ?>					<div class="pmc-menu-button">						<a href="<?php echo esc_url($menu_button_link); ?>"><?php echo esc_html($menu_button_text); ?></a>					</div>				<?php  } ?>											</div> <?php										}					?>							<?php if($show_social) { ?>					<div class="pmc-menu-social">						<?php pmc_socialLink(); ?>					</div>				<?php  } ?>							<?php if (pmc_woo() && PMC_SHOP){ ?>					<?php if($show_menu_cart) { ?>						<div class="pmc-menu-social cart">							<?php  $cart -> block($instance); ?>						<?php  } ?>					<?php  } ?>								</div>		</div>				</header>							<?php				}		function update($new_instance, $old_instance) {		$new_instance = aq_recursive_sanitize($new_instance);		return $new_instance;	}	}