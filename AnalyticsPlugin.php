<?php
/**
 * Analytics plugin for Craft CMS
 *
 * Google analytics reporting for your craft website
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2016 Vadim Goncharov
 * @link      http://roundhouseagency.com
 * @package   Analytics
 * @since     1.0.0
 */

namespace Craft;


class AnalyticsPlugin extends BasePlugin
{
    /**
     * @return mixed
     */
    public function init()
    {
        require_once(CRAFT_PLUGINS_PATH.'analytics/vendor/autoload.php');

        if (craft()->request->isCpRequest()) {
            craft()->templates->hook('analytics.prepCpTemplate', array($this, 'prepCpTemplate'));
        }

        parent::init();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
         return Craft::t('Analytics');
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return Craft::t('Google analytics reporting for your craft website');
    }

    /**
     * @return string
     */
    public function getDocumentationUrl()
    {
        return 'https://github.com/roundhouse/analytics/blob/master/README.md';
    }

    /**
     * @return string
     */
    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/roundhouse/analytics/master/releases.json';
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '1.0.0';
    }

    /**
     * @return string
     */
    public function getSchemaVersion()
    {
        return '1.0.0';
    }

    /**
     * @return string
     */
    public function getDeveloper()
    {
        return 'Vadim Goncharov';
    }

    /**
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'http://roundhouseagency.com';
    }

    /**
     * @return bool
     */
    public function hasCpSection()
    {
        return true;
    }

    /**
     * Hook Register CP Routes
     */
    public function registerCpRoutes()
    {
        return array(
            'analytics' => array('action' => "analytics/index"),
            'analytics/settings' => array('action' => "analytics/settings"),
        );
    }

    public function prepCpTemplate(&$context)
    {
        $context['subnav'] = array();
        $context['subnav']['dashboard'] = array('icon' => 'settings', 'label' => Craft::t('Dashboard'), 'url' => 'analytics');
        $context['subnav']['settings'] = array('icon' => 'settings', 'label' => Craft::t('Settings'), 'url' => 'analytics/settings');
    }

    /**
     * @return mixed
     */
    public function addTwigExtension()
    {
        Craft::import('plugins.analytics.twigextensions.AnalyticsTwigExtension');

        return new AnalyticsTwigExtension();
    }

    /**
     */
    public function onBeforeInstall()
    {
    }

    /**
     */
    public function onAfterInstall()
    {
    }

    /**
     */
    public function onBeforeUninstall()
    {
    }

    /**
     */
    public function onAfterUninstall()
    {
    }

    /**
     * @return array
     */
    protected function defineSettings()
    {
        return array(
            'tokenId'    => AttributeType::Number,
            'account'  => AttributeType::Number,
            'property' => AttributeType::Number
        );

    }

    /**
     * @return mixed
     */
    public function getSettingsHtml()
    {
       return craft()->templates->render('analytics/settings/index', array(
           'settings' => $this->getSettings()
       ));
    }

    /**
     * @return mixed
     */
    public function prepSettings($settings)
    {
        // Modify $settings here...

        return $settings;
    }

}