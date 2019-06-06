<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RolesPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'roles', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string( 'label' )->unique();
            $table->string( 'description' );
            $table->timestamps();
            $table->softDeletes();
        } );

        Schema::create( 'permissions', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string( 'label' )->unique();
            $table->string( 'description' );
            $table->timestamps();
            $table->softDeletes();
        } );

        Schema::create( 'role_user', function ( Blueprint $table )  {
            $table->unsignedBigInteger( 'role_id' );
            $table->unsignedBigInteger( 'user_id' );
            $table->primary( [ 'user_id', 'role_id' ] );
            $table->timestamps();
            $table->foreign( 'role_id' )->references( 'id' )->on( 'roles' );
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' );
        } );

        Schema::create( 'permission_role', function ( Blueprint $table ) {
            $table->unsignedBigInteger( 'permission_id' );
            $table->unsignedBigInteger( 'role_id' );
            $table->primary( [ 'role_id', 'permission_id' ] );
            $table->timestamps();
            $table->foreign( 'permission_id' )->references( 'id' )->on( 'permissions' );
            $table->foreign( 'role_id' )->references( 'id' )->on( 'roles' );
        } );

        Schema::create( 'permission_user', function ( Blueprint $table )  {
            $table->unsignedBigInteger( 'permission_id' );
            $table->unsignedBigInteger( 'user_id' );
            $table->primary( [ 'user_id', 'permission_id' ] );
            $table->timestamps();
            $table->foreign( 'permission_id' )->references( 'id' )->on( 'permissions' );
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists( 'roles' );
        Schema::dropIfExists( 'permissions' );
        Schema::dropIfExists( 'role_user' );
        Schema::dropIfExists( 'permission_role' );
        Schema::dropIfExists( 'permission_user' );
        Schema::enableForeignKeyConstraints();

    }
}
