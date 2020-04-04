<?php
    $root = $_SERVER['DOCUMENT_ROOT'] .'/admin';
	require_once($root .'/assets/config/database.php');
	
	session_start();

	if(isset($_SESSION['cr_id'])) {
		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$query = parse_url($url, PHP_URL_QUERY);
		parse_str($query, $params);
		
		// get id
		$userId = $_SESSION['cr_id'];
		$name = $_SESSION['cr_name'];

	} else {
		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$PrevURL= $url;
		header("Location: ../login.php?RecLock=".$PrevURL);
	}
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Eng Peng Insurance</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- link to css -->
	<?php include($root .'/allCSS1.php')?>
   <style>
    #weatherWidget .currentDesc {
        color: #ffffff!important;
    }
        .traffic-chart {
            min-height: 335px;
        }
        #flotPie1  {
            height: 150px;
        }
        #flotPie1 td {
            padding:3px;
        }
        #flotPie1 table {
            top: 20px!important;
            right: -10px!important;
        }
        .chart-container {
            display: table;
            min-width: 270px ;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #flotLine5  {
             height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }
        #cellPaiChart{
            height: 160px;
        }

    </style>
</head>

<body>
    <!--Left Panel -->
	<?php  include($root .'/assets/nav/leftNav.php')?> 
    <!-- Right Panel -->
    <?php include($root .'/assets/nav/rightNav.php')?>
        <!-- /#header -->
        <!-- Content -->
    <div id="right-panel" class="right-panel">
		<div class="content">
            <div class="animated fadeIn">

                <div class="ui-typography">
                    <div class="row">
                        <div class="col-md-12">
							<div class="card">
                                <div class="card-header">
                                    <strong class="card-title" v-if="headerText">Typography</strong>
                                </div>

								<div class="card-body"><!-- Aaron HERE -->
									<div class="typo-articles">
										<p>
										  The unique stripes of zebras make them one of the animals most familiar to people. They occur in a variety of habitats, such as grasslands, savannas, <span
										  class="bg-flat-color-1 text-light">woodlands</span>, thorny scrublands, <span
										  class="clickable-text">mountains</span>
										  , and coastal hills. However, various anthropogenic factors have had a severe impact on zebra populations, in particular hunting for skins and habitat destruction. Grévy's zebra and the mountain <mark>highlighted text</mark> zebra are endangered.</p>
										  <blockquote class="blockquote mt-3 text-right">
											  <p>
											  Blockquotes. However, various anthropogenic factors have had a severe impact on zebra populations, in particular hunting for skins. </p>
											  <footer class="blockquote-footer">Jefferey Lebowski</footer>
										  </blockquote>
										  <p>
											  lthough zebra species may have overlapping ranges, they do not interbreed. In captivity, plains zebras have been crossed with mountain zebras. The hybrid foals <span
											  class="bg-flat-color-1 text-light">selected text</span> lacked a dewlap and resembled their
										  </p>
									</div> <!-- End of typo-articles -->
                                </div> <!-- End of card-body -->
							</div><!-- End of card -->
						</div> <!-- class md-lg-12 -->
					</div><!-- end of row-->
				</div><!-- end of typography -->
</div><!-- .animated -->
</div><!-- .content -->
		<!-- Table-->
        <div class="content">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">List of Insurance</strong>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
											<th>Policy No.</th>
                                            <th>Class</th>
											<th>Location</th>
											<th>Rate</th>
											<th>Premium</th>
											<th>Company</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>19FKKK0000336-00</td>
                                            <td>Fire</td>
                                            <td>Topokon</td>
                                            <td>$320,800</td>
                                            <td>$31,220</td>
                                            <td>IMPIAN INTERAKTIF SDN BHD</td>
                                        </tr>
										<tr>
                                            <td>19FKSD5489536-66</td>
                                            <td>Water</td>
                                            <td>Bundung, Topokon</td>
                                            <td>$150,800</td>
                                            <td>$76,220</td>
                                            <td>IMPIAN INTERAKTIF SDN BHD</td>
                                        </tr>
										<tr>
                                            <td>RE55E6W800336-87</td>
                                            <td>Electricity</td>
                                            <td>Tambulaung</td>
                                            <td>$10,800</td>
                                            <td>$1,220</td>
                                            <td>IMPIAN INTERAKTIF SDN BHD</td>
                                        </tr>
										<tr>
                                            <td>154545456SDSZZ-00</td>
                                            <td>Fire</td>
                                            <td>Salut C</td>
                                            <td>$3,000</td>
                                            <td>$220</td>
                                            <td>IMPIAN INTERAKTIF SDN BHD</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		<!-- END OF CONTENT-->
                
        <div class="clearfix"></div>
        <!-- Footer -->
        <?PHP include($root .'/footer.php')?>
        <!-- /.site-footer -->
    </div> <!-- from right panel page -->
</div>
    <!-- /#right-panel -->

    <!-- link to the script-->
	<?php include ($root .'/allScript2.php')?>
	
	<script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
      } );
  </script>
</body>
</html>
