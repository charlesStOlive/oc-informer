<?php namespace Waka\Informer\Behaviors;

use Backend\Classes\ControllerBehavior;

use October\Rain\Support\Collection;
use October\Rain\Exception\ApplicationException;
use Flash;
use Redirect;
use Session;


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
                'color' => 'danger',
                'icon' => 'icon-minus-circle',
                'datas' =>  $this->getInformsByType($model, 'problem'),
            ],
            'warning' => [
                'color' => 'warning',
                'icon' => 'icon-warning',
                'datas' =>  $this->getInformsByType($model, 'warning'),
            ],
            'success' => [
                'color' => 'success',
                'icon' => 'icon-check-circle',
                'datas' =>  $this->getInformsByType($model, 'success'),
            ],
            'info' => [
                'color' => 'info',
                'icon' => 'icon-info',
                'datas' =>  $this->getInformsByType($model, 'info'),
            ]
        ];
        //
        $this->vars['infos'] = $infos;
        // $infoArray = [];
        // $infoArray['problem'] = $this->getInformsByType($model, 'problem');
        // $infoArray['warning'] = $this->getInformsByType($model, 'warning');
        // $infoArray['info'] = $this->getInformsByType($model, 'info');
        // $infoArray['success'] = $this->getInformsByType($model, 'success');
        // //
        // $this->vars['infos'] = $infoArray;
        //
        return $this->makePartial('$/waka/informer/behaviors/popupinfo/_popup.htm');
    }

    public function getInformsByType($model, $type) {
        trace_log($type.'_____________________________________________');
        trace_log($model->toArray());
        //trace_log($model->where('type', '=', $type));
        return  $model->where('type', '=', $type);
    }
    
}