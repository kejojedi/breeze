<?php

namespace Kejojedi\Breeze;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Database;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Router;
use Illuminate\Support\MessageBag;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Factory as ViewFactory;
use Illuminate\View\FileViewFinder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonoLogger;

class Breeze
{
    /** @var Database $database */
    public $database;
    public $title;
    public $parameters = [];
    /** @var MessageBag $errors */
    public $errors;
    public $viewFactory;

    public function __construct()
    {
        include __DIR__ . '/../../../../config.php';
    }

    public function bootstrap()
    {
        session_start();

        $this->connect();
        $this->pagination();
        $this->route();
    }

    public function viewFactory()
    {
        if (!$this->viewFactory) {
            $filesystem = new Filesystem;
            $dispatcher = new Dispatcher(new Container);
            $resolver = new EngineResolver;
            $compiler = new BladeCompiler($filesystem, __DIR__ . '../../views/compiled');

            $resolver->register('blade', function () use ($compiler) {
                return new CompilerEngine($compiler);
            });
            $resolver->register('php', function () {
                return new PhpEngine;
            });

            $finder = new FileViewFinder($filesystem, [__DIR__ . '../../views/templates']);
            $this->viewFactory = new ViewFactory($resolver, $finder, $dispatcher);
        }

        return $this->viewFactory;
    }

    public function connect()
    {
        $database = new Database;
        $database->addConnection([
            'driver' => 'mysql',
            'host' => db_host,
            'port' => db_port,
            'database' => db_name,
            'username' => db_username,
            'password' => db_password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        $database->setAsGlobal();
        $database->bootEloquent();

        $this->database = $database;
    }

    public function pagination()
    {
        LengthAwarePaginator::viewFactoryResolver(function () {
            return $this->viewFactory();
        });
        LengthAwarePaginator::currentPathResolver(function () {
            return isset($_SERVER['REQUEST_URI']) ? strtok($_SERVER['REQUEST_URI'], '?') : '/';
        });
        LengthAwarePaginator::currentPageResolver(function ($pageName = 'page') {
            return isset($_REQUEST[$pageName]) ? $_REQUEST[$pageName] : 1;
        });
    }

    public function route()
    {
        $request = Request::capture();
        $router = new Router(new Dispatcher);
        $filesystem = new Filesystem;

        foreach ($filesystem->allFiles(__DIR__ . '/../../../../app') as $file) {
            $contents = file_get_contents($file->getRealPath());
            preg_match('|route\((.*?)\)|', $contents, $match);

            if (isset($match[1])) {
                $route = trim($match[1], '"\'');
                $router->any($route, function () use ($router, $file) {
                    $this->parameters = $router->getCurrentRoute()->parameters();
                    return include $file->getRealPath();
                });
            }
        }

        $response = $router->dispatch($request);
        $response->send();
    }

    public function view($content)
    {
        return $this->viewFactory()->make('layout', [
            'title' => $this->title,
            'content' => $content,
            'errors' => $this->errors,
        ]);
    }

    public function validate($rules)
    {
        $loader = new FileLoader(new Filesystem, __DIR__ . '../../lang');
        $translator = new Translator($loader, 'en');
        $presence = new DatabasePresenceVerifier($this->database->getDatabaseManager());
        $validation = new ValidationFactory($translator, new Container);

        $validation->setPresenceVerifier($presence);
        $validator = $validation->make($_POST, $rules);

        $this->errors = $validator->errors();

        return $this->errors->isEmpty();
    }

    public function error($name)
    {
        return $this->errors && $this->errors->has($name)
            ? $this->errors->first($name)
            : null;
    }

    public function paginate(LengthAwarePaginator $elements)
    {
        return (string)$elements->appends($_GET)->links('pagination');
    }

    public function logMessage($message)
    {
        $file = __DIR__ . '/../../../../log.txt';

        /** @var MonoLogger $log */
        $log = new Logger(new MonoLogger('Breeze'));
        $log->pushHandler(new StreamHandler($file));
        $log->info($message);
    }
}
