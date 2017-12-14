<?php

class AUSteve_Heisenberg_Customizer {

	function __construct() {

		add_action( 'customize_register', array($this, 'add_customizer_sections') );

		add_action( 'customize_register', array($this, 'add_customizer_background_and_layout_settings') );

		add_action( 'customize_register', array($this, 'add_customizer_homepage_section_settings') );

		add_action( 'customize_preview_init', array($this, 'customizer_live_css_preview') );

		add_action( 'wp_head', array($this, 'add_custom_css_to_head') );
	}

	function add_customizer_background_and_layout_settings() {
		global $wp_customize;

		$wp_customize->add_setting( 'austeve_background_fixed' );
		$wp_customize->add_setting( 'austeve_backgrounds' );
		$wp_customize->add_setting( 'austeve_menu_layout' );

	   	//Background fixed/scrolling
	   	$wp_customize->add_control(
		    new WP_Customize_Dropdown_Control(
		        $wp_customize,
		        'austeve_background_fixed',
		        array(
					'label' 	=> __( 'Fixed/Scrolling?', 'heisenberg' ),
					'description' => __( 'Should the background image be fixed, or scroll with the content (Image #1 will be repeated vertically)', 'heisenberg' ),
					'section' 	=> 'austeve_bg_section',
					'settings' 	=> 'austeve_background_fixed',
					'help_text'  => 'Select style',
					'choices' 	=> array(
						'fixed' 	=> 'Fixed',
						'scroll' 	=> 'Scrolling',
					)
		        )
		    )
		);

	   	//Display page background(s) for homepage only
	   	$wp_customize->add_setting( 'austeve_background_homeonly' );
	   	$wp_customize->add_control( 
	   		'austeve_background_homeonly', 
			array(
				'label'    => __( 'Display background image for homepage only', 'heisenberg' ),
				'section'  => 'austeve_bg_section',
				'settings' => 'austeve_background_homeonly',
				'type'     => 'checkbox',
			)
		);

	   	//Display individual page background(s) for pages that have featured images set
	   	$wp_customize->add_setting( 'austeve_background_page_featuredimage' );
	   	$wp_customize->add_control( 
	   		'austeve_background_page_featuredimage', 
			array(
				'label'    => __( 'Display featured images as the background for pages', 'heisenberg' ),
				'section'  => 'austeve_bg_section',
				'settings' => 'austeve_background_page_featuredimage',
				'type'     => 'checkbox',
			)
		);

		//Backgrounds
		$wp_customize->add_control( 
	   		'austeve_backgrounds', 
			array(
				'label'    => __( 'Number of background images', 'heisenberg' ),
				'section'  => 'austeve_bg_section',
				'settings' => 'austeve_backgrounds',
				'type'     => 'text',
			)
		);

		$backgrounds = get_theme_mod('austeve_backgrounds', 0);

		for ($b = 0; $b < $backgrounds; $b++) {

	   		$wp_customize->add_setting( 'austeve_background_image_'.($b+1) );
	   		$wp_customize->add_setting( 'austeve_background_opacity_'.($b+1) );

			//Background Image
		   	$wp_customize->add_control( 
		   		new WP_Customize_Image_Control( 
		   			$wp_customize, 
		   			'austeve_background_image_'.($b+1), 
		   			array(
					    'label'    => __( 'Image #'.($b+1).':', 'heisenberg' ),
					    'section'  => 'austeve_bg_section',
					    'settings' => 'austeve_background_image_'.($b+1),
					) 
				) 
			);

		   	//Background opacity
		   	$wp_customize->add_control( 
		   		'austeve_background_opacity_'.($b+1), 
				array(
					'label'    => __( '#'.($b+1).' opacity', 'heisenberg' ),
					'section'  => 'austeve_bg_section',
					'settings' => 'austeve_background_opacity_'.($b+1),
					'type'     => 'text',
				)
			);

		}

	   	//Background colour of content on pages that aren't the home page
	   	$wp_customize->add_setting( 'austeve_pagecontent_bg_color' );
	   	$wp_customize->add_control( 
			new WP_Customize_Color_Control( 
				$wp_customize, 
				'austeve_pagecontent_bg_color', 
				array(
					'label'      => __( 'Regular page background colour:', 'heisenberg' ),
					'description'      => __( 'Background colour of pages that aren\'t the home page', 'heisenberg' ),
					'section'    => 'austeve_bg_section',
					'settings'   => 'austeve_pagecontent_bg_color',
				) 
			) 
		);

	   	//Menu layouts
	   	$wp_customize->add_control(
		    new WP_Customize_Dropdown_Control(
		        $wp_customize,
		        'austeve_menu_layout',
		        array(
					'label' 	=> __( 'Layout', 'heisenberg' ),
					'section' 	=> 'austeve_menu_section',
					'settings' 	=> 'austeve_menu_layout',
					'help_text'  => 'Select menu layout...',
					'choices' 	=> array(
						'topbar-right' 	=> 'Top-bar Right',
						'centered-single' 	=> 'Centered Single Menu',
						'centered-single-above' 	=> 'Centered above logo',
						'none' 	=> 'None',
					)
		        )
		    )
		);
	}

