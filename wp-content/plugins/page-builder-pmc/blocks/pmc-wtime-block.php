<?php
/** WTime Block **/
class PMC_WTime_Block extends AQ_Block {
	function __construct() {
		$block_options = array(
			'name'			=> 'Working time',
			'size'			=> 'span12',
			'icon' => 'fa-calendar',
			'icon_color' => 'FFF',
			'category' => 'Content',
			'help' => 'With this block you can add your working time.'				
		);
		
		parent::__construct('pmc_wtime_block', $block_options);
		
		add_action('wp_ajax_aq_block_wtime_add_new', array($this, 'add_wtime'));
	}
	
	function form($instance) {
		$defaults = array(
			'speed' => 6000,
			'wtimes'		=> array(
				1 => array(
					'day' => 'Monday',
					'whours' => '',
					'background' => '0',
					'color' => '#fff'					
				)
			)
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		?>
		
		<br>
		<div class="description cf">
			<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>" alt = "wtimes">
				<?php
				$wtimes = is_array($wtimes) ? $wtimes : $defaults['wtimes'];
				$count = 1;
				foreach($wtimes as $wtime) {	
					$this->wtime($wtime, $count, $block_id);
					$count++;
				}
				?>
			</ul>
			<p></p>
			<a href="#" rel="wtime" class="aq-sortable-add-new button">Add New Day</a>
			<p></p>
		</div>
		<?php
	}
	
	function wtime($wtime = array(), $count = 0, $block_id) {
		$defaults = array (
			'day' => '',
			'whours' => '',
			'text' => '',	
			'color' => '#fff'			
		);
		$wtime = wp_parse_args($wtime, $defaults);		
		?>
		<li id="<?php echo $this->get_field_id('wtimes') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
		
			
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $wtime['day'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#">Open / Close</a>
				</div>
			</div>

			<div class="sortable-body">
				<p class="description">
					<label for="<?php echo $this->get_field_id('wtimes') ?>-<?php echo $count ?>-day">
						Day<br/>
						<input type="text" id="<?php echo $this->get_field_id('wtimes') ?>-<?php echo $count ?>-day" class="input-full" name="<?php echo $this->get_field_name('wtimes') ?>[<?php echo $count ?>][day]" value="<?php echo $wtime['day'] ?>" />
					</label>
				</p>				
				<p class="description">
					<label for="<?php echo $this->get_field_id('wtimes') ?>-<?php echo $count ?>-whours">
						Working hours<br/>
						<input type="text" id="<?php echo $this->get_field_id('wtimes') ?>-<?php echo $count ?>-whours" class="input-full" name="<?php echo $this->get_field_name('wtimes') ?>[<?php echo $count ?>][whours]" value="<?php echo $wtime['whours'] ?>" />
					</label>
				</p>
				<p class="description">
					<label for="<?php echo $this->get_field_id('wtimes') ?>-<?php echo $count ?>-text">
						Background color<br/>
						<div class="aqpb-color-picker">
							<input type="text" id="<?php echo $this->get_field_id('wtimes') ?>-<?php echo $count ?>-background" class="input-color-picker"  name="<?php echo $this->get_field_name('wtimes') ?>[<?php echo $count ?>][background]" value="<?php echo $wtime['background'] ?>" data-default-color="#000"/>
						</div>						
					</label>
					<label for="<?php echo $this->get_field_id('wtimes') ?>-<?php echo $count ?>-text">
						Text color<br/>
						<div class="aqpb-color-picker">
							<input type="text" id="<?php echo $this->get_field_id('wtimes') ?>-<?php echo $count ?>-color" class="input-color-picker"  name="<?php echo $this->get_field_name('wtimes') ?>[<?php echo $count ?>][color]" value="<?php echo $wtime['color'] ?>" data-default-color="#fff"/>
						</div>						
					</label>					
				</p>
				<p class="description"><a href="#" class="sortable-delete">Delete</a></p>
			</div>
			
		</li>
		<?php
	}
	
	function add_wtime() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		
		//default key/value for the tab
		$wtime = array(
			'day' => 'Monday',
			'whours' => '',
			'text' => '',
			'color' => '#fff'			
		);
		
		if($count) {
			$this->wtime($wtime, $count, $block_id);
		} else {
			die(-1);
		}
		
		die();
	}
	
	function block($instance) {
		$defaults = array(		
			'wtimes'		=> array(
				1 => array(
					'day' => 'Monday',
					'whours' => '',
					'background' => '#000',
					'color' => '#fff'
				)
			)		
		);
					
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		
		$count = count($wtimes);
		$i = 1;
		
		?>			
		<div id="wtimes_<?php echo rand(1,100) ?>" class="wtimes cf">
			<ul class="slides-wtimes">
			
			<?php foreach ($wtimes as $wtime) {	
				
					?>
					
					<li class="wtime" style="background:<?php echo esc_html($wtime['background']); ?>;color:<?php echo esc_html($wtime['color']); ?>">
						<div class="wtime-day">
							<?php echo esc_html($wtime['day']) ?>
						</div>
						<div class="wtime-whours">
							<?php echo esc_html($wtime['whours']) ?>
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
