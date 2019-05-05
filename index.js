var k = document.cookie;

function createForm() {

    var formBody = $('#createForm');
    var form = $('<form></form>');
    form.attr({ id: 'myForm', action: 'upload_file.php', method: 'post', enctype: 'multipart/form-data' });
    form.append('<label for="file">File to be uploaded: </label>');
    form.append('<input type="file" name="file" id="file" />');
    form.append('<input type="text" name="filename" id="filename" placeholder="enter alternative name" />');
    form.append('<input type="submit" name="submit" value="Submit" />');
    formBody.append(form);

}

function getFileList() {
    $.ajax({
        url: 'file_list.php',
        complete: function (response) {
            var fileList = JSON.parse(response.responseText);
            for (let i in fileList) {
                var item = fileList[i];
                var listItem = $('#file_list').append(`<li>${item}</li>`);
                if (Cookies.get(fileList[i])) {
                    listItem.append(`<div>(${Cookies.get(fileList[i])})</div>`);
                }
                // Cookies.get(fileList[i]) ? fileList[i] + '>>' + Cookies.get(fileList[i]) : fileList[i];
            }
        },
        error: function () {
            $('#file_list').html('Error occurred.');
        }
    });
}

//unable to send payload through ajax post
function downLoadFile(filename) {
    var data = {};
    data.filename = 'asd.html';
    var json1 = JSON.stringify(data);
    $.ajax({
        url: 'download_file.php',
        contentType: 'application/json;charset=utf-8',
        data: json1,
        dataType: 'json',
        success: function (response) {
            window.location = 'download_file.php';

        },
        error: function () {
            $('#file_list').html('Error occurred.');
        }
    });

}


//alternate method to pass filename for downloading
function hiddenForm(file) {
    var form = $('<form></form>');
    form.attr('action', 'download_file.php');
    form.attr('method', 'post');
    form.attr('target', '_self');

    var my_input = $(`<input type="hidden" name="downFileName"/>`);
    my_input.attr('value', file);

    form.append(my_input);
    $('#hidden').append(form);
    form.submit();

}

// downLoadFile('asd.html');
$('#file_list').on('click', 'li', function () {
    hiddenForm($(this).text());

})
createForm();
getFileList();