	function add_customizer_homepage_section_settings() {
		global $wp_customize;

		$wp_customize->add_setting( 'austeve_general_sections' );
		$wp_customize->add_setting( 'austeve_general_section_height' );
		$wp_customize->add_setting( 'austeve_general_section_scroll' );

		//Front page content sections
		$wp_customize->add_control( 
	   		'austeve_general_sections', 
			array(
				'label'    => __( 'Number of content sections', 'heisenberg' ),
				'section'  => 'static_front_page',
				'settings' => 'austeve_general_sections',
				'type'     => 'text',
			)
		);

		//Front page content section height
		$wp_customize->add_control( 
	   		'austeve_general_section_height', 
			array(
				'label'    => __( 'Set minimum height of each section to window height', 'heisenberg' ),
				'section'  => 'static_front_page',
				'settings' => 'austeve_general_section_height',
				'type'     => 'checkbox',
			)
		);

		//Front page scrolling from section to section
		$wp_customize->add_control( 
	   		'austeve_general_section_scroll', 
			array(
				'label'    => __( 'Smoothly scroll from section to section. Best used in conjunction with the minimum height setting.', 'heisenberg' ),
				'section'  => 'static_front_page',
				'settings' => 'austeve_general_section_scroll',
				'type'     => 'checkbox',
			)
		);

		$sections = get_theme_mod('austeve_general_sections', 0);

		for ($s = 0; $s < $sections; $s++) {
			
			//Get section name
			$sectionName = get_theme_mod('austeve_content_'.$s.'_name', null);
			if (!$sectionName)
			{
				$sectionName = '#'.($s+1);
			}

			//Add a section
			$wp_customize->add_section( 'austeve_content_section_'.$s , array(
			    'title'       => __( 'Section: '.$sectionName, 'heisenberg' ),
			    'priority'    => 200,
			) );

			//Add settings
	   		$wp_customize->add_setting( 'austeve_content_'.$s.'_name' );
	   		$wp_customize->add_setting( 'austeve_content_'.$s.'_spacing' );
	   		$wp_customize->add_setting( 'austeve_content_'.$s.'_style' );
	   		$wp_customize->add_setting( 'austeve_content_'.$s.'_page' );
	   		$wp_customize->add_setting( 'austeve_content_'.$s.'_sidebar' );
	   		$wp_customize->add_setting( 'austeve_content_'.$s.'_bgImage' );
	   		$wp_customize->add_setting( 'austeve_content_'.$s.'_bgColour' );
	   		$wp_customize->add_setting( 'austeve_content_'.$s.'_bgOpacity' );
	   		$wp_customize->add_setting( 'austeve_content_'.$s.'_bgForSmall', 
	   			array (
					'default'  => true
				) 
	   		);

	   		//Section ID control
			$wp_customize->add_control( 
		   		'austeve_content_'.$s.'_name', 
				array(
					'label'    => __( 'Section Name', 'heisenberg' ),
					'section'  => 'austeve_content_section_'.$s,
					'settings' => 'austeve_content_'.$s.'_name',
					'type'     => 'text',
				)
			);

		   	//Add a top-level control
		   	$wp_customize->add_control(
			    new WP_Customize_ContentStyle_Control(
			        $wp_customize,
			        'austeve_content_'.$s.'_style',
			        array(
						'label' 	=> __( 'Content', 'heisenberg' ),
						'section' 	=> 'austeve_content_section_'.$s,
						'settings' 	=> 'austeve_content_'.$s.'_style',
						'choices' 	=> array(
							'none' 	=> 'No content (spacing only)',
							'page' 		=> 'Page',
							'sidebar' 	=> 'Sidebar',
						),
						'content_section' => $s,
			        )
			    )
			);

			$section_style = get_theme_mod('austeve_content_'.$s.'_style');

			//Add a page selector control
		   	$wp_customize->add_control(
			    new WP_Customize_Page_Control(
			        $wp_customize,
			        'austeve_content_'.$s.'_page',
			        array(
						'label' 	=> __( 'Page', 'heisenberg' ),
						'section' 	=> 'austeve_content_section_'.$s,
						'settings' 	=> 'austeve_content_'.$s.'_page',
						'content_section' => $s,
			        )
			    )
			);

			//Add a sidebar selector control
		   	$wp_customize->add_control(
			    new WP_Customize_Sidebar_Control(
			        $wp_customize,
			        'austeve_content_'.$s.'_sidebar',
			        array(
						'label' 	=> __( 'Sidebar', 'heisenberg' ),
						'section' 	=> 'austeve_content_section_'.$s,
						'settings' 	=> 'austeve_content_'.$s.'_sidebar',
						'description' 	=> __('Ensure your sidebar is populated with at least one widget first', 'heisenberg' ),
						'content_section' => $s,
			        )
			    )
			);

			//Section background image
		   	$wp_customize->add_control( 
		   		new WP_Customize_Image_Control( 
		   			$wp_customize, 
		   			'austeve_content_'.$s.'_bgImage', 
		   			array(
					    'label'    => __( 'Background image:', 'heisenberg' ),
					    'section'  => 'austeve_content_section_'.$s,
					    'settings' => 'austeve_content_'.$s.'_bgImage',
					) 
				) 
			);

		   	//Section background colour
		   	$wp_customize->add_control( 
				new WP_Customize_Color_Control( 
					$wp_customize, 
					'austeve_content_'.$s.'_bgColour', 
					array(
						'label'      => __( 'Background colour:', 'heisenberg' ),
						'section'    => 'austeve_content_section_'.$s,
						'settings'   => 'austeve_content_'.$s.'_bgColour',
					) 
				) 
			);

		   	//Section background opacity
		   	$wp_customize->add_control( 
		   		'austeve_content_'.$s.'_bgOpacity', 
				array(
					'label'    => __( 'Background opacity', 'heisenberg' ),
					'section'  => 'austeve_content_section_'.$s,
					'settings' => 'austeve_content_'.$s.'_bgOpacity',
					'type'     => 'text',
				)
			);

		   	//Section background image for small screens
		   	$wp_customize->add_control( 
		   		'austeve_content_'.$s.'_bgForSmall', 
				array(
					'label'    => __( 'Display background image for small screens', 'heisenberg' ),
					'section'  => 'austeve_content_section_'.$s,
					'settings' => 'austeve_content_'.$s.'_bgForSmall',
					'type'     => 'checkbox',
				)
			);

		   	//Section spacing customized
		   	$wp_customize->add_control( 
		   		'austeve_content_'.$s.'_spacing', 
				array(
					'label'    => __( 'Custom spacing', 'heisenberg' ),
					'description'    => __( 'Percentage of spacing to be placed at the top of the content container. Used if the \'space content\' setting is true', 'heisenberg' ),
					'section'  => 'austeve_content_section_'.$s,
					'settings' => 'austeve_content_'.$s.'_spacing',
					'type'     => 'text',
				)
			);
		}
	}

