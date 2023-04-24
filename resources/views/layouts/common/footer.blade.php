<!-- Footer -->
<footer class="footer mt-auto" style="position:fixed;width:100%;bottom:0;background:#fff">
  <div class="copyright">
    <p> &copy; <span id="copy-year"></span> Copyright Mousewait.com <a class="text-primary ml-2" href="http://mousewait.xyz/mousewaitnew" target="_blank">Mousewait</a>. </p>
  </div>
  <script>
    var d = new Date();
    var year = d.getFullYear();
    document.getElementById("copy-year").innerHTML = year;
  </script>
</footer>
<script src="resources/assets/plugins/jquery/jquery.min.js"></script>
<script src="resources/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="resources/assets/plugins/simplebar/simplebar.min.js"></script>
<script src="https://unpkg.com/hotkeys-js/dist/hotkeys.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.min.js"></script>
<script src="resources/assets/plugins/apexcharts/apexcharts.js"></script>
<script src="resources/assets/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="resources/assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
<script src="resources/assets/plugins/jvectormap/jquery-jvectormap-world-mill.js"></script>
<script src="resources/assets/plugins/jvectormap/jquery-jvectormap-us-aea.js"></script>
<script src="resources/assets/plugins/daterangepicker/moment.min.js"></script>
<script src="resources/assets/plugins/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="resources/assets/js/ckeditor/ckeditor.js"></script>

<script>
  jQuery(document).ready(function() {
    jQuery('input[name="dateRange"]').daterangepicker({
      autoUpdateInput: false,
      singleDatePicker: true,
      locale: {
        cancelLabel: 'Clear'
      }
    });
    jQuery('input[name="dateRange"]').on('apply.daterangepicker', function(ev, picker) {
      jQuery(this).val(picker.startDate.format('MM/DD/YYYY'));
    });
    jQuery('input[name="dateRange"]').on('cancel.daterangepicker', function(ev, picker) {
      jQuery(this).val('');
    });
  });
</script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="resources/assets/plugins/toaster/toastr.min.js"></script>
<script src="resources/assets/js/mono.js"></script>
<script src="resources/assets/js/chart.js"></script>
<script src="resources/assets/js/map.js"></script>
<script src="resources/assets/js/custom.js"></script>
<script>
  $("document").ready(function() {
    setTimeout(function() {
      $("div.alert").fadeOut();
    }, 5000);
  });
</script>

<script>
  $(function() {
    $(".user-input").autocomplete({
      delay: 300,
      source: function(request, response) {
        var songSearch = request.term;
        var songList = [];
        $.ajax({
          url: "https://mousewait.xyz/mousewaitnew/backend/api/v1/getAllUserList",
          data: {
            term: songSearch
          },
          method: "GET",
          success: function(data) {
            $.each(data.data, function(key, value) {
              songList.push(value.user_name);
            });
            response(songList);
          },
        })
      }
    });
  });
</script>

<script>
//http://www.jqueryrain.com/?lnsG0UbP 

/*
window.onerror = function(errorMsg) {
    $('#console').html($('#console').html()+'<br>'+errorMsg)
}*/
$('#from_datetime').datetimepicker({
dayOfWeekStart : 1,
lang:'en',
disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
startDate:  '<?php date('y-m-d') ?>',
format:'Y-m-d H:i', 
defaultDate:'<?php date('y-m-d') ?>', // it's my birthday
defaultTime:'<?php date('H:i') ?>',


});
$('#from_datetime').datetimepicker({value:'<?php date('y-m-d H:i');?>',step:1});

$('#end_datetime').datetimepicker({
dayOfWeekStart : 1,
lang:'en',
disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
startDate:  '<?php date('y-m-d') ?>',
format:'Y-m-d H:i', 
defaultDate:'<?php date('y-m-d');?>', // it's my birthday
defaultTime:'<?php date('H:i');?>',
});
$('#end_datetime').datetimepicker({value:'<?php date('y-m-d H:i');?>',step:1});



