<?php

namespace App\Http\Controllers;
use PDO;

use Illuminate\Http\Request;

class winproController extends Controller
{
    private $dbh;

    public function __construct()
    {
        /*         $this->middleware('auth'); */
        $this->test = 'test';

        $hostname = '192.168.1.13';
        $dbname = 'bertrand';
        $user = 'user_read';
        $pass = 'user@123';


        try {
            $this->dbh = new PDO("mysql:host=$hostname;dbname=$dbname;charset=utf8", $user, $pass);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
    }
    public function windowInfo(){
        $barcode = $_GET['barcode'];

        $query = "SELECT p.codebarre as barcode, p.commande as commande, p.id as order_pos, p.index AS order_item, c.client as client_code, cl.nom as client
        from prepalot p
        JOIN commande c ON p.commande = c.numero
        JOIN client cl ON c.client = cl.code
        WHERE LEFT (p.codebarre, 5) =  $barcode";

        $sth = $this->dbh->prepare($query);
        $sth->execute();
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
        echo (json_encode($rows));
    }
}
