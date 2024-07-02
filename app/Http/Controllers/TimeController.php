<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;

use App\Models\Entry;

use App\Models\Category;

use App\Models\Param;

use Validator;

class TimeController extends Controller
{

    public $path_view = 'time';

    public $header_view = 'Times';

    public function index()
    {
        $page_header = $this->header_view;

        $categories = Array();
        $_cat = new Category();
        $_categories = $_cat->select(['categories.*'])->orderBy('name','ASC')->get();

        $i=0;
        foreach($_categories as $linha)
        { 
            $categories[] = Array( 'id' => $linha->id, 'nome' => $linha->name . "&nbsp;(" . $linha->id . ")" );
            $i++;
        }

        $categories = MontaIdCategory($categories, 0, 200);

        $parcelas = Array();
        for ($p=2; $p<=12; $p++) {
          $parcelas[] = Array( 'id' => $p, 'nome' => $p );
        }

        $parcelas = MontaParcelas($parcelas,0);

        $years = Array();
        for ($p=date('Y'); $p<=date('Y')+10; $p++) {
          $years[] = Array( 'id' => $p, 'nome' => $p );
        }

        $years = MontaDrop('year',$years,date('Y'));

        $months = Array();
        for ($p=1; $p<=12; $p++) {
          $months[] = Array( 'id' => $p, 'nome' => $p );
        }

        $months = MontaDrop('month',$months,date('m'));

        $alert = MontaAlert();

        $cartoes = Array();
        $cartoes[] = Array( 'id' => 'Mastercard', 'nome' => 'Mastercard', 'dia' => '15' );
        $cartoes[] = Array( 'id' => 'Visa',       'nome' => 'Visa',       'dia' => '8'  );
        $cartoes[] = Array( 'id' => 'Hering',     'nome' => 'Hering',     'dia' => '20' );

        $cartoes = MontaCartoes($cartoes,'Mastercard');

        $vlTotal = 120.0;
        //$vlTotal = number_format($vlTotal, 2, '.', '.');
        $descricao = 'Teste';

        return view($this->path_view . '.index', 
            compact(
                'vlTotal',
                'descricao',
                'categories', 
                'parcelas',
                'cartoes',
                'years',
                'months',
                'page_header',
                'alert'
            ));

    }

    public function store(Request $request)
    {

        date_default_timezone_set('America/Sao_Paulo');

        $kind = 0;
        $msg = "";
        $acao = "";
        $query = "";
        $status = 1;
        $fixed_costs = 0;
        $checked = 0;
        $published = 1;

        $ano = 0;
        $mes = 0;
        $hora = date("H:i:s");
        $agora = date("Y-m-d") . ' ' . $hora;
        $ano = $request->input('year');
        $mes = $request->input('month');

        $acao = (string) $request->input('acao');

        $cartoes = Array();
        $cartoes[] = Array( 'id' => 'Mastercard', 'nome' => 'Mastercard', 'dia' => '15' );
        $cartoes[] = Array( 'id' => 'Visa',       'nome' => 'Visa',       'dia' => '8'  );
        $cartoes[] = Array( 'id' => 'Hering',     'nome' => 'Hering',     'dia' => '20' );

        if ($acao == 'salvar') 
        {

            $id_category    = $request->input('id_category');
            $card           = $request->input('cards');
            $times          = $request->input('times');
            $vl_entry       = $request->input('vl_entry');
            $ds_category    = "";
            $ds_subcategory = $card;

            $dia = 1;
            foreach ($cartoes as $k => $v) {
                if ($card == $v['id']) {
                    $dia = $v['dia'];
                }
            }
            
            for ($x = 1; $x <= $times; $x++) 
            {
            
                $vl_entry    = $request->input('vlParcela_'.$x);
                $ds_category = $request->input('descricao_'.$x);
                $dt_entry    = $ano . '-' . $mes . '-' . $dia . ' ' . $hora;
            
                if ($vl_entry >= 0) {
                    $vl_entry = ($vl_entry * -1);
                }
            
                $_reg = Entry::create([
                    'id_category' => $id_category,
                    'dt_entry' => $dt_entry,
                    'vl_entry' => $vl_entry,
                    'ds_category' => $ds_category,
                    'ds_subcategory' => $ds_subcategory,
                    'status' => $status,
                    'fixed_costs' => $fixed_costs,
                    'checked' => $checked,
                    'published' => $published,
                ]);

                $mes++;

                if ($mes == 13) { 
                    $mes = 1;
                    $ano++;
                }
                
            }
            
            $kind = 1;
            $msg = 'registers were created successfully';

            session(['kind' => $kind]);
            session(['msg' => $msg]);

        }        

        return redirect($this->path_view);

        return [
            'message' => 'OK',
            'request' => $request->all(),
        ];        

    }

    public function show($id)
    {

        $query = "";
        $query .= "SELECT ";
        $query .= "   j.ds_category, ";
        $query .= "   j.ds_subcategory ";
        $query .= "FROM ";
        $query .= "   entries j ";
        $query .= "WHERE ";
        $query .= "   j.id_category = " . $id . " ";
        if ($id == 113) $query .= "  AND j.ds_subcategory = '' ";
        $query .= "ORDER BY ";
        $query .= "   j.id DESC ";

        $registers = DB::connection('mysql')->select($query);

        $ds_category = "";
        $ds_subcategory = "";

        foreach($registers as $_item)
        {
            $ds_category = $_item->ds_category;
            $ds_subcategory = $_item->ds_subcategory;
            break;
        }

        $_last = Array();
        $_last[] = Array( 
            'ds_category' => $ds_category, 
            'ds_subcategory' => $ds_subcategory, 
        );

        return $_last;

    }

}
