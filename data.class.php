<?php

namespace PhoneManager;



//adding mysqli globaly so php can use it in this namespace.
//dodavanje mysqli globalno tako da php moze da ga koristi u ovom prostornom imenu.
use mysqli;



//Connection on database using mysqli()
//Povezivanje na bazu podataka upotrebom mysqli()
class Connection {
    private $hostname = "localhost";
    private $username = "admin";
    private $password = "admin";
    private $database = "devices";
    public $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli(
            $this->hostname,
            $this->username,
            $this->password,
            $this->database
        );

        if ($this->connection->connect_errno) {
            die("Connection error: " . $this->connection->connect_error);
        } else {
            echo "You are connected!";
        }
    }
}




//class for phones
//klasa za telefone
abstract class Phone extends Connection {

  public $id;

  public $phone_make;

  public $phone_model;

  public $phone_storage;

  public $screen_size;

  public $phone_color;


  public function __construct($id, $phone_make, $phone_model, $phone_storage, $screen_size, $phone_color) {
    parent::__construct();
    $this->id = $id;
    $this->phone_make = $phone_make;
    $this->phone_model = $phone_model;
    $this->phone_storage = $phone_storage;
    $this->screen_size = $screen_size;
    $this->phone_color = $phone_color;
  }


  //needed to add abstract function for learning purpose, could be much better implemented.
  //morao sam da dodam abstraktnu funkciju u vidu da postoji bolji nacin da se pokazu informacije o telefonima.
  abstract function showDeviceInfo();

  

  //simplest way to add data into db but not safest way
  //jednostavan nacin za dodavanje uredjaja u db ali nije siguran
  public function addDevice(){
    $sql = "INSERT INTO phones (phone_make, phone_model, phone_storage, screen_size, phone_color)
          VALUES ('$this->phone_make', '$this->phone_model', '$this->phone_storage', '$this->screen_size', '$this->phone_color')";
          if ($this->connection->query($sql)) {
            echo "Phone inserted";
        } else {
            echo "Error while inserting new phone: " . $this->connection->error;
        }
      }
}

// TRAITS THAT ARE IMPLEMENTED INTO EVERY MANIFACTURER CLASS
// TRAITOVI KOJI SU IMPLEMENTIRANI U SVAKU KLASU PROIZOVJACA

trait wirelessCharging
{
    public function enableWirelessCharging (){
    }
}
trait faceID
{
    public function enableFaceId (){
    }
}

trait fingerprintId
{
    public function enableFingerprintId(){

    }
}

trait nativeAppMarketplace
{
    public function nativeAppMarketplace(){
    }
}




//MANIFACTURER CLASSES
//KLASE PROIZVOJACA

class Apple extends Phone{
    use wirelessCharging, faceID, nativeAppMarketplace;

    public function showDeviceInfo() {
        return "Device: {$this->phone_make} {$this->phone_model}, Storage: {$this->phone_storage}, Screen size: {$this->screen_size}, Color: {$this->phone_color}";
    }

    public function enableWirelessCharging(){
        return "This device is using magsafe.";
    }
    public function enableFaceId(){
        return "To unlock device use FaceId.";
    }
    public function nativeAppMarketplace(){
        return "This device native app marketplace is App Store";
    }
}

class Samsung extends Phone{
    use wirelessCharging, fingerprintId, nativeAppMarketplace;

    public function showDeviceInfo() {
        return "Device: {$this->phone_make} {$this->phone_model}, Storage: {$this->phone_storage}, Screen size: {$this->screen_size}, Color: {$this->phone_color}";
    }

    public function enableWirelessCharging(){
        return "This device is using QI wireless charging.";
    }
    public function enableFingerprintId(){
        return "To unlock device use your fingerprint.";
    }
    public function nativeAppMarketplace(){
        return "This device native app marketplace is Google Play store";
    }
}

class Huawei extends Phone{
    use wirelessCharging, fingerprintId, nativeAppMarketplace;

    public function showDeviceInfo() {
        return "Device: {$this->phone_make} {$this->phone_model}, Storage: {$this->phone_storage}, Screen size: {$this->screen_size}, Color: {$this->phone_color}";
    }

    public function enableWirelessCharging(){
        return "This device is using QI wireless charging.";
    }
    public function enableFingerprintId(){
        return "To unlock device use your fingerprint.";
    }
    public function nativeAppMarketplace(){
        return "This device native app marketplace is App Gallery";
    }

}


//adding some phones
//dodavanje telefona

$iphone = new Apple(null, "Apple", "Iphone 15 Pro", "1TB", "6.1", "White Titanium");
$iphone->addDevice();
echo $iphone->showDeviceInfo();
echo $iphone->enableWirelessCharging();
echo $iphone->enableFaceId();
echo $iphone->nativeAppMarketplace();


$samsung = new Samsung(null, "Samsung", "Galaxy S25", "512GB", "6.2", "Silver shadow");
$samsung->addDevice();
echo $samsung->showDeviceInfo();
echo $samsung->enableWirelessCharging();
echo $samsung->enableFingerprintId();
echo $samsung->nativeAppMarketplace();


$huawei = new Huawei(null, "Huawei", "Mate X6", "512GB", "7.9", "Nebula Red");
$huawei->addDevice();
echo $huawei->showDeviceInfo();
echo $huawei->enableWirelessCharging();
echo $huawei->enableFingerprintId();
echo $huawei->nativeAppMarketplace();


