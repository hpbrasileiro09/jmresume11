<x-app-layout>

<div class="card mt-5" style="background-color: #EDEBB1;">
  <h2 class="card-header">Times</h2>
  <div class="card-body">
          
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
           <a href="{{ route('entry.index') }}"><span data-feather="dollar-sign"></span></a>
           <a href="{{ route('entry.support') }}"><span data-feather="tool"></span></a>
           <!--a href="{{ route('time.index') }}"><span data-feather="calendar"></span></a-->
           <a href="{{ route('param.edit', 1) }}"><span data-feather="settings"></span></a>
           <a href="{{ route('entry.create') }}"><span data-feather="plus-square"></span></a>
        </div>

<?php echo $alert; ?>

<form action="{{ route('time.store') }}" id="fparcela" name="fparcela" class="form-horizontal" method="post">

<div class="row">

<div class="col-md-5 col-sm-5">

    {!! csrf_field() !!}

    <div class="row">
      <div class="col-4">
        <div class="form-group">
          <label for="times" class="control-label">Parcelas</label>
          <?php echo $parcelas; ?>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label for="cards" class="control-label">Cartões</label>
          <?php echo $cartoes; ?>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label for="id_day" class="control-label">Dia</label>
          <input type='number' class="form-control" name='id_day' id='id_day' value='<?php echo $id_day; ?>' placeholder='day' />
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-4">
        <div class="form-group">
          <label for="year" class="control-label text-nowrap ">Iniciar Ano</label>
          <?php echo $years; ?>
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label for="year" class="control-label text-nowrap ">Iniciar Mês</label>
          <?php echo $months; ?>
        </div>
      </div>
      <div class="col-4">
      </div>
    </div>
    <div class="row">
      <div class="col-4">
        <div class="form-group">
          <label for="id_category" class="control-label">Categoria</label>
          <?php echo $categories; ?>
        </div>
      </div>
      <div class="col-8">
        <div class="form-group">
          <label for="ds_category" class="control-label">Descrição</label>
          <input type='text' class="form-control" name='ds_category' id='ds_category' value='<?php echo $descricao; ?>' placeholder='ds_category' />
          <input type='hidden' name='ds_subcategory' id='ds_subcategory' value='' placeholder='ds_subcategory' />
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-4">
        <div class="form-group">
          <label for="vl_entry" class="control-label text-nowrap">Valor Total</label>
          <input type='text' class="form-control" style='text-align: right;' name='vl_entry' id='vl_entry' value='<?php echo $vlTotal; ?>'  placeholder='vl_entry' />
        </div>
      </div>
      <div class="col-8">
      </div>
    </div>
    <div class="row">
      <div class="col-6">
        <div class="form-group">
          <input type="hidden" name="acao" id="acao" value="salvar" />
          <label class="control-label text-nowrap"></label>
          <input type="button" value="Gerar Parcelas" id="form-parcelas" class="btn btn-primary" style="margin-top: 10px;"/>
        </div>
      </div>
      <div class="col-6">
      </div>
    </div>

  </div> <!--div class="col-xs-4"-->

<div class="col-md-7 col-sm-7">

      <input type="button" value="Recalcular" style="display: none; float: right;margin-top: 20px;" id="form-calcula" class="btn btn-primary" />

      <table id="grid" class="table table-striped table-hover ">
        <thead>
          <tr>
            <th style='text-align: left; width:10px;'>Parcela</th>
            <th style='text-align: left; width:15px;'>Vencimento</th>
            <th align="left">Descrição</th>
            <th style='text-align: left; width:30px;'>Cartão</th>
            <th style='text-align: right; width:100px;'>Vl.Parcela</th>
          </tr>
        </thead>
        <tr>
          <td align="center" colspan="5">&nbsp;</td>
        </tr>
      </table>
                    
      <div id="botao_salvar" style="display: none; float: right; padding-top: 20px;">
        <button id="submitp" class="btn btn-primary button_submit">Save changes</button>
      </div>

</div> <!--div class="col-xs-8"-->

