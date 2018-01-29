<?php
/**
 * My Entries module for Craft CMS 3.x
 *
 * Widget to show my entries.
 *
 * @link      https://simple.com.au
 * @copyright Copyright (c) 2018 Simple Integrated Marketing
 */

namespace modules\myentriesmodule;

use modules\myentriesmodule\assetbundles\myentriesmodule\MyEntriesModuleAsset;

use Craft;
use craft\events\RegisterTemplateRootsEvent;
use craft\events\TemplateEvent;
use craft\web\View;
use craft\services\Dashboard;
use craft\events\RegisterComponentTypesEvent;

use modules\myentriesmodule\widgets\MyEntriesModuleWidget;
use yii\base\Event;
use yii\base\InvalidConfigException;
use yii\base\Module;

/**
 * Class MyEntriesModule
 *
 * @author    Simple Integrated Marketing
 * @package   MyEntriesModule
 * @since     1.0.0
 *
 */
class MyEntriesModule extends Module
{
    // Static Properties
    // =========================================================================

    /**
     * @var MyEntriesModule
     */
    public static $instance;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        Craft::setAlias('@my-entries-module', $this->getBasePath());
        $this->controllerNamespace = 'modules\myentriesmodule\controllers';


        // Base template directory
        Event::on(View::class, View::EVENT_REGISTER_CP_TEMPLATE_ROOTS, function (RegisterTemplateRootsEvent $e) {
            if (is_dir($baseDir = $this->getBasePath().DIRECTORY_SEPARATOR.'templates')) {
                $e->roots[$this->id] = $baseDir;
            }
        });

        // Set this as the global instance of this module class
        static::setInstance($this);

        parent::__construct($id, $parent, $config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$instance = $this;

        if (Craft::$app->getRequest()->getIsCpRequest()) {
            Event::on(
                View::class,
                View::EVENT_BEFORE_RENDER_TEMPLATE,
                function (TemplateEvent $event) {
                    try {
                        Craft::$app->getView()->registerAssetBundle(MyEntriesModuleAsset::class);
                    } catch (InvalidConfigException $e) {
                        Craft::error(
                            'Error registering AssetBundle - '.$e->getMessage(),
                            __METHOD__
                        );
                    }
                }
            );
        }

        Event::on(
            Dashboard::class,
            Dashboard::EVENT_REGISTER_WIDGET_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = MyEntriesModuleWidget::class;
            }
        );

        Craft::info(
            'My Entries module loaded',
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================
}
