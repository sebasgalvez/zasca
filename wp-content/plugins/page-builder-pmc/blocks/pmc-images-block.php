<?php
/** Images Block **/
class PMC_Images_Block extends AQ_Block {
	function __construct() {
		$block_options = array(
			'name'			=> 'Gallery',
			'size'			=> 'span3',
			'icon' => 'fa-picture-o',
			'icon_color' => 'FFF',
			'category' => 'Content',
			'help' => 'With this block you can add simple images gallery.'				
		);
		
		parent::__construct('pmc_images_block', $block_options);
		
		add_action('wp_ajax_aq_block_images_add_new', array($this, 'add_images'));
	}
	
	function form($instance) {
		$defaults = array(
			'imagess'		=> array(
				1 => array(
					'image' => '',
					'alt' => 'Alt text',				
				)
			)
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		?>
		
		<br>
		<div class="description cf">
			<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>" alt = "imagess">
				<?php
				$imagess = is_array($imagess) ? $imagess : $defaults['imagess'];
				$count = 1;
				foreach($imagess as $images) {	
					$this->images($images, $count, $block_id);
					$count++;
				}
				?>
			</ul>
			<p></p>
			<a href="#" rel="images" class="aq-sortable-add-new button">Add New Images</a>
			<p></p>
		</div>
		<?php
	}
	
	function images($images = array(), $count = 0, $block_id) {
		$defaults = array (
			'image' => '',
			'alt' => 'Alt text',			
		);
		$images = wp_parse_args($images, $defaults);		
		?>
		<li id="<?php echo $this->get_field_id('imagess') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
		
			
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $images['alt'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#">Open / Close</a>
				</div>
			</div>

			<div class="sortable-body">
				<p class="imagess-desc description">
					<label for="<?php echo $this->get_field_id('imagess') ?>-<?php echo $count ?>-image"">
						Upload an image<br/>
						<input type="text" id="<?php echo $this->get_field_id('imagess') ?>-<?php echo $count ?>-image" class="input-full input-upload" name="<?php echo $this->get_field_name('imagess') ?>[<?php echo $count ?>][image]" value="<?php echo $images['image'] ?>">
						<a href="#" class="aq_upload_button button" >Upload</a><p></p>					
					</label>
					<?php if(isset($image)) { ?>
					<div class="screenshot">
						<image src="<?php echo $images['image'] ?>" />
					</div>
					<?php } ?>
				</p>					
				<p class="description">
					<label for="<?php echo $this->get_field_id('imagess') ?>-<?php echo $count ?>-alt">
						Alt text<br/>
						<input type="text" id="<?php echo $this->get_field_id('imagess') ?>-<?php echo $count ?>-alt" class="input-full" name="<?php echo $this->get_field_name('imagess') ?>[<?php echo $count ?>][alt]" value="<?php echo $images['alt'] ?>" />
					</label>
				</p>
				<p class="description"><a href="#" class="sortable-delete">Delete</a></p>
			</div>
			
		</li>
		<?php
	}
	
	function add_images() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		
		//default key/value for the tab
		$images = array(
			'image' => '',
			'alt' => 'Alt text',		
		);
		
		if($count) {
			$this->images($images, $count, $block_id);
		} else {
			die(-1);
		}
		
		die();
	}
	
	function block($instance) {
		$defaults = array(		
			'imagess'		=> array(
				1 => array(
					'image' => '',
					'alt' => 'Alt text',				
					)
			)		
		);
					
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		
		$count = count($imagess);
		$i = 1;
		
		?>			
		<div id="imagess_<?php echo rand(1,100) ?>" class="imagess cf">
			
			<?php foreach ($imagess as $images) {	
				
					?>
					
					<div class="images-block">
						<a href="<?php echo esc_html($images['image']) ?>" rel="lightbox[image_block]" title="<?php echo esc_html($images['alt']) ?>"><img src ="<?php echo esc_html($images['image']) ?>" alt="<?php echo esc_html($images['alt']) ?>"></a>				
					</div>
					<?php
				}
			 ?>
	
			
		</div>
		
		<?php
		
	}
	
	function update($new_instance, $old_instance) {
		$new_instance = aq_recursive_sanitize($new_instance);
		return $new_instance;
	}	
	
}
