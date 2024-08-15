<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;

use App\Models\Param;

use App\Models\Entry;

use App\Models\Category;

use Validator;

class ToolsController extends Controller
{

    public $path_view = 'tools';

    public $header_view = 'Tools';

    public function index()
    {

        $page_header = $this->header_view;

        $alert = '';

        $i = 0;
        $year = \Request::get('year');
        $year = ($year == 0 ? date('Y') : $year);
        $years = Array();
        while(true)
        { 
            if ($i >= 7) break;
            $years[] = Array( 'id' => ($year + $i), 'nome' => ($year + $i) );
            $i++;
        }

        $i = 1;
        $month = \Request::get('month');
        $month = ($month == 0 ? date('m') : $month);
        $months = getYearMonths();

        if ($month+1 == 13) $month = 0;
        $mes = (($month+1) >= 10 ? ($month+1) : "0".($month+1));

        $update = \Request::get('update');
        $action = \Request::get('action');

        $mat = \Request::get("bag");
        $mat0 = explode(",", $mat); 

        /*
        $dt_inicio = "2024-01-01 00:00:00";
        $dt_fim = "2025-01-01 00:00:00";
        $query = $this->montaSql($dt_inicio, $dt_fim);
        $registers = DB::connection('mysql')->select($query);
        */

        $_category = new Category();
        $categories = $_category->all();

        $registers = Array();
        $registers[] = Array( 'id' => 1,  'id_category' => 100, 'vencimento' => 4,  'ds_category' => 'Condominio Golden Place', 'vl_entry' => -500.0,   'ds_subcategory' => '' );
        $registers[] = Array( 'id' => 2,  'id_category' => 87,  'vencimento' => 5,  'ds_category' => 'Crédito',                 'vl_entry' => 4100.0,   'ds_subcategory' => '' );
        $registers[] = Array( 'id' => 3,  'id_category' => 86,  'vencimento' => 8,  'ds_category' => 'Mercado',                 'vl_entry' => -800.0,   'ds_subcategory' => '' );
        $registers[] = Array( 'id' => 4,  'id_category' => 97,  'vencimento' => 8,  'ds_category' => 'Prime Video',             'vl_entry' => -14.9,    'ds_subcategory' => 'Visa' );
        $registers[] = Array( 'id' => 5,  'id_category' => 113, 'vencimento' => 10, 'ds_category' => 'Sesi',                    'vl_entry' => -1098.96, 'ds_subcategory' => '' );
        $registers[] = Array( 'id' => 6,  'id_category' => 97,  'vencimento' => 15, 'ds_category' => 'Microsoft*xbox',          'vl_entry' => -44.99,   'ds_subcategory' => 'Mastercard' );
        $registers[] = Array( 'id' => 7,  'id_category' => 119, 'vencimento' => 15, 'ds_category' => 'Netflix',                 'vl_entry' => -44.9,    'ds_subcategory' => 'Mastercard' );
        $registers[] = Array( 'id' => 8,  'id_category' => 132, 'vencimento' => 15, 'ds_category' => 'Vivo Controle',           'vl_entry' => -35.5,    'ds_subcategory' => '' );
        $registers[] = Array( 'id' => 9,  'id_category' => 133, 'vencimento' => 15, 'ds_category' => 'Vivo Fibra',              'vl_entry' => -150.0,   'ds_subcategory' => '' );
        $registers[] = Array( 'id' => 10, 'id_category' => 106, 'vencimento' => 17, 'ds_category' => 'Sesi Ristorante',         'vl_entry' => -260.0,   'ds_subcategory' => '' );
        $registers[] = Array( 'id' => 11, 'id_category' => 99,  'vencimento' => 21, 'ds_category' => 'Luz Golden Place',        'vl_entry' => -260.0,   'ds_subcategory' => '' );
        $registers[] = Array( 'id' => 12, 'id_category' => 140, 'vencimento' => 28, 'ds_category' => 'Unimed',                  'vl_entry' => -850.0,   'ds_subcategory' => '' );

        /*
        86 Mercado
        87 Crédito SL    
        97 Prime Video (Visa)
        97 Microsoft*xbox (Mastercard)
        99 Luz Golden Place
        100 Condominio Golden Place
        113 Sesi 
        119 Netflix (Mastecard)
        132 Vivo Controle
        133 Vivo Fibra
        140 Unimed
        */

        $payments = "";

        if ($update == 'on') {

            $grava = 1;

            $year = \Request::get('year');
            $month = \Request::get('month');

            $i = 0;
            foreach($registers as $register) {
                $im = 0;
                foreach($mat0 as $item)
                {
                    if ($register['id'] == $item) {
                        $im = 1;
                        break;
                    }
                }
                if ($im == 1) {
                    $dt_entry = $year . "-" . (strlen($month) <= 1 ? '0' : '').$month . "-" . (strlen($register['vencimento']) <= 1 ? '0' : '').$register['vencimento'];
                    $dt_entry = $dt_entry . " 00:00:00";
                    $vl_entry = $register['vl_entry'];
                    if ($grava == 1) {
                        $_reg = Entry::create([
                            'id_category' => $register['id_category'],
                            'dt_entry' => $dt_entry, 
                            'vl_entry' => $vl_entry,
                            'nm_entry' => '',
                            'ds_category' => $register['ds_category'],
                            'ds_subcategory' => $register['ds_subcategory'],
                            'status' => '1',
                            'fixed_costs' => '1',
                            'checked' => '0',
                            'published' => '1',
                            'ds_detail' => '',
                        ]);
                    }
                    $i += 1;
                }
            }

            if ($i > 0) {
                $kind = 1;
                $msg = $i . " register(s) were created successfully!";
                session(['kind' => $kind]);
                session(['msg' => $msg]);
                $alert = MontaAlert();
            }
    
        }

        return view('tools.index', 
        compact(
            'page_header', 
            'year', 
            'month', 
            'years', 
            'months', 
            'payments',
            'registers',
            'update',
            'alert',
            'categories',
        ));        

    }

    public function montaSql($dt_inicio, $dt_fim)
    {

        $query = "";
        $query .= "SELECT ";
        $query .= "   ano, ";
        $query .= "   id_category, ";
        $query .= "   c.name as nm_category, ";
        $query .= "   vl_entry ";
        $query .= "FROM ( ";
        $query .= "SELECT ";
        $query .= "   year(j.dt_entry) as ano, ";
        $query .= "   j.id_category, ";
        $query .= "   SUM(j.vl_entry)/12 AS vl_entry ";
        $query .= "FROM ";
        $query .= "   entries j ";
        $query .= "WHERE ";
        $query .= "  j.dt_entry BETWEEN '" . $dt_inicio . "' AND '" . $dt_fim . "' ";
        $query .= "  AND j.fixed_costs = 1 ";
        $query .= "  AND j.vl_entry <= 0.0 ";
        $query .= "GROUP BY ";
        $query .= "   year(j.dt_entry), ";
        $query .= "   j.id_category ";
        $query .= ") AS Temp ";
        $query .= "   INNER JOIN categories c ON c.id = Temp.id_category ";

        return $query;

    }

}
