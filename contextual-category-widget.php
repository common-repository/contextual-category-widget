<?php
/*
Plugin Name: Contextual Category Widget
Plugin URI: https://github.com/artetecha.com
Description: A WordPress widget showing the description of the first category in the single post currently being displayed.
Version: 0.6.1
Author: Vincenzo Russo
Author URI: https://artetecha.com
License: GPL2
*/

/*  Copyright 2019  Vincenzo Russo  (email : v@artetecha.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Contextual_Category_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'contextual_category_widget', // Base ID
            'Contextual Category Widget', // Name
            array( 'description' => 'A widget showing the description of the first category in the single post currently being displayed.', ) // Args
        );
    }

    public function widget( $args, $instance ) {

        // The widget is meant only for single articles.
        if ( !is_single() ) {
            return false;
        }

        // Get the categories.
        $cats = get_the_category();

        // We only look at the first category on the article at this stage.
        // If this has no description, we don't display the widget.
        if ( empty( $cats[0]->category_description ) ) {
            return;
        }

        echo $args['before_widget'];

        // Widget main output.
        $text = '';

        // The title of the widget is the category's name.
        $title = $cats[0]->name;
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        // Add the title to the text.
        if ( $title ) {
			$text .= $args['before_title'] . $title . $args['after_title'];
        }

        // Apply filters to the text.
        $text .= apply_filters( 'widget_text', '<p>' . $cats[0]->category_description . '</p>', $instance, $this );

?>
        <div class="textwidget">
<?php
        // Output the widget wrapped into a div with class 'textwidget'.
        // We currently think it is sensible to reuse that class, as the output
        // of this widget would be very much like that of a Text Widget.
        echo $text;
?>
        </div>
<?php
        echo $args['after_widget'];
    }
}

// Init handler.
function contextual_category_widget_init(){
    register_widget('Contextual_Category_Widget');
}

// Init widget.
add_action( 'widgets_init', 'contextual_category_widget_init');
