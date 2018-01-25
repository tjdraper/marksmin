<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2018 BuzzingPixel, LLC
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

// Include configuration file
include_once PATH_THIRD . '/marksmin/addon.setup.php';

/**
 * Class Marksmin_ext
 */
class Marksmin_ext
{
    // Set properties for EE
    public $description = MARKSMIN_DESCRIPTION;
    public $docs_url = MARKSMIN_DOCS_URL;
    public $name = MARKSMIN_NAME;
    public $settings_exist = 'n';
    public $version = MARKSMIN_VER;

    /**
     * Activate Extension
     *
     * @return void
     */
    public function activate_extension()
    {
        ee()->db->insert('extensions', array(
            'class' => __CLASS__,
            'method' => 'template_post_parse',
            'hook' => 'template_post_parse',
            'settings' => '',
            'priority' => 10,
            'version' => $this->version,
            'enabled' => 'y'
        ));
    }

    /**
     * Update Extension
     * @param string $current
     * @return bool
     */
    public function update_extension($current = '')
    {
        if ($current === '' || $current === $this->version) {
            return false;
        }

        ee()->db->where('class', __CLASS__);
        ee()->db->update('extensions', array(
            'version' => $this->version
        ));

        return true;
    }

    /**
     * Disable Extension
     */
    public function disable_extension()
    {
        ee()->db->where('class', __CLASS__);
        ee()->db->delete('extensions');
    }

    /**
     * Method for template_post_parse hook
     * @param string  Parsed template string
     * @param bool Whether an embed or not
     * @return string Template string
     */
    public function template_post_parse($template, $sub)
    {
        /** @var \EE_Template $eeTemplateService */
        $eeTemplateService = ee()->TMPL;

        /** @var \EE_Config $eeConfigService */
        $eeConfigService = ee()->config;

        /** @var \EE_Extensions $eeExtensionsService */
        $eeExtensionsService = ee()->extensions;

        $type = $eeTemplateService->template_type;

        $groupName = $eeTemplateService->group_name;
        $templateName = $eeTemplateService->template_name;

        $currentTemplate = "{$groupName}/{$templateName}";
        $notFoundTemplate = $eeConfigService->item('site_404');

        if ($type === 'webpage' ||
            $type === '404' ||
            $currentTemplate === $notFoundTemplate
        ) {
            // Play nice with other extensions
            if (isset($eeExtensionsService->last_call) &&
                $eeExtensionsService->last_call
            ) {
                $template = $eeExtensionsService->last_call;
            }

            // Do nothing if not final template
            if ($sub !== false) {
                return $template;
            }

            // Is HTML minification disabled
            if ($eeConfigService->item('marksmin_enabled') !== true) {
                return $template;
            }

            $options = array(
                'xhtml' => ee()->config->item('marksmin_xhtml')
            );

            return \Minify_HTML::minify($template, $options);
        }

        return $template;
    }
}
