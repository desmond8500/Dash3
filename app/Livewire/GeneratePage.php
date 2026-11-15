<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use ReflectionClass;
use ReflectionMethod;

class GeneratePage extends Component
{
    function mount(){
        $this->models = $this->get_models();
    }

    function load_models(){
        $this->models = $this->get_models();
    }

    public function render()
    {
        return view('livewire.generate-page');
    }


    public array $models = [];
    public ?string $selectedModel = null;
    public string $modelContent = '';
    public array $fillable = [];
    public array $relations = [];
    public array $methods = [];
    public array $modelAttributes = [
        [
            'name' => '',
            'type' => 'string',
            'nullable' => false,
        ],
    ];

    function get_models(){
        return collect(File::files(app_path('Models')))
            ->filter(fn($file) => $file->getExtension() === 'php')
            ->map(fn($file) => $file->getFilenameWithoutExtension())
            ->sort()
            ->values()
            ->toArray();
    }

    public function updatedSelectedModel(): void
    {
        if (!$this->selectedModel) {
            $this->modelContent = '';
            $this->fillable = [];
            return;
        }

        $path = app_path('Models/' . $this->selectedModel . '.php');

        if (File::exists($path)) {
            $this->modelContent = File::get($path);
        } else {
            $this->modelContent = '';
        }
        $this->fillable = $this->getFillableAttributes();
        $this->relations = $this->getRelations();
        $this->methods = $this->getOtherMethods();
    }

    public function getFillableAttributes(): array
    {
        if (!$this->selectedModel) {
            return [];
        }

        $class = 'App\\Models\\' . $this->selectedModel;

        if (!class_exists($class)) {
            return [];
        }

        return collect((new $class)->getFillable())
            ->map(fn($attribute) => [
                'name' => $attribute,
                'label' => str($attribute)->replace('_', ' ')->title()->toString(),
                'type' => 'text',
            ])
            ->values()
            ->toArray();
    }

    public function getRelations(): array
    {
        if (!$this->selectedModel) {
            return [];
        }

        $class = 'App\\Models\\' . $this->selectedModel;

        if (!class_exists($class)) {
            return [];
        }

        $reflection = new ReflectionClass($class);
        $relations = [];

        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {

            // Ignorer les méthodes héritées de Model
            if ($method->getDeclaringClass()->getName() !== $class) {
                continue;
            }

            // Les relations n'ont normalement pas de paramètres
            if ($method->getNumberOfParameters() > 0) {
                continue;
            }

            try {
                $result = $method->invoke(new $class);

                if ($result instanceof Relation) {
                    $relations[] = [
                        'name' => $method->getName(),
                        'type' => class_basename($result),
                        'related' => $result->getRelated()::class,
                    ];
                }
            } catch (\Throwable $e) {
                // Ignorer les méthodes qui ne sont pas des relations
            }
        }

        return $relations;
    }

    public function getOtherMethods(): array
    {
        if (!$this->selectedModel) {
            return [];
        }

        $class = 'App\\Models\\' . $this->selectedModel;

        if (!class_exists($class)) {
            return [];
        }

        $reflection = new ReflectionClass($class);
        $model = new $class;

        return collect($reflection->getMethods(ReflectionMethod::IS_PUBLIC))
            ->filter(
                fn($method) =>
                $method->getDeclaringClass()->getName() === $class
            )
            ->filter(function ($method) use ($model) {

                if ($method->getNumberOfParameters() > 0) {
                    return true;
                }

                try {
                    return !($method->invoke($model) instanceof \Illuminate\Database\Eloquent\Relations\Relation);
                } catch (\Throwable $e) {
                    return true;
                }
            })
            ->map(function ($method) {

                return [
                    'name' => $method->getName(),

                    'parameters' => collect($method->getParameters())
                        ->map(function ($parameter) {

                            $type = $parameter->getType();

                            return [
                                'name' => $parameter->getName(),
                                'type' => $type?->getName(),
                                'nullable' => $type?->allowsNull(),
                                'optional' => $parameter->isOptional(),
                                'default' => $parameter->isDefaultValueAvailable()
                                    ? $parameter->getDefaultValue()
                                    : null,
                            ];
                        })
                        ->toArray(),
                ];
            })
            ->values()
            ->toArray();
    }

    public string $modelName = '';

    public array $modelOptions = [
        'migration' => false,
        'factory' => false,
        'seeder' => false,
        'controller' => false,
        'resource' => false,
        'policy' => false,
    ];



    public function addAttribute(): void
    {
        $this->modelAttributes[] = [
            'name' => '',
            'type' => 'string',
            'nullable' => false,
        ];
    }

    public function removeAttribute(int $index): void
    {
        unset($this->modelAttributes[$index]);

        $this->modelAttributes = array_values($this->modelAttributes);
    }

    public function getFillable(): array
    {
        return collect($this->modelAttributes)
            ->pluck('name')
            ->filter()
            ->values()
            ->toArray();
    }

    public function getMigrationColumns(): array
    {
        return collect($this->modelAttributes)
            ->filter(fn($attribute) => !empty($attribute['name']))
            ->map(function ($attribute) {

                return [
                    'name' => $attribute['name'],
                    'type' => $attribute['type'],
                    'nullable' => $attribute['nullable'],
                ];
            })
            ->values()
            ->toArray();
    }

    public function createModel(): void
    {
        $name = ucfirst(trim($this->modelName));

        if (!$name) {
            $this->addError('modelName', 'Le nom du modèle est obligatoire.');
            return;
        }

        $options = [
            'name' => $name,
        ];

        foreach ($this->modelOptions as $option => $enabled) {
            if ($enabled) {
                $options['--' . $option] = true;
            }
        }

        Artisan::call('make:model', $options);

        $file = app_path("/Models/$name.php");
        $fillable = '    protected $fillable = [' . "\n";
        $fillables = $this->getFillableAttributes();
        foreach ($fillables as $key => $value) {
            $fillable .= "        '$name',\n";
        }
        $fillable .= '    ];' . "\n";

        $content = file_get_contents($file);
        $content = preg_replace('/}\s*$/', $fillable . "\n}", $content);
        file_put_contents($file, $content);

        $this->load_models();

        $this->selectedModel = $name;

        $this->modelContent = File::get(
            app_path("Models/{$name}.php")
        );
    }
}
