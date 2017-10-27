<?php
/**
 * Published Event plugin for Craft CMS 3.x
 *
 * Triggers an event for entries when they are published or expire in the future
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\publishedevent\events;

use craft\elements\Entry;
use yii\base\Event;

/**
 * @author    Superbig
 * @package   PublishedEvent
 * @since     1.0.0
 */
class PublishedEvent extends Event
{
    /**
     * @var Entry The associated entry
     */
    public $entry;
}