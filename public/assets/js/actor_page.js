$(document).ready(function () {

    $("#actorTable").dataTable({
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
            url: `fetchActorList`,
            data: function (data) { },
            error: (error) => {
                console.log(error);
            },
        },
    });

    $(document).on("submit", "#addActorForm", function (e) {
        e.preventDefault();
        let formData = new FormData($("#addActorForm")[0]);

        $.ajax({
            type: "POST",
            url: `${domainURL}storeActor`,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {
                    console.log(response.errors);
                } else if (response.status == 200) {
                    $("#addActorModal").modal("hide");
                    swal({
                        title: "Actor Added Succesfully!",
                        icon: "success",
                    });
                    $("#actorTable").DataTable().ajax.reload(null, false);
                }
            },
        });
    });

    $("#actorTable").on("click", ".edit", function (e) {
        e.preventDefault();

        var id = $(this).attr("rel");
        var image = $(this).data("image");
        var actor = $(this).data("title");

        $("#actor_id").val(id);
        $('#editActorImage').attr('src', `upload/${image}`);
        $("#editActor").val(actor);

        console.log(actor);

        $("#editActorModal").modal("show");

    });

    $(document).on('submit', '#editActorForm', function (e) {
        e.preventDefault();
        var id = $('#actor_id').val();
        console.log(id);
        let EditformData = new FormData($('#editActorForm')[0]);

        $.ajax({
            type: "POST",
            url: `${domainURL}updateActor/` + id,
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
                        title: "Actor Updated Succesfully!",
                        icon: "success",
                    });
                    $("#actorTable").DataTable().ajax.reload(null, false);
                    $('#editActorModal').modal('hide');

                }
            }
        });
    });

    $("#actorTable").on('click', '.delete', function (e) {
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
                        url: `${domainURL}deleteActor/` + id,
                        dataType: "json",
                        success: function (response) {
                            if (response.status == 404) {
                                console.log(response.message);
                            } else if (response.status == 200) {
                                swal(
                                    `Actor Delete Successfully`, {
                                    icon: "success",
                                });
                                console.log(response.message);
                                $("#actorTable").DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            }
        });
    });



});
