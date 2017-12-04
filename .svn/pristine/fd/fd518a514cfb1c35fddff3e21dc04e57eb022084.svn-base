var app = angular.module('funNewPlay', []);

app.controller('funNewPlayIndex' ,function($scope, $http) {

	$scope.test = 'test';
	$scope.recommandListShow = true;
	$scope.newUpdateListShow = false;
	$http.get("indexjason.php")
  	.success(function (response) {$scope.rps = response.QQ;});
	$scope.nps = [{name:'超級度假村',area:'台東', address:'新莊市土城區倪福路113巷24號',img:'r4.png',like:'145'}
								,{name:'級度度假村',area:'花蓮', address:'淡水市土城區倪福路113巷24號',img:'r5.png',like:'145'}
								,{name:'超級級度村',area:'台北', address:'新北市土城區倪福路113巷24號',img:'r6.png',like:'145'}
								];

	$scope.listDisplayChange = function(a,e){
		$('.maincontainer_productcontainer_selector a.active').removeClass('active');
		if (a == 'n') {
			$scope.newUpdateListShow = true;
			$scope.recommandListShow = false;
		}else if(a == 'r'){
			$scope.newUpdateListShow = false;
			$scope.recommandListShow = true;
		}
		$('.maincontainer_productcontainer_selector a.'+ a ).addClass('active');
	}
});