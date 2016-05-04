<?php
/**
 *
 * @package phpBB Extension - tas2580 AJAX Notifications
 * @copyright (c) 2016 tas2580 (https://tas2580.net)
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace tas2580\ajaxnotification\migrations;

class initial_extension extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			// Add configs
			array('config.add', array('ajaxnotification_timeout', '10')),
		);
	}
}
