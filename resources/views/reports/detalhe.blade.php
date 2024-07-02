
<x-app-layout>

    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <br/>
              <div class="box-tools">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('entry.index') }}"><span data-feather="dollar-sign"></span></a>
                    <a href="{{ route('entry.support') }}"><span data-feather="tool"></span></a>
                    <a href="{{ route('time.index') }}"><span data-feather="calendar"></span></a>
                    <a href="{{ route('entry.create') }}"><span data-feather="plus-square"></span></a>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
            
                <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                            <th scope="col"></th>
                            <th scope="col"><font style='float: left;'>Categoria&nbsp;<?php echo $ano; ?></font></th>
                            <th scope="col"></th>
                            <?php
                            foreach($mesesG as $lmes) 
                            {
                                echo "<th scope=\"col\"><font style='float: right;'>".$lmes['abrev']."</font></th>";
                            }
                            ?>
                        </tr>
                    </thead>
                        <tfoot>
                      <tr>
                          <td colspan="14"><em>Jm Detalhe&nbsp;<?php echo $ano; ?></em></td>
                          <td>&nbsp;</td>
                        </tr>
                    </tfoot>
                    <tbody>

                <?php 

                $jan = Array();
                $fev = Array();
                $mar = Array();
                $abr = Array();
                $mai = Array();
                $jun = Array();
                $jul = Array();
                $ago = Array();
                $set = Array();
                $out = Array();
                $nov = Array();
                $dez = Array();

                foreach($categoriesC as $category)
                {

                    $item = Array();
                    $item['tipo'] = 'C'; 
                    $item['ordem'] = $category->ordem; 
                    $item['name'] = $category->name; 
                    $item['category_id'] = $category->id; 
                    $item['vl_prev'] = $category->vl_prev; 

                    $x=1;
                    foreach($mesesG as $lmes) 
                    {
                        $vl_entry = 0;
                        foreach($creditos as $entry)
                        {
                            if ($entry->mes == $lmes['id'] && $entry->ano == $lmes['ano'] && $entry->id_category == $category->id) 
                            {
                                $vl_entry += $entry->vl_entry;
                            }
                        }
                        if ($x ==  1) $jan[] = $vl_entry;
                        if ($x ==  2) $fev[] = $vl_entry;
                        if ($x ==  3) $mar[] = $vl_entry;
                        if ($x ==  4) $abr[] = $vl_entry;
                        if ($x ==  5) $mai[] = $vl_entry;
                        if ($x ==  6) $jun[] = $vl_entry;
                        if ($x ==  7) $jul[] = $vl_entry;
                        if ($x ==  8) $ago[] = $vl_entry;
                        if ($x ==  9) $set[] = $vl_entry;
                        if ($x == 10) $out[] = $vl_entry;
                        if ($x == 11) $nov[] = $vl_entry;
                        if ($x == 12) $dez[] = $vl_entry;

                        $item['M'.$x] = $vl_entry; 
                        $item['MA'.$x] = $lmes['ano']; 
                        $item['MI'.$x] = $lmes[ 'id']; 
                        $item['VP'.$x] = 0; 

                        $x++;
                    }

                    $geral[] = $item;

                }

                foreach($geral as $gitem)
                {

                    if ($gitem['tipo'] != 'C') continue;
                    
                    $xvalue = 0;
                    for ($z=1; $z<=12; $z++) {
                        $xvalue += $gitem['M'.$z];
                    }

                    if ($xvalue == 0) continue;

                    echo "<tr>";
                    echo "<td>".trataTextoSize($gitem['ordem'])."</td>";
                    echo "<td>".$gitem['name'].'&nbsp;('.trataTextoSize($gitem['category_id']).")</td>";
                    echo "<td>".trataValorB($gitem['vl_prev'])."</td>";
                    for ($z=1; $z<=12; $z++) {
                        echo "<td>".trataValorA($gitem['M'.$z], $gitem['MA'.$z], $gitem['MI'.$z], $gitem['category_id'])."</td>";
                    }
                    echo "</tr>";

                }

                $creditosT = Array();

                ?>

                    <tr>
                        <td><em></em></td>
                        <td><em>Cr&eacute;dito</em></td>
                        <td><em></em></td>
                        <?php
                        $tval = 0;
                        foreach($jan as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($fev as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($mar as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($abr as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($mai as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($jun as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($jul as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($ago as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($set as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($out as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($nov as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($dez as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        ?>
                    </tr>

                <?php

                $jan = Array();
                $fev = Array();
                $mar = Array();
                $abr = Array();
                $mai = Array();
                $jun = Array();
                $jul = Array();
                $ago = Array();
                $set = Array();
                $out = Array();
                $nov = Array();
                $dez = Array();

        $geral = Array();

                foreach($categoriesD as $category)
                {

                    $item = Array();
                    $item['tipo'] = 'D'; 
                    $item['ordem'] = $category->ordem; 
                    $item['name'] = $category->name; 
                    $item['category_id'] = $category->id; 
                    $item['vl_prev'] = $category->vl_prev; 

                    $x=1;
                    foreach($mesesG as $lmes) 
                    {
                        $vl_prev = 0;
                        $vl_entry = 0;
                        foreach($debitos as $entry)
                        {
                            if ($entry->mes == $lmes['id'] && $entry->ano == $lmes['ano'] && 
                                $entry->id_category == $category->id) 
                            {
                                $vl_entry += $entry->vl_entry;
                            }
                        }
                        if ($vl_entry == 0) {
                            if ($category->vl_prev != 0) {
                                $vl_entry = $category->vl_prev;
                                $vl_prev = 1;
                            }
                        }
                        if ($x ==  1) $jan[] = $vl_entry;
                        if ($x ==  2) $fev[] = $vl_entry;
                        if ($x ==  3) $mar[] = $vl_entry;
                        if ($x ==  4) $abr[] = $vl_entry;
                        if ($x ==  5) $mai[] = $vl_entry;
                        if ($x ==  6) $jun[] = $vl_entry;
                        if ($x ==  7) $jul[] = $vl_entry;
                        if ($x ==  8) $ago[] = $vl_entry;
                        if ($x ==  9) $set[] = $vl_entry;
                        if ($x == 10) $out[] = $vl_entry;
                        if ($x == 11) $nov[] = $vl_entry;
                        if ($x == 12) $dez[] = $vl_entry;

                        $item['M'.$x] = $vl_entry; 
                        $item['MA'.$x] = $lmes['ano']; 
                        $item['MI'.$x] = $lmes['id']; 
                        $item['VP'.$x] = $vl_prev; 

                        $x++;
                    }

                    $geral[] = $item;

                }

                foreach($geral as $gitem)
                {

                    if ($gitem['tipo'] != 'D') continue;

                    $xvalue = 0;
                    for ($z=1; $z<=12; $z++) {
                        $xvalue += $gitem['M'.$z];
                    }

                    if ($xvalue == 0) continue;

                    echo "<tr>";
                    echo "<td>".trataTextoSize($gitem['ordem'])."</td>";
                    echo "<td>".$gitem['name'].'&nbsp;('.trataTextoSize($gitem['category_id']).")</td>";
                    echo "<td>".trataValorB($gitem['vl_prev'])."</td>";
                    for ($z=1; $z<=12; $z++) {
                        echo "<td>".trataValorA($gitem['M'.$z], $gitem['MA'.$z], $gitem['MI'.$z], $gitem['category_id'], 1, $gitem['VP'.$z])."</td>";
                    }
                    echo "</tr>";

                }

                $debitosT = Array();

                ?>

                    <tr>
                        <td><em></em></td>
                        <td><em>D&eacute;bito</em></td>
                        <?php
                        echo "<td>".trataValorB($tprev)."</td>";
                        $tval = 0;
                        foreach($jan as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($fev as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($mar as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($abr as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($mai as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($jun as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($jul as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($ago as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($set as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($out as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($nov as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($dez as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        ?>
                    </tr>

                    <tr>
                        <td><em></em></td>
                        <td><em></em></td>
                        <td><em></em></td>
                        <?php
                        $x=0;
                        foreach($creditosT as $icred)
                        {
                            $resp = $icred + $debitosT[$x++];
                            echo "<td>".trataValor($resp)."</td>";
                        }
                        ?>
                    </tr>                

                </tbody>
              </table>

               <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                            <th scope="col"></th>
                            <th scope="col"><font style='float: left;'>Categoria&nbsp;<?php echo $ano; ?></font></th>
                            <th scope="col"></th>
                            <?php
                            foreach($mesesG as $lmes) 
                            {
                                echo "<th scope=\"col\"><font style='float: right;'>".$lmes['abrev']."</font></th>";
                            }
                            ?>
                        </tr>
                    </thead>
                        <tfoot>
                      <tr>
                          <td colspan="14"><em>Jm Detalhe&nbsp;<?php echo $ano; ?></em></td>
                          <td>&nbsp;</td>
                        </tr>
                    </tfoot>
                    <tbody>

                    <!-- ================================= -->

                    <?php

                    $valor12 = 0;
                    foreach($total12 as $item) 
                    {
                        $valor12 += $item->total;
                    }

                    $resumo = [];

                    $x=0;
                    $clinha = []; 
                    foreach($creditosT as $icred)
                    {
                        $resp = $creditosT[$x++];
                        $clinha[] = $resp;
                    }

                    $resumo[] = $clinha;

                    $x=0;
                    $dlinha = []; 
                    foreach($debitosT as $icred)
                    {
                        $resp = $debitosT[$x++];
                        $dlinha[] = $resp;
                    }

                    $resumo[] = $dlinha;

                    for($x = 0; $x<count($clinha); $x++) {
                        $_cre = $clinha[$x];
                        $_deb = $dlinha[$x];
                        $_last = $_cre + $_deb;
                        $tlinha[] = $_last;
                    }

                    //$resumo[] = $tlinha;

                    $x = 0;    
                    $_html = "";

                    $_html .= "<tr>";
                    $_html .= "<td><em></em></td>";
                    $_html .= "<td><em></em></td>";
                    $_html .= "<td><em></em></td>";
                    for($x = 0; $x<count($clinha); $x++) {
                        $_html .= "<td><em></em></td>";
                    }
                    $_html .= "</tr>";                

                    $_html .= "<tr>";
                    $_html .= "<td><em></em></td>";
                    $_html .= "<td><em>ACUMULADO</em></td>";
                    $_html .= "<td><em></em></td>";
                    $_last = 0;
                    for($x = 0; $x<count($clinha); $x++) {
                        $_cre = $clinha[$x];
                        $_deb = $dlinha[$x];
                        $_apo = 0.0; //$apoio[$x];
                        if ($x == 0) { 
                            $_last = $valor12; 
                        }
                        $_html .= "<td>".trataValor($_last)."</td>";
                        $_last += $_cre + $_apo + $_deb; 
                    }
                    $_html .= "</tr>";                

                    $x=0;
                    foreach($resumo as $linha) {
                        $_label = "";
                        if ($x == 0) $_label = "CRÉDITO";
                        if ($x == 1) $_label = "DÉBITO";
                        $_html .= "<tr>";
                        $_html .= "<td><em></em></td>";
                        $_html .= "<td><em>" . $_label . "</em></td>";
                        $_html .= "<td><em></em></td>";
                        foreach($linha as $item)
                        {
                            $_html .= "<td>".trataValor($item)."</td>";
                        }
                        $_html .= "</tr>";                
                        $x++;
                    } 

                    $_html .= "<tr>";
                    $_html .= "<td><em></em></td>";
                    $_html .= "<td><em>RESUMO</em></td>";
                    $_html .= "<td><em></em></td>";
                    $_last = 0;
                    for($x = 0; $x<count($clinha); $x++) {
                        $_cre = $clinha[$x];
                        $_deb = $dlinha[$x];
                        $_apo = 0.0; //$apoio[$x];
                        if ($x == 0) { 
                            $_last = $valor12; 
                        } 
                        $_last += $_cre + $_apo + $_deb; 
                        $_html .= "<td>".trataValor($_last)."</td>";
                    }
                    $_html .= "</tr>";                

                    $_html .= "<tr>";
                    $_html .= "<td><em></em></td>";
                    $_html .= "<td><em></em></td>";
                    $_html .= "<td><em></em></td>";
                    for($x = 0; $x<count($clinha); $x++) {
                        $_html .= "<td><em></em></td>";
                    }
                    $_html .= "</tr>";                

                    echo $_html;

                    ?>

                    <!-- ================================= -->

                </tbody>
              </table>

                <!-- Modal -->
                <div id="myModalX" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" style="max-width: 100%; max-height: 100%; height: auto; display: table;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <iframe width="100%" height="100%" frameborder="0" scrolling="yes" marginheight="0" marginwidth="0" id="ifrm" src="#"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

<script>
  $(function () {

    $("a[href=\\#myModalX]").click(function(ev) {

        ev.preventDefault();

        var path = $(this).attr("path");

        $('#ifrm').attr('src', path);

        $('#ifrm').css('height',$(window).height()*0.6);

        //$('.modal-content').css('height',$( window ).height()*0.4);

    });

  });
</script>

</x-app-layout>
