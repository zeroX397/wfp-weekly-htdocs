<?php


error_reporting(E_ERROR | E_PARSE);

define('LARAVEL_START', microtime(true));

require_once __DIR__ . '/../autoload.php';

class LaravelVsCode
{
    public static function relativePath($path)
    {
        if (!str_contains($path, base_path())) {
            return (string) $path;
        }

        return ltrim(str_replace(base_path(), '', realpath($path)), DIRECTORY_SEPARATOR);
    }

    public static function outputMarker($key)
    {
        return '__VSCODE_LARAVEL_' . $key . '__';
    }

    public static function startupError(\Throwable $e)
    {
        throw new Error(self::outputMarker('STARTUP_ERROR') . ': ' . $e->getMessage());
    }
}

try {
    $app = require_once __DIR__ . '/../../bootstrap/app.php';
} catch (\Throwable $e) {
    LaravelVsCode::startupError($e);
    exit(1);
}

$app->register(new class($app) extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        config([
            'logging.channels.null' => [
                'driver' => 'monolog',
                'handler' => \Monolog\Handler\NullHandler::class,
            ],
            'logging.default' => 'null',
        ]);
    }
});

try {
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
} catch (\Throwable $e) {
    LaravelVsCode::startupError($e);
    exit(1);
}

echo LaravelVsCode::outputMarker('START_OUTPUT');

collect(glob(base_path('**/Models/*.php')))->each(fn($file) => include_once($file));

if (class_exists('\phpDocumentor\Reflection\DocBlockFactory')) {
    $factory = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
} else {
    $factory = null;
}

function getMethodDocblocks($method, $factory)
{
    if ($factory !== null) {
        $docblock = $factory->create($method->getDocComment());
        $params = collect($docblock->getTagsByName("param"))->map(fn($p) => (string) $p)->all();
        $return = (string) $docblock->getTagsByName("return")[0] ?? null;

        return [$params, $return];
    }


    $params = collect($method->getParameters())
        ->map(function (\ReflectionParameter $param) {
            $types = match ($param?->getType()) {
                null => [],
                default => method_exists($param->getType(), "getTypes")
                    ? $param->getType()->getTypes()
                    : [$param->getType()]
            };

            $types = collect($types)
                ->filter()
                ->values()
                ->map(fn($t) => $t->getName());

            return trim($types->join("|") . " $" . $param->getName());
        })
        ->all();

    $return = $method->getReturnType()?->getName();

    return [$params, $return];
}

function getBuilderMethod($method, $factory)
{
    [$params, $return] = getMethodDocblocks($method, $factory);

    return [
        "name" => $method->getName(),
        "parameters" => $params,
        "return" => $return,
    ];
};

function getModelInfo($className, $factory)
{
    $output = new \Symfony\Component\Console\Output\BufferedOutput();

    try {
        \Illuminate\Support\Facades\Artisan::call(
            "model:show",
            [
                "model" => $className,
                "--json" => true,
            ],
            $output
        );
    } catch (\Exception | \Throwable $e) {
        return null;
    }

    $data = json_decode($output->fetch(), true);

    if ($data === null) {
        return null;
    }

    $reflection = (new \ReflectionClass($className));

    if ($factory !== null && ($comment = $reflection->getDocComment())) {
        $docblock = $factory->create($comment);
        $existingProperties = collect($docblock->getTagsByName("property"))->map(fn($p) => $p->getVariableName());
        $existingReadProperties = collect($docblock->getTagsByName("property-read"))->map(fn($p) => $p->getVariableName());
        $existingProperties = $existingProperties->merge($existingReadProperties);
    } else {
        $existingProperties = collect();
    }

    $data['attributes'] = collect($data['attributes'])
        ->map(fn($attrs) => array_merge($attrs, [
            'title_case' => str_replace('_', '', \Illuminate\Support\Str::title($attrs['name'])),
            'documented' => $existingProperties->contains($attrs['name']),
        ]))
        ->toArray();

    $data['scopes'] = collect($reflection->getMethods())
        ->filter(fn($method) => $method->isPublic() && !$method->isStatic() && $method->name !== '__construct')
        ->filter(fn($method) => str_starts_with($method->name, 'scope'))
        ->map(fn($method) => str_replace('scope', '', $method->name))
        ->map(fn($method) => strtolower(substr($method, 0, 1)) . substr($method, 1))
        ->values()
        ->toArray();

    $data['uri'] = $reflection->getFileName();

    return [
        $className => $data,
    ];
}

$reflection = new \ReflectionClass(\Illuminate\Database\Query\Builder::class);
$builderMethods = collect($reflection->getMethods(\ReflectionMethod::IS_PUBLIC))
    ->filter(fn(ReflectionMethod $method) => !str_starts_with($method->getName(), "__"))
    ->map(fn(\ReflectionMethod $method) => getBuilderMethod($method, $factory))
    ->filter()
    ->values();

echo collect([
    'builderMethods' => $builderMethods,
    'models' => collect(get_declared_classes())
        ->filter(fn($class) => is_subclass_of($class, \Illuminate\Database\Eloquent\Model::class))
        ->filter(fn($class) => !in_array($class, [\Illuminate\Database\Eloquent\Relations\Pivot::class, \Illuminate\Foundation\Auth\User::class]))
        ->values()
        ->flatMap(fn(string $className) => getModelInfo($className, $factory))
        ->filter(),
])->toJson();

echo LaravelVsCode::outputMarker('END_OUTPUT');

exit(0);
