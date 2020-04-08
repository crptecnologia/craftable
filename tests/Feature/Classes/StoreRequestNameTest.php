<?php

namespace Brackets\AdminGenerator\Tests\Feature\Classes;

use Brackets\AdminGenerator\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\File;

class StoreRequestNameTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function store_request_generation_should_generate_a_store_request_name(): void
    {
        $filePath = base_path('Modules/Category/Http/Requests/Category/StoreCategory.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:request:store', [
            'module' => 'Category',
            'table_name' => 'categories'
        ]);

        $this->assertFileExists($filePath);

        $this->assertFileStartWith('<?php

namespace Modules\Category\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreCategory extends FormRequest', $filePath);
    }

    /** @test */
    public function is_generated_correct_name_for_custom_model_name(): void
    {
        $filePath = base_path('Modules/Category/Http/Requests/Billing/Cat/StoreCat.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:request:store', [
            'module' => 'category',
            'table_name' => 'categories',
            '--model-name' => 'Billing\\Cat',
        ]);

        $this->assertFileExists($filePath);
        $this->assertFileStartWith('<?php

namespace Modules\Category\Http\Requests\Billing\Cat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreCat extends FormRequest', $filePath);
    }

    /** @test */
    public function is_generated_correct_name_for_custom_model_name_outside_default_folder(): void
    {
        $filePath = base_path('Modules/Category/Http/Requests/Billing/Cat/StoreCat.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:request:store', [
            'module' => 'category',
            'table_name' => 'categories',
            '--model-name' => 'Billing\\Cat',
        ]);

        $this->assertFileExists($filePath);
        $this->assertFileStartWith('<?php

namespace Modules\Category\Http\Requests\Billing\Cat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreCat extends FormRequest', $filePath);
    }
}
