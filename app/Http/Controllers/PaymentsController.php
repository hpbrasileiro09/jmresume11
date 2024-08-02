<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;

use App\Models\Param;

use Validator;

class PaymentsController extends Controller
{

    public $path_view = 'payments';

    public $header_view = 'Payments';

    public function index()
    {

        $page_header = $this->header_view;

        $i = 0;
        $year = \Request::get('year');
        $year = ($year == 0 ? date('Y') : $year);
        $years = Array();
        while(true)
        { 
            if ($i >= 5) break;
            $years[] = Array( 'id' => ($year + $i), 'nome' => ($year + $i) );
            $i++;
        }

        $i = 1;
        $month = \Request::get('month');
        $month = ($month == 0 ? date('m') : $month);
        $months = getYearMonths();

        if ($month+1 == 13) $month = 0;
        $mes = (($month+1) >= 10 ? ($month+1) : "0".($month+1));

        $payments = "";
        $payments .= ".:Pagamentos:.\n";
        $payments .= "- Sesi 10/".$mes." |>\n";
        $payments .= "- Visa 08/".$mes." | Dia Bom 01 |>\n";
        $payments .= "- Golden Place 05/".$mes." |> (recebi mas falta chegar no banco)\n";
        $payments .= "- Mercado 10/".$mes." | Dia Bom 02 |>\n";
        $payments .= "- Campana 10/".$mes." | R$ 92.00 (3 de 3) |\n";
        $payments .= "- Vivo Fibra 17/".$mes." |> 10/08 e-mail deve chegar |> R$ 150.00 |\n";
        $payments .= "- Unimed 31/".$mes." |> 08/".$mes." gera o Boleto |> (verificar e-mail Rosana) |\n";
        $payments .= "- Vivo Controle 02/".$mes." | Débito Automático |> R$ 35.50\n";
        $payments .= "- Mastercard Multiplo 15/".$mes." | Débito Automático | Dia Bom 06 |>\n";
        $payments .= "- Luz 25/".$mes." | Débito Automático |>";

        return view('payments.index', 
        compact(
            'page_header', 
            'year', 
            'month', 
            'years', 
            'months', 
            'payments'
        ));        

    }

}
