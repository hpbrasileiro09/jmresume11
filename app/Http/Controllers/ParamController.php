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

        return view($this->path_view . '.edit', 
            compact('register', 'page_header', 'valor'));        
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

        return response()->redirectToRoute('entry.index');        
    }    

}
