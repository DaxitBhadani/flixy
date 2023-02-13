$(document).ready(function () {

    $("#contentTable").dataTable({
        processing: true,
        serverSide: true,
        serverMethod: "post",
        aaSorting: [
            [0, "desc"]
        ],
        columnDefs: [{
            targets: [0, 1, 2, 3, 4, 5, 6, 7],
            orderable: false,
        },],
        ajax: {
            url: `fetchContentList`,
            data: function (data) { },
            error: (error) => {
                console.log(error);
            },
        },
    });

    $(document).on("submit", "#addNewContentForm", function (e) {
        e.preventDefault();
        let formData = new FormData($("#addNewContentForm")[0]);

        $.ajax({
            type: "POST",
            url: `${domainURL}storeNewContent`,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {
                    console.log(response.errors);
                } else if (response.status == 200) {
                    $("#addContentModal").modal("hide");
                    swal({
                        title: "Content Added Succesfully!",
                        icon: "success",
                    });
                    $("#contentTable").DataTable().ajax.reload(null, false);
                    $("#contentSeriesTable").DataTable().ajax.reload(null, false);
                }
            },
        });
    });

    $("#contentTable").on("change", ".featured", function (event) {
        event.preventDefault();

        swal({
            title: "Are you sure?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                swal("Your Content Add In Featured", {
                    icon: "success",
                });

                if (user_type == "1") {
                    $id = $(this).attr("rel");

                    if ($(this).prop("checked") == true) {
                        swal("Your Content Add In Featured", {
                            icon: "success",
                        });
                        $value = 1;
                        console.log("Checkbox is Checked.");
                        console.log("1 == true");
                    } else {
                        swal("Your Content remove In featured", {
                            icon: "success",
                        });
                        $value = 0;
                        console.log("Checkbox is unchecked.");
                        console.log("0 == false");
                    }

                    $.post(
                        "updateContent/" + $id,
                        {
                            id: $id,
                            featured: $value,
                        },

                        function (returnedData) {
                            console.log(returnedData);

                            $("#contentTable").DataTable().ajax.reload(null, false);
                            $("#contentSeriesTable").DataTable().ajax.reload(null, false);
                        }
                    ).fail(function (error) {
                        console.log(error);
                    });
                } else {
                    iziToast.error({
                        title: "Error!",
                        message: " you are Tester ",
                        position: "topRight",
                    });
                }
            } else {
                $("#contentTable").DataTable().ajax.reload(null, false);
                $("#contentSeriesTable").DataTable().ajax.reload(null, false);
                swal("Your Content Not Add In featured");
            }
        });
    });

    $("#contentTable").on("click", ".edit", function (e) {
        e.preventDefault();

        var id = $(this).attr("rel");
        var title = $(this).data("title");
        var content_type = $(this).data("content_type");
        var desc = $(this).data("desc");
        var duration = $(this).data("duration");
        var year = $(this).data("year");
        var language = $(this).data("language");
        var rating = $(this).data("rating");
        var trailerId = $(this).data("trailer_id");
        var genres = $(this).data("genres");
        var vimage = $(this).data("vimage");
        var himage = $(this).data("himage");

        $("#content_id").val(id);
        $("#editContentTitle").val(title);
        $("#editContent_type").val(content_type).selectric('refresh');
        $("#editDesc").val(desc);
        $("#editDuration").val(duration);
        $("#editReleaseYear").val(year);
        $("#editSelectLang").val(language).selectric('refresh');
        $("#editRating").val(rating);
        $("#editTrailerId").val(trailerId);
        $("#editGenres").val(genres.split(',')).selectric('refresh');
        $('#editVerticlePosterImg').attr('src', `upload/${vimage}`);
        $('#editHorizontalPosterImg').attr('src', `upload/${himage}`);

        $("#editContentModal").modal("show");

    });

    $(document).on('submit', '#editContentForm', function (e) {
        e.preventDefault();
        var id = $('#content_id').val();

        let EditformData = new FormData($('#editContentForm')[0]);

        $.ajax({
            type: "POST",
            url: `${domainURL}updateContent/` + id,
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
                        title: "Content Updated Succesfully!",
                        icon: "success",
                    });
                    $("#contentTable").DataTable().ajax.reload(null, false);
                    $("#contentSeriesTable").DataTable().ajax.reload(null, false);
                    $('#editContentModal').modal('hide');

                }
            }
        });
    });

    $("#contentTable").on('click', '.delete', function (e) {
        e.preventDefault();

        var id = $(this).attr('rel');
        console.log(id);

        swal({
            title: "Are you sure You want to delete!",
            icon: "error",
            buttons: true,
            dangerMode: true,
        })
            .then((deleteValue) => {
                if (deleteValue) {
                    if (deleteValue == true) {
                        $.ajax({
                            type: "POST",
                            url: `${domainURL}deleteContent/` + id,
                            dataType: "json",
                            success: function (response) {
                                if (response.status == 404) {
                                    console.log(response.message);
                                } else if (response.status == 200) {
                                    swal(
                                        `Content Deleted Successfully`, {
                                        icon: "success",
                                    });
                                    console.log(response.message);
                                    $("#contentTable").DataTable().ajax.reload(null, false);
                                    $("#contentSeriesTable").DataTable().ajax.reload(null, false);
                                }
                            }
                        });
                    }
                }
            });
    });

    // Series Table Js

    $("#contentSeriesTable").dataTable({
        processing: true,
        serverSide: true,
        serverMethod: "post",
        aaSorting: [
            [0, "desc"]
        ],
        columnDefs: [{
            targets: [0, 1, 2, 3, 4, 5, 6, 7],
            orderable: false,
        },],
        ajax: {
            url: `fetchContentSeries`,
            data: function (data) { },
            error: (error) => {
                console.log(error);
            },
        },
    });

    $("#contentSeriesTable").on("change", ".featured", function (event) {
        event.preventDefault();

        swal({
            title: "Are you sure?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                swal("Your Content Add In Featured", {
                    icon: "success",
                });

                if (user_type == "1") {
                    $id = $(this).attr("rel");

                    if ($(this).prop("checked") == true) {
                        swal("Your Content Add In Featured", {
                            icon: "success",
                        });
                        $value = 1;
                        console.log("Checkbox is Checked.");
                        console.log("1 == true");
                    } else {
                        swal("Your Content remove In featured", {
                            icon: "success",
                        });
                        $value = 0;
                        console.log("Checkbox is unchecked.");
                        console.log("0 == false");
                    }
                    $.post(
                        "updateContent/" + $id,
                        {
                            id: $id,
                            featured: $value,
                        },
                        function (returnedData) {
                            $("#contentSeriesTable").DataTable().ajax.reload(null, false);
                        }
                    ).fail(function (error) {
                        console.log(error);
                    });
                } else {
                    iziToast.error({
                        title: "Error!",
                        message: " you are Tester ",
                        position: "topRight",
                    });
                }
            } else {
                $("#contentSeriesTable").DataTable().ajax.reload(null, false);
                swal("Your Content Not Add In featured");
            }
        });
    });

    $("#contentSeriesTable").on("click", ".ssedit", function (e) {
        e.preventDefault();

        var id = $(this).attr("rel");
        var title = $(this).data("title");
        var content_type = $(this).data("content_type");
        var desc = $(this).data("desc");
        var duration = $(this).data("duration");
        var year = $(this).data("year");
        var language = $(this).data("language");
        var rating = $(this).data("rating");
        var trailerId = $(this).data("trailer_id");
        var genres = $(this).data("genres");
        var vimage = $(this).data("vimage");
        var himage = $(this).data("himage");

        $("#content_id").val(id);
        $("#editContentTitle").val(title);
        $("#editContent_type").val(content_type).selectric('refresh');
        $("#editDesc").val(desc);
        $("#editDuration").val(duration);
        $("#editReleaseYear").val(year);
        $("#editSelectLang").val(language).selectric('refresh');
        $("#editRating").val(rating);
        $("#editTrailerId").val(trailerId);
        $("#editGenres").val(genres || genres.split(',')).selectric('refresh');
        $('#editVerticlePosterImg').attr('src', `upload/${vimage}`);
        $('#editHorizontalPosterImg').attr('src', `upload/${himage}`);

        $("#editContentModal").modal("show");

    });

    $("#contentSeriesTable").on('click', '.delete', function (e) {
        e.preventDefault();

        var id = $(this).attr('rel');
        console.log(id);

        swal({
            title: "Are you sure You want to delete!",
            icon: "error",
            buttons: true,
            dangerMode: true,
        })
            .then((deleteValue) => {
                if (deleteValue) {
                    if (deleteValue == true) {
                        $.ajax({
                            type: "POST",
                            url: `${domainURL}deleteContent/` + id,
                            dataType: "json",
                            success: function (response) {
                                if (response.status == 404) {
                                    console.log(response.message);
                                } else if (response.status == 200) {
                                    swal(
                                        `Content Deleted Successfully`, {
                                        icon: "success",
                                    });
                                    console.log(response.message);
                                    $("#contentTable").DataTable().ajax.reload(null, false);
                                    $("#contentSeriesTable").DataTable().ajax.reload(null, false);
                                }
                            }
                        });
                    }
                }
            });
    });

  

});