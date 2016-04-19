<?php
/** instagram Block **/
class PMC_Instagram_Block extends AQ_Block {
	function __construct() {
		$block_options = array(
			'name'			=> 'Instagram',
			'size'			=> 'span3',
			'icon' => 'fa-instagram',
			'icon_color' => 'FFF',
			'category' => 'Content',
			'help' => 'With this block you can add Instagram image gallery.'				
		);
		
		parent::__construct('pmc_instagram_block', $block_options);
		
	}
	
	function form($instance) {
		$defaults = array(
			'hashtag' => 'brixtonlounge',
			'user' => 'premiumcoding',
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		?>
		
		<div class="description">	
			<h3>Instagram options</h3>
			<label for="<?php echo $this->get_field_id('user') ?>">
				Instagram User<br/>
				<?php echo aq_field_input('user', $block_id, $user) ?>
			</label>
			<label for="<?php echo $this->get_field_id('hashtag') ?> " style="width:100%;float: left;margin-bottom: 10px;">
				Instagram hashtag<br/>
				<?php echo aq_field_input('hashtag', $block_id, $hashtag) ?>
			</label>					
			
			
		</div>	
		<?php
	}
	
	
	function block($instance) {
		$defaults = array(
			'hashtag' => 'brixtonlounge',
			'user' => 'premiumcoding',
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		?>			
		<div class="pmc-instagram">
			<?php 		echo do_shortcode('[alpine-phototile-for-instagram id='.rand(0,999).' user="'.$user.'" src="global_tag" tag="'.$hashtag.'" imgl="instagram" style="wall" row="5" size="M" num="10" align="center" max="100"]'); ?>
		</div>
		
		<?php
		
	}
	
	function update($new_instance, $old_instance) {
		$new_instance = aq_recursive_sanitize($new_instance);
		return $new_instance;
	}	
	
}
