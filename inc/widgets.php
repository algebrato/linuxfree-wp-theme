<?php
/**
 * Give this theme some additional widgets.
 *
 * @package vantage
 * @since 1.0
 * @license GPL 2.0
 */

class Vantage_CircleIcon_Widget extends WP_Widget {

	public function __construct() {
		// widget actual processes
		parent::__construct(
			'circleicon-widget', // Base ID
			__('Circle Icon', 'vantage'), // Name
			array( 'description' => __( 'An icon in a circle with some text beneath it', 'vantage' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$instance = wp_parse_args( $instance, array(
			'title' => '',
			'text' => '',
			'icon' => '',
			'image' => '',
			'icon_position' => 'top',
			'icon_size' => 'small',
			'icon_background_color' => '',
			'more' => '',
			'more_url' => '',
			'all_linkable' => false,
			'box' => false,
		) );

		$icon_styles = array();
		if(!empty($instance['image'])) {
			$icon_styles[] = 'background-image: url('.esc_url($instance['image']).')';
		}
		if( !empty($instance['icon_background_color']) && preg_match('/^#?+[0-9a-f]{3}(?:[0-9a-f]{3})?$/i', $instance['icon_background_color'])) {
			$icon_styles[] = 'background-color: '.$instance['icon_background_color'];
		}

		$icon = $instance['icon'];
		if ( ! empty( $icon ) ) {
			$icon = apply_filters('vantage_fontawesome_icon_name', $icon );
		}
		?>
		<div class="circle-icon-box circle-icon-position-<?php echo esc_attr($instance['icon_position']) ?> <?php echo empty($instance['box']) ? 'circle-icon-hide-box' : 'circle-icon-show-box' ?> circle-icon-size-<?php echo $instance['icon_size'] ?>">
			<div class="circle-icon-wrapper">
                <?php if(!empty($instance['more_url']) && !empty($instance['all_linkable'])) : ?><a href="<?php echo esc_url($instance['more_url']) ?>" class="link-icon"><?php endif; ?>
				<div class="circle-icon" <?php if(!empty($icon_styles)) echo 'style="'.implode(';', $icon_styles).'"' ?>>
					<?php if(!empty($icon)) : ?><div class="<?php echo esc_attr($icon) ?>"></div><?php endif; ?>
				</div>
                <?php if(!empty($instance['more_url']) && !empty($instance['all_linkable'])) : ?></a><?php endif; ?>
			</div>

            <?php if(!empty($instance['more_url']) && !empty($instance['all_linkable'])) : ?><a href="<?php echo esc_url($instance['more_url']) ?>" class="link-title"><?php endif; ?>
			<?php if(!empty($instance['title'])) : ?><h4><?php echo wp_kses_post( apply_filters('widget_title', $instance['title'] ) ) ?></h4><?php endif; ?>
            <?php if(!empty($instance['more_url']) && !empty($instance['all_linkable'])) : ?></a><?php endif; ?>

			<?php if(!empty($instance['text'])) : ?><p class="text"><?php echo wp_kses_post($instance['text']) ?></p><?php endif; ?>
			<?php if(!empty($instance['more_url'])) : ?>
				<a href="<?php echo esc_url($instance['more_url']) ?>" class="btn btn-primary" style="color: white;" ><?php echo !empty($instance['more']) ? esc_html($instance['more']) : __('More Info', 'vantage') ?> <i></i></a>
			<?php endif; ?>
		</div>
		<?php

		echo $args['after_widget'];
	}

	/**
	 * Display the circle icon widget form.
	 *
	 * @param array $instance
	 * @return string|void
	 */
	public function form( $instance ) {

		$instance = wp_parse_args( $instance, array(
			'title' => '',
			'text' => '',
			'icon' => '',
			'image' => '',
			'icon_position' => 'top',
			'icon_size' => 'small',
			'icon_background_color' => '',
			'more' => '',
			'more_url' => '',
			'all_linkable' => false,
			'box' => false,
		) );

		$icons = include ( get_template_directory() . '/fontawesome/icons.php' );
		$sections = include (get_template_directory().'/fontawesome/icon-sections.php');
		if(!empty($instance['icon'])) {
			$instance['icon'] = apply_filters('vantage_fontawesome_icon_name', $instance['icon'] );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title') ?>"><?php _e('Title', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" value="<?php echo esc_attr($instance['title']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('text') ?>"><?php _e('Text', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('text') ?>" name="<?php echo $this->get_field_name('text') ?>" value="<?php echo esc_attr($instance['text']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('icon') ?>"><?php _e('Icon', 'vantage') ?></label>
			<select id="<?php echo $this->get_field_id('icon') ?>" name="<?php echo $this->get_field_name('icon') ?>">
				<option value="" <?php selected(!empty($instance['icon'])) ?>><?php esc_html_e('None', 'vantage') ?></option>
				<?php foreach($icons as $section => $s_icons) : ?>
					<?php if(isset($sections[$section])) : ?><optgroup label="<?php echo esc_attr($sections[$section]) ?>"><?php endif; ?>
						<?php foreach($s_icons as $icon) : ?>
							<option value="<?php echo esc_attr($icon) ?>" <?php selected($instance['icon'], $icon) ?>><?php echo esc_html(vantage_icon_get_name($icon)) ?></option>
						<?php endforeach; ?>
					</optgroup>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('icon_background_color') ?>"><?php _e('Icon Background Color', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('icon_background_color') ?>" name="<?php echo $this->get_field_name('icon_background_color') ?>" value="<?php echo esc_attr($instance['icon_background_color']) ?>" />
			<span class="description"><?php _e('A hex color', 'vantage'); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('image') ?>"><?php _e('Circle Background Image URL', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('image') ?>" name="<?php echo $this->get_field_name('image') ?>" value="<?php echo esc_attr($instance['image']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('icon_position') ?>"><?php _e('Icon Position', 'vantage') ?></label>
			<select id="<?php echo $this->get_field_id('icon_position') ?>" name="<?php echo $this->get_field_name('icon_position') ?>">
				<option value="top" <?php selected('top', $instance['icon_position']) ?>><?php esc_html_e('Top', 'vantage') ?></option>
				<option value="bottom" <?php selected('bottom', $instance['icon_position']) ?>><?php esc_html_e('Bottom', 'vantage') ?></option>
				<option value="left" <?php selected('left', $instance['icon_position']) ?>><?php esc_html_e('Left', 'vantage') ?></option>
				<option value="right" <?php selected('right', $instance['icon_position']) ?>><?php esc_html_e('Right', 'vantage') ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('icon_size') ?>"><?php _e('Icon Size', 'vantage') ?></label>
			<select id="<?php echo $this->get_field_id('icon_size') ?>" name="<?php echo $this->get_field_name('icon_size') ?>">
				<option value="small" <?php selected('small', $instance['icon_size']) ?>><?php esc_html_e('Small', 'vantage') ?></option>
				<option value="medium" <?php selected('medium', $instance['icon_size']) ?>><?php esc_html_e('Medium', 'vantage') ?></option>
				<option value="large" <?php selected('large', $instance['icon_size']) ?>><?php esc_html_e('Large', 'vantage') ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('more') ?>"><?php _e('More Text', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('more') ?>" name="<?php echo $this->get_field_name('more') ?>" value="<?php echo esc_attr($instance['more']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('more_url') ?>"><?php _e('More URL', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('more_url') ?>" name="<?php echo $this->get_field_name('more_url') ?>" value="<?php echo esc_attr($instance['more_url']) ?>" />
		</p>
        <p>
            <label for="<?php echo $this->get_field_id('all_linkable') ?>">
                <input type="checkbox" id="<?php echo $this->get_field_id('all_linkable') ?>" name="<?php echo $this->get_field_name('all_linkable') ?>" <?php checked( $instance['all_linkable'] ) ?> />
                <?php _e('Link title and icon to "More URL"', 'vantage') ?>
            </label>
        </p>
		<!--
		<p>
			<label for="<?php echo $this->get_field_id('box') ?>">
				<input type="checkbox" id="<?php echo $this->get_field_id('box') ?>" name="<?php echo $this->get_field_name('box') ?>" <?php checked($instance['box']) ?> />
				<?php _e('Show Box Container', 'vantage') ?>
			</label>
		</p>
		-->
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$new_instance['box'] = !empty($new_instance['box']);
		$new_instance['all_linkable'] = !empty($new_instance['all_linkable']);
		return $new_instance;
	}
}


//MIO WIDGET

class Vantage_Heavens_Widget extends WP_Widget{
	public function __construct(){
		parent::__construct(
			'Heavens_Widget', 
			__('Heavens Above Widget', 'vantage'), 
			array('description' => __( 'Wigdet per inserire i temi di Heavens Above', 'vantage' ), ) 
		); 
	}

	public function widget( $args, $instance ){
		echo $args['before_widget'];

		?>
		<h4 class="widget-title"><?php echo esc_html($instance['headline']) ?></h4>
		<img src="<?php echo esc_html($instance['linkimg'])?>" alt="<?php echo esc_html($instance['headline']) ?>" width="200" height="200">
		<p style="margin-bottom: 0px"><?php echo wp_kses_post($instance['sub_headline']) ?></p>	
		<?php
		
		echo $args['after_widget'];


	}
	public function form( $instance ) {
		$instance = wp_parse_args( $instance, array(
			'headline' => '',
			'linkimg'  => '',
			'sub_headline' => '',
		) );

		?>
		<p>
			<label for="<?php echo $this->get_field_id('headline') ?>"><?php _e('Headline', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('headline') ?>" name="<?php echo $this->get_field_name('headline') ?>" value="<?php echo esc_attr($instance['headline']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('linkimg') ?>"><?php _e('Image Link', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('linkimg') ?>" name="<?php echo $this->get_field_name('linkimg') ?>" value="<?php echo esc_attr($instance['linkimg']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('sub_headline') ?>"><?php _e('Sub Headline', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('sub_headline') ?>" name="<?php echo $this->get_field_name('sub_headline') ?>" value="<?php echo esc_attr($instance['sub_headline']) ?>" />
		</p>
		<?php
	}



}

//****************************************************


class Vantage_HR_Wigdet extends WP_Widget {
	public function __construct(){
		parent::__construct(
			'line-widge',
			__('Vantage HR', 'vantage'),
			array('description' => __('Una linea orizzontale.', 'vantage'), )
		);
	}
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
			
		?>
		<hr align="center" size="1" width="<?php echo esc_html($instance['percent']) ?>" color="<?php echo esc_html($instance['color']) ?>"   >
		<?php

		echo $args['after_widget'];
	}
 
	public function form( $instance ) {
		$instance = wp_parse_args( $instance, array(
			'percent' => '',
			'color' => '',
		) );

		?>
		<p>
			<label for="<?php echo $this->get_field_id('percent') ?>"><?php _e('Percentuale', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('percent') ?>" name="<?php echo $this->get_field_name('percent') ?>" value="<?php echo esc_attr($instance['percent']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('color') ?>"><?php _e('Color in HEX', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('color') ?>" name="<?php echo $this->get_field_name('color') ?>" value="<?php echo esc_attr($instance['color']) ?>" />
		</p>
		<?php
	}
 
}




class Vantage_Headline_Widget extends WP_Widget {
	public function __construct() {
		// widget actual processes
		parent::__construct(
			'headline-widget', // Base ID
			__('Vantage Headline', 'vantage'), // Name
			array( 'description' => __( 'A lovely big headline.', 'vantage' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		?>
		<h1><?php echo esc_html($instance['headline']) ?></h1>
		<div class="decoration"><div class="decoration-inside"></div></div>
		<h3><?php echo wp_kses_post($instance['sub_headline']) ?></h3>
		<?php

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$instance = wp_parse_args( $instance, array(
			'headline' => '',
			'sub_headline' => '',
		) );

		?>
		<p>
			<label for="<?php echo $this->get_field_id('headline') ?>"><?php _e('Headline', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('headline') ?>" name="<?php echo $this->get_field_name('headline') ?>" value="<?php echo esc_attr($instance['headline']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('sub_headline') ?>"><?php _e('Sub Headline', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('sub_headline') ?>" name="<?php echo $this->get_field_name('sub_headline') ?>" value="<?php echo esc_attr($instance['sub_headline']) ?>" />
		</p>
		<?php
	}
}

/**
 * A widget for display social media networks
 *
 * Class Vantage_Social_Media_Widget
 */
class Vantage_Social_Media_Widget extends WP_Widget{

	private $networks;

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'vantage-social-media',
			__('Vantage Social Media', 'vantage'),
			array(
				'description' => __( 'Add nice little icons that link out to your social media profiles.', 'vantage' )
			)
		);

		$this->networks = apply_filters('vantage_social_widget_networks', array(
			'facebook' => __('Facebook', 'vantage'),
			'twitter' => __('Twitter', 'vantage'),
			'google-plus' => __('Google Plus', 'vantage'),
			'github' => __('GitHub','vantage'),
			'rss' => __('RSS', 'vantage'),
		));
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget
		echo $args['before_widget'];

		if(!empty($instance['title'])) {
			echo $args['before_title'].$instance['title'].$args['after_title'];
		}

		foreach($this->networks as $id => $name) {
			if(!empty($instance[$id])) {
				?><a class="social-media-icon social-media-icon-<?php echo $id ?> social-media-icon-<?php echo esc_attr($instance['size']) ?>" href="<?php echo esc_url( $instance[$id], array('http', 'https', 'mailto', 'skype') ) ?>" title="<?php echo esc_html( get_bloginfo('name') . ' ' . $name ) ?>" <?php if(!empty($instance['new_window'])) echo 'target="_blank"'; ?>><?php

				$icon = apply_filters('vantage_social_widget_icon_'.$id, '');
				if(!empty($icon)) echo $icon;
				else echo '<span class="fa fa-' . $id . '"></span>';

				?></a><?php
			}
		}

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$instance = wp_parse_args($instance, array(
			'size' => 'medium',
			'title' => '',
			'new_window' => false,
		) );

		$sizes = apply_filters('vantage_social_widget_sizes', array(
			'medium' => __('Medium', 'vantage'),
		));

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title') ?>"><?php _e('Title', 'vantage') ?></label><br/>
			<input type="text" name="<?php echo $this->get_field_name('title') ?>" id="<?php echo $this->get_field_id('title') ?>" value="<?php echo esc_attr($instance['title']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('size') ?>"><?php _e('Icon Size', 'vantage') ?></label><br/>
			<select id="<?php echo $this->get_field_id('size') ?>" name="<?php echo $this->get_field_name('size') ?>">
				<?php foreach($sizes as $id => $name) : ?>
					<option value="<?php echo esc_attr($id) ?>" <?php selected($instance['size'], $id) ?>><?php echo esc_html($name) ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<?php

		foreach($this->networks as $id => $name) {
			?>
			<p>
				<label for="<?php echo $this->get_field_id($id) ?>"><?php echo $name ?></label>
				<input type="text" id="<?php echo $this->get_field_id($id) ?>" name="<?php echo $this->get_field_name($id) ?>" value="<?php echo esc_attr(!empty($instance[$id]) ? $instance[$id] : '') ?>" class="widefat"/>
			</p>
		<?php
		}

		?>
		<p>
			<input type="checkbox" name="<?php echo $this->get_field_name('new_window') ?>" id="<?php echo $this->get_field_id('new_window') ?>" <?php checked($instance['new_window']) ?> />
			<label for="<?php echo $this->get_field_id('new_window') ?>"><?php _e('Open in New Window', 'vantage') ?></label>

		</p>
		<?php

		#if(!defined('SITEORIGIN_IS_PREMIUM')) {
		/*	?>
		#	<p style="background: #cbe385; padding: 8px;">
		#		<?php printf(__('Get additional social and professional network icons and sizes in <a href="%s" target="_blank">Vantage Premium</a>.', 'vantage'), admin_url('themes.php?page=premium_upgrade')) ?>
		#	</p>
		<?php*/
		#}
	}

	public function update( $new_instance, $old_instance ) {
		$new_instance['new_window'] = !empty($new_instance['new_window']);
		return $new_instance;
	}
}


class Vantage_Page_EOM extends WP_Widget {
	public function __construct(){
		parent::__construct('page_EOM', __('Cielo del Mese', 'vantage'), array('description'=> __( 'Widget per il cielo del mese.', 'vantage')) );
	}
	public function widget($args, $instance){
		echo $args['before_widget'];
		setlocale(LC_TIME, 'ita', 'it_IT.utf8');
		$mia_data = strftime("%B %Y");
		$DATA_MPC = getdate();
		$giorno = $DATA_MPC['mday'];
		$mese = $DATA_MPC['mon'];
		$anno = $DATA_MPC['year'];

?>
		<h1> Situazione del cielo di <font color="red"><strong> <?php echo $mia_data    ?> </strong></font> </h1>

	<form method="POST" action="http://scully.cfa.harvard.edu/cgi-bin/mpeph.cgi" target="_NEW">
<pre>
Asteroidi per il mese di: <strong> <?php echo $mia_data    ?> </strong>


Minor Planet Code       : C24 - Seveso
Ultimo Aggiornamento    : 2015/1/9

<strong>ATTENZIONE:</strong>Alcuni oggetti potrebbero 
aver cambiato designazione durante il
mese non essendo piu` disponibili.
</pre>


<table class="rwd-table">
		<tbody>
			<tr>
				<th>Oggetto</th>
				<th>V</th>
				<th>Elong.</th>
				<th>TIPO</th>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15M53W">2015 MW53</td>
				<td data-th="V">17.8</td>
				<td data-th="Elong.">122.4E</td>
				<td data-th="TIPO">NEA</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15S02V">2015 SV2</td>
				<td data-th="V">17.5</td>
				<td data-th="Elong.">161.5W</td>
				<td data-th="TIPO">NEA</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15TH9B">2015 TB179</td>
				<td data-th="V">18.2</td>
				<td data-th="Elong.">171.7W</td>
				<td data-th="TIPO">NEA</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15TN7L">2015 TL237</td>
				<td data-th="V">18.5</td>
				<td data-th="Elong.">169.0E</td>
				<td data-th="TIPO">NEA</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15U52T">2015 UT52</td>
				<td data-th="V">18.9</td>
				<td data-th="Elong.">166.4E</td>
				<td data-th="TIPO">NEA</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15W09H">2015 WH9</td>
				<td data-th="V">18.4</td>
				<td data-th="Elong.">159.5W</td>
				<td data-th="TIPO">NEA</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15XQ1N">2015 XN261</td>
				<td data-th="V">18.4</td>
				<td data-th="Elong.">94.9E</td>
				<td data-th="TIPO">NEA</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15XQ1W">2015 XW261</td>
				<td data-th="V">18.8</td>
				<td data-th="Elong.">166.9E</td>
				<td data-th="TIPO">NEA</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15X8U">2015 XU378</td>
				<td data-th="V">18.1</td>
				<td data-th="Elong.">111.8W</td>
				<td data-th="TIPO">NEA</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15Y01B">2015 YB1</td>
				<td data-th="V">18.4</td>
				<td data-th="Elong.">144.8W</td>
				<td data-th="TIPO">NEA</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15Y02D">2015 YD2</td>
				<td data-th="V">19.0</td>
				<td data-th="Elong.">132.1E</td>
				<td data-th="TIPO">NEA</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15Q09S">2015 QS9</td>
				<td data-th="V">18.9</td>
				<td data-th="Elong.">171.3W</td>
				<td data-th="TIPO">Mars</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15Q09U">2015 QU9</td>
				<td data-th="V">17.3</td>
				<td data-th="Elong.">153.6E</td>
				<td data-th="TIPO">Mars</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15T24J">2015 TJ24</td>
				<td data-th="V">18.9</td>
				<td data-th="Elong.">159.5W</td>
				<td data-th="TIPO">Main</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15TN6T">2015 TT236</td>
				<td data-th="V">18.5</td>
				<td data-th="Elong.">135.1W</td>
				<td data-th="TIPO">Mars</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15X01A">2015 XA1</td>
				<td data-th="V">18.8</td>
				<td data-th="Elong.">143.8W</td>
				<td data-th="TIPO">Main</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15XG8J">2015 XJ168</td>
				<td data-th="V">18.8</td>
				<td data-th="Elong.">131.4E</td>
				<td data-th="TIPO">Main</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15XQ1U">2015 XU261</td>
				<td data-th="V">18.7</td>
				<td data-th="Elong.">144.7E</td>
				<td data-th="TIPO">Mars</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15X7R">2015 XR377</td>
				<td data-th="V">18.9</td>
				<td data-th="Elong.">173.3E</td>
				<td data-th="TIPO">Mars</td>
			</tr>
                       <tr>
				<td data-th="Oggetto"><input type="checkbox" name="Obj" value="K15Y01G">2015 YG1</td>
				<td data-th="V">17.6</td>
				<td data-th="Elong.">93.2W</td>
				<td data-th="TIPO">Main</td>
			</tr>
		</tbody>
</table>
<center><input type="submit" value=" Genera Effemeride "> <input type="reset" value=" Resetta i valori "><p></p></center>
<p></p><hr><p>
 </p><center>
 Options:
 <p>By default, ephemerides are referred to MPC C24
 </p><p>Start date for ephemerides: <input name="d" maxlength="20" size="17" value="<?php echo "$anno $mese $giorno"?>">  Number of dates to output <input name="l" maxlength="4" size="4" value="36">
 </p><p>Ephemeris interval: <input name="i" maxlength="3" size="3" value="1">  Ephemeris
 units: <input type="radio" name="u" value="d"> days  <input type="radio" name="u" value="h" checked=""> hours  <input type="radio" name="u" value="m"> minutes  <input type="radio" name="u" value="s"> seconds
 </p><p><a href="http://cfa-www.harvard.edu/iau/lists/ObsCodes.html">Observatory code</a>: <input name="c" maxlength="3" size="3" value="C24">
 </p><p>Display positions in: <input type="radio" name="raty" value="h">truncated sexagesimal or
 <input type="radio" name="raty" value="a" checked=""> full sexagesimal or
 <input type="radio" name="raty" value="d"> decimal units
 </p><p>Display motions as: <input type="radio" name="m" value="s"> "/sec  <input type="radio" name="m" value="m" checked=""> "/min  <input type="radio" name="m" value="h"> "/hr  <input type="radio" name="m" value="d"> °/day
 </p><p><input type="radio" name="s" value="t" checked=""> Total motion and direction
   <input type="radio" name="s" value="s"> Separate R.A. and Decl. sky motions
     <input type="radio" name="s" value="c"> Separate R.A. and Decl. coordinate motions
     </p><p><input type="checkbox" name="igd" value="y" checked=""> Suppress output if sun above local horizon
     </p><p><input type="checkbox" name="ibh" value="y" checked=""> Suppress output if object below local horizon
     </p><p><input type="checkbox" name="fp" value="y"> Generate perturbed ephemerides for unperturbed orbits
     </p><p>Also display elements for epoch <input name="oed" maxlength="20" size="17" value="">
     </p><p><a href="#formats">Format</a> for elements output:
     </p><p>
     <table border="0" cellpadding="5" cellspacing="0" width="100%">
     <tbody><tr>
     <td width="33%"><input type="radio" name="e" value="-2"> none</td>
     <td width="33%"><input type="radio" name="e" value="-1"> MPC 1-line</td>
     <td width="33%"><input type="radio" name="e" value="0" checked=""> MPC 8-line</td>
     </tr><tr><td width="33%"><input type="radio" name="e" value="1"> SkyMap (SkyMap Software)</td><td width="33%"><input type="radio" name="e" value="2"> Guide (Project Pluto)</td><td width="33%"><input type="radio" name="e" value="12"> MegaStar V4.x (E.L.B. Software)</td></tr><tr><td width="33%"><input type="radio" name="e" value="6"> TheSky (Software Bisque)</td>
     </tr>
     </tbody></table>
      </p></center>
      <p>
      If you select 8-line MPC format, you may display the residual block for the objects selected:
      </p><p>
      <input type="checkbox" name="res" value="y"> Show residuals blocks.Show only residual lines containing observations from code <input type="input" name="resoc" size="3" maxlength="3" value="">.
      <input type="hidden" name="adir" value="S" if="" you="" select="" 8-line="" mpc="" format="" the="" elements="" will="" be="" displayed="" with="" ephemerides.="" any="" other="" than="" format,="" only="" are="" returned.="" in="" such="" cases="" your="" browser="" should="" download="" file="" and="" save="" it="" to="" local="" disk.="" <p="">
      </p><center><input type="submit" value=" Get ephemerides/orbits "> <input type="reset" value=" Reset form "><p></p></center>
      <p></p><hr><p></p></form>
<?php
		
	}
}


/**
 * Register the Vantage specific widgets.
 */
function vantage_register_widgets(){
	register_widget('Vantage_Social_Media_Widget');
	register_widget('Vantage_CircleIcon_Widget');
	register_widget('Vantage_Headline_Widget');
	register_widget('Vantage_Heavens_Widget');
	register_widget('Vantage_HR_Wigdet');
	register_widget('Vantage_Page_EOM');
}
add_action( 'widgets_init', 'vantage_register_widgets');

/**
 * Filter the carousel loop title to add navigation controls.
 */
function vantage_filter_carousel_loop($title, $instance = array(), $id = false){
	if($id == 'siteorigin-panels-postloop' && isset($instance['template']) && $instance['template'] == 'loops/loop-carousel.php') {
		$new_title = '<span class="vantage-carousel-title"><span class="vantage-carousel-title-text">'. $title . '</span>';
		$new_title .= '<a href="#" class="next" title="' . esc_attr( __('Next', 'vantage') ) . '"><span class="vantage-icon-arrow-right"></span></a>';
		$new_title .= '<a href="#" class="previous" title="' . esc_attr( __('Previous', 'vantage') ) . '"><span class="vantage-icon-arrow-left"></span></a>';
		$new_title .= '</span>';
		$title = $new_title;
	}
	return $title;
}
add_filter('widget_title', 'vantage_filter_carousel_loop', 10, 3);

/**
 * Handle ajax requests for the carousel.
 */
function vantage_carousel_ajax_handler(){
	if(empty($_GET['query'])) return;

	$query = $_GET['query'];
	$query['paged'] = $_GET['paged'];
	$query['post_status'] = 'publish';

	$query = new WP_Query($query);

	ob_start();
	?>
	<div class="vantage-carousel-wrapper">

		<?php $vars = vantage_get_query_variables(); ?>

		<ul class="vantage-carousel" data-query="<?php echo esc_attr(json_encode( $vars )) ?>" data-ajax-url="<?php echo esc_url( admin_url('admin-ajax.php') ) ?>">
			<?php while( $query->have_posts() ) : $query->the_post(); ?>
				<li class="carousel-entry">
					<div class="thumbnail">
						<?php if( has_post_thumbnail() ) : $img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'vantage-carousel'); ?>
							<a href="<?php the_permalink() ?>" style="background-image: url(<?php echo esc_url($img[0]) ?>)">
								<span class="overlay"></span>
							</a>
						<?php else : ?>
							<a href="<?php the_permalink() ?>" class="default-thumbnail"><span class="overlay"></span></a>
						<?php endif; ?>
					</div>
					<?php
					$title = get_the_title();
					if( empty( $title ) ) {
						$title = _e( 'Post ', 'vantage' ) . get_the_ID();
					} ?>
					<h3><a href="<?php the_permalink() ?>"><?php echo $title ?></a></h3>
				</li>
			<?php endwhile; ?>
		</ul>
	</div>
	<?php

	// Reset everything
	wp_reset_postdata();

	header('content-type:application/json');
	echo json_encode( array(
		'html' => ob_get_clean(),
		'count' => $query->post_count,
	) );

	exit();
}
add_action('wp_ajax_vantage_carousel_load', 'vantage_carousel_ajax_handler');
add_action('wp_ajax_nopriv_vantage_carousel_load', 'vantage_carousel_ajax_handler');
