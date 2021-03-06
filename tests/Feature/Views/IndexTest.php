<?php

namespace Brackets\AdminGenerator\Tests\Feature\Views;

use Brackets\AdminGenerator\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\File;

class IndexTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function index_listing_should_get_auto_generated(): void
    {
        $indexPath = base_path('Modules/Category/Resources/views/category/index.blade.php');
        $listingJsPath = base_path('Modules/Category/Resources/js/category/Listing.js');
        $indexJsPath = base_path('Modules/Category/Resources/js/category/index.js');
        $bootstrapJsPath = base_path('Modules/Category/Resources/js/index.js');

        $this->assertFileNotExists($indexPath);
        $this->assertFileNotExists($listingJsPath);
        $this->assertFileNotExists($indexJsPath);

        $this->artisan('admin:generate:index', [
            'module' => 'category',
            'table_name' => 'categories'
        ]);

        $this->assertFileExists($indexPath);
        $this->assertFileExists($listingJsPath);
        $this->assertFileExists($indexJsPath);
        $this->assertStringStartsWith('@extends(\'brackets/admin-ui::admin.layout.default\')', File::get($indexPath));
        $this->assertStringStartsWith('import AppListing from \'../../../../../Core/Resources/assets/js/app-components/Listing/AppListing\';

Vue.component(\'category-listing\', {
    mixins: [AppListing]
});', File::get($listingJsPath));
        $this->assertStringStartsWith('import \'./Listing\'', File::get($indexJsPath));
        $this->assertStringStartsWith('import \'./category\';', File::get($bootstrapJsPath));
    }

    /** @test */
    public function index_listing_should_get_auto_generated_with_custom_model(): void
    {
        $indexPath = base_path('Modules/Category/Resources/views/billing/my-article/index.blade.php');
        $listingJsPath = base_path('Modules/Category/Resources/js/billing-my-article/Listing.js');
        $indexJsPath = base_path('Modules/Category/Resources/js/billing-my-article/index.js');
        $bootstrapJsPath = base_path('Modules/Category/Resources/js/index.js');



        $this->assertFileNotExists($indexPath);
        $this->assertFileNotExists($listingJsPath);
        $this->assertFileNotExists($indexJsPath);

        $this->artisan('admin:generate:index', [
            'module' => 'category',
            'table_name' => 'categories',
            '--model-name' => 'Billing\\MyArticle'
        ]);

        $this->assertFileExists($indexPath);
        $this->assertFileExists($listingJsPath);
        $this->assertFileExists($indexJsPath);
        $this->assertStringStartsWith('@extends(\'brackets/admin-ui::admin.layout.default\')', File::get($indexPath));
        $this->assertStringStartsWith('import AppListing from \'../../../../../Core/Resources/assets/js/app-components/Listing/AppListing\';

Vue.component(\'billing-my-article-listing\', {
    mixins: [AppListing]
});', File::get($listingJsPath));

        $this->assertStringStartsWith('import \'./Listing\';', File::get($indexJsPath));
        $this->assertStringStartsWith('import \'./billing-my-article\';', File::get($bootstrapJsPath));
    }
}
