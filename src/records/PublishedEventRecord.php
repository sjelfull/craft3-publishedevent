<?php
/**
 * Published Event plugin for Craft CMS 3.x
 *
 * Triggers an event for entries when they are published or expire in the future
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\publishedevent\records;

use superbig\publishedevent\PublishedEvent;

use Craft;
use craft\db\ActiveRecord;

/**
 * @author    Superbig
 * @package   PublishedEvent
 * @since     1.0.0
 */
class PublishedEventRecord extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function tableName ()
    {
        return '{{%publishedevent}}';
    }
}
