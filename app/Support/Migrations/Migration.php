<?php
namespace App\Support\Migrations;

use Noodlehaus\Config;
use Illuminate\Database\Capsule\Manager as Capsule;
use Phinx\Migration\AbstractMigration;

class Migration extends AbstractMigration
{
    /** @var \Illuminate\Database\Capsule\Manager $capsule */
    public $capsule;

    /** @var \Illuminate\Database\Schema\Builder $capsule */
    public $schema;

 
    public function init()
    {
        $database = new Config(
            base_path('config/Database.php')
        );

        $this->capsule = new Capsule;
        $this->capsule->addConnection($database->get('db'));
        $this->capsule->bootEloquent();
        $this->capsule->setAsGlobal();
        $this->schema = $this->capsule->schema();
    }
}
