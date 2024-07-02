<x-app-layout>

<div class="card mt-5">
  <h2 class="card-header">Times</h2>
  <div class="card-body">
          
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
           <a href="{{ route('entry.index') }}"><span data-feather="dollar-sign"></span></a>
           <a href="{{ route('entry.support') }}"><span data-feather="tool"></span></a>
           <!--a href="{{ route('time.index') }}"><span data-feather="calendar"></span></a-->
           <a href="{{ route('entry.create') }}"><span data-feather="plus-square"></span></a>
        </div>

<?php echo $alert; ?>

<form action="{{ route('time.store') }}" id="fparcela" name="fparcela" class="form-horizontal" method="post">

<div class="row">

<div class="col-md-4 col-sm-4">

<div class="box box-primary">

  <div class="box-header with-border">
    <!--h3 class="box-title">&nbsp;Times</h3-->
  </div>
  <!-- /.box-header -->

	<div class="box-body">

  	<!--input type="hidden" name="_method" value="PUT"-->

    {!! csrf_field() !!}

    <div class="form-group">
        <label for="times" class="col-sm-3 control-label ">Parcelas</label>
        <div class="col-lg-9">
          <?php echo $parcelas; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="cards" class="col-sm-3 control-label ">Cartões</label>
        <div class="col-lg-9">
          <?php echo $cartoes; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="year" class="col-sm-3 control-label text-nowrap ">Iniciar Ano</label>
        <div class="col-lg-9">
          <?php echo $years; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="year" class="col-sm-3 control-label text-nowrap ">Iniciar Mês</label>
        <div class="col-lg-9">
          <?php echo $months; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="ds_category" class="col-sm-3 control-label ">Descrição</label>
        <div class="col-lg-9">
          <input type='text' style="width: 200px;" class="form-control" name='ds_category' id='ds_category' value='<?php echo $descricao; ?>' placeholder='ds_category' />
          <input type='hidden' name='ds_subcategory' id='ds_subcategory' value='' placeholder='ds_subcategory' />
        </div>
    </div>

    <div class="form-group">
        <label for="id_category" class="col-sm-3 control-label">Categoria</label>
        <div class="col-lg-9">
          <?php echo $categories; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="id_category" class="col-sm-3 control-label text-nowrap ">Valor Total</label>
        <div class="col-lg-9">
          <input type='text' class="form-control" style='text-align: right; width: 200px;' name='vl_entry' id='vl_entry' value='<?php echo $vlTotal; ?>'  placeholder='vl_entry' />
        </div>
    </div>

    <input type="hidden" name="acao" id="acao" value="salvar" />

    <div class="form-group">
      <label class="col-sm-3 control-label text-nowrap"></label>
      <div class="col-lg-9">
        <input type="button" value="Gerar Parcelas" id="form-parcelas" class="btn btn-primary" />
      </div>
    </div>

  </div> <!--div class="box-body"-->

</div> <!--div class="box box-primary"-->

</div> <!--div class="col-xs-4"-->

<div class="col-md-8 col-sm-8">

<div class="box box-default">

    <div class="box-header with-border">
      <!--h3 class="box-title">&nbsp;Times</h3-->
      <div class="box-tools pull-right">
        <div class="input-group input-group-sm" style="width: 10px;">
          <div class="input-group-btn">
            <input type="button" value="Recalcular" style="display: none;" id="form-calcula" class="btn btn-primary" />
          </div>
        </div>
      </div><!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">

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

    </div> <!--div class="box-body"-->

</div> <!--div class="box box-default"-->

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

    $('#id_category').on('change', function() {
        $('#lastdscategory input:hidden[id=id_category]').val( $(this).val() );
        lastDsCategory();
    });

    var lastDsCategory = function( ) {
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
        var $sParcela = $('#fparcela select[id=times]').val();
        var $sVlTotal = $('#fparcela input:text[id=vl_entry]').val();
        for (var $x=1; $x<=$sParcela; $x++) {
            //$fParcela = roundTo2Decimals($('#fparcela input:text[id=vlParcela_'+$x+']').val());
            $fParcela = roundTo2Decimals($('#vlParcela_'+$x+'').val());
            $valor += parseFloat($fParcela);
        }
        //$('#fparcela input:text[id=total]').val(roundTo2Decimals($valor));
        $('#total').val(roundTo2Decimals($valor));
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
        var $sDia = "15";
        var $iMonth = $sMonth;
        var $iYear = $sYear;

        if ($sCartao == "Visa") $sDia = "08";
        if ($sCartao == "Hering") $sDia = "20";

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