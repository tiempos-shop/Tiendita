<?php

include_once "../API/API.php";
include_once "../DHL/ShipType.php";
include_once "../DHL/PackageModel.php";

class DHL extends API
{
    /**
     * @var mixed
     */
    private $user;
    /**
     * @var mixed
     */
    private $password;
    /**
     * @var mixed
     */
    private $DropOffType;
    /**
     * @var mixed
     */
    private $ServiceType;
    /**
     * @var mixed
     */
    private $UnitOfMeasurement;
    /**
     * @var mixed
     */
    private $PaymentInfo;
    /**
     * @var mixed
     */
    private $Account;
    /**
     * @var mixed
     */
    private $RateUrl;
    /**
     * @var mixed
     */
    private $ShipmentUrl;
    /**
     * @var mixed
     */
    private $PickupUrl;

    public function __construct() {
        parent::__construct();
        $cfg = require_once 'config.php';
        $this->user=$cfg["user"];
        $this->password=$cfg["password"];
        $this->DropOffType=$cfg["DropOffType"];
        $this->ServiceType=$cfg["ServiceType"];
        $this->UnitOfMeasurement=$cfg["UnitOfMeasurement"];
        $this->PaymentInfo=$cfg["PaymentInfo"];
        $this->Account=$cfg["Account"];
        $this->RateUrl=$cfg["RateUrl"];
        $this->ShipmentUrl=$cfg["ShipmentUrl"];
        $this->PickupUrl=$cfg["PickupUrl"];
    }

    private function CALL_DHL(string $url, array $data): array
    {
        return parent::JSON_POST_DATA_AUT_ARRAY($url, $data, $this->user, $this->password);
    }

    private function RateRequest(array $RequestedShipment):array{
        return
            [
                "RateRequest" =>
                [
                    "RequestedShipment" => $RequestedShipment,
                    "ClientDetails" => null
                ]
            ];
    }

    private function RequestedShipment(array $SpecialServices,array $Ship,array $Packages,string $ShipTimestamp):array{
        return
            [
                "DropOffType" => "REGULAR_PICKUP",
                "ServiceType" => $this->ServiceType,
                "SpecialServices" => $SpecialServices,
                "Ship" => $Ship,
                "Packages" =>$Packages,
                "ShipTimestamp" => $ShipTimestamp,
                "UnitOfMeasurement" => $this->UnitOfMeasurement,
                "PaymentInfo" => $this->PaymentInfo,
                "Account" => $this->Account
            ];
    }

    private function SpecialServices($monto_seguro,string $CurrencyCode="MXN", $isShip = false):array{

        $dataService = [
            "ServiceType" => "II",
            "ServiceValue" => $monto_seguro,
            "CurrencyCode" => $CurrencyCode
        ];
        return [
                    "Service" =>
                    $isShip ? [$dataService] : $dataService
                ];
    }

    private function Ship(ShipType $shipper, ShipType $recipient):array{
        return
            [
                "Shipper" => $shipper->Ship(),
                "Recipient" => $recipient->Ship()
            ];
    }

    private function Packages(int $number,$weight,$length,$width,$height):array{
        return
        [
            "RequestedPackages" =>
                [
                    "@number" => $number,
                    "Weight"=> [
                        "Value" => $weight
                    ],
                    "Dimensions" =>
                        [
                            "Length" => $length,
                            "Width" => $width,
                            "Height" => $height
                        ]
                ]
        ];
    }

    private function PackagesShip(PackageModel $packageModel):array{
        return
            [
                "RequestedPackages" =>
                    [[
                        "@number" => $packageModel->number,
                        "Weight"=> $packageModel->weight,
                        "Dimensions" =>
                            [
                                "Length" => $packageModel->length,
                                "Width" => $packageModel->width,
                                "Height" => $packageModel->height
                            ],
                        "CustomerReferences" =>"38393070"
                    ]]
            ];
    }

    public function GetRateRequest($precio,$currency,int $shipper_cp,int $receiver_cp,int $products_number,$weight,$length,$width,$height):array{
        $special_services=$this->SpecialServices($precio,$currency);

        $shipper=new ShipType($shipper_cp);
        $receiver=new ShipType($receiver_cp);
        $ship=$this->Ship($shipper,$receiver);
        $packages=$this->Packages($products_number,$weight,$length,$width,$height);
        $date=date('Y-m-d');
        $time=date('H:i:s');
        $time_stamp=$date."T$time GMT-06:00";

        $request_shipment=$this->RequestedShipment($special_services,$ship,$packages,$time_stamp);
        return $this->RateRequest($request_shipment);
    }

    public function RateApiCall($precio,string $currency,int $shipper_cp,int $receiver_cp,int $products_number,$weight,$length,$width,$height):array{
        $request=$this->GetRateRequest($precio,$currency,$shipper_cp,$receiver_cp,$products_number,$weight,$length,$width,$height);
        return $this->CALL_DHL($this->RateUrl,$request);
    }
    public function ShipingApiCall(Array $request)
    {
        return $this->CALL_DHL($this->ShipmentUrl, $request);
    }
    public function ShipmentRequested($ShipmentInfo, $PostalCode,$PersonName, $CompanyName, $PhoneNumber,$EmailAddress, $StreetLines, $City , $CountryCode, PackageModel $packageModel):array{
        $date=date('Y-m-d');
        $time=date('H:i:s');
        $time_stamp=$date."T$time GMT-06:00";

        $receiver = new ShipType($PostalCode);
        $addressShop = $receiver->Address("calle guadalajara", "Guadalajara", "44220" , "MX");
        $contactShop = $receiver->Contact("Estaban", "Tiendas Shop", "555-555-555","correo@tiendasshop.com");
        $address = $receiver->Address($StreetLines, $City, $PostalCode , $CountryCode);
        $contact = $receiver->Contact($PersonName, $CompanyName, $PhoneNumber,$EmailAddress);
        return
            [
                "ShipmentRequest" =>
                    [
                        "RequestedShipment" =>
                            [
                                "ShipmentInfo" => $ShipmentInfo,
                                "ShipTimestamp" => $time_stamp,
                                "PaymentInfo" => "DAP",
                                "InternationalDetail" => $this->InternationalDetail(1,
                                    "Cartera de Prueba color negro",
                                    "1", "1", "1"),
                                "Ship" => [
                                    "Shipper" =>  [ "Contact" => $contactShop, "Address" => $addressShop],
                                    "Recipient" => [ "Contact" => $contact, "Address" => $address]
                                ],
                                "Packages" => $this->PackagesShip($packageModel)
                            ]
                    ]
            ];

    }

    public function ShipmentInfo($precio,$currency){
        return
            [
                "DropOffType" => "REGULAR_PICKUP",
                "ServiceType" => $this->ServiceType,
                "Account" => $this->Account,
                "Currency" => $currency,
                "UnitOfMeasurement" => "SI",
                "LabelType" => "PDF",
                "SpecialServices" => $this->SpecialServices($precio,$currency, true)
            ];
    }

    public function  InternationalDetail($numberOfPieces, $Description, $quantity, $unitPrice, $customsValue)
    {
        return [
            "Commodities" => [
                "NumberOfPieces" => $numberOfPieces,
                "Description" =>$Description,
                "Quantity"=>$quantity,
                "UnitPrice" =>$unitPrice,
                "CustomsValue" =>$customsValue
            ]
        ];
    }







}