$('#default_datetimepicker').datetimepicker({
    formatTime:'H:i',
    formatDate:'d.m.Y',
    defaultDate:'8.12.1986', // it's my birthday
    defaultTime:'10:00',
    timepickerScrollbar:false
});

$('#datetimepicker10').datetimepicker({
    step:5,
    inline:true
});
$('#datetimepicker_mask').datetimepicker({
    mask:'9999/19/39 29:59'
});

$('#datetimepicker1').datetimepicker({
    datepicker:false,
    format:'H:i',
    step:5
});
$('#datetimepicker2').datetimepicker({
    yearOffset:222,
    lang:'ch',
    timepicker:false,
    format:'d/m/Y',
    formatDate:'Y/m/d',
    minDate:'-1970/01/02', // yesterday is minimum date
    maxDate:'+1970/01/02' // and tommorow is maximum date calendar
});
$('#datetimepicker3').datetimepicker({
    inline:true
});
$('#datetimepicker4').datetimepicker();
$('#open').click(function(){
    $('#datetimepicker4').datetimepicker('show');
});
$('#close').click(function(){
    $('#datetimepicker4').datetimepicker('hide');
});
$('#reset').click(function(){
    $('#datetimepicker4').datetimepicker('reset');
});
$('#datetimepicker5').datetimepicker({
    datepicker:false,
    allowTimes:['12:00','13:00','15:00','17:00','17:05','17:20','19:00','20:00'],
    step:5
});
$('#datetimepicker6').datetimepicker();
$('#destroy').click(function(){
    if( $('#datetimepicker6').data('xdsoft_datetimepicker') ){
        $('#datetimepicker6').datetimepicker('destroy');
        this.value = 'create';
    }else{
        $('#datetimepicker6').datetimepicker();
        this.value = 'destroy';
    }
});
var logic = function( currentDateTime ){
    if( currentDateTime.getDay()==6 ){
        this.setOptions({
            minTime:'11:00'
        });
    }else
        this.setOptions({
            minTime:'8:00'
        });
};
$('#datetimepicker7').datetimepicker({
    onChangeDateTime:logic,
    onShow:logic
});
$('#datetimepicker8').datetimepicker({
    onGenerate:function( ct ){
        $(this).find('.xdsoft_date')
            .toggleClass('xdsoft_disabled');
    },
    minDate:'-1970/01/2',
    maxDate:'+1970/01/2',
    timepicker:false
});
$('#datetimepicker9').datetimepicker({
    onGenerate:function( ct ){
        $(this).find('.xdsoft_date.xdsoft_weekend')
            .addClass('xdsoft_disabled');
    },
    weekends:['01.01.2014','02.01.2014','03.01.2014','04.01.2014','05.01.2014','06.01.2014'],
    timepicker:false
});
var dateToDisable = new Date();
    dateToDisable.setDate(dateToDisable.getDate() + 2);
$('#datetimepicker11').datetimepicker({
    beforeShowDay: function(date) {
        if (date.getMonth() == dateToDisable.getMonth() && date.getDate() == dateToDisable.getDate()) {
            return [false, ""]
        }

        return [true, ""];
    }
});
$('#datetimepicker12').datetimepicker({
    beforeShowDay: function(date) {
        if (date.getMonth() == dateToDisable.getMonth() && date.getDate() == dateToDisable.getDate()) {
            return [true, "custom-date-style"];
        }

        return [true, ""];
    }
});
$('#datetimepicker_dark').datetimepicker({theme:'dark'})


</script>

<script>


function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
		 $("#img-preview").css("display", 'block');
      $("#img-preview").attr("src", e.target.result);
    };

    reader.readAsDataURL(input.files[0]);
  } 
}


function readURLSecond(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
		 $("#img-preview-second").css("display", 'block');
      $("#img-preview-second").attr("src", e.target.result);
    };

    reader.readAsDataURL(input.files[0]);
  } 
}
   </script>