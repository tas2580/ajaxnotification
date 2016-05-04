<?php
/**
 *
 * @package phpBB Extension - tas2580 AJAX Notifications
 * @copyright (c) 2016 tas2580 (https://tas2580.net)
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace tas2580\ajaxnotification\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\config\config 			$config				Config object
	* @param \phpbb\controller\helper			$helper				Helper object
	* @param \phpbb\template\template		$template				Template object
	* @param \phpbb\user					$user				User object
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	public static function getSubscribedEvents()
	{
		return array(
			'core.page_header'						=> 'page_header',
			'core.acp_board_config_edit_add'			=> 'acp_board_config_edit_add',
		);
	}

	/**
	* Send AJAX URL to template
	*
	* @return null
	* @access public
	*/
	public function page_header()
	{
		$this->template->assign_vars(array(
			'U_AJAXNOTIFICATION'			=> $this->helper->route('tas2580_ajaxnotification', array()),
			'U_AJAXNOTIFICATION_TIMER'		=> $this->config['ajaxnotification_timeout'] * 1000,
		));
	}

	/**
	* Add field to acp_board load settings page
	*
	* @param	object	$event	The event object
	* @return	null
	* @access	public
	*/
	public function acp_board_config_edit_add($event)
	{
		if ($event['mode'] == 'load')
		{
			$this->user->add_lang_ext('tas2580/ajaxnotification', 'common');

			$display_vars = $event['display_vars'];
			$insert = array('ajaxnotification_timeout' => array(
				'lang'		=> 'ACP_AJAXNOTIFICATION_TIMEOUT',
				'validate'	=> 'int:0:99999',
				'type'	=> 'number:0:99999',
				'explain'	=> true,
				'append'	=> ' ' . $this->user->lang['SECONDS']
			));
			$display_vars['vars'] = $this->array_insert($display_vars['vars'], 'legend2', $insert);
			$event['display_vars'] = $display_vars;
		}
	}

	private function array_insert(&$array, $position, $insert)
	{
		if (is_int($position))
		{
			array_splice($array, $position, 0, $insert);
		}
		else
		{
			$pos   = array_search($position, array_keys($array));
			$array = array_merge(
				array_slice($array, 0, $pos),
				$insert,
				array_slice($array, $pos)
			);
		}
		return $array;
	}

}
