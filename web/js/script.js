$(document).ready(function()
{
    $(".close").on("click",function()
    {
        $(this).parent().slideUp();
    })
});