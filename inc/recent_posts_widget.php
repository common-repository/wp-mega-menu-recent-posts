<?php

class Mega_Menu_Recent_Posts extends WP_Widget {

	function __construct() {

		parent::__construct( false, $name = __( 'Mega Menu Recent Posts', 'mega-menu-recent-posts' ) );
	}

	function widget( $args, $instance ) {

		extract( $args );
		global $posttypes;
		$title          = apply_filters( 'widget_title', $instance['title'] );
		$cat            = apply_filters( 'widget_cat', $instance['cat'] );
		$number         = apply_filters( 'widget_number', $instance['number'] );
		$postsinrow     = apply_filters( 'widget_postsinrow', $instance['postsinrow'] );
		?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) {
			echo $before_title . $title . $after_title;
		} ?>
		<ul class="mega-sub-menu">
			<?php
			global $post;
			$tmp_post = $post;
			$args    = array(
				'posts_per_page' => $number,
				'post_type'      => 'post',
				'category_name'  => $cat,
				'orderby' => 'post_date',
				'order' => 'DESC',
			);

			if(!empty($postsinrow ))
				$width = 100/$postsinrow ;
			else
				$width=25;



			$all_posts = get_posts( $args );
			$size=count(($all_posts));
			if (is_array($all_posts) ) :
				$i=0;
				?>
				<?php 
				foreach ( $all_posts as $post ) : setup_postdata( $post ); ?>
				<?php 	 $thumbnail = get_the_post_thumbnail_url($post,'post-thumbnail');
					if($thumbnail){
						 ?>
				            <li class="menu_post_list set_li_<?php echo $postsinrow; ?>">
				                <div class="mega_menu_textwidget">
				                    <a class="bg-image1" style="background-image: url(<?php echo $thumbnail; ?>);" href="<?php the_permalink(); ?>">
				                        <div class="hover1">
				                        <h1><?php the_title(); ?></h1>
				                        <div class="btn1"><?php echo esc_html__('Read Story','wp-mega-menu-recent-posts'); ?></div>
				                        </div>
				                    </a>
				                </div>
				            </li>
				<?php 
				}
				$i++;
				endforeach; ?>
			<?php endif; ?>
			<?php $post = $tmp_post; ?>
		</ul>
		<?php echo $after_widget; ?>
		<?php
	}
	function update( $new_instance, $old_instance ) {
		global $posttypes;
		$instance                   = $old_instance;
		$instance['title']          = strip_tags( $new_instance['title'] );
		$instance['cat']            = strip_tags( $new_instance['cat'] );
		$instance['number']         = strip_tags( $new_instance['number'] );
		$instance['postsinrow']         = strip_tags( $new_instance['postsinrow'] );
		return $instance;
	}

	function form( $instance ) {

		$title          = esc_attr( $instance['title'] );
		$cat            = esc_attr( $instance['cat'] );
		$number         = esc_attr( $instance['number'] );
		$postsinrow     = esc_attr( $instance['postsinrow'] );
		$categories = get_categories( array(
					    'orderby' => 'name',
					    'parent'  => 0
					) );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e( 'Select Category:' ); ?></label>

			<select name="<?php echo $this->get_field_name( 'cat' ); ?>" id="<?php echo $this->get_field_id( 'cat' ); ?>" class="widefat">
				<?php
				foreach ( $categories as $option ) {
					printf('<option value="%s" id="%s" %s >%s</option>' , 
						$option->name,
						$option->name,
						($cat == $option->name) ? ' selected="selected"' : '',
						$option->name

							 ); 

					//'<option value="'.$option->name. '" id="'.$option->name.'"', $cat == $option->name ? ' selected="selected"' : '', '>', $option->name, '</option>';
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of total Posts:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr($number); ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'postsinrow' ); ?>"><?php _e( 'Number of Posts in One Row:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'postsinrow' ); ?>" name="<?php echo $this->get_field_name( 'postsinrow' ); ?>" type="text" value="<?php echo esc_attr($postsinrow); ?>"/>
		</p>
		<?php
	}

	function get_feature_promo( $desc, $url, $upgrade = "UPGRADE" ) {
		$f_desc = sanitize_text_field( htmlspecialchars( $desc ) );
		$mpro  = '<br>';
		$mpro .= '<span style="background-color:DarkGoldenRod; color:white;font-style:normal;text-weight:bold">';
		$mpro .= '&nbsp;' . $upgrade . ':&nbsp;';
		$mpro .= '</span>';
		$mpro .= '<span style="color:DarkGoldenRod;font-style:normal;">';
		$mpro .= '&nbsp;' . $f_desc . ' ';
		$mpro .= '<a target="_blank" HREF="'.esc_url($url).'">'.esc_html__('Learn more','wp-mega-menu-recent-posts') .'</a>';
		$mpro .= '</span>';
		return $mpro;
	}
} 

?>