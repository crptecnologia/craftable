<?php

namespace Brackets\AdminGenerator\Tests\Feature\Classes;

use Brackets\AdminGenerator\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\File;

class ControllerNameTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function controller_should_be_generated_under_default_namespace(): void
    {
        $filePath = base_path('Modules/Category/Http/Controllers/CategoriesController.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:controller', [
            'module' => 'category',
            'table_name' => 'categories'
        ]);

        $this->assertFileExists($filePath);

        $expected = '<?php

namespace Modules\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Category\Http\Requests\Category\BulkDestroyCategory;
use Modules\Category\Http\Requests\Category\DestroyCategory;
use Modules\Category\Http\Requests\Category\IndexCategory;
use Modules\Category\Http\Requests\Category\StoreCategory;
use Modules\Category\Http\Requests\Category\UpdateCategory;
use Modules\Category\Entities\Category;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CategoriesController extends Controller';

        $this->assertEquals($expected, substr(File::get($filePath), 0, mb_strlen($expected)));
    }

    /** @test */
    public function controller_name_can_be_namespaced(): void
    {
        $filePath = base_path('Modules/Category/Http/Controllers/Billing/MyNameController.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:controller', [
            'module' => 'category',
            'table_name' => 'categories',
            'class_name' => 'Billing\\MyNameController',
        ]);

        $this->assertFileExists($filePath);

        $expected = '<?php

namespace Modules\Category\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use Modules\Category\Http\Requests\Category\BulkDestroyCategory;
use Modules\Category\Http\Requests\Category\DestroyCategory;
use Modules\Category\Http\Requests\Category\IndexCategory;
use Modules\Category\Http\Requests\Category\StoreCategory;
use Modules\Category\Http\Requests\Category\UpdateCategory;
use Modules\Category\Entities\Category;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MyNameController extends Controller';

        $this->assertEquals($expected, substr(File::get($filePath), 0, mb_strlen($expected)));
    }

    /** @test */
    public function you_can_generate_controller_outside_default_directory(): void
    {
        $filePath = base_path('Modules/Category/Http/Controllers/Billing/CategoriesController.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:controller', [
            'module' => 'Category',
            'table_name' => 'categories',
            'class_name' => 'Billing\\CategoriesController',

        ]);

        $this->assertFileExists($filePath);

        $expected = '<?php

namespace Modules\Category\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use Modules\Category\Http\Requests\Category\BulkDestroyCategory;
use Modules\Category\Http\Requests\Category\DestroyCategory;
use Modules\Category\Http\Requests\Category\IndexCategory;
use Modules\Category\Http\Requests\Category\StoreCategory;
use Modules\Category\Http\Requests\Category\UpdateCategory;
use Modules\Category\Entities\Category;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CategoriesController extends Controller';

        $this->assertEquals($expected, substr(File::get($filePath), 0, mb_strlen($expected)));
    }

    /** @test */
    public function you_can_pass_a_model_class_name(): void
    {
        $filePath = base_path('Modules/Category/Http/Controllers/Billing/CategoriesController.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:controller', [
            'table_name' => 'categories',
            'class_name' => 'Modules\\Category\\Http\\Controllers\\Billing\\CategoriesController',
            '--model-name' => 'Billing\\Cat',
            'module' => 'category',
        ]);

        $this->assertFileExists($filePath);

        $expected = '<?php

namespace Modules\Category\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use Modules\Category\Http\Requests\Billing\Cat\BulkDestroyCat;
use Modules\Category\Http\Requests\Billing\Cat\DestroyCat;
use Modules\Category\Http\Requests\Billing\Cat\IndexCat;
use Modules\Category\Http\Requests\Billing\Cat\StoreCat;
use Modules\Category\Http\Requests\Billing\Cat\UpdateCat;
use Modules\Category\Entities\Billing\Cat;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CategoriesController extends Controller';

        $this->assertEquals($expected, mb_substr(File::get($filePath), 0, mb_strlen($expected)));
    }

}
