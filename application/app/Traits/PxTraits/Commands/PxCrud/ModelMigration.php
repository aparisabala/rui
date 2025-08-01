<?php
namespace App\Traits\PxTraits\Commands\PxCrud;
use File;
trait ModelMigration
{
    public function MakeModelMigration()
    {
       $d = $this->getDefaults();
       $model = $d['model'];
       $tableName = $d['tableName'];
       $path = base_path("App\\Models") . "\\" . $model . '.php';
        if (!File::exists($path)) {
            $modelContent = $this->ModelContent($model,$tableName);
            File::put($path, $modelContent);
            $this->info("Model " . $model . " created ");
            $timestamp = date('Y_m_d_His');
            $filename = "{$timestamp}_create_{$tableName}_table.php";
            $migPath = base_path("database\\migrations") . "\\" . $filename;
            if(!File::exists($migPath)) {
                $migContent = $this->MigrationContent($model,$tableName);
                File::put($migPath, $migContent);
            }
            $this->info("Migration for " . $model . " created");
        } 
    }

    public function ModelContent($model, $tableName)
    {
        $codeString = <<<PHP
        <?php

        namespace App\Models;

        use App\Traits\BaseTrait;
        use Illuminate\Database\Eloquent\Model;

        //place
        class $model extends Model
        {
            
            use BaseTrait;
            protected \$table = '$tableName';

        }
        PHP;
        return $codeString;
    }

    public function MigrationContent($model, $tableName)
    {
        $codeString = <<<PHP
        <?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        return new class extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create('$tableName', function (Blueprint \$table) {
                    \$table->id();
                    \$table->uuid('uuid');
                    \$table->string('name');
                    \$table->timestamps();
                });
            }

            /**
             * Reverse the migrations.
             *
             * @return void
             */
            public function down()
            {
                Schema::dropIfExists('$tableName');
            }
        };

        PHP;
        return $codeString;
    }

}
