<?php
/**
 * Published Event plugin for Craft CMS 3.x
 *
 * Triggers an event for entries when they are published or expire in the future
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\publishedevent\controllers;

use superbig\publishedevent\PublishedEvent;

use Craft;
use craft\web\Controller;

/**
 * @author    Superbig
 * @package   PublishedEvent
 * @since     1.0.0
 */
class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = [ 'check' ];

    // Public Methods
    // =========================================================================

    public function actionCheck ()
    {
        $existingRecords = craft()->publishedEvent->check();
        $this->returnJson($existingRecords);
    }
}
