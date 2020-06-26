<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Console;

use October\Rain\Scaffold\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateResource extends GeneratorCommand
{
    /**
     * @var string The console command name.
     */
    protected $name = 'apishopaholic:create:resource';

    /**
     * @var string The console command description.
     */
    protected $description = 'Create a new Api resource elements';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Resource';

    protected $arColumns = [];

    /**
     * A mapping of stub to generated file.
     *
     * @var array
     */
    protected $stubs = [
        'resource/IndexCollection.stub' => 'classes/resource/{{lower_name}}/IndexCollection.php',
        'resource/ListCollection.stub'  => 'classes/resource/{{lower_name}}/ListCollection.php',
        'resource/ItemResource.stub'    => 'classes/resource/{{lower_name}}/ItemResource.php',
        'resource/ShowResource.stub'    => 'classes/resource/{{lower_name}}/ShowResource.php',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->vars = $this->processVars($this->prepareVars());
        $this->vars['images'] = $bImages = !!$this->option('add-images');
        $this->vars['preview_image'] = $bPreviewImage = !!$this->option('add-preview-image');
        if ($bImages) {
            $this->arColumns[] = 'images';
        }
        if ($bPreviewImage) {
            $this->arColumns[] = 'preview_image';
        }
        $this->vars['attributes'] = $this->arColumns;

        $this->makeStubs();

        $this->info($this->type.' created successfully.');
    }


    /**
     * Prepare variables for stubs.
     *
     * return @array
     */
    protected function prepareVars()
    {
        $sMainPluginCode = $this->argument('plugin');
        $sExpansionPluginCode = $this->argument('expansion_plugin');

        $arMainParts = explode('.', $sMainPluginCode);
        $sMainPlugin = array_pop($arMainParts);
        $sMainAuthor = array_pop($arMainParts);

        $arExpansionParts = explode(".", $sExpansionPluginCode);
        $sExpansionPlugin = array_pop($arExpansionParts);
        $sExpansionAuthor = array_pop($arExpansionParts);

        $sModel = $this->argument('model');

        /** @var \Model $obModel */
        $obModel = app(join("\\", [$sExpansionAuthor, $sExpansionPlugin, 'Models', $sModel]));
        if ($obModel) {
            $this->arColumns = $obModel->getConnection()->getSchemaBuilder()->getColumnListing($obModel->getTable());
        }

        return [
            'name'             => $sModel,
            'author'           => $sMainAuthor,
            'plugin'           => $sMainPlugin,
            'expansion_author' => $sExpansionAuthor,
            'expansion_plugin' => $sExpansionPlugin
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['plugin', InputArgument::REQUIRED, 'The name of your plugin to create. Eg: Author.MyPlugin'],
            ['expansion_plugin', InputArgument::REQUIRED, 'The name of the other plugin. Eg: Lovata.Shopaholic'],
            ['model', InputArgument::REQUIRED, 'The name of the model. Eg: Product'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Overwrite existing files with generated ones.'],
            ['add-images', null, InputOption::VALUE_NONE, 'Add images relation.'],
            ['add-preview-image', null, InputOption::VALUE_NONE, 'Add preview_image relation.'],
        ];
    }
}
