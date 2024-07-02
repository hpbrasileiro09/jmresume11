<x-app-layout>

<div class="card mt-5" style="background-color: lightgreen;">
  <h2 class="card-header">New Entry</h2>
  <div class="card-body">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <a href="{{ route('entry.index') }}"><span data-feather="dollar-sign"></span></a>
      <a href="{{ route('entry.support') }}"><span data-feather="tool"></span></a>
      <a href="{{ route('time.index') }}"><span data-feather="calendar"></span></a>
      <!--a href="{{ route('entry.create') }}"><span data-feather="plus-square"></span></a-->
    </div>
    <form action="{{ route('entry.store') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
      @include('entry.form')
    </form>
    <form id="lastdscategory" name="lastdscategory" action="#" method="post">
      <input type="hidden" name="id_category" id="id_category" value="0" />
    </form> 
  </div>
</div>

<script>
  $(function () {
    $('.id_category').on('change', function() {
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
  });
</script>

</x-app-layout>