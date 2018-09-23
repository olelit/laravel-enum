<?php

namespace MadWeb\Enum\Test;

use Illuminate\Support\Facades\Artisan;

class EnumMakeCommandTest extends TestCase
{
    public $mockConsoleOutput = false;

    /** @test */
    public function make_command()
    {
        $exitCode = $this->artisan('make:enum', ['name' => 'TestEnum']);

        $this->assertEquals(0, $exitCode);
        $this->assertContains('Enum created successfully', Artisan::output());
        $this->assertFileExists($this->app->basePath('app/Enums/TestEnum.php'));

        unlink($this->app->basePath('app/Enums/TestEnum.php'));
        rmdir($this->app->basePath('app/Enums'));
    }
}
