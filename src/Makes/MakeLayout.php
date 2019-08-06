<?php
/**
 * Created by PhpStorm.
 * User: fernandobritofl
 * Date: 4/22/15
 * Time: 11:49 PM
 */

namespace HelloPeterlee\Scaffold\Makes;

use Illuminate\Filesystem\Filesystem;
use HelloPeterlee\Scaffold\Commands\ScaffoldMakeCommand;

class MakeLayout
{
    use MakerTrait;

    /**
     * Create a new instance.
     *
     * @param ScaffoldMakeCommand $scaffoldCommand
     * @param Filesystem $files
     * @return void
     */
    public function __construct(ScaffoldMakeCommand $scaffoldCommand, Filesystem $files)
    {
        $this->files = $files;
        $this->scaffoldCommandObj = $scaffoldCommand;

        $this->start();
    }

    /**
     * Start make layout(view).
     *
     * @return void
     */
    protected function start()
    {
        $this->scaffoldCommandObj->line("\n--- Layouts ---");
//        $ui = $this->scaffoldCommandObj->getMeta()['ui'];
        $meta = $this->scaffoldCommandObj->getMeta();
        $ui = $meta['ui'];

        $this->putViewLayout("Stubs/views/$ui/layout.blade.php.stub", 'layout.blade.php');
        $this->putViewLayout("Stubs/views/$ui/base.blade.php.stub", 'base.blade.php');
        $this->putViewLayout("Stubs/views/$ui/error.blade.php.stub", 'common/error.blade.php');
        $this->putViewLayout("Stubs/views/$ui/_partials/_form_confirm_delete.blade.php.stub", '_partials/_form_confirm_delete.blade.php');
        $this->putViewLayout("Stubs/views/$ui/_partials/_check_all.blade.php.stub", '_partials/_check_all.blade.php');
    }


    /**
     * Write layout in path
     *
     * @param $path_resource
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function putViewLayout($stub, $file)
    {
        $path_file = $this->getPathResource() . $file;
        $path_stub = substr(__DIR__, 0, -5) . $stub;

        $this->makeDirectory($path_file);

        if ($this->files->exists($path_file)) {
            return $this->scaffoldCommandObj->comment("x $path_file");
        }

        if (!$this->files->exists($path_stub)) {
            return $this->scaffoldCommandObj->comment("x :( $path_stub not exist");
        }
        $html = $this->files->get($path_stub);
        $html = $this->buildStub($this->scaffoldCommandObj->getMeta(), $html);
        $this->files->put($path_file, $html);
        $this->scaffoldCommandObj->info("+ $path_file");
    }

    /**
     * Get the path to where we should store the view.
     *
     * @return string
     */
    protected function getPathResource()
    {
        $meta = $this->scaffoldCommandObj->getMeta();
        $module_base_dir = './app/Modules/' . $meta['Module'];
        return $module_base_dir . '/resources/views/';
    }
}