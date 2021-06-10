<?php namespace Waka\Informer\Behaviors;

use Backend\Classes\ControllerBehavior;

use Winter\Storm\Support\Collection;
use Winter\Storm\Exception\ApplicationException;
use Flash;
use Redirect;
use Session;
use Lang;

class PopupInfo extends ControllerBehavior
{


    public function __construct($controller)
    {
        parent::__construct($controller);
    }


     //ci dessous tous les calculs pour permettre l'import excel.

    public function onCallInfoPopupBehavior()
    {
        $modelName = post('model');
        $model = new $modelName;
        $model = $model->find(post('id'))->informs()->get(['data', 'type']);
        //
        $infos = [
            
            'problem' => [
                'title' => Lang::get('waka.informer::lang.errors.problem'),
                'color' => 'danger',
                'icon' => 'icon-minus-circle',
                'datas' =>  $this->getInformsByType($model, 'problem'),
            ],
            'warning' => [
                'title' => Lang::get('waka.informer::lang.errors.warning'),
                'color' => 'warning',
                'icon' => 'icon-warning',
                'datas' =>  $this->getInformsByType($model, 'warning'),
            ],
            'success' => [
                'title' => Lang::get('waka.informer::lang.errors.success'),
                'color' => 'success',
                'icon' => 'icon-check-circle',
                'datas' =>  $this->getInformsByType($model, 'success'),
            ],
            'info' => [
                'title' => Lang::get('waka.informer::lang.errors.info'),
                'color' => 'info',
                'icon' => 'icon-info',
                'datas' =>  $this->getInformsByType($model, 'info'),
            ]
        ];
        //
        $this->vars['infos'] = $infos;
        return $this->makePartial('$/waka/informer/behaviors/popupinfo/_popup.htm');
    }

    public function getInformsByType($model, $type)
    {
        return  $model->where('type', '=', $type);
    }
}
