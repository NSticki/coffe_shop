require('./bootstrap');

require('summernote');
require('summernote/dist/summernote.js')
require('summernote/dist/summernote-bs4.js');
require('summernote/dist/summernote-bs4.css');

import 'bootstrap4-datetimepicker';

// JQuery
import $ from 'jquery';

window.$ = window.jQuery = $;

/* Datepicker */
import 'jquery-ui/ui/widgets/datepicker.js';

$('.datepicker').datetimepicker({
    format: 'HH:mm',
    icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down",
        previous: "fa fa-chevron-left",
        next: "fa fa-chevron-right",
        today: "fa fa-clock-o",
        clear: "fa fa-trash-o"
    }
});

$('.summernote').summernote({
    height: 250,
    local: 'ru-RU'
});


const addBtn = $('#addOption');
const table = $('#options-table');
var i = $(table).find('[id*="item-"]').length;
addBtn.on('click', function () {

    let html =
        `<tr id="item-${i}">
            <input type="hidden" name="options[${i}][guid]" value="null">
            <td><input class="form-control" type="checkbox" name="options[${i}][is_disabled]" value="1"></td>
            <td><input class="form-control" type="text" name="options[${i}][name]" placeholder="Название"></td>
            <td><select class="custom-select" name="options[${i}][prefix]">
                    <option value="-">-</option>
                    <option value="+">+</option>
                </select></td>
            <td><input class="form-control" type="text" name="options[${i}][price]" placeholder="Цена"></td>
            <td><input class="form-control" type="text" name="options[${i}][weight]" placeholder="Вес 0.00"></td>
            <td class="text-right">
                <button type="button" onclick="deleteItem(this)"  data-target="${i}" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr>`;
    $('#options-table').append(html);
    i++

})
