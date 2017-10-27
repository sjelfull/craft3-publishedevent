<?php
/**
 * Published Event plugin for Craft CMS 3.x
 *
 * Triggers an event for entries when they are published or expire in the future
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\publishedevent;

use craft\base\Element;
use craft\elements\Entry;
use craft\events\ElementEvent;
use craft\events\ModelEvent;
use craft\services\Elements;
use superbig\publishedevent\services\PublishedEventService as PublishedEventServiceService;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\console\Application as ConsoleApplication;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class PublishedEvent
 *
 * @author    Superbig
 * @package   PublishedEvent
 * @since     1.0.0
 *
 * @property  PublishedEventServiceService $publishedEventService
 */
class PublishedEvent extends Plugin
{
    // Static Properties
    // =========================================================================

    const EVENT_PUBLISHED = 'published';
    const EVENT_EXPIRED   = 'expired';

    /**
     * @var PublishedEvent
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init ()
    {
        parent::init();
        self::$plugin = $this;

        if ( Craft::$app instanceof ConsoleApplication ) {
            $this->controllerNamespace = 'superbig\publishedevent\console\controllers';
        }

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['siteActionTrigger1'] = 'published-event/default';
            }
        );

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['cpActionTrigger1'] = 'published-event/default/do-something';
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ( $event->plugin === $this ) {
                }
            }
        );

        Event::on(
            Entry::class,
            Elements::EVENT_AFTER_SAVE_ELEMENT,
            function (ElementEvent $event) {
                $this->publishedEventService->onSave($event->element);
            }
        );

        Craft::info(
            Craft::t(
                'published-event',
                '{name} plugin loaded',
                [ 'name' => $this->name ]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
