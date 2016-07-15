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
    
    // Settings Index
    public function actionSettings()
    {
        $plugin = craft()->plugins->getPlugin('analytics');
        $provider = craft()->oauth->getProvider('google');

        $variables = array(
            'provider' => false,
            'account' => false,
            'token' => false,
            'error' => false,
            'settings' => $plugin->getSettings()
        );


        if ($provider && $provider->isConfigured()) {
            $token = craft()->analytics_authorize->getToken();
            if ($token) {
                $variables['token'] = $token;
                $variables['provider'] = $provider;

                $account = $provider->getAccount($token);
                $variables['account'] = $account;
            }
        }

        $this->renderTemplate('analytics/settings/index', $variables);
    }

    // /**
    //  * @return array
    //  */
    // public function actionIndex()
    // {
    //     // $plugin     = craft()->plugins->getPlugin('analytics');
    //     // $provider   = craft()->oauth->getProvider('google');
    //     // $token      = craft()->analytics->getToken();

    //     // Variables
    //     // $variables['token'] = '';

    //     // if ($token) {
    //     //     $variables['token'] = $token;
    //     //     $token->refreshToken;
    //     // }
    //     //  Google api access
    //     // $client = new Google_Client();
    //     // $client->setAccessToken($token->accessToken);

    //     // // $expiry = getDate().now + $token->endOfLife;

    //     // // var_dump($token->refreshToken);

    //     // if ($token->endOfLife < $dateNow) {
    //     //     var_dump('token exprired');
    //     // } else {
    //     //     var_dump('token is valid');
    //     // }


    //     // die();

    //     // $accounts = craft()->analytics_managementAccounts->getManagementAccounts($token);
    //     // $variables['accounts'] = $accounts;
        
        
    //     $dateNow = DateTimeHelper::currentTimeStamp();
    //     $variables['date'] = $dateNow;

    //     $this->renderTemplate('analytics/pages/index', $variables);
    // }
}