$(document).ready(function() {
    $('.amount').keyup(function () {
        let num1 = $(this).val();
        let result;

        if (num1 >= 200 && num1 <= 10000)
        {
            result = Math.round(num1 * 0.15);
        }
        else if (num1 >= 10001 && num1 <= 50000)
        {
            result = Math.round(num1 * 0.10);
        }
        else if (num1 > 50000)
        {
            result = Math.round(num1 * 0.07);
        }
        else {
            result = ('');
        }
        document.getElementById("result").innerHTML =  '<span class="label label-warning">Frais de service retenus : '  + result + ' €' + '</span>';
    });
});