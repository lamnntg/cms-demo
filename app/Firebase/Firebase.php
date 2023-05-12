<?php
namespace App\Firebase;

use Kreait\Firebase\Factory;
use Kreait\Firebase\RemoteConfig\Template;
use Kreait\Firebase\ServiceAccount;

class Firebase
{

    // TODO: If using SDK
    /**
     * @var Factory
     */
    protected $firebase;

    public function __construct()
    {
        $this->firebase = (new Factory)->withServiceAccount(
            ServiceAccount::fromValue(storage_path('firebase_credentials.json'))
        );
    }

    /**
     * getRemoteConfig function
     *
     * get all remote config or by name
     *
     * @return array
     */
    public function getRemoteConfig($name = null)
    {
        $remoteConfigs = $this->firebase->createRemoteConfig()->get();

        if (!is_null($name)) {
            return  json_decode(
                $remoteConfigs->parameters()[$name]->defaultValue()->value(),
                1
            );
        }

        return $remoteConfigs->jsonSerialize();
    }
}
