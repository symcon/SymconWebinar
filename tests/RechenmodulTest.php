<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

include_once __DIR__ . '/stubs/GlobalStubs.php';
include_once __DIR__ . '/stubs/KernelStubs.php';
include_once __DIR__ . '/stubs/ModuleStubs.php';
include_once __DIR__ . '/stubs/MessageStubs.php';

class RechenModulTest extends TestCase
{
    private $rechenModulID = '{BCA877CA-06FD-2212-D0B1-766C8D099E9D}';

    public function setUp(): void
    {
        //Reset
        IPS\Kernel::reset();
        //Register our library we need for testing
        IPS\ModuleLoader::loadLibrary(__DIR__ . '/../library.json');
        parent::setUp();
    }

    public function testBasicSum()
    {
        $var1 = 3;
        $var2 = 4;
        $var3 = 5;

        $sum = $var1 + $var2 + $var3;
        $this->assertEquals(12, $sum);
    }

    public function testSum()
    {
        $variable1ID = IPS_CreateVariable(1);
        $variable2ID = IPS_CreateVariable(1);
        $variable3ID = IPS_CreateVariable(1);

        SetValue($variable1ID, 3);
        SetValue($variable2ID, 4);
        SetValue($variable3ID, 5);

        $rechenModulID = IPS_CreateInstance($this->rechenModulID);

        IPS_SetProperty($rechenModulID, 'Calculation', 1); // Sum
        IPS_SetProperty($rechenModulID, 'Variables', json_encode(
            [
                [
                    'ID' => $variable1ID
                ],
                [
                    'ID' => $variable2ID
                ],
                [
                    'ID' => $variable3ID
                ]
            ]
        ));
        IPS_ApplyChanges($rechenModulID);

        $sumVariableID = IPS_GetObjectIDByIdent('Sum', $rechenModulID);
        $this->assertEquals(12, GetValue($sumVariableID));
    }

    public function testAverage()
    {
        $variable1ID = IPS_CreateVariable(1);
        $variable2ID = IPS_CreateVariable(1);
        $variable3ID = IPS_CreateVariable(1);

        SetValue($variable1ID, 3);
        SetValue($variable2ID, 4);
        SetValue($variable3ID, 5);

        $rechenModulID = IPS_CreateInstance($this->rechenModulID);

        IPS_SetProperty($rechenModulID, 'Calculation', 4); // Average
        IPS_SetProperty($rechenModulID, 'Variables', json_encode(
            [
                [
                    'ID' => $variable1ID
                ],
                [
                    'ID' => $variable2ID
                ],
                [
                    'ID' => $variable3ID
                ]
            ]
        ));
        IPS_ApplyChanges($rechenModulID);

        $averageVariableID = IPS_GetObjectIDByIdent('Average', $rechenModulID);
        $this->assertEquals(4, GetValue($averageVariableID));
    }

    public function testAverageNoVariables()
    {
        $rechenModulID = IPS_CreateInstance($this->rechenModulID);

        IPS_SetProperty($rechenModulID, 'Calculation', 4); // Average
        IPS_SetProperty($rechenModulID, 'Variables', json_encode([]));
        IPS_ApplyChanges($rechenModulID);

        $averageVariableID = IPS_GetObjectIDByIdent('Average', $rechenModulID);
        $this->assertEquals(0, GetValue($averageVariableID));
    }

    public function testAverageNonVariable()
    {
        $variable1ID = IPS_CreateVariable(1);
        $variable2ID = IPS_CreateVariable(1);
        $scriptID = IPS_CreateScript(0);

        SetValue($variable1ID, 3);
        SetValue($variable2ID, 4);

        $rechenModulID = IPS_CreateInstance($this->rechenModulID);

        IPS_SetProperty($rechenModulID, 'Calculation', 4); // Average
        IPS_SetProperty($rechenModulID, 'Variables', json_encode(
            [
                [
                    'ID' => $variable1ID
                ],
                [
                    'ID' => $variable2ID
                ],
                [
                    'ID' => $scriptID
                ]
            ]
        ));
        IPS_ApplyChanges($rechenModulID);

        $averageVariableID = IPS_GetObjectIDByIdent('Average', $rechenModulID);
        $this->assertEquals(3.5, GetValue($averageVariableID));
    }

    public function testMinimum()
    {
        $variable1ID = IPS_CreateVariable(1);
        $variable2ID = IPS_CreateVariable(1);
        $variable3ID = IPS_CreateVariable(1);

        SetValue($variable1ID, 3);
        SetValue($variable2ID, 4);
        SetValue($variable3ID, 5);

        $rechenModulID = IPS_CreateInstance($this->rechenModulID);

        IPS_SetProperty($rechenModulID, 'Calculation', 2); // Minimum
        IPS_SetProperty($rechenModulID, 'Variables', json_encode(
            [
                [
                    'ID' => $variable1ID
                ],
                [
                    'ID' => $variable2ID
                ],
                [
                    'ID' => $variable3ID
                ]
            ]
        ));
        IPS_ApplyChanges($rechenModulID);

        $minimumVariableID = IPS_GetObjectIDByIdent('Minimum', $rechenModulID);
        $this->assertEquals(3, GetValue($minimumVariableID));
    }
}