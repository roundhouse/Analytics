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

use Google_Client;
use Google_Service_Analytics;

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

    /**
     * @return array
     */
    public function actionSettingsIndex()
    {
        $plugin     = craft()->plugins->getPlugin('analytics');
        $provider   = craft()->oauth->getProvider('google');
        $token      = craft()->analytics->getToken();

        // Variables
        $variables['token'] = '';

        if ($token) {
            $variables['token'] = $token;
            $token->refreshToken;
        }
        //  Google api access
        // $client = new Google_Client();
        // $client->setAccessToken($token->accessToken);

        // // $expiry = getDate().now + $token->endOfLife;
        $dateNow = DateTimeHelper::currentTimeStamp();

        // // var_dump($token->refreshToken);

        // if ($token->endOfLife < $dateNow) {
        //     var_dump('token exprired');
        // } else {
        //     var_dump('token is valid');
        // }


        // die();

        // $accounts = craft()->analytics_managementAccounts->getManagementAccounts($token);
        // $variables['accounts'] = $accounts;
        
        
        $variables['date'] = $dateNow;

        $this->renderTemplate('analytics/settings', $variables);
    }
}