	function add_customizer_sections() {

		global $wp_customize;

		$wp_customize->add_section( 'austeve_bg_section' , array(
			'title'       => __( 'Background', 'heisenberg' ),
			'priority'    => 30,
			'description' => 'Upload a background image',
		) );

		$wp_customize->add_section( 'austeve_fonts_colours' , array(
			'title'      	=> __('Fonts & Colours','heisenberg'),
			'description'	=> __('Font & colour customizations.','heisenberg'),
			'priority'   	=> 30,
		) );
	}

	function add_custom_css_to_head() {	
	    ?>
	        <style type="text/css">
				
				<?php if (get_theme_mod('austeve_pagecontent_bg_color')) : ?>
	        	.content-area:not(.index) {
				    background: <?php echo get_theme_mod('austeve_pagecontent_bg_color', 'transparent'); ?>;
				    padding: 2rem;
				}
				<?php endif; ?>

	            <?php

	            $backgrounds = get_theme_mod('austeve_backgrounds', 0);

				for ($b = 0; $b < $backgrounds; $b++) {
					echo "#bgImage".($b+1)." {";
					echo "background-image: url(".get_theme_mod('austeve_background_image_'.($b+1), '').");";
					echo "opacity: ".get_theme_mod('austeve_background_opacity_'.($b+1), '1.0').";";
	            	echo "}";
				}
	            
				$sections = get_theme_mod('austeve_general_sections', 0);

				for ($s = 0; $s < $sections; $s++) {

	            	echo ".section-".$s." .content-background-div { ";
	            	echo "    background-color: ".get_theme_mod('austeve_content_'.$s.'_bgColour', '').";";
	            	echo "    opacity: ".get_theme_mod('austeve_content_'.$s.'_bgOpacity', '1.0').";";
	            	echo "    transform: translate3d(0, 0, 0);"; /* Required for the background to display in the right plane on Safari */
	            	echo "}";

	            	echo ".section-".$s." .content-background-image { ";
	            	echo "    background-image: url(".get_theme_mod('austeve_content_'.$s.'_bgImage', '').");";
	            	echo "}";
	        	}

				//Individual page backgrounds using featured image
				if (is_page() && get_theme_mod('austeve_background_page_featuredimage', false) && has_post_thumbnail())
				{
					echo ".bgImage {";
					echo "background-image: url(".get_the_post_thumbnail_url(get_the_ID(), 'full').") !important;";
					echo "}";
				}
	        	?>

	        </style>
	        
	    <?php
	}

