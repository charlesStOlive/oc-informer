<?php namespace Waka\Informer\Classes\Traits;

use \Waka\Informer\Models\Inform;


trait InformerTrait
{
    public function record_inform($type, $data) {
        $inform = new Inform();
        $inform->type = $type;
        $inform->data = $data;
        $this->informs()->save($inform);
    }
    public function delete_informs() {
        if(count($this->informs)) $this->informs()->delete();;
    }
}
