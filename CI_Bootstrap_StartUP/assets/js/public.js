$(document).ready(function () {
    $(".datepicker").datepicker({dateFormat: 'dd.mm.yy', beforeShowDay: function (date) {
            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
            return [array_of_recerved_dates.indexOf(string) == -1]
        }});
    $(".datepicker1").datepicker({dateFormat: 'dd.mm.yy'});
});