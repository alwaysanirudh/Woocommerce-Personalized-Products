angular.module('friends', [])
    .controller("friendsCtrl", ['$scope', function ($scope) {
        if(!patternOnly){
            $scope.name = "Friends";
        } else {
            $scope.name = name;
        }

    }])
    .directive('ngFriends', function () {
        return{
            restrict: "AE",
            replace: true,
            link: function (scope, element) {

                scope.$watch('[name]', function () {
                    var name = scope.name.replace(/[^a-zA-Z ]/g, '');
                    var names =  name.split(" ");
                    if(names.length >= 1){
                        scope.disabled = false;
                        var fName = friendify(names[0]);
                        generator_key = 'friends-black:'+names[0]+':0';
                        var html = "<div id='friends'><div id='friends-body'>"+
                                       "<span class='name'>"
                                       +fName+
                                       "</span></div></div>";

                    }else{
                        var html = "<div id='friends'></div>";
                    }
                    element.html(html);
                });



                // Search the element in the name
                function friendify(name){
                    name = name.toUpperCase();
                    if(name.length < 2){
                        return '';
                    }

                    var colors = {1: 'red', 2: 'yellow', 3: 'green'};
                    var c = 1;
                    r = name[0];

                    for(i=1; i<name.length; i++){
                        r = r + "<span class='dot "+colors[c]+"'></span>" + name[i];
                        c++;
                        if(c == 4){
                            c= 1;
                        }

                    }

                    return r;
                }

            }
        };
    })