<?php
/**
 * Analytics plugin for Craft CMS
 *
 * Analytics Task
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2016 Vadim Goncharov
 * @link      http://roundhouseagency.com
 * @package   Analytics
 * @since     1.0.0
 */

namespace Craft;

class AnalyticsTask extends BaseTask
{
    /**
     * @access protected
     * @return array
     */

    protected function defineSettings()
    {
        return array(
            'someSetting' => AttributeType::String,
        );
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'Analytics Tasks';
    }

    /**
     * @return int
     */
    public function getTotalSteps()
    {
        return 1;
    }

    /**
     * @param int $step
     * @return bool
     */
    public function runStep($step)
    {
        return true;
    }
}
