function formSubmit(target) {
    event.preventDefault();

    var form = $("#inputform");

    // 送信先の変更
    form.attr('action', target);

    // 送信
    form.submit();
}


$(function() {
    var checkboxes = $(".reportContainer_subpin-item input[type='checkbox']");

    for (var i = 0; i < checkboxes.length; i++) {
        if($(checkboxes[i]).is(":checked")) {
            $(checkboxes[i]).parent().addClass("reportContainer_subpin-on");
        }
    }

    // チェックボックス
    checkboxes.on('change', function() {
        if($(this).is(":checked")){
            $(this).parent().addClass("reportContainer_subpin-on");
        }else{
            $(this).parent().removeClass("reportContainer_subpin-on");
        }
    });

    // pickadate
    $('.js-datepicker').pickadate({
        selectMonths: true,
        selectYears: 20,
        max: true,
        klass: {
            navPrev: '',
            navNext: ''
        }
    });
    $('.js-timepicker').pickatime({
        format: 'HH:i',
        interval: 60

    });
});


