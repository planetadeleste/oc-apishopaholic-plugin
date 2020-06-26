<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Console;

use October\Rain\Scaffold\GeneratorCommand;
use October\Rain\Support\Str;

class CreateApiController extends GeneratorCommand
{
    /**
     * @var string The console command name.
     */
    protected $name = 'apishopaholic:create:controller';

    /**
     * @var string The console command description.
     */
    protected $description = 'Create a new Api controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Api Controller';

    /**
     * A mapping of stub to generated file.
     *
     * @var array
     */
    protected $stubs = [
        'controller/controller.stub' => 'controller/api/{{studly_name}}.php',
    ];

    /**
     * @inheritDoc
     */
    protected function prepareVars()
    {
        $pluginCode = $this->argument('plugin');

        $parts = explode('.', $pluginCode);
        $plugin = array_pop($parts);
        $author = array_pop($parts);

        $controller = $this->argument('controller');

        /*
         * Determine the model name to use,
         * either supplied or singular from the controller name.
         */
        $model = $this->option('model');
        if (!$model) {
            $model = Str::singular($controller);
        }

        return [
            'name' => $controller,
            'model' => $model,
            'author' => $author,
            'plugin' => $plugin
        ];
    }
}
