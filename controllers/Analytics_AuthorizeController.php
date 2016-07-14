<?php
/**
 * Analytics plugin for Craft CMS
 *
 * Analytics Authorize Controller
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2016 Vadim Goncharov
 * @link      http://roundhouseagency.com
 * @package   Analytics
 * @since     1.0.0
 */

namespace Craft;

class Analytics_AuthorizeController extends BaseController
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
     * Connect to Google
     * 
     * @return null
     */
    public function actionConnect()
    {
        $referer = craft()->httpSession->get('google.referer');

        if (!$referer) {
            $referer = craft()->request->getUrlReferrer();
            craft()->httpSession->add('google.referer', $referer);
        }

        $scope = [
            'https://www.googleapis.com/auth/analytics.readonly'
        ];

        $authorizationOptions = [
            'access_type' => 'offline'
        ];

        if ($response = craft()->oauth->connect([
            'plugin'    => 'analytics',
            'provider'  => $this->handle,
            'scope'     => $scope,
            'authorizationOptions'  => $authorizationOptions
        ])) {
            if ($response['success']) {
                $token = $response['token'];
                craft()->analytics->saveToken($token);
                craft()->userSession->setNotice(Craft::t("Connected to Google Account"));
            } else {
                craft()->userSession->setError(Craft::t($response['errorMsg']));
            }
        } else {
            craft()->userSession->setError(Craft::t("Couldn’t connect"));
        }

        craft()->httpSession->remove('google.referer');
        $this->redirect($referer);
    }

    /**
     * Disconnect from Google
     * 
     * @return null
     */
    public function actionDisconnect()
    {
        if (craft()->analytics->purgeToken()) {
            craft()->userSession->setNotice(Craft::t("Disconnected from Google Account"));
        } else {
            craft()->userSession->setError(Craft::t("Couldn’t disconnect from Google Account"));
        }
        $redirect = craft()->request->getUrlReferrer();
        $this->redirect($redirect);
    }
}