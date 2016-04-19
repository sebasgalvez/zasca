<?php
/** Testimonial_2 Block **/
class AQ_Testimonial_2_Block extends AQ_Block {
	function __construct() {
		$block_options = array(
			'name'			=> 'Testimonial 2',
			'size'			=> 'span3',
			'icon' => 'fa-comments',
			'icon_color' => 'FFF',
			'category' => 'Content',
			'help' => 'Testimonial 2 block allows you to add quotes from your customers without slider .'				
		);
		
		parent::__construct('aq_testimonial_2_block', $block_options);
		
		add_action('wp_ajax_aq_block_testimonial_2_add_new', array($this, 'add_testimonial_2'));
	}
	
	function form($instance) {
		$defaults = array(
			'testimonial_2s'		=> array(
				1 => array(
					'author' => 'Author',
					'image' => '',	
					'link' => '',
					'text' => '',
					'show_author_on_top' => '0'
				)
			)
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		?>

		<div class="description cf">
			<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>" alt = "testimonial_2s">
				<?php
				$testimonial_2s = is_array($testimonial_2s) ? $testimonial_2s : $defaults['testimonial_2s'];
				$count = 1;
				foreach($testimonial_2s as $testimonial_2) {	
					$this->testimonial_2($testimonial_2, $count, $block_id);
					$count++;
				}
				?>
			</ul>
			<p></p>
			<a href="#" rel="testimonial_2" class="aq-sortable-add-new button">Add New</a>
			<p></p>
		</div>
		<?php
	}
	
	function testimonial_2($testimonial_2 = array(), $count = 0, $block_id) {
		$defaults = array (
			'author' => 'Author',
			'image' => '',			
			'link' => '',
			'text' => '',	
			
		);
		$testimonial_2 = wp_parse_args($testimonial_2, $defaults);		
		?>
		<li id="<?php echo $this->get_field_id('testimonial_2s') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
		
			
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $testimonial_2['author'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#">Open / Close</a>
				</div>
			</div>

			<div class="sortable-body">
				<p class="testimonial_2s-desc description">
					<label for="<?php echo $this->get_field_id('testimonial_2s') ?>-<?php echo $count ?>-image"">
						Upload an image<br/>
						<input type="text" id="<?php echo $this->get_field_id('testimonial_2s') ?>-<?php echo $count ?>-image" class="input-full input-upload" name="<?php echo $this->get_field_name('testimonial_2s') ?>[<?php echo $count ?>][image]" value="<?php echo $testimonial_2['image'] ?>">
						<a href="#" class="aq_upload_button button" >Upload</a><p></p>					
					</label>
					<?php if(isset($image)) { ?>
					<div class="screenshot">
						<image src="<?php echo $testimonial_2['image'] ?>" />
					</div>
					<?php } ?>
				</p>				
				<p class="description">
					<label for="<?php echo $this->get_field_id('testimonial_2s') ?>-<?php echo $count ?>-author">
						Author<br/>
						<input type="text" id="<?php echo $this->get_field_id('testimonial_2s') ?>-<?php echo $count ?>-author" class="input-full" name="<?php echo $this->get_field_name('testimonial_2s') ?>[<?php echo $count ?>][author]" value="<?php echo $testimonial_2['author'] ?>" />
					</label>
				</p>				
				<p class="description">
					<label for="<?php echo $this->get_field_id('testimonial_2s') ?>-<?php echo $count ?>-link">
						Link<br/>
						<input type="text" id="<?php echo $this->get_field_id('testimonial_2s') ?>-<?php echo $count ?>-link" class="input-full" name="<?php echo $this->get_field_name('testimonial_2s') ?>[<?php echo $count ?>][link]" value="<?php echo $testimonial_2['link'] ?>" />
					</label>
				</p>
				<p class="description">
					<label for="<?php echo $this->get_field_id('testimonial_2s') ?>-<?php echo $count ?>-text">
						Testimonial Text<br/>
						<textarea id="<?php echo $this->get_field_id('testimonial_2s') ?>-<?php echo $count ?>-text" class="textarea-full" name="<?php echo $this->get_field_name('testimonial_2s') ?>[<?php echo $count ?>][text]" rows="5"><?php echo $testimonial_2['text'] ?></textarea>
					</label>
				</p>
				<p class="description"><a href="#" class="sortable-delete">Delete</a></p>
			</div>
			
		</li>
		<?php
	}
	
	function add_testimonial_2() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		
		//default key/value for the tab
		$testimonial_2 = array(
			'author' => 'Author',
			'image' => '',	
			'link' => '',
			'text' => ''
		);
		
		if($count) {
			$this->testimonial_2($testimonial_2, $count, $block_id);
		} else {
			die(-1);
		}
		
		die();
	}
	
	function block($instance) {
		$defaults = array(			
			'testimonial_2s'		=> array(
				1 => array(
					'author' => 'Author',
					'image' => '',	
					'link' => '',
					'text' => '',
					'show_author_on_top' => '0'
				)
			)		
		);
					
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);


		$count = count($testimonial_2s);
		$i = 1;
		
		?>
			
		<div id="testimonial_2s_<?php echo rand(1,100) ?>" class="testimonial_2s cf">
			<ul class="slides-testimonial_2s">
			
			<?php foreach ($testimonial_2s as $testimonial_2) {	
			

				
				if(!empty($testimonial_2['author']) && !empty($testimonial_2['text'])) {
					
					if(!empty($testimonial_2['link'])) {
						$author = '<a href="'.$testimonial_2['link'].'"><span class="author">'. do_shortcode(htmlspecialchars_decode($testimonial_2['author'])).'</span></a>';
					} else {
						$author = '<span class="author">'. do_shortcode(htmlspecialchars_decode($testimonial_2['author'])).'</span>';
					}
				
				
					?>
					
					<li class="testimonial_2">
						<div class="testimonial_2-avatar">
							<img src = "<?php echo esc_url($testimonial_2['image'] ) ?>">
						</div>
						
						<div class="testimonial_2-description">
							<div class="testimonial_2-texts">
								<i class="fa fa-quote-right"></i><div class="testi-text"><?php echo do_shortcode(htmlspecialchars_decode($testimonial_2['text'])) ?></div><i class="fa fa-quote-right"></i>
							</div>						
							<div class="testimonial_2-author">
								<?php echo $author ?>
							</div>
						</div>	
					</li>
					<?php
				}
			} ?>
			
			</ul>
			
		</div>
		
		<?php
		
	}
	
	function update($new_instance, $old_instance) {
		$new_instance = aq_recursive_sanitize($new_instance);
		return $new_instance;
	}	
	
}
