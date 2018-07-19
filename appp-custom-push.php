<?php
/*
Plugin Name: AppPresser Custom Push
Plugin URI: http://apppresser.com
Description: An AppPush add-on for customizing push notification sent through your myapppresser.com account
Version: 1.0.0
Author: AppPresser Team
Author URI: http://apppresser.com
License: GPLv2
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

class AppPresserCustomPush {

	const VERSION           = '1.0.0';

	public function hooks() {
		add_filter( 'ap3_send_push_data', array( $this, 'custom_push__android' ) );
		add_filter( 'ap3_send_push_data', array( $this, 'custom_push__ios' ) );
	}

	public function custom_push__ios( $data ) {
		
		if( !isset( $data['custom'] ) ) {
			$data['custom'] = array();
		}


		/**
		 * Sample:
		 * 
		 * Overwrite the title and message for iOS only.
		 * 
		 */

		$data['custom']['ios'] = array(
			'subtitle' => 'Test subtitle',
			'title' => 'ios overwrite the title',
			'alert' => 'ios overwrite the message',
		);

		$data['custom']['default_msg'] = "Overwrite iOS default message";

		return $data;
	}

	public function custom_push__android( $data ) {

		if( 
			isset( 
				$_POST,
				$_POST['send_push_notification'],
				$_POST['_thumbnail_id'],
				$_POST['ID'] 
			) 
			&& $_POST['send_push_notification'] === '1'
		  ) {
			
			$thumb_url = get_the_post_thumbnail_url( $_POST['ID'] );

			if( $thumb_url ) {

				if( !isset( $data['custom'] ) ) {
					$data['custom'] = array();
				}

				/**
				 * Sample:
				 * 
				 * Overwrite the title and message for Android only plus
				 * adds the thumbnail.
				 * 
				 */

				$data['custom']['android'] = array(
					'summaryText' => get_the_excerpt( $_POST['ID'] ),
					'title' => 'android overwrite the title',
					'message' => 'android overwrite the message',
					'style' => 'picture',
					'picture' => $thumb_url, // big image
					'image' => $thumb_url, // right side little image
					// 'image-type' => 'circle',
					// 'vibrationPattern' => array( 0, 500, 1000, 500 ), // some phones
				);
			}
		}

		return $data;
	}
}


$apppImagePush = new AppPresserCustomPush();
$apppImagePush->hooks();