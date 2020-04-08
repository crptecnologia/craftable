<?php

namespace Brackets\AdminGenerator\Tests\Feature\Appenders;

use Brackets\AdminGenerator\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\File;

class LangTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function auto_generated_lang_append(): void
    {
        $filePath = base_path('Modules/Category/Resources/lang/en/category.php');

        $this->artisan('admin:generate:lang', [
            'table_name' => 'categories',
            'module' => 'category'
        ]);

        $this->assertFileStartWith('<?php

return [
    \'category\' => [
        \'title\' => \'Categories\',

        \'actions\' => [
            \'index\' => \'Categories\',
            \'create\' => \'New Category\',
            \'edit\' => \'Edit :name\',
        ],

        \'columns\' => [
            \'id\' => \'ID\',
            \'title\' => \'Title\',
            
        ],
    ],

    // Do not delete me :) I\'m used for auto-generation
];', $filePath);
    }

    /** @test */
    public function namespaced_model_lang_append(): void
    {
        $filePath = base_path('Modules/Category/Resources/lang/en/category.php');

        $this->artisan('admin:generate:lang', [
            'module' => 'category',
            'table_name' => 'categories',
            '--model-name' => 'Billing\\CategOry',
        ]);

        $this->assertFileStartWith('<?php

return [
    \'billing_categ-ory\' => [
        \'title\' => \'Categories\',

        \'actions\' => [
            \'index\' => \'Categories\',
            \'create\' => \'New Category\',
            \'edit\' => \'Edit :name\',
        ],

        \'columns\' => [
            \'id\' => \'ID\',
            \'title\' => \'Title\',
            
        ],
    ],

    // Do not delete me :) I\'m used for auto-generation
];', $filePath);
    }

}
