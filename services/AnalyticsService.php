<?php
/**
 * Analytics plugin for Craft CMS
 *
 * Analytics Service
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2016 Vadim Goncharov
 * @link      http://roundhouseagency.com
 * @package   Analytics
 * @since     1.0.0
 */

namespace Craft;

class AnalyticsService extends BaseApplicationComponent
{
    // Save token
    public function saveToken(Oauth_TokenModel $token)
    {
        $plugin = craft()->plugins->getPlugin('analytics');
        $settings = $plugin->getSettings();

        $existingToken = craft()->oauth->getTokenById($settings->tokenId);
        if ($existingToken) {
            $token->id = $existingToken->id;
        }

        craft()->oauth->saveToken($token);
        $settings->tokenId = $token->id;
        craft()->plugins->savePluginSettings($plugin, $settings);
    }

    // Get token
    public function getToken()
    {
        if($this->token) {
            return $this->token;
        } else {
            $plugin = craft()->plugins->getPlugin('analytics');
            $settings = $plugin->getSettings();
            $tokenId = $settings->tokenId;
            $token = craft()->oauth->getTokenById($tokenId);
            return $token;
        }
    }

    // Purge google token
    public function purgeToken()
    {
        $plugin = craft()->plugins->getPlugin('analytics');
        $settings = $plugin->getSettings();

        if ($settings->tokenId) {
            $token = craft()->oauth->getTokenById($settings->tokenId);

            if ($token) {
                if(craft()->oauth->deleteToken($token)) {
                    $settings->tokenId = null;
                    craft()->plugins->savePluginSettings($plugin, $settings);
                    return true;
                }
            }
        }
        return false;
    }
}