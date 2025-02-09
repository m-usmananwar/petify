<?php

use App\Enum\AuctionStatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('color')->nullable();
            $table->string('age')->nullable();
            $table->string('type')->nullable();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('status')->default(AuctionStatusEnum::PENDING->value);
            $table->string('tag_line')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('initial_price', 10, 2);
            $table->dateTime('start_time')->nullable();
            $table->dateTime('expiry_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auctions');
    }
};
