<?php
header('Access-Control-Allow-Origin:*');
#header('Access-Control-Max-Age:86400');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
#header('Access-Control-Allow-Methods:GET, POST, PUT, DELETE, OPTIONS');
//phpinfo();
class Analysis
{
    private $url;
    private $referrer;
    private $browser;
    public function __construct($url, $referrer, $browser)
    {
        $this->url = $url;
        $this->referrer = $referrer;
        $this->browser = $browser;
    }
    public function Insert()
    {
        if(trim($this->url) != ""){
            $conn = new mysqli("localhost", "root", "", "");
            try {
                $stmt = $conn->prepare("INSERT INTO analysis (url, referrer, browser, createddate) VALUES (?, ?, ?, now())");
                try {
                    $stmt->bind_param("sss", $this->url, $this->referrer, $this->browser);
                    $stmt->execute();
                } finally {
                    $stmt->close();
                }
            } catch (Exception $e) {
                var_dump($e);
                die($e);
            } finally {
                mysqli_close($conn);
            }
        }
    }
}
$node = new Analysis($_POST["url"], $_POST["referrer"], $_POST["browser"]);