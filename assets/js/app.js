

var $ = require('jquery');

require('bootstrap-sass');

require('../css/app.scss');

$(document).ready(function()
{
    $(".close").on("click",function()
    {
        $(this).parent().slideUp();
    })
});