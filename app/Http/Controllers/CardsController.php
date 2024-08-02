<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;

use App\Models\Param;

use Validator;

class CardsController extends Controller
{

    public $path_view = 'cards';

    public $header_view = 'Cards';

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
        $imonth = ((date('m') + 1) > 12 ? 1 : (date('m') + 1));
        $month = \Request::get('month');
        $month = ($month == 0 ? $imonth : $month);
        $months = getYearMonths();

        $day = \Request::get('day');
        $day = ($day == 0 ? 15 : $day);

        $payments = "";

        $cartoesx = Array();
        $cartoesx[] = Array( 'id' => 'Mastercard', 'nome' => 'Mastercard', 'dia' => '15', 'day' => 15 );
        $cartoesx[] = Array( 'id' => 'Visa',       'nome' => 'Visa',       'dia' => '8',  'day' => 8 );
        
        $cartoes = MontaCards($cartoesx, $day);
        
        $_param = Param::findOrFail(1);
        $agorax = $_param->value;

        $search = ( $day == 15 ? "Mastercard" : "Visa" );
        $dia = $year . '-' . (strlen($month) == 1 ? '0' : '') . $month . '-' . (strlen($day) == 1 ? '0' : '') . $day;

        $query = $this->montaSql($agorax, $search, false, $dia);

        $registers = DB::connection('mysql')->select($query);

