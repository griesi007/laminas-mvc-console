<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-console for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-console/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-console/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\Mvc\Console\Service;

use Psr\Container\ContainerInterface;
use Laminas\Console\Console;
use Laminas\Console\Response as ConsoleResponse;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * Delegator factory for the Response service.
 *
 * If a console environment is detected, returns a ConsoleResponse instead
 * of the default response.
 */
class ConsoleResponseDelegatorFactory implements DelegatorFactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $name
     * @param callable $callback
     * @param null|array $options
     * @return ConsoleResponse|\Laminas\Http\Response
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null)
    {
        if (! Console::isConsole()) {
            return $callback();
        }

        return new ConsoleResponse();
    }

    /**
     * laminas-servicemanager v2 compatibility.
     *
     * Proxies to __invoke().
     *
     * @param ServiceLocatorInterface $container
     * @param string $name
     * @param string $requestedName
     * @param callable $callback
     * @return ConsoleResponse|\Laminas\Http\Response
     */
    public function createDelegatorWithName(ServiceLocatorInterface $container, $name, $requestedName, $callback)
    {
        return $this($container, $requestedName, $callback);
    }
}
