<?php namespace Waka\Informer\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateInformsTable extends Migration
{
    public function up()
    {
        Schema::create('waka_informer_informs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('type');
            $table->text('data')->nullable();
            $table->boolean('check')->default(0);
            $table->date('hide_until')->nullable();
            $table->integer('informeable_id')->unsigned()->nullable();
            $table->string('informeable_type')->nullable();                                        
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('waka_informer_informs');
    }
}