        return view('cards.index', 
        compact(
            'page_header', 
            'year', 
            'month', 
            'years', 
            'months', 
            'payments',
            'cartoes',
            'day',
            'registers',
        ));             

    }

    public function montaSql($agorax, $search, $_union = true, $dia=null)
    {

        $d = new \DateTime( $agorax );
        $d->modify( 'first day of +24 month' );
        $futuro = $d->format( 'Y-m-d' ) . ' 00:00:00';

        $faixaax='0';
        $faixabx='1';

        $query = "";

        $query .= "SELECT ";
        $query .= "   id, ";
        $query .= "   id_category, ";
        $query .= "   nm_category, ";
        $query .= "   dt_entry, ";
        $query .= "   dt_entry_br, "; 
        $query .= "   ano, ";
        $query .= "   mes, ";
        $query .= "   dia, ";
        $query .= "   dia_da_semana, ";
        $query .= "   vl_entry, ";
        $query .= "   ds_category, ";
        $query .= "   ds_subcategory, ";
        $query .= "   ds_detail, ";
        $query .= "   status, ";
        $query .= "   fixed_costs, ";
        $query .= "   checked, ";
        $query .= "   published, ";
        $query .= "   icone, ";
        $query .= "   cartao ";
        $query .= "FROM ";
        $query .= "   ( ";

        if ($_union == true)
        {

            $query .= "SELECT ";
            $query .= "   0 AS id, ";
            $query .= "   0 AS id_category, ";
            $query .= "   'ENTRADA MONEY' AS nm_category, ";
            $query .= "   '' AS dt_entry, ";
            $query .= "   '" . date("d/m/Y",strtotime($agorax)) . "' AS dt_entry_br, "; 
            $query .= "    0 AS ano, ";
            $query .= "    0 AS mes, ";
            $query .= "    0 AS dia, ";
            $query .= "    '' AS dia_da_semana, ";
            $query .= "   SUM(j.vl_entry) AS vl_entry, ";
            $query .= "   '' AS ds_category, ";
            $query .= "   '' AS ds_subcategory, ";
            $query .= "   '' AS ds_detail, ";
            $query .= "   1 AS status, ";
            $query .= "   0 AS fixed_costs, ";
            $query .= "   1 AS checked, ";
            $query .= "   1 AS published, ";
            $query .= "   '' AS icone, ";
            $query .= "   '' AS cartao ";
            $query .= "FROM ";
            $query .= "   entries j ";
            $query .= "WHERE ";
            $query .= "  j.status = 1 ";
            $query .= "  AND j.dt_entry >= '2009-12-20 00:00:00' AND ";
            $query .= "  j.dt_entry <= Str_to_date(Date_format(";
            $query .= "  ADDDATE('" . $agorax . "',+" . $faixaax . "),'%Y-%m-%d 23:59:59'),";
            $query .= "  Get_format(DATETIME,'iso')) ";
            $query .= "UNION ";
        }

        $_images[] = Array( 'id' =>  '89', 'src' => asset('icones/globo.png'),     'alt' => 'globo' );
        $_images[] = Array( 'id' =>  '91', 'src' => asset('icones/telefone.png'),  'alt' => 'telefone' );
        $_images[] = Array( 'id' =>  '90', 'src' => asset('icones/internet.png'),  'alt' => 'internet' );
        $_images[] = Array( 'id' =>  '99', 'src' => asset('icones/luz.gif'),       'alt' => 'luz' );
        $_images[] = Array( 'id' => '100', 'src' => asset('icones/house.png'),     'alt' => 'condominio' );
        $_images[] = Array( 'id' => '102', 'src' => asset('icones/hospital.png'),  'alt' => 'unimed' );
        $_images[] = Array( 'id' => '132', 'src' => asset('icones/sercomtel.png'), 'alt' => 'sercomtel' );
        $_images[] = Array( 'id' => '133', 'src' => asset('icones/internet.png'),  'alt' => 'internet' );

        $query .= "SELECT ";
        $query .= "   j.id, ";
        $query .= "   j.id_category, ";
        $query .= "   c.name as nm_category, ";
        $query .= "   j.dt_entry, ";
        $query .= "   COALESCE(DATE_FORMAT(j.dt_entry, '%d/%m/%Y'),'') AS dt_entry_br, "; 
        $query .= "   year(j.dt_entry) as ano, ";
        $query .= "   month(j.dt_entry) as mes, ";
        $query .= "   day(j.dt_entry) as dia, ";
        $query .= "   CASE DATE_FORMAT(j.dt_entry,'%w') ";
        $query .= "     WHEN  1 THEN 'Segunda' ";
        $query .= "     WHEN  2 THEN 'Terça' ";
        $query .= "     WHEN  3 THEN 'Quarta' ";
        $query .= "     WHEN  4 THEN 'Quinta' ";
        $query .= "     WHEN  5 THEN 'Sexta' ";
        $query .= "     WHEN  6 THEN 'Sábado' ";
        $query .= "     ELSE 'Domingo' ";
        $query .= "   END AS dia_da_semana, ";
        $query .= "   j.vl_entry, ";
        $query .= "   j.ds_category, ";
        $query .= "   j.ds_subcategory, ";
        $query .= "   j.ds_detail, ";
        $query .= "   j.status, ";
        $query .= "   j.fixed_costs, ";
        $query .= "   j.checked, ";
        $query .= "   j.published, ";
        $query .= "  CASE j.id_category ";

        foreach($_images as $item)
        {
            $query .= "     WHEN  ".$item['id']." THEN '<img ";
            $query .= "  src=\"".$item['src']."\" width=\"16\" height=\"16\" border=\"0\" alt=\"".$item['alt']."\" />' ";
        }

        $query .= "     ELSE '' ";
        $query .= "  END AS icone, ";
        $query .= "  CASE j.ds_subcategory ";
        $query .= "     WHEN  'Mastercard' THEN '<img ";
        $query .= "  src=\"".asset("icones/master.gif")."\" width=\"16\" height=\"16\" border=\"0\" alt=\"master\" />' ";
        $query .= "     WHEN  'Visa' THEN '<img ";
        $query .= "  src=\"".asset("icones/visa.gif")."\" width=\"16\" height=\"16\" border=\"0\" alt=\"visa\" />' ";
        $query .= "     WHEN  'Hering' THEN '<img ";
        $query .= "  src=\"".asset("icones/hering.jpg")."\" width=\"16\" height=\"16\" border=\"0\" alt=\"hering\" />' ";
        $query .= "     ELSE '' ";
        $query .= "  END AS cartao ";
        $query .= "FROM ";
        $query .= "   entries j ";
        $query .= "   INNER JOIN categories c ON c.id = j.id_category ";
        $query .= "WHERE ";

        if (strlen($search)) { 
            $query .= " ( ";
            $query .= " j.ds_category LIKE '%" . $search. "%' OR ";
            $query .= " j.ds_subcategory LIKE '%" . $search. "%' OR ";
            $query .= " c.name LIKE '%" . $search. "%' ";
            $query .= " ) ";
            if (strlen($dia)) { 
                $query .= " AND j.dt_entry BETWEEN '" . $dia . " 00:00:00' AND '" . $dia . " 23:59:59' ";
            }
        } else {
            $query .= "  j.dt_entry BETWEEN ";
            $query .= "  Str_to_date(Date_format(ADDDATE('" . $agorax . "',+" . $faixabx . "),'%Y-%m-%d 00:00:00'),";
            $query .= "  Get_format(DATETIME,'iso')) AND '" . $futuro . "' ";
        }

        $query .= ") AS entries ";

        if ($_union == true)
        {
            $query .="ORDER BY dt_entry, ds_subcategory ";
    		//$query .= "LIMIT 0, 25 ";
        } else {
            if (strlen($search)) { 
                if (strlen($dia)) { 
                    $query.="ORDER BY vl_entry ";
                } else {
                    $query.="ORDER BY id DESC ";
                }
            } else {
                $query.="ORDER BY id DESC ";
            }
    		$query .= "LIMIT 0, 40 ";
        }

        return $query;

    }

}
