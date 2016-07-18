<?php
/**
 * Analytics plugin for Craft CMS
 *
 * Analytics Authorize Accounts Service
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2016 Vadim Goncharov
 * @link      http://roundhouseagency.com
 * @package   Analytics
 * @since     1.0.0
 */

namespace Craft;

use Google_Client;
use Google_Service_Analytics;

class Analytics_AuthorizeService extends BaseApplicationComponent
{
    // Public Methods
    // =========================================================================
    
    // Save Token
    public function saveToken(Oauth_TokenModel $token)
    {
        $plugin = craft()->plugins->getPlugin('analytics');
        $settings = $plugin->getSettings();
        $currentToken = craft()->oauth->getTokenById($settings->tokenId);

        if ($currentToken) {
            $token->id = $currentToken->id;
        }
        craft()->oauth->saveToken($token);
        $settings->tokenId = $token->id;
        craft()->plugins->savePluginSettings($plugin, $settings);
    }

    // Get Token
    public function getToken()
    {
        $plugin = craft()->plugins->getPlugin('analytics');
        $tokenId = $plugin->getSettings()->tokenId;
        $token = craft()->oauth->getTokenById($tokenId);
        return $token;
    }

    // Purge Token
    public function purgeToken()
    {
        $plugin = craft()->plugins->getPlugin('twitter');
        $settings = $plugin->getSettings();

        if ($settings->tokenId) {
            $token = craft()->oauth->getTokenById($settings->tokenId);

            if ($token) {
                if (craft()->oauth->deleteToken($token)) {
                    $settings->tokenId = null;
                    craft()->plugins->savePluginSettings($plugin, $settings);
                    return true;
                }
            }
        }
        return false;
    }
}