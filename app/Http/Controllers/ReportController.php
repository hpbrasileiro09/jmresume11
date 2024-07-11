<?php

namespace App\Http\Controllers;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;

use App\Http\Requests;

use Carbon\Carbon;

use App\Models\Entry;

use App\Models\Category;

use App\Models\Param;

use Validator;

class ReportController extends Controller
{
    
    public $path_view = 'reports';

    public $header_view = 'Reports';

    public function index()
    {
        echo "index";
        exit;
    }

    public function detalhe(Request $request)
    {

        $ano = $request->input('ano', date('Y'));
        $mes = $request->input('mes', 1);

        $entries = Array();
        $debitos = Array();
        $creditos = Array();

        $meses = Array();

        $meses[] = Array( 'id' =>  1, 'abrev' => 'Jan', 'completo' => 'Janeiro' );
        $meses[] = Array( 'id' =>  2, 'abrev' => 'Fev', 'completo' => 'Fevereiro' );
        $meses[] = Array( 'id' =>  3, 'abrev' => 'Mar', 'completo' => 'Marco' );
        $meses[] = Array( 'id' =>  4, 'abrev' => 'Abr', 'completo' => 'Abril' );
        $meses[] = Array( 'id' =>  5, 'abrev' => 'Mai', 'completo' => 'Maio' );
        $meses[] = Array( 'id' =>  6, 'abrev' => 'Jun', 'completo' => 'Junho' );
        $meses[] = Array( 'id' =>  7, 'abrev' => 'Jul', 'completo' => 'Julho' );
        $meses[] = Array( 'id' =>  8, 'abrev' => 'Ago', 'completo' => 'Agosto' );
        $meses[] = Array( 'id' =>  9, 'abrev' => 'Set', 'completo' => 'Setembro' );
        $meses[] = Array( 'id' => 10, 'abrev' => 'Out', 'completo' => 'Outubro' );
        $meses[] = Array( 'id' => 11, 'abrev' => 'Nov', 'completo' => 'Novembro' );
        $meses[] = Array( 'id' => 12, 'abrev' => 'Dez', 'completo' => 'Dezembro' );

        $mesesG = Array();

        $zano = $ano;
        $zmes = $mes;

        for ($x=1; $x<=12;$x++)
        {
            if ($zmes > 12) {
                $zmes = 1;
                $zano++;
            } 
            foreach($meses as $lmes) 
            {
                if ($lmes['id'] == $zmes) 
                {
                    $mesesG[] = Array( 'id' => $lmes['id'], 'ano' => $zano, 'abrev' => $lmes['abrev'], 'completo' => $lmes['completo'] );
                    break;
                }
            }
            $zmes++;
        }

        //======================================

        $categoriesC = Array();

        $query = "";
        $query .= "SELECT ";
        $query .= "   c.id, ";
        $query .= "   c.name, ";
        $query .= "   0 AS vl_prev, ";
        $query .= "   0 AS day_prev, ";
        $query .= "   c.ordem ";
        $query .= "FROM ";
        $query .= "   categories c ";
        $query .= "WHERE ";
        $query .= "   c.id IN ( 81, 82, 87, 116, 120, 126, 127, 128 ) ";
        $query .= "ORDER BY ";
        $query .= "   c.ordem DESC ";

        $registers = DB::connection('mysql')->select($query);

        $i=0;
        foreach($registers as $linha) 
        { 
            $categoriesC[] = $linha;
            $i++;
        }

        //======================================

        $categoriesD = Array();

        $query = "";
        $query .= "SELECT ";
        $query .= "   c.id, ";
        $query .= "   c.name, ";
        $query .= "   c.vl_prev, ";
        $query .= "   c.day_prev, ";
        $query .= "   c.ordem ";
        $query .= "FROM ";
        $query .= "   categories c ";
        $query .= "ORDER BY ";
        $query .= "   c.ordem DESC ";

        $registers = DB::connection('mysql')->select($query);

        $i=0;

        $tprev = 0;
        foreach($registers as $linha) 
        { 
            $tprev += $linha->vl_prev;
            $categoriesD[] = $linha;
            $i++;
        }

        //======================================

        $apoio = [];
        $apoio[] = 0; //jan
        $apoio[] = 0; //fev
        $apoio[] = 0; //mar
        $apoio[] = 0; //abr
        $apoio[] = 0; //mai
        $apoio[] = 0; //jun
        $apoio[] = 0; //jul
        $apoio[] = 0; //ago
        $apoio[] = 0; //set
        $apoio[] = 0; //out
        $apoio[] = 0; //nov
        $apoio[] = 0; //dez

        $_param = Param::select(['params.*'])->where('label','=',$ano)->get();
        foreach($_param as $item) {
            $apoio = explode(";", $item->value); 
        }

        $agorax = '2009-12-20 00:00:00';
        $futuro = ($ano) . '-01-01 00:00:00';
        $faixaax= '0';
        $faixabx= '0';

        $query = "";
        $query .= "SELECT ";
        $query .= "   sum(j.vl_entry) AS total ";
        $query .= "FROM ";
        $query .= "   entries j ";
        $query .= "   INNER JOIN categories c ON c.id = j.id_category ";
        $query .= "WHERE ";
        $query .= "   j.status = 1 AND ";
        $query .= "   j.dt_entry ";
        $query .= "   BETWEEN ";
        $query .= "   Str_to_date(Date_format('" . $agorax . "','%Y-%m-%d 00:00:00'),Get_format(DATETIME,'iso'))";
        $query .= "    AND '" . $futuro . "' ";

        $total12 = DB::connection('mysql')->select($query);

        $agorax = '2010-01-01 00:00:00';
        $futuro = ($ano + 1) . '-01-01 00:00:00';
        $faixaax= '0';
        $faixabx= '0';

        $query = "";
        $query .= "SELECT ";
        $query .= "   'C' AS tipo, ";
        $query .= "   j.id, ";
        $query .= "   j.id_category, ";
        $query .= "   c.name AS nm_category, ";
        $query .= "   MONTH(j.dt_entry) AS mes, ";
        $query .= "   YEAR(j.dt_entry) AS ano, ";
        $query .= "   j.vl_entry, ";
        $query .= "   j.ds_category, ";
        $query .= "   j.ds_subcategory, ";
        $query .= "   j.status, ";
        $query .= "   j.fixed_costs, ";
        $query .= "   j.checked, ";
        $query .= "   j.published ";
        $query .= "FROM ";
        $query .= "   entries j ";
        $query .= "   INNER JOIN categories c ON c.id = j.id_category ";
        $query .= "WHERE ";
        $query .= "   j.status = 1 AND ";
        $query .= "   j.published = 1 AND ";
        $query .= "   j.vl_entry > 0 AND ";
        $query .= "   j.dt_entry BETWEEN Str_to_date(Date_format(ADDDATE('" . $agorax . "',+" . $faixabx . "),'%Y-%m-%d 00:00:00'),Get_format(DATETIME,'iso')) AND '" . $futuro . "' ";

        $creditos = DB::connection('mysql')->select($query);

        $query = "";
        $query .= "SELECT ";
        $query .= "   'D' AS tipo, ";
        $query .= "   j.id, ";
        $query .= "   j.id_category, ";
        $query .= "   c.name AS nm_category, ";
        $query .= "   MONTH(j.dt_entry) AS mes, ";
        $query .= "   YEAR(j.dt_entry) AS ano, ";
        $query .= "   j.vl_entry, ";
        $query .= "   j.ds_category, ";
        $query .= "   j.ds_subcategory, ";
        $query .= "   j.status, ";
        $query .= "   j.fixed_costs, ";
        $query .= "   j.checked, ";
        $query .= "   j.published ";
        $query .= "FROM ";
        $query .= "   entries j ";
        $query .= "   INNER JOIN categories c ON c.id = j.id_category ";
        $query .= "WHERE ";
        $query .= "   j.status = 1 AND ";
        $query .= "   j.published = 1 AND ";
        $query .= "   j.vl_entry <= 0 AND ";
        $query .= "   j.dt_entry BETWEEN Str_to_date(Date_format(ADDDATE('" . $agorax . "',+" . $faixabx . "),'%Y-%m-%d 00:00:00'),Get_format(DATETIME,'iso')) AND '" . $futuro . "' ";

        $debitos = DB::connection('mysql')->select($query);

        $spinnerp = "$(\'#spinnerP\').hide();";

        return view($this->path_view . '.detalhe', 
            compact(
                'tprev',
                'lmes',
                'ano',
                'mesesG',
                'categoriesC',
                'categoriesD',
                'debitos',
                'creditos',
                'total12',
                'apoio',
                'spinnerp',
            ));    

    }

