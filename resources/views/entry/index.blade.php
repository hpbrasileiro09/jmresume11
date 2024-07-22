  
<x-app-layout>

<div class="card mt-5">
  <h2 class="card-header">Entries</h2>
  <div class="card-body">
          
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
           <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><span data-feather="arrow-left-circle"></span></a>
           <a href="{{ route('time.index') }}"><span data-feather="calendar"></span></a>
           <a href="{{ route('entry.support') }}"><span data-feather="tool"></span></a>
           <a href="{{ route('param.edit', 1) }}"><span data-feather="settings"></span></a>
           <a href="{{ route('entry.create') }}"><span data-feather="plus-square"></span></a>
        </div>

        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th>Date</th>
                  <th>Description</th>
                  <th>Category</th>
                  <th><font style='float: right;'>Value</font></th>
                  <th><font style='float: right;'>Total</font></th>
                </tr>
                </thead>
              <tbody>
                <?php

                  $i = 0;
                  $mes = 0;
                  $iphi = 0;
                  $total = 0;
                  $cartao = 0;

                  $_icone = '';
                  $scartao = '';
                  $_cartao = '';

                ?>
				@foreach($registers as $register)
                <?php

                  if ($i == 1) $mes = $register->mes;

                  if ($register->ds_subcategory == 'Visa' || $register->ds_subcategory == 'Mastercard') {
                      if ($register->status == 1) {
                          $cartao += $register->vl_entry;
                      }
                  } else
                      $cartao = 0;

                  $_class = "";

                  if ($mes != $register->mes) 
                  {
                      $mes = $register->mes;

                      $linhas = "";
                      $linhas .= "<tr class='ln-info'>";
                      $linhas .= "<td colspan='8' align='right'>".getMonth($mes)."</td>";
                      $linhas .= "</tr>";
                      echo $linhas;
                  }

                  $_icone = $register->icone;
                  $_cartao = $register->cartao;
                  $scartao = ( $cartao != 0 ? trataValorC($cartao) : '' );

                  if ($register->dt_entry >= strftime("%Y-%m-%d 00:00:00",time()) && $iphi == 0)
                  {
                      $iphi = 1;
                  }

                  $iblack = 0;

                  if ($i == 0) $_class = "class='ln-success'"; 
                  
                  if ($register->status == 1) {
                      $total += $register->vl_entry;
                  } else {
                      $iblack = 1;
                      $_class = "class='ln-warning'";
                  }

                  if ($register->checked == 1) {
                      $iblack = 2;
                      $_class = "class='ln-success'";
                  }

                ?>
					<tr <?php echo $_class ?> >
            <td>
              <?php if ($register->id != 0) { ?>
                <a style="text-decoration: none;" href="{{ route('entry.show', $register->id) }}">
                  <span data-feather="trash-2"></span>
                </a>
                <?php if ($rb_modal == "1") { ?>
                  &nbsp;&nbsp;&nbsp;
                  <a href="#" id="w_<?php echo $register->id; ?>" class="itemModal" role="button" data-target="#myModal" data-toggle="modal">
                    <span data-feather="edit"></span>
                  </a>
                <?php } else { ?>
                  &nbsp;&nbsp;&nbsp;
                  <a style="text-decoration: none;" href="{{ route('entry.edit', $register->id) }}">
                    <span data-feather="edit"></span>
                  </a>
                <?php } ?>
              <?php } ?>
            </td>
						<td><?php echo $_icone ?></td>
            <td><?php echo trataDDS($register->dia_da_semana) ?></td>
            <td><?php echo trataDDS11($register->dt_entry_br) ?></td>
            <td><?php echo trataTexto($register->ds_category,11)."&nbsp;".trataTexto($register->ds_subcategory,11)."&nbsp;".$_cartao ?></td>
            <td><?php echo trataTexto($register->nm_category,11)."&nbsp;".trataTexto("(".$register->id_category.")",11)."&nbsp;".$scartao ?></td>
            <td><?php echo trataValor($register->vl_entry, 0) ?></td>
            <td><?php echo trataValor($total, 0) ?></td>
					</tr>
          <?php 
            $i++; 
          ?>
				@endforeach
        </tbody>
        </table>
        
  </div>
</div>  

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 id="offcanvasRightLabel">Params</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form action="{{ route('param.update', 1) }}" class="form-horizontal" method="post">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="tipo" value="1">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-12">
                <div class="form-group{{ $errors->has('agora') ? ' has-error' : '' }}">
                    <label for="agora" class="control-label col-sm-4">Now</label>
                    <input type="date" name="agora" id="agora" class="form-control" value="{{ $agorax }}" placeholder="Now...">
                    @if ($errors->has('agora'))
                        <span class="help-block">
                            <strong>{{ $errors->first('agora') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group">
            <br />
            <input type="submit" value="Save" class="btn btn-primary" />
        </div>
    </form>
  </div>
</div>

<style>
.ln-warning {
    background-color: #F6F783;
}
.ln-success {
    background-color: #A2F1D2;
}
.ln-info {
    background-color: #D1D1CC;
}
</style>

</x-app-layout>
