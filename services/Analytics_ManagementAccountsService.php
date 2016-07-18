<?php
/**
 * Analytics plugin for Craft CMS
 *
 * Analytics Management Accounts Service
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

class Analytics_ManagementAccountsService extends BaseApplicationComponent
{
    // Public Methods
    // =========================================================================

    public function getManagementAccounts($token)
    {
        // Authorize
        $client = new Google_Client();

        $client->setAccessToken($token->accessToken);

        // Get Analytics
        $analyticsService = new Google_Service_Analytics($client);
        $managementAccounts = $analyticsService->management_accounts->listManagementAccounts();
        $accounts = [];

        foreach ($managementAccounts['items'] as $account) {
            $accounts[] = [ 'id' => $account['id'], 'name' => $account['name'] ];
        }
        return $accounts;
    }

    public function getManagementWebProperties($token, $accountId)
    {
        // Authorize
        $client = new Google_Client();
        $client->setAccessToken($token->accessToken);

        // Get Analytics
        $analyticsService = new Google_Service_Analytics($client);
        $managementProperties = $analyticsService->management_webproperties->listManagementWebproperties($accountId);
        $webProperties = [];

        foreach ($managementProperties['items'] as $account) {
            $webProperties[] = [ 'id' => $account['id'], 'name' => $account['name'] ];
        }
        return $webProperties;
    }

    public function getWebProperty($token, $accountId, $propertyId)
    {
        // Authorize
        $client = new Google_Client();
        $client->setAccessToken($token->accessToken);

        // Get Property
        $analyticsService = new Google_Service_Analytics($client);
        $managementProperties = $analyticsService->management_webproperties->get($accountId, $propertyId);

        return $property;
    }
}