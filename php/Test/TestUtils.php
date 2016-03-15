<?php

class TestUtils {
    const SANDBOX_KEYSTORE_PASSWORD = "unreal";
    const SANDBOX_KEYSTORE_PATH = "C:\\Users\\JBK0718\\dev\\mastercard\\keystore\\sandbox\\414d686c777974526d2f71367141505a68304673746b633d.p12";
    const SANDBOX_CONSUMER_KEY = "820oCPqU4KAUEAwy0I6_Xf1dkjAlfSrEbSfeIq961563e1f8!414d686c777974526d2f71367141505a68304673746b633d";

    const PRODUCTION_KEYSTORE_PASSWORD = "unreal";
    const PRODUCTION_KEYSTORE_PATH = "C:\\Users\\JBK0718\\dev\\mastercard\\keystore\\production\\546536344e2b647558374a4156382f414644524173673d3d.p12";

    // APP-SPECIFIC PRODUCTION KEYS
    const LOCATION_PRODUCTION_CONSUMER_KEY = "yW8e1pgChCfdA4U3ZkSz-vBPdXgnxm1dDiVLHAVze9216d5b!546536344e2b647558374a4156382f414644524173673d3d";

    private $environment;

    public function __construct($environment)
    {
        $this->environment = $environment;
    }

    public function getPrivateKey()
    {
        $keystorePath = "";
        $keystorePassword = "";

        if ($this->environment == Environment::PRODUCTION)
        {
            $keystorePath = self::PRODUCTION_KEYSTORE_PATH;
            $keystorePassword = self::PRODUCTION_KEYSTORE_PASSWORD;
        }
        else
        {
            $keystorePath = self::SANDBOX_KEYSTORE_PATH;
            $keystorePassword = self::SANDBOX_KEYSTORE_PASSWORD;
        }

        $path = realpath($keystorePath);
        $keystore = array();
        $pkcs12 = file_get_contents($path);
        trim(openssl_pkcs12_read( $pkcs12, $keystore, $keystorePassword));
        return  $keystore['pkey'];
    }
}