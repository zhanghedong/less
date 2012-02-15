<?php
/**
 * User: 1625
 * Date: 12-2-15
 * Time: 上午9:37
 * To change this template use File | Settings | File Templates.
 */
?>
<!doctype html>
<html>
<head>
    <title>Less Converter</title>
    <link rel="stylesheet/less" type="text/css" href="less-converter.less">
    <script src="../js/less-1.1.3.min.js"></script>
    <script src="../js/jquery-1.7.1.min.js"></script>
</head>
<body>

<div class="layout-11 headrow">
    <div class="column-3">Put your less code in here</div>
    <div class="column">Click this</div>
    <div class="column-3">Your CSS will come out over here</div>
    <div class="column-4">Your Optimized CSS will come out over here</div>
</div>

<div class="layout-11">
    <div class="column-3">
        <div class="import">LESS URL:&nbsp;<input type="text" name="src" value="http://d.com/lesscss/themes/style.less" id="src"><input type="button" id="import" value="import">
        </div>
        <textarea name="in" id="in" rows="6" cols="50"></textarea>
    </div>
    <div class="column-1">
        <input type="button" id="convert" value="Convert &raquo;"/>
    </div>
    <div class="column-3">
        <textarea name="out" id="out" rows="10" cols="50"></textarea>
    </div>
    <div class="column-4">
        <textarea name="optimized" id="optimized" rows="10" cols="50"></textarea>
    </div>
</div>

<script type="text/javascript">
    function optimize_css(css) {
        css = css.replace(/\n/g, "");
        css = css.replace(/{  /g, "{");
        css = css.replace(/ {/g, "{");
        css = css.replace(/;}/g, "}");
        css = css.replace(/: /g, ":");
        css = css.replace(/\/\*.+?\*\//g, "");
        css = css.replace(/\;  /g, ";");
        return css;
    }
    $(function () {
        var source = '';
        function getCssSource(url){


        }
        $('#import').bind('click', function () {
            var url = $('#src').val();
            var number = Math.random();
            if (url.indexOf('.less') != -1) {
                $.get(url + '?v=' + number, function (data) {
                    var arr = data.split('import');
                    console.log(arr);
                    if (arr.length > 1) {
                        var substr = '';
                        var urlStr = [];
                        for (var i = 0; i < arr.length; i++) {
                            substr = arr[i];
                            if( substr.indexOf('.less') != -1 ){
                                var s = substr.indexOf('\'') + 1;
                                var e = substr.indexOf('.less') + 3;
                                var str = substr.substr(s,e);
                                urlStr.push(str);
                            }
                        }
                        console.log(urlStr);
                    } else {
                        source = data;
                    }
                    $("#in").val(source);
                })
            }

        })

        $("#convert").bind('click', function () {
            var input = $("#in").val();
            $("#out").empty();
            try {
                new (less.Parser)().parse(input, function (err, tree) {
                    if (err) {
                        output = "Error, " + err.name + " on line " + err.line + ":\n" + err.message;
                        $("#out").val(output);
                    } else {
                        output = tree.toCSS();
                        $("#out").val(output);
                        $('#optimized').val(optimize_css(output));
                    }
                });
            } catch (err) {
                if (err.line) {
                    $("#out").val("Error line " + err.line + ":\n" + err.message);
                } else {
                    $("#out").val("Could not parse line " + err.callLine + ":\n" + err.callExtract);
                }
                //console.log(err);
            }
        });
    })
</script>
</body>
</html>
