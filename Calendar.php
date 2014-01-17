<?php

namespace yii\calendar;

use \yii\base\Widget;
use \yii\helpers\Html;
use \yii\helpers\Json;
use \yii\web\JsExpression;

class Calendar extends Widget
{
    public $options = [
        'class' => 'fc-calendar-container'
    ];
    
    public $clientOptions = [];
    
    public $inputOptions = [];
    
    public $model;
    
    public $attribute;
    
    public function run()
    {
        CalendarAsset::register($this->getView());
        
        if (!isset($this->options['id'])) {
            if(!empty($this->model) && !empty($this->attribute)) {
                $this->options['id'] = Html::getInputId($this->model, $this->attribute);
                $this->createInput();
            } else {
                $this->options['id'] = 'calendario';
            }
        }
        
        $this->createContainer();
        $this->registerScript($this->clientOptions);
    }
    
    protected function createContainer()
    {
        echo Html::tag('div', '', $this->options);
    }
    
    protected function createInput()
    {
        if(!isset($this->clientOptions['onDayClick'])) {
            $this->clientOptions['onDayClick'] = new JsExpression('function(cell, content, date) {
                console.log(cell, content, date);
                jQuery("#' . Html::getInputId($this->model, $this->attribute) . '").val();
            }');
        }
        echo Html::activeHiddenInput($this->model, $this->attribute, $this->inputOptions);
    }
    
    protected function registerScript()
    {
        $configure = !empty($this->clientOptions) ? Json::encode($this->clientOptions) : '';
        $this->getView()->registerJs("jQuery('#{$this->options['id']}').calendario($configure);");
    }
}