<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class ModeloTestCase extends BaseTestCase
{
    //
    /**
     * Variable para almacenar el nombre de la tabla
     */
    public string $table;
    protected static string $ommit_msj;
    /**
     * Variable para almacenar la instancia
     */
    public $inst;
    /**
     * Variable para almacenar el registro recuperado de la BD
     */
    public $reg;
    /**
     * Variable para guardar el UUID de la instancia
     */
    public string $id;


    public static function setUpBeforeClass(): void
    {
        echo 'Inicio de los tests' . PHP_EOL;
        static::$ommit_msj = 'No se aplica ';
    }
    public static function tearDownAfterClass(): void
    {
        echo 'Fin de los tests' . PHP_EOL;
    }

    /**
     * Test básico de uso del factory.
     */
    public function test_factory(): void
    {}
    /**
     * Test de los estados del factory
     * (si es que aplica)
     */
    public function test_estados(): void
    {
        echo static::$ommit_msj . __FUNCTION__ . PHP_EOL;
        $this->assertTrue(true);
    }
    /**
     * Test de las secuencias del factory
     * (si es que aplica)
     */
    public function test_secuencias(): void /** Si es que aplica */
    {
        echo static::$ommit_msj . __FUNCTION__ . PHP_EOL;
        $this->assertTrue(true);
    }

    /** Tests CRUD */
    /**
     * Test para el CREATE
     */
    public function test_create(): void
    {

    }
    /**
     * Test para el READ
     */
    public function test_read(): void
    {

    }
    /**
     * Test para el UPDATE
     */
    public function test_update(): void
    {

    }
    /**
     * Test para el DELETE
     */
    public function test_delete(): void
    {

    }

    /**
     * Test de uso del seeder
     */
    public function test_seeder(): void
    {

    }
}
