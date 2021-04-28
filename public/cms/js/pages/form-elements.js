$(document).ready(function() {
    
    "use strict";
    
    $('.date-picker').datepicker({
        orientation: "top auto",
        autoclose: true
    });
    
    $('#cp1').colorpicker({
        format: 'hex'
    });
    $('#cp2').colorpicker();
    
    $('#timepicker1').timepicker();
});