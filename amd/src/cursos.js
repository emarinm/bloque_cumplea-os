define("block_bcn_birthdays_section/cursos", ["jquery"], (function ($) {

    var arr = [];
    $('#table').on('check.bs.table', function (row, $element) {
        $element.tipo = $("[name='config_tipo']").val();
        arr[$element.id] = $element;
        var input = $("[name='config_cursos']");
        input.attr("value", JSON.stringify(arr));
    });

    $('#table').on('uncheck.bs.table', function (row, $element) {

        $element.tipo = $("[name='config_tipo']").val();
        arr[$element.id] = $element;
        var input = $("[name='config_cursos']");
        input.attr("value", JSON.stringify(arr));
    });

    $('#tablecat').on('check.bs.table', function (row, $element) {
    
        $element.tipo = $("[name='config_tipo']").val();
        arr[$element.id] = $element;
        var input = $("[name='config_cursos']");
        input.attr("value", JSON.stringify(arr));
    
    });

    $('#tablecat').on('uncheck.bs.table', function (row, $element) {
         $element.tipo = $("[name='config_tipo']").val();
        arr[$element.id] = $element;
        var input = $("[name='config_cursos']");
        input.attr("value", JSON.stringify(arr));
    });
}));