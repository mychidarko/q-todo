<?php 
    namespace App\Database\Migrations;
    
    use Leaf\Database;
    
    class CreateTodos extends Database {
        public function __construct() {
            parent::__construct();
        }
        
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()  {
            if(!$this->capsule::schema()->hasTable("todos")):
                $this->capsule::schema()->create("todos", function ($table) {
                    $table->increments('id');
                    $table->string('user_id');
                    $table->string('todo');
                    $table->timestamps();
                });
            endif;
        }
        
        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            $this->capsule::schema()->dropIfExists("todos");
        }
    }