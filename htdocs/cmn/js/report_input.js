function formSubmit(e){event.preventDefault();var t=$("#inputform");t.attr("action",e),t.submit()}$(function(){for(var e=$(".reportContainer_subpin-item input[type='checkbox']"),t=0;t<e.length;t++)$(e[t]).is(":checked")&&$(e[t]).parent().addClass("reportContainer_subpin-on");e.on("change",function(){$(this).is(":checked")?$(this).parent().addClass("reportContainer_subpin-on"):$(this).parent().removeClass("reportContainer_subpin-on")}),$(".js-datepicker").pickadate({selectMonths:!0,selectYears:20,max:!0,klass:{navPrev:"",navNext:""}}),$(".js-timepicker").pickatime({format:"HH:i",interval:60})});