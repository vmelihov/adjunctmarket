<?php

namespace common\src\helpers;

class HtmlHelper
{
    /**
     * @param string $cssClass
     * @return callable
     */
    public static function getCallbackRadioItem(string $cssClass = 'g-mb20'): callable
    {
        return static function ($index, $label, $name, $checked, $value) use ($cssClass) {
            $check = $checked ? ' checked' : '';
            $return = '<div class="' . $cssClass . '">';
            $return .= '<label class="ui-radio">';
            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"' . $check . '>';
            $return .= '<span class="ui-radio__decor"></span>';
            $return .= '<span class="ui-radio__text">' . $label . '</span>';
            $return .= '</label></div>';

            return $return;
        };
    }

    /**
     * @param string $cssClass
     * @return callable
     */
    public static function getCallbackCheckboxItem(string $cssClass = 'g-mb20'): callable
    {
        return static function ($index, $label, $name, $checked, $value) use ($cssClass) {
            $check = $checked ? ' checked' : '';
            $return = '<label class="ui-checkbox ' . $cssClass . '">';
            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"' . $check . '>';
            $return .= '<span class="ui-radio__decor"></span>';
            $return .= '<span class="ui-radio__text">' . $label . '</span>';
            $return .= '</label>';

            return $return;
        };
    }
}