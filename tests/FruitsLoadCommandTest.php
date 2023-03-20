<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class FruitsLoadCommandTest extends KernelTestCase
{
    public function testExecuteLoadAll(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('fruits:load');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);
        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('Data loaded successfully.', $output);
    }
}
