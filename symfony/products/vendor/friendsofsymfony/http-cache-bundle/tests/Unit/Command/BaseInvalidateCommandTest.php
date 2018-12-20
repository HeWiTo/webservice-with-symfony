<?php

/*
 * This file is part of the FOSHttpCacheBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\HttpCacheBundle\Tests\Unit\Command;

use FOS\HttpCacheBundle\CacheManager;
use FOS\HttpCacheBundle\Command\InvalidatePathCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseInvalidateCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testContainerAccess()
    {
        $invalidator = \Mockery::mock(CacheManager::class)
            ->shouldReceive('invalidatePath')->once()->with('/my/path')
            ->shouldReceive('invalidatePath')->once()->with('/other/path')
            ->shouldReceive('invalidatePath')->once()->with('/another')
            ->getMock()
        ;
        $container = \Mockery::mock(ContainerInterface::class)
            ->shouldReceive('get')->once()->with('fos_http_cache.cache_manager')->andReturn($invalidator)
            ->getMock()
        ;

        $application = new Application();
        $command = new InvalidatePathCommand();
        $command->setContainer($container);
        $application->add($command);

        $command = $application->find('fos:httpcache:invalidate:path');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'paths' => ['/my/path', '/other/path'],
        ]);

        // the only output should be generated by the listener in verbose mode
        $this->assertEquals('', $commandTester->getDisplay());

        // the cache manager is only fetched once
        $commandTester->execute([
            'command' => $command->getName(),
            'paths' => ['/another'],
        ]);
    }
}
