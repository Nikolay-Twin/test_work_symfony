

$("document").ready(function() {
    $("#form_calculate").on("click", function() {
        send('/api/v1/calculate', getData());
    });

    $("#form_buy").on("click", function() {
        send('/api/v1/buy', getData());
    });
});

function getData() {
    return JSON.stringify(Object.fromEntries(new Map([
        ['product', $("#form_product").val()],
        ['taxNumber', $("#form_taxNumber").val()],
        ['couponCode', $("#form_couponCode").val()],
        ['paymentProcessor', $("#form_paymentProcessor").val()],
        ['money', $("#form_money").val()],
    ])));
}

function clear() {
    $("#form_success").empty();
    $("#form_errors").empty();
}

function send(path, formData) {
    $.ajax({
        url: path,
        method: 'put',
        dataType: 'json',
        data: formData,
        success: function(data) {
            let answer = data;
            clear();
            if (typeof answer.message != 'undefined') {
                $("#form_success").append(answer.message + '<br>');
            }
        },
        error: function(data) {
            let answer = data.responseJSON;
            if (answer.message == 'validation_failed'  || answer.message == 'billing_errors') {
                clear();
                $.each(answer.errors, (index, value) => {
                    $("#form_errors").append(value.message + '<br>');
                })
            }
        }
    });
}
