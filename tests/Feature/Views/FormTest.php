<?php

namespace Brackets\AdminGenerator\Tests\Feature\Views;

use Brackets\AdminGenerator\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\File;

class FormTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function view_form_should_get_auto_generated(): void
    {
        $elementsPath = base_path('Modules/Category/Resources/views/category/components/form-elements.blade.php');
        $createPath = base_path('Modules/Category/Resources/views/category/create.blade.php');
        $editPath = base_path('Modules/Category/Resources/views/category/edit.blade.php');
        $formJsPath = base_path('Modules/Category/Resources/js/category/Form.js');
        $indexJsPath = base_path('Modules/Category/Resources/js/category/index.js');
        $bootstrapJsPath = base_path('Modules/Category/Resources/js/index.js');

        $this->assertFileNotExists($elementsPath);
        $this->assertFileNotExists($createPath);
        $this->assertFileNotExists($editPath);
        $this->assertFileNotExists($formJsPath);
        $this->assertFileNotExists($indexJsPath);
        $this->assertFileNotExists($bootstrapJsPath);

        $this->artisan('admin:generate:form', [
            'module' => 'category',
            'table_name' => 'categories'
        ]);

        $this->assertFileExists($elementsPath);
        $this->assertFileExists($createPath);
        $this->assertFileExists($editPath);
        $this->assertFileExists($formJsPath);
        $this->assertFileExists($indexJsPath);
        $this->assertFileExists($bootstrapJsPath);
        $this->assertStringStartsWith('<div ', File::get($elementsPath));
        $this->assertStringStartsWith('@extends(\'brackets/admin-ui::admin.layout.default\')', File::get($createPath));
        $this->assertStringStartsWith('@extends(\'brackets/admin-ui::admin.layout.default\')', File::get($editPath));
        $this->assertStringStartsWith('import AppForm from \'../../../../../Core/Resources/assets/js/app-components/Form/AppForm\';

Vue.component(\'category-form\', {
    mixins: [AppForm]', File::get($formJsPath));
        $this->assertStringStartsWith('import \'./Form\'', File::get($indexJsPath));
        $this->assertStringStartsWith('import \'./category\';', File::get($bootstrapJsPath));
    }

    /** @test */
    public function view_form_should_get_generated_with_custom_model(): void
    {


        $elementsPath = base_path('Modules/Category/Resources/views/billing/my-article/components/form-elements.blade.php');
        $createPath = base_path('Modules/Category/Resources/views/billing/my-article/create.blade.php');
        $editPath = base_path('Modules/Category/Resources/views/billing/my-article/edit.blade.php');
        $formJsPath = base_path('Modules/Category/Resources/js/billing-my-article/Form.js');
        $indexJsPath = base_path('Modules/Category/Resources/js/billing-my-article/index.js');
        $bootstrapJsPath = base_path('Modules/Category/Resources/js/index.js');

        $this->assertFileNotExists($elementsPath);
        $this->assertFileNotExists($createPath);
        $this->assertFileNotExists($editPath);
        $this->assertFileNotExists($formJsPath);
        $this->assertFileNotExists($indexJsPath);
        $this->assertFileNotExists($bootstrapJsPath);

        $this->artisan('admin:generate:form', [
            'module' => 'category',
            'table_name' => 'categories',
            '--model-name' => 'Billing\\MyArticle'
        ]);

        $this->assertFileExists($elementsPath);
        $this->assertFileExists($createPath);
        $this->assertFileExists($editPath);
        $this->assertFileExists($formJsPath);
        $this->assertFileExists($indexJsPath);
        $this->assertFileExists($bootstrapJsPath);
        $this->assertStringStartsWith('<div ', File::get($elementsPath));
        $this->assertStringStartsWith('@extends(\'brackets/admin-ui::admin.layout.default\')', File::get($createPath));
        $this->assertStringStartsWith('@extends(\'brackets/admin-ui::admin.layout.default\')', File::get($editPath));
        $this->assertStringStartsWith('import AppForm from \'../../../../../Core/Resources/assets/js/app-components/Form/AppForm\';

Vue.component(\'billing-my-article-form\', {
    mixins: [AppForm]', File::get($formJsPath));
        $this->assertStringStartsWith('import \'./Form\'', File::get($indexJsPath));
        $this->assertStringStartsWith('import \'./billing-my-article\';', File::get($bootstrapJsPath));
    }
}