    public function uparam(Request $request)
    {

        $ano = $request->input('ano');

        $_param = Param::select(['params.*'])->where('label','=',$ano)->get();

        foreach($_param as $item) {
            $_value = "";
            for ($x=0; $x < 12; $x++)
                $_value .= ($x == 0 ? "" : ";") . $request->input('mes'.$x);
            $item->value = $_value;
            $item->save();
        }

        return response()->redirectToRoute($this->path_view . '.detalhe');        

    }

    public function lupa(Request $request)
    {

        $ano = $request->input('ano', date('Y'));
        $mes = $request->input('mes', 1);
        $categoria = $request->input('cat', 0);
        $debito = $request->input('deb', 0);

        $entries = Array();

        $query = "";

        $query .= "SELECT ";
        $query .= "   id, ";
        $query .= "   id_category, ";
        $query .= "   nm_category, ";
        $query .= "   dt_entry, ";
        $query .= "   dt_entry_br, "; 
        $query .= "   vl_entry, ";
        $query .= "   ds_category, ";
        $query .= "   ds_subcategory, ";
        $query .= "   status, ";
        $query .= "   fixed_costs, ";
        $query .= "   checked, ";
        $query .= "   published ";
        $query .= "FROM ";
        $query .= "   ( ";

        $query .= "SELECT ";
        $query .= "   j.id, ";
        $query .= "   j.id_category, ";
        $query .= "   c.name as nm_category, ";
        $query .= "   j.dt_entry, ";
        $query .= "   COALESCE(DATE_FORMAT(j.dt_entry, '%d/%m'),'') AS dt_entry_br, "; 
        $query .= "   j.vl_entry, ";
        $query .= "   j.ds_category AS ds_category, ";
        $query .= "   CASE WHEN ISNULL(j.ds_subcategory) = 1 THEN '' ELSE j.ds_subcategory END AS ds_subcategory, ";
        $query .= "   j.status, ";
        $query .= "   j.fixed_costs, ";
        $query .= "   j.checked, ";
        $query .= "   j.published ";
        $query .= "FROM ";
        $query .= "   entries j ";
        $query .= "   INNER JOIN categories c ON c.id = j.id_category ";
        $query .= "WHERE ";
        $query .= "   j.status = 1 AND ";
        $query .= "   j.id_category = ".$categoria." AND ";
        $query .= "   YEAR(j.dt_entry) = ".$ano." AND ";
        $query .= "   MONTH(j.dt_entry) = ".$mes." ";

        if ($debito) 
            $query .= " AND j.vl_entry < 0 ";
        else
            $query .= " AND j.vl_entry >= 0 ";

        $query .= ") AS entries ";
        $query.="ORDER BY dt_entry, ds_subcategory";

        $entries = DB::connection('mysql')->select($query);

        return Response::json($entries, 200);

    }

}

