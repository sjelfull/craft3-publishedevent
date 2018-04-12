<?php
/**
 * Published Event plugin for Craft CMS 3.x
 *
 * Triggers an event for entries when they are published or expire in the future
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\publishedevent\console\controllers;

use superbig\publishedevent\PublishedEvent;

use Craft;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Default Command
 *
 * @author    Superbig
 * @package   PublishedEvent
 * @since     1.0.0
 */
class EntryController extends Controller
{
    // Public Methods
    // =========================================================================

    /**
     * Check for published or expired entries
     *
     * @return string
     */
    public function actionCheck ()
    {
        $this->stdout('Checking for published or expired entries' . PHP_EOL, Console::FG_GREY);

        $existingRecords = PublishedEvent::$plugin->publishedEventService->check();
        $numExistingRecords = count($existingRecords);
        $this->stdout( 'Found ' . $numExistingRecords . ' ' . $this->plural($numExistingRecords, 'entry', 'entries') . ' that ' . $this->plural($numExistingRecords, 'is', 'are') . ' waiting to be published or expired' . PHP_EOL, Console::FG_GREEN );
    }

    private function plural ($amount, $singular = '', $plural = 's')
    {
        if ( $amount === 1 ) {
            return $singular;
        }
        return $plural;
    }
}
