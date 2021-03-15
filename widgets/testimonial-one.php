<?php
namespace ewebdevselements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Testimonial_One extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'testimonial-one';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Testimonial One', 'ewebdevs-elements' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'ewebdevs_elements' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'ewebdevs-elements' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'testimonial_section',
			[
				'label' => __( 'Testimonial List', 'ewebdevs-elements' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$repeater = new \Elementor\Repeater();

		//Name ==============
		$repeater->add_control(
			'name',
			[
				'name' => 'name',
				'label' => __( 'Testimonial Name', 'ewebdevs-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Testimonial Name', 'ewebdevs-elements' ),
				'default' => __( 'John Doe', 'ewebdevs-elements' ),
			]

		);
		$repeater->add_responsive_control(
			'name_color',
			[
				'label' => __( 'Color', 'ewebdevs-elements' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}'
				],
			]
		);

		//Designation ==============
		$repeater->add_control(
			'designation',
			[
				'name' => 'designation',
				'label' => __( 'Testimonial Designation', 'ewebdevs-elements' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Testimonial Designation', 'ewebdevs-elements' ),
				'default' => __( 'CEO', 'ewebdevs-elements' ),
			]

		);

		//Image ==============
		$repeater->add_control(
			'image',
			[
				'name' => 'image',
				'label' => __( 'Testimonial Image', 'ewebdevs-elements' ),
				'type' => Controls_Manager::MEDIA,
				'label_block' => true,
				'placeholder' => __( 'Testimonial Image', 'ewebdevs-elements' ),
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]

		);

		//Description ============
		$repeater->add_control(
			'details',
			[
				'name' => 'details',
				'label' => __( 'Testimonial Details', 'ewebdevs-elements' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Our approach has empowered local, national, and global brands to grow their businesses and achieve a competitive advantage  and we can do the same for you.', 'ewebdevs-elements' ),
			]
		);
		$repeater->add_responsive_control(
			'detail_color',
			[
				'label' => __( 'Color', 'ewebdevs-elements' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}'
				],
			]
		);

		//Testimonial Repeater ============
		$this->add_control(
			'testimonial_list',
			[
				'label' => __( 'Testimonial List', 'ewebdevs-elements' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'name' => __( 'Jhone Deo', 'ewebdevs-elements' ),
						'details' => __( 'Our approach has empowered local, national, and global brands to grow their businesses and achieve a competitive advantage  and we can do the same for you.', 'ewebdevs-elements' ),
					],
				],
				'title_field' => '{{{ name }}}',
			]
		);

		$this->end_controls_section();

		//Style Section ==============
		$this->start_controls_section(
			'name_section',
			[
				'label' => __( 'Name Style', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		//Name Style ==============
		$this->add_responsive_control(
			'name_color',
			[
				'label' => __( 'Color', 'ewebdevs-elements' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cm-info h3' => 'color: {{VALUE}}'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'label' => __( 'Typography', 'plugin-domain' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .cm-info h3',
			]
		);
		$this->end_controls_section();

		//Designation Style ==============
		$this->start_controls_section(
			'designation_section',
			[
				'label' => __( 'Designation Style', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		//Designation==============
		$this->add_responsive_control(
			'designation_color',
			[
				'label' => __( 'Color', 'ewebdevs-elements' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cm-info span' => 'color: {{VALUE}}'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'designation_typography',
				'label' => __( 'Typography', 'plugin-domain' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .cm-info span',
			]
		);

		$this->end_controls_section();

		//Description Style ==============
		$this->start_controls_section(
			'description_section',
			[
				'label' => __( 'Designation Style', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		//Designation==============
		$this->add_responsive_control(
			'description_color',
			[
				'label' => __( 'Color', 'ewebdevs-elements' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testi-comment p' => 'color: {{VALUE}}'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'label' => __( 'Typography', 'plugin-domain' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .testi-comment p',
			]
		);



	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		?>
            <section class="testimonial-sec">
                <div class="container">
                    <div class="testi-sec">
                        <div class="testi-carousel">
                            <?php
                                if ( $settings['testimonial_list'] ) {
                                    foreach (  $settings['testimonial_list'] as $item ) {
                                        ?>
                                        <div class="testi-slide">
                                            <div class="testi-comment">
                                                <div class="cm-head">
                                                    <div class="cm-img">
                                                        <img src="<?php echo esc_attr( $item['image']['url'] ); ?>" alt="">
                                                    </div><!--cm-img end-->
                                                    <div class="cm-info">
                                                        <h3><?php echo esc_attr( $item['name'] ); ?></h3>
                                                        <span><?php echo esc_attr( $item['designation'] ); ?></span>
                                                    </div>
                                                </div>
                                                <p><?php echo esc_attr( $item['details'] ); ?></p>
                                            </div><!--testi-comment end-->
                                        </div><!--testi-slide end-->
                                        <?php
                                    }
                                }
                            ?>
                        </div><!--testi-carousel end-->
                    </div><!--testi-sec end-->
                </div>
            </section><!--testimonial-sec end-->
		<?php

	}
}
