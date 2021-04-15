$(function ($) {
    $('body').on("click", '#addFields', function () {
        $('form').append('<br><input type="text" />')
    })
})(jQuery)

        var index = 1
        $(function ($) {
            index++
            console.log(index);
            var name = "protein[" + index + "][name]"
            var wheal = "protein[" + index +"][wheal]"
            $('body').on("click", '#addFields', function () {
                $('form').append('<br><input type="text" name = '+ name + 'list="origins" />')
                //$('form').append('<label  for="wheal">wheal</label><br> <input autocomplete="off"  type="number" id="wheal" name="'wheal'" min = "0" max = ""> <br>')
            })
        })