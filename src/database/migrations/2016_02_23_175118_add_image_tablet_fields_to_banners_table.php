<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddImageTabletFieldsToBannersTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function(Blueprint $table) {

            $table->string('image_tablet_file_name')->nullable();
            $table->integer('image_tablet_file_size')->nullable()->after('image_tablet_file_name');
            $table->string('image_tablet_content_type')->nullable()->after('image_tablet_file_size');
            $table->timestamp('image_tablet_updated_at')->nullable()->after('image_tablet_content_type');

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
                'image_tablet_file_name',
                'image_tablet_file_size',
                'image_tablet_content_type',
                'image_tablet_updated_at',
            ]);
        });
    }

}
