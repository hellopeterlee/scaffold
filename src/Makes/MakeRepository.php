<?php
/**
 * Created by PhpStorm.
 * User: peirenlei
 * Date: 2018/7/16
 * Time: 17:21
 */

namespace PeterLee\Scaffold\Makes;

use PeterLee\Scaffold\Commands\ScaffoldMakeCommand;
use Illuminate\Filesystem\Filesystem;

class MakeRepository
{
    use MakerTrait;

    /**
     * Store name from Model
     *
     * @var ScaffoldMakeCommand
     */
    protected $scaffoldCommandObj;

    /**
     * Create a new instance.
     *
     * @param ScaffoldMakeCommand $scaffoldCommand
     * @param Filesystem $files
     * @return void
     */
    function __construct(ScaffoldMakeCommand $scaffoldCommand, Filesystem $files)
    {
        $this->files = $files;
        $this->scaffoldCommandObj = $scaffoldCommand;

        $this->start();
    }

    private function start()
    {
        //Repository
        $interface_name = $this->scaffoldCommandObj->getObjName('Name') . 'Repository';
        $interface_path = $this->getPath($interface_name, 'repository');
        if ($this->files->exists($interface_path))
        {
            return $this->scaffoldCommandObj->comment("x " . $interface_path);
        }
        $this->makeDirectory($interface_path);
        $this->files->put($interface_path, $this->compileRepositoryStub('Stubs/repository.stub'));
        $this->scaffoldCommandObj->info('+ ' . $interface_path);

        //RepositoryEloquent
        $name = $this->scaffoldCommandObj->getObjName('Name') . 'RepositoryEloquent';
        $path = $this->getPath($name, 'repository_eloquent');
        if ($this->files->exists($path))
        {
            return $this->scaffoldCommandObj->comment("x " . $path);
        }
        $this->makeDirectory($path);
        $this->files->put($path, $this->compileRepositoryStub('Stubs/repository_eloquent.stub'));
        $this->scaffoldCommandObj->info('+ ' . $path);
    }

    protected function compileRepositoryStub($stub_name)
    {
        $stub = $this->files->get(substr(__DIR__,0, -5) . $stub_name);
        $this->buildStub($this->scaffoldCommandObj->getMeta(), $stub);
        return $stub;
    }
}