<?php

namespace Brackets\AdminGenerator\Tests\Feature\Appenders;

use Brackets\AdminGenerator\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\File;

class ModelFactoryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function factory_generator_should_auto_generate_everything_from_table(): void
    {
        $filePath = base_path('Modules/Category/Database/factories/ModelFactory.php');

        $this->artisan('admin:generate:factory', [
            'module' => 'category',
            'table_name' => 'categories'
        ]);

        $this->assertFileStartWith('<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Modules\Category\Entities\Category::class', $filePath);
    }

    /** @test */
    public function you_can_specify_a_model_name(): void
    {
        $filePath = base_path('Modules/Category/Database/factories/ModelFactory.php');

        $this->artisan('admin:generate:factory', [
            'module' => 'category',
            'table_name' => 'categories',
            '--model-name' => 'Billing\\Cat',
        ]);

        $this->assertStringStartsWith('<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Modules\Category\Entities\Billing\Cat::class', File::get($filePath));
    }

    /** @test */
    public function you_can_specify_a_model_name_outside_default_folder(): void
    {
        $filePath = base_path('Modules/Category/Database/factories/ModelFactory.php');

        $this->artisan('admin:generate:factory', [
            'module' => 'category',
            'table_name' => 'categories',
            '--model-name' => 'Modules\Category\Entities\Billing\MyCat',
        ]);

        $this->assertStringStartsWith('<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Modules\Category\Entities\Billing\MyCat::class', File::get($filePath));
    }

}
