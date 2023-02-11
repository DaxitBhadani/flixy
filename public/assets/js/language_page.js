$(document).ready(function () {

    $("#languageTable").dataTable({
        processing: true,
        serverSide: true,
        serverMethod: "post",
        aaSorting: [
            [0, "desc"]
        ],
        columnDefs: [{
            targets: [0, 1],
            orderable: false,
        },],
        ajax: {
            url: `fetchLanguageList`,
            data: function (data) { },
            error: (error) => {
                console.log(error);
            },
        },
    });

    $(document).on('submit', '#addLanguageForm', function (e) {
        e.preventDefault();
        let formData = new FormData($('#addLanguageForm')[0]);

        $.ajax({
            type: "POST",
            url: `${domainURL}storeLanguage`,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {

                    console.log(response.errors);

                } else if (response.status == 200) {
                    $('#addLanguageModal').modal('hide');
                    swal({
                        title: "Language Added Succesfully!",
                        icon: "success",
                    });
                    $("#languageTable").DataTable().ajax.reload(null, false);
                }
            }
        });
    });

    $("#languageTable").on('click', '.edit', function (e) {
        e.preventDefault();

        var id = $(this).attr('rel');
        var languageName = $(this).data('title');

        $('#Language_id').val(id);
        $('#editLanguageName').val(languageName);

        console.log(languageName);

        $('#editLanguageModal').modal('show');

    });

    $(document).on('submit', '#editLanguageform', function (e) {
        e.preventDefault();
        var id = $('#Language_id').val();

        let EditformData = new FormData($('#editLanguageform')[0]);

        $.ajax({
            type: "POST",
            url: `${domainURL}updateLanguage/` + id,
            data: EditformData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {
                    console.log("400");
                    console.log(response.errors);
                } else if (response.status == 404) {
                    alert(response.message);

                } else if (response.status == 200) {

                    swal({
                        title: "Language Updated Succesfully!",
                        icon: "success",
                    });
                    $("#languageTable").DataTable().ajax.reload(null, false);
                    $('#editLanguageModal').modal('hide');

                }
            }
        });
    });

    $("#languageTable").on('click', '.delete', function (e) {
        e.preventDefault();

        var id = $(this).attr('rel');
        console.log(id);

        swal({
            title: "Are you sure You want to delete!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((deleteValue) => {
                if (deleteValue) {
                    if (deleteValue == true) {
                        $.ajax({
                            type: "POST",
                            url: `${domainURL}deleteLanguage/` + id,
                            dataType: "json",
                            success: function (response) {
                                if (response.status == 404) {
                                    console.log(response.message);
                                } else if (response.status == 200) {
                                    swal(`Language Delete Successfully`, {
                                        icon: "success",
                                    });
                                    console.log(response.message);
                                    $("#languageTable").DataTable().ajax.reload(null, false);
                                }
                            }
                        });
                    }
                }
            });
    });


});
