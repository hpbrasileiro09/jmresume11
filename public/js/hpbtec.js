
function show_confirm()
{
    return confirm("Are You Sure");
}

$(document).ready(function() {

    $('#arvore1').DataTable({
      "columns": [
          { "width": "15%" },
          { "width": "15%" },
          { "width": "50%" },
          { "width": "20%" }
        ],      
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": false,
      "autoWidth": true
    });

  function init(){

      var address = $('#pac-formatted_address').val();

      if (!address || 0 === address.length) {
        address = 'Praça La Salle, 83 - Jardim Canadá, Londrina - PR, 86020-480';
      }

      var map = new google.maps.Map(document.getElementById('map'), { 
        zoom: 16
      });
      var geocoder = new google.maps.Geocoder();

      var input = document.getElementById('pac-input');
      var searchBox = new google.maps.places.SearchBox(input);
      map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

      // Bias the SearchBox results towards current map's viewport.
      map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
      });

      var markers = [];
      // Listen for the event fired when the user selects a prediction and retrieve
      // more details for that place.
      searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
          return;
        }

        // Clear out the old markers.
        markers.forEach(function(marker) {
          marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
          if (!place.geometry) {
            console.log("Returned place contains no geometry");
            return;
          }
          var icon = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
          };

          // Create a marker for each place.
          var hum = new google.maps.Marker({
            map: map,
            icon: icon,
            title: place.name,
            position: place.geometry.location,
            draggable:true
          });

          google.maps.event.addListener(hum, "dragend", function(event) { 
            var lat = event.latLng.lat(); 
            var lng = event.latLng.lng(); 
            $('#pac-latitude').val(lat);
            $('#pac-longitude').val(lng);
          }); 

          markers.push(hum);

          $('#pac-latitude').val(place.geometry.location.lat());
          $('#pac-longitude').val(place.geometry.location.lng());
          $('#pac-formatted_address').val(place.formatted_address);

          /*
          var street = null;
          for (var i = 0, component; component = components[i]; i++) {
              console.log(component);
              if (component.types[0] == 'route') {
                  street = component['long_name'];
              }
          }
          console.log(street);
          */

          if (place.geometry.viewport) {
            // Only geocodes have viewport.
            bounds.union(place.geometry.viewport);
          } else {
            bounds.extend(place.geometry.location);
          }
        });
        map.fitBounds(bounds);
      });

      geocoder.geocode({
        'address': address
      }, 
      function(results, status) {
        if(status == google.maps.GeocoderStatus.OK) {
          var dois = new google.maps.Marker({
            position: results[0].geometry.location,
            draggable:true,
            map: map
          });

          google.maps.event.addListener(dois, "dragend", function(event) { 
            var lat = event.latLng.lat(); 
            var lng = event.latLng.lng(); 
            $('#pac-latitude').val(lat);
            $('#pac-longitude').val(lng);
          }); 

          google.maps.event.trigger(map, 'resize');
          map.setCenter(results[0].geometry.location);
          
          $('#pac-latitude').val(results[0].geometry.location.lat());
          $('#pac-longitude').val(results[0].geometry.location.lng());

          $('#pac-formatted_address').val(results[0].formatted_address);

        }
      });
  }

  var maps_load = 0;    
  if ( $('#myModalMaps').length ) {
    $('#myModalMaps').on('shown.bs.modal', function(){
      if (maps_load == 0) init();
      maps_load = 1;
    });
  }

  $(".buttonx").click(function() {
      $("#latitude").val( $('#pac-latitude').val() );
      $("#longitude").val( $('#pac-longitude').val() );
      $("#address").val( $('#pac-formatted_address').val() );
      $("#myModalMaps").modal('hide');
  } );

  // Replace the <textarea id="editor1"> with a CKEditor
  // instance, using default configuration.
  if ( $('#editor1').length ) {  
    // the variable is defined
    CKEDITOR.replace('editor1');
  } 

  if (typeof data !== 'undefined') {
    $('.selectpicker').selectpicker('val', data);
  }

  $('.selectpicker').change(function() {
    var foo = []; 
    $('#departments :selected').each(function(i, selected){ 
      foo[i] = $(selected).val(); 
    });
    $('#postmeta').val(foo);    
  });    

  $(".itemx").click(function() {
      $("#department_id").val( $(this).data("id") );
      $("#department_lb").val( $(this).data("name") );
      $("#myModal").modal('hide');
  } );

} );

$('#myModalComment').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  var content = button.data('content'); 
  var from = button.data('from');
  var comment_id = button.data('comment_id');
  var status = button.data('status');
  var answer = button.data('answer');
  var modal = $(this);
  modal.find('#content').text(content);
  modal.find('#from').text(from);
  modal.find('#comment_id').val(comment_id);
  if (status == 0) {
    modal.find('#btn_save').show();
    modal.find('#answer').text('');
  } else {
    modal.find('#btn_save').hide();
    modal.find('#answer').text(answer);
  }
});

$(function () {
    //Date picker
    $('#research_begin').datepicker({
        todayHighlight: true,
        format: 'dd/mm/yyyy',            
        autoclose: true,
        language: 'pt-BR'
    });
    //Date picker
    $('#research_end').datepicker({
        todayHighlight: true,
        format: 'dd/mm/yyyy',            
        autoclose: true,
        language: 'pt-BR'
    });
    //Date picker
    $('#post_begin').datepicker({
        todayHighlight: true,
        format: 'dd/mm/yyyy',            
        autoclose: true,
        language: 'pt-BR'
    });
    //Date picker
    $('#post_end').datepicker({
        todayHighlight: true,
        format: 'dd/mm/yyyy',            
        autoclose: true,
        language: 'pt-BR'
    });
    //Date picker
    $('#enrollment_begin').datepicker({
        todayHighlight: true,
        format: 'dd/mm/yyyy',            
        autoclose: true,
        language: 'pt-BR'
    });
    //Date picker
    $('#enrollment_end').datepicker({
        todayHighlight: true,
        format: 'dd/mm/yyyy',            
        autoclose: true,
        language: 'pt-BR'
    });

    //Date picker
    $('.dt_entry').datepicker({
        todayHighlight: true,
        format: 'dd/mm/yyyy',            
        autoclose: true,
        language: 'pt-BR'
    });

    //Enable iCheck plugin for checkboxes
    //iCheck for checkbox and radio inputs
    $('.mailbox-messages input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });

    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
      var clicks = $(this).data('clicks');
      if (clicks) {
        //Uncheck all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
        $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
      } else {
        //Check all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("check");
        $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
      }
      $(this).data("clicks", !clicks);
    });

    $(".mark").click(function () {
      $('#f_markunmark').submit();
    });

    $( "#ftab0" ).submit(function( event ) {
      $("#i_loading_0").show();
    });    

    $( "#ftab1" ).submit(function( event ) {
      $("#i_loading_1").show();
    });    

    $( "#ftab2" ).submit(function( event ) {
      $("#i_loading_2").show();
    });    

});    
