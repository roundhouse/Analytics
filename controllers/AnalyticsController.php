<?php
/**
 * Analytics plugin for Craft CMS
 *
 * Analytics Controller
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2016 Vadim Goncharov
 * @link      http://roundhouseagency.com
 * @package   Analytics
 * @since     1.0.0
 */

namespace Craft;

class AnalyticsController extends BaseController
{
    // Properties
    // =========================================================================

    /**
     * @var string
     */
    private $handle = 'google';

    // Public Methods
    // =========================================================================
    
    // Dashboard
    public function actionIndex()
    {
        $plugin     = craft()->plugins->getPlugin('analytics');
        $provider   = craft()->oauth->getProvider('google');
        $token      = craft()->analytics_authorize->getToken();

        if ($provider && $provider->isConfigured()) {
            $token = craft()->analytics_authorize->getToken();
            if ($token) {
                $variables['token'] = $token;
                $variables['provider'] = $provider;
            }
        }

        $this->renderTemplate('analytics/dashboard/index', $variables);
    }

    // Settings Index
    public function actionSettings()
    {
        // Load scripts & styles
        craft()->templates->includeJsResource('analytics/js/AnalyticsSettings.js');
        craft()->templates->includeCssResource('analytics/css/AnalyticsSettings.css');

        $plugin = craft()->plugins->getPlugin('analytics');
        $provider = craft()->oauth->getProvider('google');
        $token = craft()->analytics_authorize->getToken();

        if ($provider && $provider->isConfigured()) {
            $token = craft()->analytics_authorize->getToken();
            if ($token) {
                $variables['token'] = $token;
                $variables['provider'] = $provider;
            }
        }

        // Get Analytics Accounts
        $accounts = craft()->analytics_managementAccounts->getManagementAccounts($token);
        $variables['accounts'] = $accounts;

        $variables['settings'] = $plugin->getSettings();

        // Namespacing
        $id = craft()->templates->formatInputId('analytics');
        $namespacedId = craft()->templates->namespaceInputId($id);
        $variables['id'] = $id;
        $variables['namespacedId'] = $namespacedId;

        $this->renderTemplate('analytics/settings/index', $variables);
    }

    // Get Web Properties
    public function actionGetWebProperties()
    {
        $provider = craft()->oauth->getProvider('google');
        $token = craft()->analytics_authorize->getToken();

        if ($provider && $provider->isConfigured()) {
            $token = craft()->analytics_authorize->getToken();
            if ($token) {
                $variables['token'] = $token;
                $variables['provider'] = $provider;
            }
        }

        $accountId = craft()->request->getPost('accountId');
        $properties = craft()->analytics_managementAccounts->getManagementWebProperties($token, $accountId);
        $this->returnJson($properties);
    }

    // Get Web Property
    public function actionGetWebProperty()
    {
        $provider = craft()->oauth->getProvider('google');
        $token = craft()->analytics_authorize->getToken();

        if ($provider && $provider->isConfigured()) {
            $token = craft()->analytics_authorize->getToken();
            if ($token) {
                $variables['token'] = $token;
                $variables['provider'] = $provider;
            }
        }

        $accountId = craft()->request->getPost('accountId');
        $propertyId = craft()->request->getPost('propertyId');
        $properties = craft()->analytics_managementAccounts->getManagementWebProperties($token, $accountId, $propertyId);
        $this->returnJson($properties);
    }

    // Save Plugin Settings
    public function actionSaveSettings()
    {
        $accountId = craft()->request->getPost('account');
        $propertyId = craft()->request->getPost('property');

        $plugin = craft()->plugins->getPlugin('analytics');
        $settings = $plugin->getSettings();

        $account = [
            'accountId' => $accountId,
        ];

        $property = [
            'propertyId' => $propertyId,
        ];

        $settings->account = $account;
        $settings->property = $property;

        craft()->plugins->savePluginSettings($plugin, JsonHelper::encode($settings));

    }
}