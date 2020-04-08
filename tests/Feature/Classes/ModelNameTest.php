<?php

namespace Brackets\AdminGenerator\Tests\Feature\Classes;

use Brackets\AdminGenerator\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ModelNameTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function model_name_should_auto_generate_from_table_name(): void
    {
        $filePath = base_path('Modules/Category/Entities/Category.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:model', [
            'module' => 'category',
            'table_name' => 'categories'
        ]);

        $this->assertFileExists($filePath);
        $this->assertFileStartWith('<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model', $filePath);
    }

    /** @test */
    public function you_can_pass_custom_class_name_for_the_model(): void
    {
        $filePath = base_path('Modules/Category/Entities/Billing/Category.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:model', [
            'module' => 'category',
            'table_name' => 'categories',
            'class_name' => 'Billing\\Category',
        ]);

        $this->assertFileExists($filePath);
        $this->assertFileStartWith('<?php

namespace Modules\Category\Entities\Billing;

use Illuminate\Database\Eloquent\Model;

class Category extends Model', $filePath);
    }

    /** @test */
    public function class_name_can_be_outside_default_folder(): void
    {
        $filePath = base_path('Modules/Category/Entities/Billing/Category.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:model', [
            'module' => 'category',
            'table_name' => 'categories',
            'class_name' => 'Billing\\Category',
        ]);

        $this->assertFileExists($filePath);
        $this->assertFileStartWith('<?php

namespace Modules\Category\Entities\Billing;

use Illuminate\Database\Eloquent\Model;

class Category extends Model', $filePath);
    }

}
