<?php

namespace App\Http\Services;

use Closure;
use ReflectionFunction;
use ReflectionException;
use Illuminate\Support\Facades\Cache;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

class CacheService
{
    /** Кэш с пагинацией.
     * @param Closure $callback
     * @return mixed
     * @throws ReflectionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function getAll(Closure $callback)
    {
        $page = request()->get('page');
        $page = is_null($page) ? 1 : $page;
        $cache_name = self::getClosureCacheName($callback);

        return Cache::remember($cache_name . $page, config('app.cache_ttl'), $callback);
    }

    /** Получает имя кэша из класса замыкания.
     * @param Closure $callback
     * @return string
     * @throws ReflectionException
     */
    private static function getClosureCacheName(Closure $callback): string
    {
        $reflectionClosure = new ReflectionFunction($callback);
        $class_path = $reflectionClosure->getClosureScopeClass()->getName();
        $tmp = explode('\\', $class_path);
        $class_name = array_pop($tmp);
        $cache_name = str_replace('Controller', '', $class_name);

        return strtolower($cache_name);
    }

    /** Очищает кэш.
     * @return void
     */
    public static function forgetCache(): void
    {
        $class_path = debug_backtrace()[1]['class'];
        $tmp = explode('\\', $class_path);
        $class_name = array_pop($tmp);
        $cache_name = str_replace('Controller', '', $class_name);
        $cache_name = strtolower($cache_name);
        for ($i = 1; $i < 1000; $i++) {
            if (Cache::has($cache_name . $i)) {
                Cache::forget($cache_name . $i);
            } else {
                break;
            }
        }
    }
}