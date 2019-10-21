$(function(){
    var entry_url = $("#entry_url").val();

    $("#cart_in").click(function(){
        var item_id = $("#item_id").val();
        location.href = entry_url + "cart.php?item_id=" + item_id; //$_GETで渡すため
    });


    $("img").hover(
        function(){
            $(this).animate({width: "300px"});
        },
        function(){
            $(this).animate({width: "250px"});
    });

});