	function customizer_live_css_preview() {
	}
}

$austeve_theme_customizations = new AUSteve_Heisenberg_Customizer();

if( class_exists( 'WP_Customize_Control' ) ):

	class WP_Customize_FoundationSize_Control extends WP_Customize_Control {
	    public $type = 'foundationsize';
		public $default_value;
	 
	    public function render_content() {
	    	$sizes = ($this->value() == '') ? $this->default_value : $this->value();
	    	$id = strtolower( esc_html( $this->label ));
	    	$id = str_replace(" ", "-", $id);

	        ?>
	        <label>
		        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	        </label>
	        <div style="text-align: right">
		        Small: <input type="text" id='<?php echo $id; ?>-small' class='<?php echo $id; ?>' value="<?php echo json_decode($sizes, true)['small']; ?>" style="width: 50%"/><br/>
		        Medium: <input type="text" id='<?php echo $id; ?>-medium' class='<?php echo $id; ?>' value="<?php echo json_decode($sizes, true)['medium']; ?>" style="width: 50%"/><br/>
		        Large: <input type="text" id='<?php echo $id; ?>-large' class='<?php echo $id; ?>' value="<?php echo json_decode($sizes, true)['large']; ?>" style="width: 50%"/>
		        <input <?php $this->link(); ?> type="hidden" id='<?php echo $id; ?>' value="<?php echo $sizes; ?>"/>
	        </div>
	        <script>
				
				jQuery( ".<?php echo $id; ?>" ).change(function() {

					var newSizesArray = {
						small: jQuery( "#<?php echo $id; ?>-small" ).attr("value"), 
						medium: jQuery( "#<?php echo $id; ?>-medium" ).attr("value"), 
						large: jQuery( "#<?php echo $id; ?>-large" ).attr("value")
					};

				  	jQuery( "#<?php echo $id; ?>" ).attr("value", JSON.stringify(newSizesArray))
					jQuery( "#<?php echo $id; ?>" ).change();
				});

			</script>

	        <?php
	    }
	}

	class WP_Customize_Textarea_Control extends WP_Customize_Control {
	    public $type = 'textarea';
		public $default_value;
	 
	    public function render_content() {
	    	$content = ($this->value() == '') ? $this->default_value : $this->value();
	        ?>
	        <label>
	        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	        <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $content ); ?></textarea>
	        </label>
	        <?php
	    }
	}

	class WP_Customize_Dropdown_Control extends WP_Customize_Control {
		public $type = 'style_radio';
		public $help_text;
 
		public function render_content() {
		?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

				<select <?php $this->link(); ?>>
					<option value="0" <?php echo selected( $this->value(), get_the_ID() )?>><?php echo $this->help_text; ?></option>
					<?php foreach ( $this->choices as $key => $value ) { 
						echo "<option " . selected( $this->value(), $key ) . " value='" . $key . "'>" . ucwords( $value ) . "</option>";
							} 
					?>
				</select>				
			</label>
		<?php
		}
	}

	class WP_Customize_ContentStyle_Control extends WP_Customize_Control {
		public $type = 'style_radio';
		public $content_section;
 
		public function render_content() {

		?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

				<select <?php $this->link(); ?>>
					<option value="0" <?php echo selected( $this->value(), get_the_ID() )?>>Select content style...</option>
					<?php foreach ( $this->choices as $key => $value ) { 
						echo "<option " . selected( $this->value(), $key ) . " value='" . $key . "'>" . $value . "</option>";
							} 
					?>
				</select>
				<script>
				
				function hideAll(s) {
					jQuery('#customize-control-austeve_content_'+s+'_page, #customize-control-austeve_content_'+s+'_sidebar' ).hide();
				}

				jQuery(function($){
					var s = '<?php echo $this->content_section; ?>';
					var v = '<?php echo $this->value(); ?>';

					hideAll(s);

					$('#customize-control-austeve_content_'+s+'_'+v ).show();
					
					$('#customize-control-austeve_content_'+s+'_style select').change(function() {
						hideAll(s);
						$('#customize-control-austeve_content_'+s+'_'+this.value ).show();

					});
				});

				</script>
			</label>
		<?php
		}
	}

	class WP_Customize_Page_Control extends WP_Customize_Control {
		public $type = 'page_dropdown';
		public $content_section;
 
		public function render_content() {

		$pages = new WP_Query( array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'orderby'     => 'title',
			'order'       => 'ASC',
			'posts_per_page' => -1
		));

		?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select <?php $this->link(); ?>>
					<option value="0" <?php echo selected( $this->value(), get_the_ID() )?>>Select page...</option>
					<?php 
					while( $pages->have_posts() ) {
						$pages->the_post();
						echo "<option " . selected( $this->value(), get_the_ID() ) . " value='" . get_the_ID() . "'>" . the_title( '', '', false ) . "</option>";
					}
					?>
				</select>
			</label>
		<?php
		}
	}

	class WP_Customize_Sidebar_Control extends WP_Customize_Control {
		public $type = 'sidebar_dropdown';
		public $content_section;
 
		public function render_content() {
		?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<select <?php $this->link(); ?>>
					<option value="0" <?php echo selected( $this->value(), get_the_ID() )?>>Select sidebar...</option>
				<?php foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { 
					echo "<option " . selected( $this->value(), ucwords($sidebar['id']) ) . " value='" . ucwords( $sidebar['id'] ) . "'>" . ucwords( $sidebar['name'] ) . "</option>";
						} 
				?>
				</select>
				
				<script>
				</script>
			</label>
		<?php
		}
	}

	class WP_Customize_Font_Control extends WP_Customize_Control {
		public $type = 'font_dropdown';
		public $content_section;
 
		public function render_content() {

			$fonts = array(
				'Helvetica Neue, Helvetica, Roboto, Arial, sans-serif'  => 'Helvetica Neue',
				'Neou Thin, Helvetica, Roboto, Arial, sans-serif' => 'Neou (thin)',
				'Neou Bold, Helvetica, Roboto, Arial, sans-serif' => 'Neou (thick)',
				'Fairfield Light, Times, Serif' => 'Fairfield Light',
				'Times New Roman, Times, Serif' => 'Times New Roman',
				'Avenir Light, Arial, sans-serif' => 'Avenir Light',
				'Cantata One, Times, serif' => 'Cantata One',
				'Roboto, Arial, sans-serif' => 'Roboto',
				'Raleway, Arial, sans-serif' => 'Raleway Black',
			);

		?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<select <?php $this->link(); ?>>
					<option value="Helvetica Neue" <?php echo selected( $this->value(), get_the_ID() )?>>Select font...</option>
				<?php foreach ( $fonts as $k => $v) { 
						echo "<option " . selected( $this->value(), $k ) . " value='" . $k . "'>" . ucwords( $v ) . "</option>";
					} 
				?>
				</select>
				
				<script>
				</script>
			</label>
		<?php
		}
	}
endif;
