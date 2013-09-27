<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package  Marksmin
 * @author   Michael Leigeber
 * @license  http://www.apache.org/licenses/LICENSE-2.0
 * @link     http://www.caddis.co
 */

class Marksmin_ext {

	public $EE;
	public $name = 'Marksmin';
	public $version = '1.1.0';
	public $description = 'Minify HTML output';
	public $docs_url = '';
	public $settings_exist = 'n';
	public $config;

	/**
	 * Constructor
	 *
	 * @param  mixed Settings array or empty string if none exist
	 * @return void
	 */
	public function __construct($settings = array())
	{
		$this->settings = $settings;
	}

	/**
	 * Activate Extension
	 * 
	 * @return void
	 */
	public function activate_extension()
	{
		ee()->db->insert('extensions',
			array(
				'class' => __CLASS__,
				'method' => 'template_post_parse',
				'hook' => 'template_post_parse',
				'settings' => '',
				'priority' => 10,
				'version' => $this->version,
				'enabled' => 'y'
			)
		);
	}

	/**
	 * Disable Extension
	 *
	 * @return void
	 */
	public function disable_extension()
	{
		ee()->db->where('class', __CLASS__);
		ee()->db->delete('extensions');
	}

	/**
	 * Method for template_post_parse hook
	 *
	 * @param  string  Parsed template string
	 * @param  bool    Whether an embed or not
	 * @param  integer Site ID
	 * @return string  Template string
	 */
	public function template_post_parse($template, $sub, $site_id)
	{
		if (ee()->TMPL->template_type != 'webpage')
		{
			return $template;
		}

		// Play nice with other extensions
		if (isset(ee()->extensions->last_call) && ee()->extensions->last_call)
		{
			$template = ee()->extensions->last_call;
		}

		// Do nothing if not final template
		if ($sub !== FALSE)
		{
			return $template;
		}

		// Is HTML minification disabled
		if (ee()->config->item('marksmin_enabled') !== true)
		{
			return $template;
		}

		require_once('libraries/Minify/HTML.php');

		$options = array();

		$options['xhtml'] = ee()->config->item('marksmin_xhtml');

		return Minify_HTML::minify($template, $options);
	}
}