<?php

use CodeIgniter\Test\CIUnitTestCase;
use App\Controllers\Perfil;

/**
 * @internal
 */
final class PerfilTest extends CIUnitTestCase
{
    public function testPerfilControllerExists(): void
    {
        $controller = new Perfil();
        $this->assertInstanceOf(Perfil::class, $controller);
    }

    public function testPerfilMethodsExist(): void
    {
        $controller = new Perfil();
        $this->assertTrue(method_exists($controller, 'index'));
        $this->assertTrue(method_exists($controller, 'actualizar'));
        $this->assertTrue(method_exists($controller, 'cambiarPassword'));
    }
}
