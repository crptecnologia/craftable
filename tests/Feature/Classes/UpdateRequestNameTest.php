<?php

namespace Brackets\AdminGenerator\Tests\Feature\Classes;

use Brackets\AdminGenerator\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateRequestNameTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function update_request_generation_should_generate_an_update_request_name(): void
    {
        $filePath = base_path('Modules/Category/Http/Requests/Category/UpdateCategory.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:request:update', [
            'module' => 'category',
            'table_name' => 'categories'
        ]);

        $this->assertFileExists($filePath);
        $this->assertFileStartWith('<?php

namespace Modules\Category\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateCategory extends FormRequest', $filePath);
    }

    /** @test */
    public function is_generated_correct_name_for_custom_model_name(): void
    {
        $filePath = base_path('Modules/Category/Http/Requests/Billing/Cat/UpdateCat.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:request:update', [
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

class UpdateCat extends FormRequest', $filePath);
    }
}
