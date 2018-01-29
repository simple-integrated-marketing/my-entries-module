<?php
/**
 * My Entries module for Craft CMS 3.x
 *
 * Widget to show my entries.
 *
 * @link      https://simple.com.au
 * @copyright Copyright (c) 2018 Simple Integrated Marketing
 */

namespace modules\myentriesmodule\widgets;

use craft\elements\Entry;
use modules\myentriesmodule\MyEntriesModule;
use modules\myentriesmodule\assetbundles\myentriesmodule\MyEntriesModuleAsset;

use Craft;
use craft\base\Widget;

/**
 * My Entries Widget
 *
 * @author    Simple Integrated Marketing
 * @package   MyEntriesModule
 * @since     1.0.0
 */
class MyEntriesModuleWidget extends Widget
{

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $numberOfEntries = 10;

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return 'My Entries';
    }

    /**
     * @inheritdoc
     */
    public static function iconPath()
    {
        return Craft::getAlias("@my-entries-module/assetbundles/myentriesmodule/dist/img/MyEntriesModule-icon.svg");
    }

    /**
     * @inheritdoc
     */
    public static function maxColspan()
    {
        return null;
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge(
            $rules,
            [
                ['numberOfEntries', 'number'],
                ['numberOfEntries', 'default', 'value' => 10],
            ]
        );
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate(
            'my-entries-module/_components/widgets/MyEntriesModuleWidget_settings',
            [
                'widget' => $this
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getBodyHtml()
    {
        Craft::$app->getView()->registerAssetBundle(MyEntriesModuleAsset::class);

        $numberOfEntries = $this->numberOfEntries;
        $currentUser = Craft::$app->getUser();
        $entries = Entry::find()->authorId($currentUser->id)->limit($numberOfEntries)->all();
        return Craft::$app->getView()->renderTemplate(
            'my-entries-module/_components/widgets/MyEntriesModuleWidget_body',
            [
                'entries' => $entries
            ]
        );
    }
}
