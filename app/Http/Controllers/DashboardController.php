<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;

use App\Models\Param;

use Validator;

class DashBoardController extends Controller
{

    public function xindex()
    {
        $_mat = getYearMonths();
        $meses = "";
        foreach($_mat as $_item) {
            $meses .= ($_item['id'] == 1 ? "" : ",")."\"".$_item['label']."\"";
        }
        $_param = Param::where('label', 'bar1')->first(); // model or null
        $bar1 = "589, 445, 483, 503, 689, 692, 634, 505, 410, 500, 600, 500";
        if ($_param) {
        $bar1 = $_param->value;
        }    
        $_param = Param::where('label', 'bar2')->first(); // model or null
        $bar2 = "639, 465, 493, 478, 589, 632, 674, 490, 510, 520, 600, 500";
        if ($_param) {
            $bar2 = $_param->value;
        }    
        return view('dashboard', compact('meses', 'bar1', 'bar2'));
    }

    public function index()
    {

        $_mat = getYearMonths();
        $meses = "";
        foreach($_mat as $_item) {
            $meses .= ($_item['id'] == 1 ? "" : ",")."\"".$_item['label']."\"";
        }

        $ano = \Request::get('ano');

        $ano = date('Y');

        $agorax = $ano.'-01-01 00:00:00';
        $futuro = ($ano + 1) . '-01-01 00:00:00';
        $faixaax= '0';
        $faixabx= '0';

        $query = "";
        $query .= "SELECT ";
        $query .= "   MONTH(j.dt_entry) AS mes, ";
        $query .= "   SUM(j.vl_entry) AS vl_entry ";
        $query .= "FROM ";
        $query .= "   entries j ";
        $query .= "WHERE ";
        $query .= "   j.status = 1 AND ";
        $query .= "   j.published = 1 AND ";
        $query .= "   j.vl_entry > 0 AND ";
        $query .= "   j.dt_entry BETWEEN Str_to_date(Date_format(ADDDATE('" . $agorax . "',+" . $faixabx . "),'%Y-%m-%d 00:00:00'),Get_format(DATETIME,'iso')) AND '" . $futuro . "' ";
        $query .= "GROUP BY ";
        $query .= "   MONTH(j.dt_entry) ";

        $vcreditos = DB::connection('mysql')->select($query);

        $bar2 = "";
        $icont = 0;
        foreach($vcreditos as $vitem) {
            $bar2 .= ($icont == 0 ? "" : ",").$vitem->vl_entry;
            $icont += 1;
        }

        $query = "";
        $query .= "SELECT ";
        $query .= "   MONTH(j.dt_entry) AS mes, ";
        $query .= "   SUM(j.vl_entry)*-1 AS vl_entry ";
        $query .= "FROM ";
        $query .= "   entries j ";
        $query .= "WHERE ";
        $query .= "   j.status = 1 AND ";
        $query .= "   j.published = 1 AND ";
        $query .= "   j.vl_entry <= 0 AND ";
        $query .= "   j.dt_entry BETWEEN Str_to_date(Date_format(ADDDATE('" . $agorax . "',+" . $faixabx . "),'%Y-%m-%d 00:00:00'),Get_format(DATETIME,'iso')) AND '" . $futuro . "' ";
        $query .= "GROUP BY ";
        $query .= "   MONTH(j.dt_entry) ";

        $vdebitos = DB::connection('mysql')->select($query);

        $bar1 = "";
        $icont = 0;
        foreach($vdebitos as $vitem) {
            $bar1 .= ($icont == 0 ? "" : ",").$vitem->vl_entry;
            $icont += 1;
        }

        return view('dashboard', compact('meses', 'bar1', 'bar2'));

    }

}
