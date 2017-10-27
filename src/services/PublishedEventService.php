<?php
/**
 * Published Event plugin for Craft CMS 3.x
 *
 * Triggers an event for entries when they are published or expire in the future
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\publishedevent\services;

use craft\elements\Entry;
use craft\helpers\DateTimeHelper;
use superbig\publishedevent\events\PublishedEvent;

use Craft;
use craft\base\Component;
use superbig\publishedevent\records\PublishedEventRecord;

/**
 * @author    Superbig
 * @package   PublishedEvent
 * @since     1.0.0
 */
class PublishedEventService extends Component
{
    // Public Methods
    // =========================================================================

    public function onSave (Entry $entry)
    {
        // TODO: Save record
        // TODO: Add job to check 1 minute after given post / expire data
    }

    /*public function onPublished (PublishedEvent $event)
    {
        $this->raiseEvent('onPublished', $event);
    }*/

    public function check ()
    {
        $criteria = Entry::find()
                         ->status(Entry::STATUS_PENDING)
                         ->select([ 'elements.id', 'entries.postDate', 'entries.expiryDate' ]);

        $pendingIds     = $criteria->ids();
        $pendingEntries = $criteria->all();

        // Get element ids of existing records
        $existingRecords = PublishedEventRecord::find()->all();

        // If a record exists for a entry that is enabled since last check, trigger event
        /** @var PublishedEventRecord $existingRecord */
        foreach ($existingRecords as $existingRecord) {
            $amongPendingEntries = in_array($existingRecord->elementId, $pendingIds);

            if ( !$amongPendingEntries ) {
                // Get entry that is now published
                $entry = Entry::findOne($existingRecord->elementId);

                if ( $entry ) {
                    $event = new PublishedEvent([ 'entry' => $entry ]);
                    $this->trigger(\superbig\publishedevent\PublishedEvent::EVENT_PUBLISHED, $event);
                    $existingRecord->delete();
                }

            }
        }

        // TODO: HAndle expired entries

        foreach ($pendingEntries as $entry) {
            $record = PublishedEventRecord::findOne([
                'elementId' => $entry->id,
            ]);

            if ( !$record ) {
                $dateTime            = DateTimeHelper::currentTimeStamp();
                $record              = new PublishedEventRecord();
                $record->elementId   = $entry->id;
                $record->siteId      = $entry->siteId;
                $record->enableDate  = $entry->postDate;
                $record->expireDate  = $entry->expiryDate;
                $record->dateCreated = $dateTime;
                $record->dateUpdated = $dateTime;
                $record->save();

                $existingRecords[] = $record;
            }
            else {
                $samePostDate = $record->enableDate === $entry->postDate;

                // Account for changed postDate?
                if ( !$samePostDate ) {
                    $record->enableDate = $entry->postDate;
                    $record->save();
                }
            }
        }

        return $existingRecords;
    }
}
