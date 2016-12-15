<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddImageMobileFieldsToBannersTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function(Blueprint $table) {

            $table->string('image_mobile_file_name')->nullable();
            $table->integer('image_mobile_file_size')->nullable()->after('image_mobile_file_name');
            $table->string('image_mobile_content_type')->nullable()->after('image_mobile_file_size');
            $table->timestamp('image_mobile_updated_at')->nullable()->after('image_mobile_content_type');

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
                'image_mobile_file_name',
                'image_mobile_file_size',
                'image_mobile_content_type',
                'image_mobile_updated_at',
            ]);
        });
    }

}
