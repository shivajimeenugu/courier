<?php

namespace App\Http\Controllers;

use App\Models\bill;
use App\Models\couries;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function AddBill(Request $req)
    {
        if($req->name)
        {
        $b = new bill;
        $b->billname=$req->name;
        $b->save();
        return response(["message"=>"Bill Sucessfully Created"]);
        }
        else{
            return response(["message"=>"Invalid Request"]);
        }
    }


    public function AddCourier(Request $req)
    {

        $url = "https://apsrtclogistics.in/Cpservice_NEW/Api//manifest/GetShipmentByMultipleAwbNos/".$req->awb;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
        // This is what solved the issue (Accepting gzip encoding)
        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        $response = curl_exec($ch);
        curl_close($ch);
        //echo $response;
        $data = json_decode($response, true);
        //print_r($data);


        $cdate_temp=$data[0]["ShipmentDate"];
        $date_and_time=explode("T",$cdate_temp);
        $cdate=$date_and_time[0];

        $camount=$data[0]["Total"];
        $cfrom=$data[0]["SenderOriginCounterName"];
        $cto=$data[0]["ReceiverOriginCounterName"];
        $csender=$data[0]["SenderName"];
        $creciver=$data[0]["ReceiverName"];

        $data=[
            "billid"=>$req->billid,
            "cid"=>$req->awb,
            "cdate"=>$cdate,
            "amount"=>$camount,
            "cfrom"=>$cfrom,
            "cto"=>$cto,
            "csender"=>$csender,
            "creciver"=>$creciver
        ];


        $c=new couries;

        if($c->where("cid",$data["cid"])->count()==1)
        {
            return response(["message"=>"Courier Allredy Exists"]);
        }
        else{
            $c->billid=$data["billid"];
            $c->cid=$data["cid"];
            $c->cdate=$data["cdate"];
            $c->amount=$data["amount"];
            $c->cfrom=$data["cfrom"];
            $c->cto=$data["cto"];
            $c->csender=$data["csender"];
            $c->creciver=$data["creciver"];
            $c->save();
            return response(["message"=>"Courier [".$data["cid"]."] Sucessfully Added"]);
        }
    }


    public function GetCourier(Request $req)
    {
        if($req->billid)
        {
            $c=new couries;
            $couriers=$c->where("billid",$req->billid)->get()->toArray();
            // dd(bill::find($req->billid)->toArray()["billname"]);
            if(!(count($couriers)>=1))
            {
                $tabledata='
            <thead>
                <th>SI.NO</th>
                <th>ID</th>
                <th>Date</th>
                <th>Amount</th>
                <th>From</th>
                <th>To</th>
            </thead>
            <tbody>
            <tr>
            <td colspan="6"><b>No Courier Data Found For Bill [ '.bill::find($req->billid)->toArray()["billname"].' ]</b></td>
            </tr>
            </tbody>
            ';

                return response(["message"=>"No Couriers Found For Bill ID [".$req->billid."]","data"=>$tabledata]);
            }
            else{

                $tabledata="
            <thead>
                <th>SI.NO</th>
                <th>ID</th>
                <th>Date</th>
                <th>Amount</th>
                <th>From</th>
                <th>To</th>
            </thead>
            <tbody>
            ";
            $count=1;
            foreach($couriers as $courier)
            {
                // dd($courier["cdate"]);
                $tabledata.="
                <tr>
                <td>".$count."</td>
                <td>".$courier["cid"]."</td>
                <td>".$courier["cdate"]."</td>
                <td>".$courier["amount"]."</td>
                <td>".$courier["cfrom"]."</td>
                <td>".$courier["cto"]."</td>
                </tr>
                ";
                $count++;
            }
            $tabledata.="</tbody>";
            // dd($tabledata);
            return response(["message"=>"Couriers Sucessfully Fetched","data"=>$tabledata]);
            }

        }
        else{
            return response(["message"=>"Invalid Request"]);
        }
    }

    public function GetBills()
    {

        $b=new bill;
        $bills=$b->all()->toArray();
        // dd($bills);
        if(!(count($bills)>=1))
        {
            $tabledata='<option value="">No Bills Found</option>
            <option value="New">Create New Bill</option>';
            return response(["message"=>"No Bills Found","data"=>$tabledata]);
        }
        else{

            $tabledata="
        ";
        $count=1;
        foreach($bills as $bill)
        {
            // dd($courier["cdate"]);
            $tabledata.='
            <option value="'.$bill["id"].'">
                '.$bill["billname"].'
            </option>
            ';
            $count++;
        }
        $tabledata.='<option value="New">Create New Bill</option>';
        // dd($tabledata);
        return response(["message"=>"Bill Sucessfully Fetched","data"=>$tabledata]);
        }


    }



    public function CreateBill(Request $req)
    {
        if($req->billname)
        {
            $b=new bill;
            $b->billname=$req->billname;
            $b->save();
            $tabledata=["billname"=>$req->billname,"id"=>$b->id];
            return response(["message"=>"Bill Sucessfully Created","data"=>$tabledata]);

        }
        else{
            return response(["message"=>"Bill Creation Faild","data"=>null]);

        }

    }




}
