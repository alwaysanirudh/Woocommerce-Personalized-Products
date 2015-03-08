angular.module('breakingBad', [])
    .controller("bbCtrl", ['$scope', function ($scope) {
        if(!patternOnly){
            $scope.name = "Breaking Bad";
            $scope.counter = 0;
            $scope.disabled = true;

            $scope.tryAgain = function() {
                            if($scope.counter == 15){
                                $scope.counter = 0;
                            } else {
                                $scope.counter++;
                            }
                         }
        } else {
            $scope.name = name;
            $scope.counter = count;
        }


    }])
    .directive('ngBreakingBad', function () {
        return{
            restrict: "AE",
            replace: true,
            link: function (scope, element) {

                scope.$watch('[name , counter]', function () {
                    var name = scope.name.replace(/[^a-zA-Z ]/g, '');
                    var names =  name.split(" ");
                    if(names.length >= 2){
                        scope.disabled = false;
                        var first = breakBad(names[0], scope.counter);
                        var last = breakBad(names[1], scope.counter);
                        generator_key = 'breaking-bad:'+names[0]+' '+names[1]+':'+scope.counter;
                        var html = "<div id='breaking-bad'><div id='bb-body'>"+
                                       "<div class='name first'>"
                                       +first+
                                       "</div><div class='name last'>"
                                       +last+
                                        "</div></div></div>";

                    }else{
                        scope.disabled = true;
                        scope.counter = 0;
                        var html = "<div id='breaking-bad'></div>";
                    }
                    element.html(html);
                });

                // Array of all Elements
                var elements = ['Ac','Ag','Al','Am','Ar','As','At','Au',
                                'B','Ba','Be','Bh','Bi','Bk','Br',
                                'C','Ca','Cd','Ce','Cf','Cl','Cm','Cn','Co','Cr','Cs','Cu',
                                'Db','Ds','Dy',
                                'Er','Es','Eu',
                                'F','Fe','Fl','Fm','Fr',
                                'Ga','Gd','Ge',
                                'H','He','Hf','Hg','Ho','Hs',
                                'I','In','Ir',
                                'K','Kr',
                                'La','Li','Lr','Lu','Lv',
                                'Md','Mg','Mn','Mo','Mt',
                                'N','Na','Nb','Nd','Ne','Ni','No','Np',
                                'O','Os',
                                'P','Pa','Pb','Pd','Pm','Po','Pr','Pt','Pu',
                                'Ra','Rb','Re','Rf','Rg','Rh','Rn','Ru',
                                'S','Sb','Sc','Se','Sg','Si','Sm','Sn','Sr',
                                'Ta','Tb','Tc','Te','Th','Ti','Tl','Tm',
                                'U','Uuo','Uup','Uus','Uut',
                                'V',
                                'W',
                                'Xe',
                                'Y','Yb',
                                'Zn','Zr'];

                // Search the element in the name
                function breakBad(name, num){
                    name = name.toLowerCase();
                    if(name.length < 3){
                        return '';
                    }

                    var userElements = [];
                    r = name;
                    for(i=0; i<elements.length; i++){

                        // Let's not match single character elements.
                        /*if(elements[i].length < 2) {
                            continue;
                        }*/

                        // Does this element occur?
                        symbol = elements[i].toLowerCase(),
                        index = name.indexOf(symbol);

                        // Nope!
                        if(index === -1) {
                            continue;
                        } else if(num > 0) {
                            num -= 1;
                            continue;
                        }

                        // Yep!
                        r = generate(name, elements[i] , index);
                        break;
                    }
                    if(r == name){
                        r = breakBad(name, num-1);
                    }

                    return r;


                }

                // Genrate the required HTML o/p
                function generate(text, symbol, imdex){
                    var left = text.slice(0, index);
                    if(left.length == 0){
                        left = '&nbsp;';
                    }
                    var right = text.slice(index + symbol.length, text.length);
                    if(right.length == 0){
                        right = '&nbsp;';
                    }
                    return "<div class='left'>"+ left + "</div>" +
                           "<div class='element'><img  src='"+dirName+"/../../assets/elements/" + symbol + ".png'/></div>" +
                           "<div class='right'>" + right +
                           "</div>";
                }

                //console.log($scope.name);
            }
        };
    })