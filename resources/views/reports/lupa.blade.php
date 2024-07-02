
@extends('reports.layout')

@section('content')

<div class="panel panel-default">
    
    <div class="panel-body">

        <table class="table table-striped table-hover ">    
            <thead>
                <tr>
                    <th scope="col">Data</th>
                    <th scope="col">Descri&ccedil;&atilde;o</th>
                    <th scope="col">Categoria</th>
                    <th scope="col"><font style='float: right;'>Valor</font></th>
                    <th scope="col"><font style='float: right;'>Total</font></th>
                </tr>
            </thead>
            <tbody>
        <?php 

        $total = 0;
        foreach($entries as $entry)
        {
            $total += $entry->vl_entry;
            $linhas = "";
            $linhas .= "<tr>";
            $linhas .= "<td>".$entry->dt_entry_br."</td>";
            $linhas .= "<td>".trataTextoL($entry->ds_category)."&nbsp;".trataTextoL($entry->ds_subcategory)."</td>";
            $linhas .= "<td>".trataTextoL($entry->nm_category)."</td>";
            $linhas .= "<td>".trataValor($entry->vl_entry)."</td>";
            $linhas .= "<td>".trataValor($total)."</td>";
            $linhas .= "</tr>";
            echo $linhas;
        }

        ?>
            </tbody>
        </table>

    </div>

</div>

@endsection
