$(document).ready(function(){
                $("#about").click(function(){
                    $(".home").css({"visibility": "hidden"});
                    $(".about").css({"visibility": "visible"});
                    
                });
                $("#profile").click(function(){
                    $(".profile").css({"visibility": "visible"});
                    $(".home").css({"visibility": "hidden"});
                    $(".about").css({"visibility": "hidden"});
                });
            });