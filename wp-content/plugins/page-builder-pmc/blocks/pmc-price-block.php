<?php
/** Price Block **/
class PMC_Price_Block extends AQ_Block {
	function __construct() {
		$block_options = array(
			'name'			=> 'Price',
			'size'			=> 'span3',
			'icon' => 'fa-money',
			'icon_color' => 'FFF',
			'category' => 'Content',
			'help' => 'With this block you can add simple price table.'				
		);
		
		parent::__construct('pmc_price_block', $block_options);
		
		add_action('wp_ajax_aq_block_price_add_new', array($this, 'add_price'));
	}
	
	function form($instance) {
		$defaults = array(
			'speed' => 6000,
			'prices'		=> array(
				1 => array(
					'title' => 'Title',
					'price' => '$20-$30',				
				)
			)
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		?>
		
		<br>
		<div class="description cf">
			<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>" alt = "prices">
				<?php
				$prices = is_array($prices) ? $prices : $defaults['prices'];
				$count = 1;
				foreach($prices as $price) {	
					$this->price($price, $count, $block_id);
					$count++;
				}
				?>
			</ul>
			<p></p>
			<a href="#" rel="price" class="aq-sortable-add-new button">Add New Price options</a>
			<p></p>
		</div>
		<?php
	}
	
	function price($price = array(), $count = 0, $block_id) {
		$defaults = array (
			'title' => 'Title',
			'price' => '$20-$30',			
		);
		$price = wp_parse_args($price, $defaults);		
		?>
		<li id="<?php echo $this->get_field_id('prices') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
		
			
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $price['title'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#">Open / Close</a>
				</div>
			</div>

			<div class="sortable-body">
				<p class="description">
					<label for="<?php echo $this->get_field_id('prices') ?>-<?php echo $count ?>-title">
						Title<br/>
						<input type="text" id="<?php echo $this->get_field_id('prices') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('prices') ?>[<?php echo $count ?>][title]" value="<?php echo $price['title'] ?>" />
					</label>
				</p>				
				<p class="description">
					<label for="<?php echo $this->get_field_id('prices') ?>-<?php echo $count ?>-price">
						Price<br/>
						<input type="text" id="<?php echo $this->get_field_id('prices') ?>-<?php echo $count ?>-price" class="input-full" name="<?php echo $this->get_field_name('prices') ?>[<?php echo $count ?>][price]" value="<?php echo $price['price'] ?>" />
					</label>
				</p>
				<p class="description"><a href="#" class="sortable-delete">Delete</a></p>
			</div>
			
		</li>
		<?php
	}
	
	function add_price() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		
		//default key/value for the tab
		$price = array(
			'title' => 'Title',
			'price' => '$20-$30',		
		);
		
		if($count) {
			$this->price($price, $count, $block_id);
		} else {
			die(-1);
		}
		
		die();
	}
	
	function block($instance) {
		$defaults = array(		
			'prices'		=> array(
				1 => array(
					'title' => 'Title',
					'price' => '$20-$30',				
					)
			)		
		);
					
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		
		$count = count($prices);
		$i = 1;
		
		?>			
		<div id="prices_<?php echo rand(1,100) ?>" class="prices cf">
			<ul class="slides-prices">
			
			<?php foreach ($prices as $price) {	
				
					?>
					
					<li class="price-block">
						<div class="price-title">
							<?php echo esc_html($price['title']) ?>
						</div>
						<div class="price-price">
							<?php echo esc_html($price['price']) ?>
						</div>						
					</li>
					<?php
				}
			 ?>
			
			</ul>
			
		</div>
		
		<?php
		
	}
	
	function update($new_instance, $old_instance) {
		$new_instance = aq_recursive_sanitize($new_instance);
		return $new_instance;
	}	
	
}
