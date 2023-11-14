<?php

namespace Penguin\Component\Facade;

use Penguin\Component\Container\Container;
use Penguin\Component\Container\Exception\ServiceNotFoundException;

abstract class Facade
{
    abstract protected static function getFacadeAccessor(): string|object;

    public static function __callStatic(string $name, array $arguments): mixed
    {
        $accesscor = static::getFacadeAccessor();
        if (is_string($accesscor)) {
            $container = Container::getInstance();
            if ($container->has($accesscor)) {
                $accesscor = $container->get($accesscor);
            } else {
                throw new ServiceNotFoundException("$accesscor service does not exist");
            }
        }
        return $accesscor->$name(...$arguments);
    }
}