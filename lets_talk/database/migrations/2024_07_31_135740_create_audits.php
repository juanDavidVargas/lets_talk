<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAudits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audits', function (Blueprint $table) {
                $table->bigIncrements('id');//ok
                $table->string('user_type')->nullable();//ok
                $table->unsignedBigInteger('user_id')->nullable();//ok
                $table->string('event'); //ok
                $table->morphs('auditable');
                $table->text('old_values')->nullable();//ok
                $table->text('new_values')->nullable();//ok
                $table->text('url')->nullable();//ok
                $table->ipAddress('ip_address')->nullable();
                $table->string('user_agent', 1023)->nullable();//ok
                $table->string('tags')->nullable();//ok
                $table->timestamps();
    
                $table->index(['user_id', 'user_type']);
        });

        // DB::table('audits')->update([
        //     'user_type'  => \App\User::class,
        //     'created_at' => DB::raw('created_at'),
        //     'updated_at' => DB::raw('updated_at'),
        // ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audits');
    }
}
