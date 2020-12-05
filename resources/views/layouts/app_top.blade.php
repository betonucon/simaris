<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>EB-17</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{url(url_link().'/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url(url_link().'/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{url(url_link().'/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{url(url_link().'/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  <!-- Theme style -->
  
  <link rel="stylesheet" href="{{url(url_link().'/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{url(url_link().'/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{url(url_link().'/plugins/iCheck/all.css')}}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{url(url_link().'/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="{{url(url_link().'/plugins/timepicker/bootstrap-timepicker.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{url(url_link().'/bower_components/select2/dist/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{url(url_link().'/dist/css/AdminLTE.min.css')}}">
  
  <link rel="stylesheet" href="{{url(url_link().'/dist/css/skins/_all-skins.min.css')}}">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header" style="position: fixed;width: 100%;">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="" class="navbar-brand"><b>BARBERLOUNGE </b>EB_17</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          @include('layouts.side_top')
          
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="{{url(url_link().'/img/pp.jpg')}}" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs">{{Auth::user()['name']}}</span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="{{url(url_link().'/img/pp.jpg')}}" class="img-circle" alt="User Image">

                  <p>
                    {{Auth::user()['name']}}
                    <small>Member {{date('d F Y')}}</small>
                  </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                  
                  <!-- /.row -->
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    
                  </div>
                  <div class="pull-right">
                    <a href="#" class="btn btn-default btn-flat" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign out</a>
                    
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper" style="margin-top:40px">
    <div class="container">
      <!-- Content Header (Page header) -->
      

      <!-- Main content -->
      @yield('content')
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        <b>Version</b> 0.0.1
      </div>
      <strong>Copyright &copy; 2020-2021 <a href="#">BARBERLOUNGE-EB17</a>.</strong> All rights
      reserved.
    </div>
    <!-- /.container -->
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{url(url_link().'/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{url(url_link().'/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{url(url_link().'/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<!-- DataTables -->
<script src="{{url(url_link().'/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url(url_link().'/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>


<!-- InputMask -->
<script src="{{url(url_link().'/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{url(url_link().'/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{url(url_link().'/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<!-- date-range-picker -->
<script src="{{url(url_link().'/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{url(url_link().'/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{url(url_link().'/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- bootstrap color picker -->
<script src="{{url(url_link().'/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
<!-- bootstrap time picker -->
<script src="{{url(url_link().'/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{url(url_link().'/plugins/iCheck/icheck.min.js')}}"></script>

<!-- SlimScroll -->
<script src="{{url(url_link().'/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{url(url_link().'/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url(url_link().'/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url(url_link().'/dist/js/demo.js')}}"></script>
<!-- page script -->
@stack('datatable')
<script>
    var ww = $(window).width();
    var limit = 769;


    function refresh() {
        ww = $(window).width();
        var w =  ww<limit ? (location.reload(true)) :  ( ww>limit ? (location.reload(true)) : ww=limit );
    }

    var tOut;
    $(window).resize(function() {
        var resW = $(window).width();
        clearTimeout(tOut);
        if ( (ww>limit && resW<limit) || (ww<limit && resW>limit) ) {        
            tOut = setTimeout(refresh, 100);
        }
    });
</script>
<script type="text/javascript">
		
		var rupiah = document.getElementById('rupiah');
		    rupiah.addEventListener('click', function(e){
			  rupiah.value = formatRupiah(this.value, 'Rp. ');
		});

		var rupiah = document.getElementById('rupiah');
		    rupiah.addEventListener('keyup', function(e){
			  rupiah.value = formatRupiah(this.value, 'Rp. ');
		});

		var rupiah1 = document.getElementById('rupiah1');
		    rupiah1.addEventListener('click', function(e){
			  rupiah1.value = formatRupiah(this.value, 'Rp. ');
		});

		var rupiah1 = document.getElementById('rupiah1');
		    rupiah1.addEventListener('keyup', function(e){
			  rupiah1.value = formatRupiah(this.value, 'Rp. ');
		});
		
		
		function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
		}
</script>
<script>
  
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    $('.select3').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, locale: { format: 'MM/DD/YYYY hh:mm A' }})
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      format:"yyyy-mm-dd",
      autoclose: true
    })
    $('#datepicker2').datepicker({
      format:"yyyy-mm-dd",
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
</body>
</html>
