<?php
class DynamicDemo extends IPSModule
{
    public function Create()
    {
        //Never delete this line!
        parent::Create();
    
        $this->RegisterAttributeInteger("Progress", 0);
        $this->RegisterAttributeBoolean("AutoUpdate", true);

        $this->RegisterTimer("ProgressTimer", 100, "DD_ProgressUp(" . $this->InstanceID . ");");
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

    public function GetConfigurationForm()
    {
        $jsonForm = json_decode(file_get_contents(__DIR__ . "/form.json"), true);

        $jsonForm["actions"][0]["current"] = $this->ReadAttributeInteger("Progress");
        $jsonForm["actions"][1]["enabled"] = !$this->ReadAttributeBoolean("AutoUpdate");
        $jsonForm["actions"][2]["value"] = $this->ReadAttributeBoolean("AutoUpdate");
        $jsonForm["actions"][3]["value"] = $this->ReadAttributeInteger("Progress");

        return json_encode($jsonForm);
    }

    public function ProgressUp()
    {
        $progress = $this->ReadAttributeInteger("Progress");
        $progress = ($progress + 1) % 100;
        $this->WriteAttributeInteger("Progress", $progress);
        if ($this->ReadAttributeBoolean("AutoUpdate")) {
            $this->UpdateFormField("MyProgress", "current", $progress);
        }
    }

    public function ReloadConfigurationForm()
    {
        $this->ReloadForm();
    }

    public function SetAutoUpdate($AutoUpdate)
    {
        $this->WriteAttributeBoolean("AutoUpdate", $AutoUpdate);
        $this->UpdateFormField("ReloadButton", "enabled", !$AutoUpdate);
    }

    public function SetProgress($Progress)
    {
        $this->WriteAttributeInteger("Progress", $Progress);
        if ($this->ReadAttributeBoolean("AutoUpdate")) {
            $this->UpdateFormField("MyProgress", "current", $Progress);
        }
    }

    public function OpenPopup()
    {
        $this->UpdateFormField("MyPopup", "visible", true);
    }
}
