<?php

namespace yii\calendar;

use \Yii;

class CalendarAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/filsh/yii2-calendar/yii/calendar/assets';

    public $js = [
        'js/calendar.js'
    ];
    
    public $css = [
        'less/calendar.less'
    ];
    
    public $depends = [
        'yii\web\JqueryAsset'
    ];
    
    public function init()
    {
        $language = str_replace('-', '_', strtolower(Yii::$app->language));
        
        if(strpos($language, '_') !== false) {
            $language = explode('_', $language)[0];
        }
        
        $this->js[] = 'i18n/'. $language .'.js';
        parent::init();
    }
}