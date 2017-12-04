<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("ConneMysql.php");

?>
<html>
<head>
	<title>Fun新玩</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="stylesheets/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css">
	<script type="text/javascript" src="javascript/angular.min.js"></script>
	<script type="text/javascript" src="javascript/app.js"></script>
	<script type="text/javascript" src="javascript/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="javascript/jquery.mobile.custom.min.js"></script>

	<script>
	$(function(){
      $('#target').click(function() {
          //$(this).val("");  
          $('input[name="keyword"]').val("");
      });
    });
	

	
  $(document).ready(function() {  
  		 $("#carousel-example-generic").swiperight(function() {		 
			  $(this).carousel('prev');
	    		});  
		 $("#carousel-example-generic").swipeleft(function() {  
		      $(this).carousel('next');
	   });
		
	});
	
	

	</script>

</head>
<body ng-app="funNewPlay" ng-controller="funNewPlayIndex">

<div id="wrapper">
	<?php require_once("mainnav.php"); ?> 

		<div class="maincontainer">
		<div class="maincontainer_banners">
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active" ></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="images/banner.png">
      
      <div class="maincontainer_banners_banner_text">馬祖一個酷炫的地方</div>
      
    
    </div>
    <div class="item">
      <img src="photos/Desert.jpg">
      <div class="maincontainer_banners_banner_text">澳洲</div>
    </div>

  </div>

  <!-- Controls -->
 <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left hidden-md hidden-lg hidden-sm hidden-xs" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right hidden-xs" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>

</div>
	<div class="maincontainer_banners_banner_des1"><img src="images/clock.png" height="50" width="50"><h3>最佳前往季節</h3>&nbsp;<h4>春夏</h4></div>
	<div class="maincontainer_banners_banner_des2"><img src="images/sale-badge.png" height="50" width="50"><h3>最多折扣</h3>&nbsp;<h4>7.5折</h4></div>
	
	<!-- <div class="maincontainer_banners_banner_des1"><img src="images/clock.png" height="50" width="50"><h3>最佳前往季節</h3>&nbsp;<h4>夏季</h4></div>
	<div class="maincontainer_banners_banner_des2"><img src="images/sale-badge.png" height="50" width="50"><h3>最多折扣</h3>&nbsp;<h4>6折</h4></div> -->
		 

			
            
            
					
					
					
					    
					      <div class="maincontainer_banners_banner_inputs">
					        <div class="maincontainer_banners_banner_inputs_inputdiv">
                            <form name="form1" method="get" action="plasearch.php">
					          <input type="text" id="target" name="keyword" value="搜 尋 場 地">
					          <input type="submit" class="searchBtn" id="button" value="" >
				            </form>
                            </div>
				          </div>
					    
					 
			</div>

			<div class="maincontainer_productcontainer">
				<div class="maincontainer_productcontainer_selector container">
					<a href="" class="active r" ng-click="listDisplayChange('r', $event)">最多推薦</a>
					<a href="" class="n" ng-click="listDisplayChange('n', $event)">最新上傳</a>
				</div>
				<div class="container">
					<div class="maincontainer_productcontainer_products row">
							
							<div ng-show="recommandListShow">
								<a href="placeinfo.php?id={{product.like}}" ng-repeat="product in rps">
									<div class="maincontainer_productcontainer_products_product col-xs-12 col-sm-6 col-md-4">
										<div class="product_container card">
											<div class="maincontainer_productcontainer_products_product_img">
												<img src="photos/{{product.img}}">
											</div>
											<div class="maincontainer_productcontainer_products_product_content">
                                            	<div class="maincontainer_productcontainer_products_product_content_right">
													<span class="glyphicon glyphicon-heart" aria-hidden="true"></span><b><font face="微軟正黑體">&nbsp;{{product.like}}
													</font>
													</b>
												</div>
												<div class="maincontainer_productcontainer_products_product_content_left">
													<p><h4>{{product.name}}</h4></p>
													<p>城市區域：{{product.area}}</p>
													<p class="lineheightb">交通資訊：{{product.address}}</p>
												</div>
												
											</div>
										</div>
									</div>
								</a>
							</div>

							<div ng-show="newUpdateListShow">
								<a href="placeinfo.php?id={{product.like}}" ng-repeat="product in rps">
									<div class="maincontainer_productcontainer_products_product col-xs-12 col-sm-6 col-md-4">
										<div class="product_container card">
											<div class="maincontainer_productcontainer_products_product_img">
												<img src="photos/{{product.img}}">
											</div>
											<div class="maincontainer_productcontainer_products_product_content">
                                            	<div class="maincontainer_productcontainer_products_product_content_right">
													<span class="glyphicon glyphicon-heart" aria-hidden="true"></span><b>&nbsp;{{product.like}}
													</b>
												</div>
												<div class="maincontainer_productcontainer_products_product_content_left">
													<p><h4>{{product.name}}</h4></p>
													<p>城市區域：{{product.area}}</p>
													<p class="lineheightb">交通資訊：{{product.address}}</p>
												</div>
												
											</div>
										</div>
									</div>
								</a>
                                
       
							</div>

					</div>
				</div>
			</div>

			<div class="maincontainer_socialnetworks">
				<div class="container">
					<ul>
						<li><a href="https://www.facebook.com/pages/Fun新玩/259091237610563"><img src="images/fb.png" width="43" height="43"></a></li>
						<li><a href="http://www.google.com.tw"><img src="images/gp.png"  width="43" height="43></a></li>
						<li><a href="#"></a></li>
					</ul>
				</div>
			</div>

		</div>
		<?php require_once("footer.html"); ?> 
    </div>
</body>
</html>