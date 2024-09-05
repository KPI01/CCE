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
    protected static string $ommitMsg;
    /**
     * Variable para guardar el UUID de la instancia
     */
    public string $id;

    public static function setUpBeforeClass(): void
    {
        echo "Inicio de los tests" . PHP_EOL;
        static::$ommitMsg = "No se aplica ";
    }
    public static function tearDownAfterClass(): void
    {
        echo "Fin de los tests" . PHP_EOL;
    }

    /**
     * Test básico de uso del factory.
     */
    public function testFactory(): void
    {
    }
    /**
     * Test de los estados del factory
     * (si es que aplica)
     */
    public function testEstados(): void
    {
        echo static::$ommitMsg . __FUNCTION__ . PHP_EOL;
        $this->assertTrue(true);
    }
    /**
     * Test de las secuencias del factory
     * (si es que aplica)
     */
    public function testSecuencias(): void
    {
        /** Si es que aplica */
        echo static::$ommitMsg . __FUNCTION__ . PHP_EOL;
        $this->assertTrue(true);
    }

    /** Tests CRUD */
    /**
     * Test para el CREATE
     */
    public function testCreate(): void
    {
    }
    /**
     * Test para el READ
     */
    public function testRead(): void
    {
    }
    /**
     * Test para el UPDATE
     */
    public function testUpdate(): void
    {
    }
    /**
     * Test para el DELETE
     */
    public function testDelete(): void
    {
    }

    /**
     * Test de uso del seeder
     */
    public function testSeeder(): void
    {
    }
}
