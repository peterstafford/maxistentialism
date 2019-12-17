<?php
/**
 * Containers: Post Meta
 *
 * @package brightbrightgreat/maxistentialism-2019
 * @author  Bright Bright Great <sayhello@brightbrightgreat.com>
 */

namespace App\Fields\Containers;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class PostMeta
{

	public function __construct()
	{
		Container::make('post_meta', 'Front Page Data')
			->where( 'post_id', '=', get_option( 'page_on_front' ) )
			->add_fields($this->frontPageFields());
		
		Container::make('post_meta', 'Podcast Information')
			->where( 'post_type', '=', 'news' )
			->add_fields($this->newsFields());
	}

	protected function frontPageFields() 
	{
		return array(

			Field::make( 'html', 'hero' )
				->set_html( '<h2>Hero Text</h2>' ),
			Field::make( 'rich_text', 'hero_body', __( 'Hero Introduction' ) ),
			Field::make( 'rich_text', 'sub_hero_snippet', __( 'Hero Secondary Copy' ) ),
			Field::make( 'html', 'hero-space' )
				->set_html( '<h1><br/></h1>' ),
				

			Field::make( 'html', 'contact_form' )
				->set_html( '<br/><h2>Contact Form Section</h2>' ),
			Field::make( 'text', 'contact_title', __( 'Contact Form Title' ) )
				->set_required(true),
			Field::make( 'rich_text', 'contact_body', __( 'Contact Form Body' ) ),
			Field::make( 'text', 'contact_success', __( 'Contact Form Success Message' ) )
				->set_help_text( 'If left blank, this will default to \'Message Sent!\' ' ),
			Field::make( 'html', 'contact_space_below' )
				->set_html( '<h1><br/></h1>' ),


			Field::make( 'complex', 'press_links', __( 'Press Links' ) )
				->set_min(1)
				->set_layout('tabbed-horizontal')
				->add_fields( 'link', array(
					Field::make( 'text', 'title', __( 'Title' ) ),
					Field::make( 'text', 'url', __( 'URL' ) ),
					Field::make( 'text', 'date', __( 'Date' ) ),
				) )
				->set_header_template( '
					<% if ( title ) { %>
						Link: <%- title %>
					<% } %>
				' ),
				Field::make( 'text', 'links_email', __( 'Press Inquiry Email' ) ),
				Field::make( 'html', 'press-space' )
					->set_html( '<h1><br/></h1>' ),



			Field::make( 'html', 'footer' )
					->set_html( '<h2>Footer</h2>' ),
			Field::make( 'image', 'm_footer_image', __( 'Mobile Footer Image' ) )
				->set_value_type( 'url' ),
			Field::make( 'image', 'd_footer_image', __( 'Desktop Footer Image' ) )
				->set_value_type( 'url' ),
		);
	}

	protected function newsFields()
	{
		return array(
			Field::make( 'text', 'feed_url', __( 'RSS Feed URL' ) ),
		);
	}

}
