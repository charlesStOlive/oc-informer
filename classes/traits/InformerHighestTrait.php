<?php namespace Waka\Informer\Classes\Traits;

use \Waka\Informer\Models\Inform;


trait InformerHighestTrait
{
    public function getInformHighttValue()
    {

        if($this->getCountTypeInform('*') == 0) {
            return $this->informHightValue = null;
        }
        if($this->getCountTypeInform('problem')) {
            return $this->informHightValue = 'problem';
        }
        if($this->getCountTypeInform('warning')) {
            return $this->informHightValue = 'warning';
        }
        if($this->getCountTypeInform('info')) {
            return $this->informHightValue = 'info';
        }
        if($this->getCountTypeInform('success')) {
            return $this->informHightValue = 'success';
        }
    }

    /**
     * Return button text or icon
     *
     * @return string
     */
    public function getIconValue($informHightValue)
    {
        $icon = 'icon_info';
        switch ($informHightValue) {
            case 'warning':
                $icon = 'icon-exclamation-circle';
                break;
            case 'problem':
                $icon = 'icon-minus-circle';
                break;
            case 'success':
                $icon = 'icon-check-circle';
                break;
            case 'info':
                $icon = 'icon-info';
                break;
            case 'icon-comments':
                $icon = 'icon-comments';
                break;
        }
        return $icon;
    }

    /**
     * Return the wright tooltip
     *
     * @return string
     */

    /**
     * Return the wright color
     *
     * @return string
     */
    public function getColorValue($informHightValue)
    {
        $color = 'grey';
        switch ($informHightValue) {
            case 'warning':
                $color = 'orange';
                break;
            case 'problem':
                $color = 'red';
                break;
            case 'success':
                $color = 'green';
                break;
            case 'info':
                $color = 'info';
                break;
        }
        return $color;
    }

    /**
     * Return button hover title
     *
     * @return string
     */
    public function getButtonTitle($informHightValue)
    {
        $color = 'Cliquez pour voir les ';
        switch ($informHightValue) {
            case 'warning':
                $color .= 'alertes';
                break;
            case 'problem':
                $color .= 'erreurs';
                break;
            case 'success':
                $color .= 'succès';
                break;
            case 'info':
                $color .= 'infos';
                break;
        }
        return $color;
    }
    
    
}
