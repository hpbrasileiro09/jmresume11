<x-app-layout>

<div class="card mt-5">
  <h2 class="card-header">Support</h2>
  <div class="card-body">
          
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><span data-feather="arrow-left-circle"></span></a>
        <input type="text" style='width: 100px; text-align: right;' id="total" name="total" value="0.0">          
        <a href="{{ route('entry.index') }}"><span data-feather="dollar-sign"></span></a>
        <!--a href="{{ route('entry.support') }}"><span data-feather="tool"></span></a-->
        <a href="{{ route('time.index') }}"><span data-feather="calendar"></span></a>
        <a href="{{ route('param.edit', 1) }}"><span data-feather="settings"></span></a>
        <a href="{{ route('entry.create') }}"><span data-feather="plus-square"></span></a>
      </div>

      <?php echo $alert; ?>

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">
              <div class="row-10">
                <div class="col-3"><input type="checkbox" id="select_all_" value="1" />
                &nbsp;Entries Support</div>
              </div>
              </h3>
              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <form action="{{ route('entry.support') }}" method="GET" role="search">
                  <div class="input-group input-group-sm" style="width: 600px;">
                    <input type="date" name="dia" id="dia" style="width: 50px; margin-right: 5px;" class="form-control pull-right" value="{{$dia}}" value="" placeholder="Dia...">
                    <input type="text" name="search" style="margin-right: 5px;" class="form-control pull-right" value="{{$search}}" placeholder="Search">
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-success"><span data-feather="search"></span></button>
                      <a href="{{ route('entry.support') }}" class="btn btn-danger btn-xs">
                        <span data-feather="refresh-cw"></span>
                      </a>
                      <a href="#" style="margin-right: 5px;" class="btnSubmit btn btn-primary btn-xs">Perform action</a>
                    </div>
                      <select class="form-select pull-right" name="action_choice" id="action_choice">
                        <option value="1">Update</option>
                        <option value="2">Delete</option>
                        <option value="3">Copy</option>
                      </select>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.box-header --><br />
            <div class="box-body">

      <form id="fsupport" name="fsupport" action="{{ route('entry.supportsave') }}" method="post" enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="containerx">
				@foreach($registers as $register)

            <div class="row">

                <div class="col-1">
                  <div class="form-check form-control">
                    <div style="padding: 4px;">
                      <input class="form-check-input check_ chkBX" class="form-control" type="checkbox" value="<?php echo $register->id; ?>" id="chkbox" name="chkbox">
                      <label class="form-check-label" for="defaultCheck1">
                        &nbsp;<font style='font-size:9px;'>#<?php echo str_pad($register->id, 6, "0", STR_PAD_LEFT); ?></font>
                      </label>                
                    </div>
                  </div>
                </div> <!--div class="col"-->

                <div class="col-2">
                  <input type="text" id="<?php echo $register->id; ?>_ds_category" name="<?php echo $register->id; ?>_ds_category" class="form-control" value="<?php echo $register->ds_category; ?>">
                </div> <!--div class="col"-->

                <div class="col-2">
                  <input type="text" id="<?php echo $register->id; ?>_ds_subcategory" name="<?php echo $register->id; ?>_ds_subcategory" class="form-control" value="<?php echo $register->ds_subcategory; ?>">
                </div> <!--div class="col"-->

                <div class="col-2">
                  <input type="text" id="<?php echo $register->id; ?>_dt_entry" name="<?php echo $register->id; ?>_dt_entry" class="form-control" value="<?php echo $register->dt_entry; ?>">
                </div> <!--div class="col"-->

                <div class="col-2">
                  <input style='text-align: right;' type="text" id="<?php echo $register->id; ?>_vl_entry" name="<?php echo $register->id; ?>_vl_entry" class="form-control" value="<?php echo $register->vl_entry; ?>">
                </div> <!--div class="col"-->

                <div class="col-2">
                  <?php echo MontaCategories($mcategories, $register->id."_id_category", $register->id_category, 0); ?>
                </div> <!--div class="col"-->

                <div class="col-1">
                  <div class="form-check form-control">
                    <input title="status" class="chk_status form-xcheck-input" type="checkbox" class="form-control" <?php echo ($register->status == 1 ? 'checked="checked"' : ''); ?> value="<?php echo $register->status; ?>" id="<?php echo $register->id; ?>_status" name="<?php echo $register->id; ?>_status">
                    <input title="checked" class="form-xcheck-input" type="checkbox" class="chk_checked form-control" <?php echo ($register->checked == 1 ? 'checked="checked"' : ''); ?> value="<?php echo $register->checked; ?>" id="<?php echo $register->id; ?>_checked" name="<?php echo $register->id; ?>_checked">
                    <input title="fixed costs" class="form-xcheck-input" type="checkbox" class="chk_fixed_costs form-control" <?php echo ($register->fixed_costs == 1 ? 'checked="checked"' : ''); ?> value="<?php echo $register->fixed_costs; ?>" id="<?php echo $register->id; ?>_fixed_costs" name="<?php echo $register->id; ?>_fixed_costs">
                    <input title="published" class="form-xcheck-input" type="checkbox" class="chk_published form-control" <?php echo ($register->published == 1 ? 'checked="checked"' : ''); ?> value="<?php echo $register->published; ?>" id="<?php echo $register->id; ?>_published" name="<?php echo $register->id; ?>_published">
                  </div>
                </div> <!--div class="col"-->

            </div>

				@endforeach

        <input type="hidden" id="bag" name="bag" value="">
        <input type="text" id="action" name="action" value="1">

      </form>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

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
        <input type="hidden" name="tipo" value="2">
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

<script>
  $(function () {

    $('.chk_status').attr('title', 'status');
    $('.chk_checked').attr('title', 'checked');
    $('.chk_fixed_costs').attr('title', 'fixed costs');
    $('.chk1_published').attr('title', 'published');

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

    $('#action_choice').on('change', function() {
        var iAction = $(this).val();
        $('#action').val(iAction);
    });

    $('#select_all_').on('change', function() {
      $('input:checkbox[id=chkbox]').not(this).prop('checked', this.checked);
      verifyChk();
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
	        var act_choice = $("#action_choice").val();	
          $("#action").val(act_choice);
	        console.log("act", $("#action").val());
	        console.log("act_choice", act_choice);
          $("#fsupport").submit();
        }  
        else
          alert('Please check at least an entry to perform an action! Thanks!');
    });

  });
</script>

</x-app-layout>
