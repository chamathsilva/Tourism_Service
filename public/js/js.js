/**
 * Created by chamathsilva on 10/19/15.
 */

$(document).ready(function(){
    $("#register").click(function(){
        url = "serviceRegister.php";
        $( location ).attr("href", url);
        return false;

    });

    $("#home").click(function(){
        url = "serviceProviderHome.php";
        $( location ).attr("href", url);
        return false;

    });


    $("#manage").click(function(){
        url = "manageService.php";
        $( location ).attr("href", url);
        return false;

    });

});