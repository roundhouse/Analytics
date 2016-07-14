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

    /**
     * @param  int $token    Oauth Token
     * @return array $accounts    List Of Management Accounts
     */
    public function getManagementAccounts($token)
    {
        // Authorize
        $client = new Google_Client();
        $client->setAccessToken($token->accessToken);


        // Get Analytics
        $analyticsService = new Google_Service_Analytics($client);
        $managementAccounts = $analyticsService->management_accounts->listManagementAccounts('~all');
        $accounts = [];

        foreach ($managementAccounts['items'] as $account) {
            $accounts[] = [ 'id' => $account['id'], 'name' => $account['name'] ];
        }
        return $accounts;
    }
}