</div> <!--div class="row"-->

</form>

</div>

</div>

<form id="lastdscategory" name="lastdscategory" action="#" method="post">
  <input type="hidden" name="id_category" id="id_category" value="0" />
</form> 

<script>
  $(function () {

    let mcards = [
    <?php 
    $icont = 0;
    foreach($cartoesx as $cartx) { 
      echo ($icont == 0 ? "{ " : ",\n{ "); 
      echo "\"id\": \"" . $cartx['id'] . "\", ";
      echo "\"nome\": \"" . $cartx['nome'] . "\", ";
      echo "\"dia\": \"" . $cartx['dia'] . "\", ";
      echo "\"day\": " . $cartx['day'] . " ";
      echo "} ";
      $icont += 1;
    } 
    ?>
    ];

    $('#id_category').on('change', function() {
        $('#lastdscategory input:hidden[id=id_category]').val( $(this).val() );
        lastDsCategory();
    });

    $('#cards').on('change', function() {
        var iCard = $(this).val();
        var sDay = mcards.find(carx => carx.id === iCard);
        $('#id_day').val(sDay.day);
    });

    var lastDsCategory = function() {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '{{ route("entry.lastcat") }}',
            data: $("form[id=lastdscategory]").serialize(),
            success: function(data) {
                $.each(data, function(key, value){
                    $('input:text[id=ds_category]').val(value.ds_category);    
                    $('input:text[id=ds_subcategory]').val(value.ds_subcategory);    
                });
            },       
            error: function(jqXHR, textStatus, errorThrown) {  
                $("#msg").html('failure! please verify');
            }              
        });         
    };

    $(function parcelas() {
        $("select[name=times]").change(function() {
            if( $(this).val() ) {
                geraParcelas();
            }
        });
    });

    $('#form-parcelas').click(function() {
        geraParcelas();
    });

    $('#form-calcula').on('click', function() {
        var $valor = 0.0;
        var $fParcela = 0.0;
        var $sCartao = $('#fparcela select[id=cards]').val();
        var $sParcela = $('#fparcela select[id=times]').val();
        var $sVlTotal = $('#fparcela input:text[id=vl_entry]').val();
        for (var $x=1; $x<=$sParcela; $x++) {
            $fParcela = roundTo2Decimals($('#vlParcela_'+$x+'').val());
            $valor += parseFloat($fParcela);
        }
        $('#total').val(roundTo2Decimals($valor));
        if ($sCartao == "Crédito") { 
          if ($sVlTotal < 0.0) {
            $sVlTotal = $sVlTotal * -1;
          }
        } 
        if ($sCartao == "Débito") { 
          if ($sVlTotal >= 0.0) {
            $sVlTotal = $sVlTotal * -1;
          }
        } 
        $('#martelo').val(roundTo2Decimals($sVlTotal - $valor));
        return true;
    });

    var roundTo2Decimals = function(numberToRound) {
        return Math.round(numberToRound * 100) / 100;
    };

    var padDigits = function(number, digits) {
        return Array(Math.max(digits - String(number).length + 1, 0)).join(0) + number;
    };  

    var geraParcelas = function( ) {

        var $digitos = 2;
        var $total = 0.0;
        var $dataH = "";
        var $sParcela = $('#fparcela select[id=times]').val();
        var $sCartao = $('#fparcela select[id=cards]').val();
        var $sYear = $('#fparcela select[id=year]').val();
        var $sMonth = $('#fparcela select[id=month]').val();

        var $sVlTotal = $('#fparcela input:text[id=vl_entry]').val();

        var $sVlParcela = roundTo2Decimals($sVlTotal / $sParcela);
        var $sDescricao = $('#fparcela input:text[id=ds_category]').val();
        var $fVlParcela = 'R$ ' + parseFloat($sVlParcela, 10).toFixed($digitos).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
        var $iDay = 0;
        var $sDia = "0";
        var $iMonth = $sMonth;
        var $iYear = $sYear;

        if ($sCartao == "Visa")       { $sDia = "08"; $iDay = 8;  } 
        if ($sCartao == "Mastercard") { $sDia = "15"; $iDay = 15; } 
        if ($sCartao == "Hering")     { $sDia = "20"; $iDay = 20; } 
        if ($sCartao == "Crédito")    { $sDia = "0"; $iDay = 0;   } 
        if ($sCartao == "Débito")     { $sDia = "0"; $iDay = 0;   } 

        if ($iDay == 0) {
          $iDay = $('#id_day').val();
          $iDay = ($iDay <= 0 ? 5 : $iDay);
          $sDia = ($iDay < 10 ? '0' : '') + '' + $iDay;
          if ($sCartao == "Crédito") { 
            if ($sVlParcela < 0.0) {
              $sVlParcela = $sVlParcela * -1;
            }
          } 
          if ($sCartao == "Débito") { 
            if ($sVlParcela >= 0.0) {
              $sVlParcela = $sVlParcela * -1;
            }
          } 
        }

        $('#grid tr:gt(0)').remove();
        
        for (var $x=1; $x<=$sParcela; $x++) {
            if ($x == 1) {
                $('#form-calcula').show();
                $('#botao_salvar').show();
            }
            var $xVencimento = $sDia + "/" + padDigits($iMonth, 2) + "/" + $iYear;
            var $xDescricao = $sDescricao + " (" + $x + " de " + $sParcela + ")";
            $iMonth++;
            if ($iMonth > 12) {
                $iMonth = 1;
                $iYear++;
            }
            $dataH = "<tr>";
            $dataH += "<td style='text-align: center;'>" + $x + "</td>"; 
            $dataH += "<td>" + $xVencimento + "</td>"; 
            $dataH += "<td>" + $xDescricao + "</td>";
            $dataH += "<td>" + $sCartao + "</td>";
            $dataH += "<td align='right'>";
            $dataH += "<input class='form-control' type='text' style='text-align: right; width:100px;' name='vlParcela_" + $x + "' id='vlParcela_" + $x + "' value='" + $sVlParcela + "' />";
            $dataH += "<input type='hidden' name='descricao_" + $x + "' value='" + $xDescricao + "' />";
            $dataH += "</td>";
            $dataH += "</tr>";
            $total += roundTo2Decimals($sVlParcela);
            $("#grid").append($dataH);
        }

        var $fVlTotal = 'R$ ' + parseFloat(roundTo2Decimals($total), 10).toFixed($digitos).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();

        $dataH = "<tr>";
        $dataH += "<td>&nbsp;</td>"; 
        $dataH += "<td>&nbsp;</td>"; 
        $dataH += "<td>&nbsp;</td>";
        $dataH += "<td align='right'><b>Total</b>&nbsp;</td>";
        $dataH += "<td align='right'>";
        $dataH += "<input class='form-control' type='text' style='text-align: right;width:100px;' id='total' name='total' value='" + $total + "' />";
        $dataH += "</td>";
        $dataH += "</tr>";
        $("#grid").append($dataH);

        if ($sCartao == "Crédito") { 
          if ($sVlTotal < 0.0) {
            $sVlTotal = $sVlTotal * -1;
          }
        } 
        if ($sCartao == "Débito") { 
          if ($sVlTotal >= 0.0) {
            $sVlTotal = $sVlTotal * -1;
          }
        } 

        var $resto = roundTo2Decimals($sVlTotal - $total);

        $dataH = "<tr>";
        $dataH += "<td>&nbsp;</td>"; 
        $dataH += "<td>&nbsp;</td>"; 
        $dataH += "<td>&nbsp;</td>";
        $dataH += "<td align='right'><b>Martelo</b>&nbsp;</td>";
        $dataH += "<td align='right'>";
        $dataH += "<input class='form-control' type='text' style='text-align: right;width:100px;' id='martelo' name='martelo' value='" + $resto + "' />";
        $dataH += "</td>";
        $dataH += "</tr>";

        $("#grid").append($dataH);

        return true;
    };   

  });
</script>

</x-app-layout>