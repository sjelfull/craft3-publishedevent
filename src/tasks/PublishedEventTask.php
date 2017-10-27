<?php
/**
 * Published Event plugin for Craft CMS 3.x
 *
 * Triggers an event for entries when they are published or expire in the future
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\publishedevent\tasks;

use craft\queue\BaseJob;
use craft\queue\QueueInterface;
use superbig\publishedevent\PublishedEvent;

/**
 * @author    Superbig
 * @package   PublishedEvent
 * @since     1.0.0
 */
class PublishedEventJob extends BaseJob
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $elementId;

    // Public Methods
    // =========================================================================

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function defaultDescription (): string
    {
        return Craft::t('published-event', 'PublishedEventTask');
    }

    /**
     * @param \yii\queue\Queue|QueueInterface $queue The queue the job belongs to
     */
    public function execute ($queue)
    {
        // TODO: Implement execute() method.
    }
}
