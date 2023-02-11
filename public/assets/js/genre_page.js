// Genre Scripts
$(document).ready(function () {

    $("#genreTable").dataTable({
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
            url: `fetchGenreList`,
            data: function (data) { },
            error: (error) => {
                console.log(error);
            },
        },
    });

    $(document).on("submit", "#addGenreForm", function (e) {
        e.preventDefault();
        let formData = new FormData($("#addGenreForm")[0]);

        $.ajax({
            type: "POST",
            url: `${domainURL}storeGenre`,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {
                    console.log(response.errors);
                } else if (response.status == 200) {
                    $("#addGenreModal").modal("hide");
                    swal({
                        title: "Genre Added Succesfully!",
                        icon: "success",
                    });
                    $("#genreTable").DataTable().ajax.reload(null, false);
                }
            },
        });
    });

    $("#genreTable").on("click", ".edit", function (e) {
        e.preventDefault();

        var id = $(this).attr("rel");
        var genre = $(this).data("title");

        $("#genre_id").val(id);
        $("#editGenre").val(genre);

        // console.log(genre);

        $("#editGenreModal").modal("show");

    });

    $(document).on('submit', '#editGenreForm', function (e) {
        e.preventDefault();
        var id = $('#genre_id').val();
        let EditformData = new FormData($('#editGenreForm')[0]);

        $.ajax({
            type: "POST",
            url: `${domainURL}updateGenre/` + id,
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
                        title: "Genre Updated Succesfully!",
                        icon: "success",
                    });
                    $("#genreTable").DataTable().ajax.reload(null, false);
                    $('#editGenreModal').modal('hide');

                }
            }
        });
    });

    $("#genreTable").on('click', '.delete', function (e) {
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
                            url: `${domainURL}deleteGenre/` + id,
                            dataType: "json",
                            success: function (response) {
                                if (response.status == 404) {
                                    console.log(response.message);
                                } else if (response.status == 200) {
                                    swal(
                                        `Genre Delete Successfully`, {
                                        icon: "success",
                                    });
                                    console.log(response.message);
                                    $("#genreTable").DataTable().ajax.reload(null, false);
                                }
                            }
                        });
                    }
                }
            });
    });

});