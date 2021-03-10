<?php

declare(strict_types=1);
	class TestSplitter extends IPSModule
	{
		public function Create()
		{
			//Never delete this line!
			parent::Create();

			$this->ConnectParent('{6179ED6A-FC31-413C-BB8E-1204150CF376}');
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

		public function ForwardData($JSONString)
		{
			$data = json_decode($JSONString);
			IPS_LogMessage('Splitter FRWD', utf8_decode($data->Buffer));

			$this->SendDataToParent(json_encode(['DataID' => '{79827379-F36E-4ADA-8A95-5F8D1DC92FA9}', 'Buffer' => $data->Buffer]));

			return 'String data for device instance!';
		}

		public function ReceiveData($JSONString)
		{
			$data = json_decode($JSONString);
			IPS_LogMessage('Splitter RECV', utf8_decode($data->Buffer));

			$this->SendDataToChildren(json_encode(['DataID' => '{9209FA1D-DF9B-B139-432F-F4D4440D8531}', 'Buffer' => $data->Buffer]));
		}
	}