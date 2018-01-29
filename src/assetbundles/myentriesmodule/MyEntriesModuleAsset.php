<?php
/**
 * My Entries module for Craft CMS 3.x
 *
 * Widget to show my entries.
 *
 * @link      https://simple.com.au
 * @copyright Copyright (c) 2018 Simple Integrated Marketing
 */

namespace modules\myentriesmodule\assetbundles\MyEntriesModule;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Simple Integrated Marketing
 * @package   MyEntriesModule
 * @since     1.0.0
 */
class MyEntriesModuleAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@my-entries-module/assetbundles/myentriesmodule/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/MyEntriesModule.js',
        ];

        $this->css = [
            'css/MyEntriesModule.css',
        ];

        parent::init();
    }
}
