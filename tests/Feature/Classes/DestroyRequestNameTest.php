<?php

namespace Brackets\AdminGenerator\Tests\Feature\Classes;

use Brackets\AdminGenerator\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\File;

class DestroyRequestNameTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function destroy_request_generation_should_generate_an_update_request_name(): void
    {
        $filePath = base_path('Modules/Category/Http/Requests/Category/DestroyCategory.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:request:destroy', [
            'table_name' => 'categories',
            'module' => 'Category',
        ]);

        $this->assertFileExists($filePath);
        $expected = '<?php

namespace Modules\Category\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DestroyCategory extends FormRequest';

        $this->assertEquals($expected, mb_substr(File::get($filePath), 0, mb_strlen($expected)));
    }

    /** @test */
    public function is_generated_correct_name_for_custom_model_name_in_destroy_request(): void
    {
        $filePath = base_path('Modules/Category/Http/Requests/Billing/Cat/DestroyCat.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:request:destroy', [
            'table_name' => 'categories',
            'module' => 'Category',
            '--model-name' => 'Billing\\Cat',
        ]);

        $this->assertFileExists($filePath);

        $expected = '<?php

namespace Modules\Category\Http\Requests\Billing\Cat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DestroyCat extends FormRequest';

        $this->assertEquals($expected, mb_substr(File::get($filePath), 0, mb_strlen($expected)));
    }
}
