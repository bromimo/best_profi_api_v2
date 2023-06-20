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

        return Cache::remember($cache_name . '-page-' . $page, config('app.cache_ttl'), $callback);
    }

    /** Очищает все страницы кэша.
     * @return void
     */
    public static function forgetCache(): void
    {
        $class_path = debug_backtrace()[1]['class'];
        $cache_name = self::getCacheName($class_path);
        for ($i = 1; $i < 1000; $i++) {
            if (Cache::has($cache_name . '-page-' . $i)) {
                Cache::forget($cache_name . '-page-' . $i);
            } else {
                break;
            }
        }
    }

    /** Получает имя кэша из пути класса.
     * @param string $class_path
     * @return string
     */
    private static function getCacheName(string $class_path): string
    {
        $tmp = explode('\\', $class_path);
        $class_name = array_pop($tmp);
        $cache_name = str_replace('Controller', '', $class_name);

        return strtolower($cache_name);
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

        return self::getCacheName($class_path);
    }
}