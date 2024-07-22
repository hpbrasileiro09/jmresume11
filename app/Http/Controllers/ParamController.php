<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;

use App\Models\Param;

use Validator;

class ParamController extends Controller
{

    public $path_view = 'param';

    public $header_view = 'Params';

    public function edit(string $id)
    {
        $page_header = $this->header_view;

        $register = Param::findOrFail($id);

        $register->value = dateToMySqlY($register->value);

        $valor = $register->value;

        $ano = 2025;
        $mes = 1;
        $times = 5;

        return view('param.edit', 
            compact('register', 'page_header', 'valor', 'ano', 'mes', 'times'));        
    }

    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'agora' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect($this->path_view . '/' . $id . '/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $register = Param::findOrFail($id);
        $register->value = $request->input('agora');
        $register->save();

        $kind = 1;
        $msg = 'register was updated successfully';

        session(['kind' => $kind]);
        session(['msg' => $msg]);

        $tipo = $request->input('tipo');

        if ($tipo == 1) return response()->redirectToRoute('entry.index');        
        
        if ($tipo == 2) return response()->redirectToRoute('entry.support');        
        
        return response()->redirectToRoute('entry.index');        
    }    

    public function generate(Request $request)
    {

        //echo "Teste_" . \Request::get('ano');
        //exit(0);

        $validator = Validator::make($request->all(), [
            'ano' => 'required',
            'mes' => 'required',
            'times' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect($this->path_view . '/' . $id . '/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $kind = 1;
        $msg = 'registers was generated successfully';

        session(['kind' => $kind]);
        session(['msg' => $msg]);

        $ano = $request->input('ano');
        $mes = $request->input('mes');
        $times = $request->input('times');

        $retorno = Array();
        $retorno[] = Array('kind', $kind);
        $retorno[] = Array('msg', $msg);
        $retorno[] = Array('ano', $ano);
        $retorno[] = Array('mes', $mes);
        $retorno[] = Array('times', $times);
       
        return $retorno;

        return response()->redirectToRoute('path.edit');        
    }    

}
