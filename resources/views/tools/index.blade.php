<x-app-layout>

<?php echo $alert; ?>

<div class="row">
<div class="col-2">

<div class="card mt-3" style="background-color: lightgray;">
  <h2 class="card-header">Tools</h2>
  <div class="card-body">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="{{ route('entry.index') }}"><span data-feather="dollar-sign"></span></a>
        <a href="{{ route('entry.support') }}"><span data-feather="tool"></span></a>
        <a href="{{ route('time.index') }}"><span data-feather="calendar"></span></a>
        <a href="{{ route('param.edit', 1) }}"><span data-feather="settings"></span></a>
        <a href="{{ route('entry.create') }}"><span data-feather="plus-square"></span></a>
    </div>
    <form id="fsupport" name="fsupport" action="{{ route('tools.index') }}" class="form-horizontal" method="get">
        <input type="hidden" name="_method" value="GET">
        @include('tools.form')
    </form>
  </div>
</div>  

</div> <!--div class="col-2"-->
<div class="col-10">

<table class="table table-bordered table-striped mt-4">
<thead>
    <tr>
      <th><input type="checkbox" id="select_all_" value="1" /></th>
      <th>Dt.Entry</th>
      <th>Ds.Category</th>
      <th>Ds.Subcategory</th>
      <th>Category</th>
      <th>Type</th>
      <th><font style='float: right;'>Value</font></th>
      <th><font style='float: right;'>Total</font></th>
    </tr>
    </thead>
  <tbody>
    <?php $total = 0; ?>
    @foreach($registers as $register)
    <?php $grupo = getNmCategory($categories, $register['id_category']) ?>
    <?php $total += $register['vl_entry']; ?> 
    <tr>
    <td>
        <input class="form-check-input xcheck_ chkBX" class="form-control" type="checkbox" value="<?php echo $register['id']; ?>" id="chkbox" name="chkbox">
    </td>
    <td><?php echo $year . "-" . (strlen($month) <= 1 ? '0' : '').$month . "-" . (strlen($register['vencimento']) <= 1 ? '0' : '').$register['vencimento'] ?></td>
    <td><?php echo trataTexto($register['ds_category'],11) ?></td>
    <td><?php echo trataTexto($register['ds_subcategory'],11) ?></td>
    <td><?php echo trataTexto( $grupo[0] ) ?></td>
    <td><?php echo trataTexto( $grupo[1] ) ?></td>
    <td>
      <?php echo trataValor($register['vl_entry'], 0) ?>
      <input type="hidden" id="<?php echo $register['id']; ?>_vl_entry" name="<?php echo $register['id']; ?>_vl_entry" value="<?php echo $register['vl_entry']; ?>">  
    </td>
    <td><?php echo trataValor($total, 0) ?></td>
    </tr>
    @endforeach
  </tbody>
</table>

</div> <!--div class="col-X"-->
</div> <!--div class="row"-->

<script>
  $(function () {

    var roundTo2Decimals = function(numberToRound) {
        return Math.round(numberToRound * 100) / 100;
    };

    var verifyChk = function( ) {
      var i = 0;
      var total = 0.0;
      var _chave = '';
      var _bag = '';
      var _virgula = ',';
      $('input:checkbox[id=chkbox]').each(function(){
        _virgula = ',';
        if ($(this).is(':checked')) {
          if (i == 0) _virgula = '';
          _bag += _virgula + $(this).val();
          total += parseFloat($('#'+$(this).val() + '_vl_entry').val(), 10);
          i++;
        }
      });
      $('#total').val(parseFloat(roundTo2Decimals(total), 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
      $('#bag').val(_bag);
    };

    $('.chkBX').on('change', function() {
      verifyChk();
    });

    $('#select_all_').on('change', function() {
      $('input:checkbox[id=chkbox]').not(this).prop('checked', this.checked);
      verifyChk();
    });

    $('#update_').on('change', function() {
      if (this.checked == true) {
        $('#btn_update').val('Update');
      } else {
        $('#btn_update').val('Reload');
      }
    });

    $(".btnSubmit").click(function(ev) {            
        ev.preventDefault();
        var i = 0;
        $('input:checkbox[id=chkbox]').each(function() {
          if ($(this).is(':checked')) {
            i++;
          }
        });
        if (i > 0) {
          $("#fsupport").submit();
        }  
        else
          alert('Please check at least an entry to perform an action! Thanks!');
    });

    var iniState = function( ) {
      $('input:checkbox[id=select_all_]').not(this).prop('checked', true);
      $('input:checkbox[id=chkbox]').not(this).prop('checked', true);
      verifyChk();
    }

    iniState();

  });
</script>

</x-app-layout>