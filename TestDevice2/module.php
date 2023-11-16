<?php

declare(strict_types=1);
class TestDevice2 extends IPSModule
{
    public function Create()
    {
        //Never delete this line!
        parent::Create();

        $this->RequireParent('{63D1D28F-6901-8BB7-8C8E-1046022EFEB4}');

        $this->RegisterPropertyInteger('DeviceID', 0);
        $this->RegisterPropertyInteger('SecondaryID', 0);
    }

    public function Destroy()
    {
        //Never delete this line!
        parent::Destroy();
    }

    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();
    }
}