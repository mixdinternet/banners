<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddImageDesktopFieldsToBannersTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function(Blueprint $table) {

            $table->string('image_desktop_file_name')->nullable();
            $table->integer('image_desktop_file_size')->nullable()->after('image_desktop_file_name');
            $table->string('image_desktop_content_type')->nullable()->after('image_desktop_file_size');
            $table->timestamp('image_desktop_updated_at')->nullable()->after('image_desktop_content_type');

        });

    }

    /**
     * Revert the changes to the table.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banners', function(Blueprint $table) {
            $table->dropColumn([
                'image_desktop_file_name',
                'image_desktop_file_size',
                'image_desktop_content_type',
                'image_desktop_updated_at'
            ]);
        });
    }

}
