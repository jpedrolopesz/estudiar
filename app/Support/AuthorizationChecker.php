<?php

namespace App\Support;

use App\Models\Project;
use Closure;
use Gate;
use Illuminate\Database\Eloquent\Model;
use Laravel\SerializableClosure\Support\ReflectionClosure;
use ReflectionClass;
use ReflectionMethod;

class AuthorizationChecker
{
    /**
     * @throws \ReflectionException
     */
    public static function getPermissions(mixed $model, ?array $abilities = null): array
    {
        $abilities ??= static::getAbilitiesForModel($model);

        return collect($abilities)
            ->filter(fn ($a) => $a !== 'before')
            ->mapWithKeys(fn ($ability) => [$ability => Gate::allows($ability, $model)])
            ->toArray();
    }

    /**
     * @return mixed[]
     *
     * @throws \ReflectionException
     */
    public static function getAbilitiesForModel(Model $model)
    {
        $policy = Gate::getPolicyFor(Project::class);
        $reflection = new ReflectionClass($policy);

        return collect($reflection->getMethods(ReflectionMethod::IS_PUBLIC))
            ->map(fn (ReflectionMethod $method) => $method->getName())
            ->toArray();
    }

    public static function getGlobalPermissions(?array $abilities = null): array
    {
        return collect(Gate::abilities())
            ->filter(function (Closure $closure, $ability) use ($abilities) {
                if ($abilities && ! in_array($ability, $abilities)) {
                    return false;
                }
                $reflection = new ReflectionClosure($closure);

                return $reflection->getNumberOfParameters() === 1;
            })
            ->mapWithKeys(fn (Closure $closure, $ability) => [$ability => Gate::check($ability)])
            ->toArray();
    }
}
