<x-app-layout>

<div class="card mt-5">
  <h2 class="card-header">Support</h2>
  <div class="card-body">
          
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
           <a href="{{ route('entry.index') }}"><span data-feather="dollar-sign"></span></a>
           <!--a href="{{ route('entry.support') }}"><span data-feather="tool"></span></a-->
           <a href="{{ route('time.index') }}"><span data-feather="calendar"></span></a>
           <a href="{{ route('entry.create') }}"><span data-feather="plus-square"></span></a>
        </div>

<?php echo $alert; ?>

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">
              <div class="row-10">
                <div class="col-2"><input type="checkbox" id="select_all_" value="1" />
                &nbsp;Entries Support</div>
              </div>
              </h3>
              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <form action="{{ route('entry.support') }}" method="GET" role="search">
                  <div class="input-group input-group-sm" style="width: 500px;">
                    <input type="text" name="search" class="form-control pull-right" value="{{$search}}" placeholder="Search">
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-success"><span data-feather="search"></span></button>
                      <a href="{{ route('entry.support') }}" class="btn btn-danger btn-xs">
                        <span data-feather="refresh-cw"></span>
                      </a>
                      <a href="#" class="btnSubmit btn btn-primary btn-xs">Perform action</a>
                    </div>
                      <select class="form-control pull-right" name="action_choice" id="action_choice">
                        <option value="1">Update</option>
                        <option value="2">Delete</option>
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
                    <input class="form-check-input check_ chkBX" class="form-control" type="checkbox" value="<?php echo $register->id; ?>" id="chkbox" name="chkbox">
                    <label class="form-check-label" for="defaultCheck1">
                      &nbsp;<font style='font-size:10px;'>#<?php echo str_pad($register->id, 6, "0", STR_PAD_LEFT); ?></font>
                    </label>                
                  </div>
                </div> <!--div class="col"-->

                <div class="col-4">
                  <input type="text" id="<?php echo $register->id; ?>_ds_category" name="<?php echo $register->id; ?>_ds_category" class="form-control" value="<?php echo $register->ds_category; ?>">
                </div> <!--div class="col"-->

                <div class="col-1">
                  <input type="text" id="<?php echo $register->id; ?>_ds_subcategory" name="<?php echo $register->id; ?>_ds_subcategory" class="form-control" value="<?php echo $register->ds_subcategory; ?>">
                </div> <!--div class="col"-->

                <div class="col-2">
                  <input type="text" id="<?php echo $register->id; ?>_dt_entry" name="<?php echo $register->id; ?>_dt_entry" class="form-control" value="<?php echo $register->dt_entry; ?>">
                </div> <!--div class="col"-->

                <div class="col-1">
                  <input type="text" id="<?php echo $register->id; ?>_vl_entry" name="<?php echo $register->id; ?>_vl_entry" class="form-control" value="<?php echo $register->vl_entry; ?>">
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
        <input type="hidden" id="action" name="action" value="1">

</form>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

</div>

</div>

<script>
  $(function () {

    $('.chk_status').attr('title', 'status');
    $('.chk_checked').attr('title', 'checked');
    $('.chk_fixed_costs').attr('title', 'fixed costs');
    $('.chk1_published').attr('title', 'published');

    var verifyChk = function( ) {
      var i = 0;
      var _bag = '';
      var _virgula = ',';
      $('input:checkbox[id=chkbox]').each(function(){
        _virgula = ',';
        if ($(this).is(':checked')) {
          if (i == 0) _virgula = '';
          _bag += _virgula + $(this).val();
          i++;
        }
      });
      $('#bag').val(_bag);
    };

    $('.chkBX').on('change', function() {
      verifyChk();
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
