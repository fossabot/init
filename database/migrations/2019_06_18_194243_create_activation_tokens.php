<?php
    
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;
    
    class CreateActivationTokens extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('activation_tokens', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('user_id')->unique()->index();
                $table->string('token', 100)->unique()->index();
                $table->timestamp('used_at')->nullable()->index();
                $table->timestamps();
                $table->softDeletes();
            });
        }
        
        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('activation_tokens');
        }
    }
