$(document).ready(function () {

    var seriesId = $(".series_id").val();

    $("#season_list").change(function () {

        var id = $('#season_list').val();
        var season_title = $('#season_list').find('option:selected').text();
        var season_trailer = $('#season_list').find('option:selected').attr('data-trailer_id');

        $("#edit_season").attr('rel', id);
        $("#delete_season").attr('rel', id);
        $("#edit_season").attr('data-title', season_title);
        $("#edit_season").attr('data-trailer', season_trailer);

        $(".season_id").attr('value', id);


    }).trigger('change');


    $(document).on("submit", "#addSeasonForm", function (e) {
        e.preventDefault();
        let formData = new FormData($("#addSeasonForm")[0]);

        $.ajax({
            type: "POST",
            url: `${domainURL}addSeason`,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {
                    console.log(response.errors);
                } else if (response.status == 200) {
                    $("#addSeasonModal").modal("hide");
                    swal({
                        title: "Season Added Succesfully!",
                        icon: "success",
                    });
                }
            },
        });
    });

    $('#season_action').on("click", ".edit", function (e) {

        var id = $(this).attr("rel");
        var season_title = $(this).data("title");
        var trailer_id = $(this).data("trailer");

        $(".season_id").attr('value', id);
        $("#title").val(season_title);
        $("#trailer_id").val(trailer_id);

        $("#editSeasonModal").modal("show");
    });


    $(document).on('submit', '#editSeasonForm', function (e) {
        e.preventDefault();

        var id = $('#season_id').val();
        console.log(id);

        let EditformData = new FormData($('#editSeasonForm')[0]);
        $.ajax({
            type: "POST",
            url: `${domainURL}updateSeason/` + id,
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
                        title: "Season Updated Succesfully!",
                        icon: "success",
                    });
                    $("#season_list").val(id).selectric('refresh');
                    $('#editSeasonModal').modal('hide');

                }
            }
        });
    });

    $("#season_action").on('click', '.delete', function (e) {
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
                            url: `${domainURL}deleteSeason/` + id,
                            dataType: "json",
                            success: function (response) {
                                if (response.status == 404) {
                                    console.log(response.message);
                                } else if (response.status == 200) {
                                    swal(
                                        `Season Delete Successfully`, {
                                        icon: "success",
                                    });
                                    console.log(response.message);
                                }
                            }
                        });
                    }
                }
            });
    });


    $("#seasonTable").dataTable({
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
            url: `${domainURL}fetchEpisodeList`,
            data: function (data) { },
            error: (error) => {
                console.log(error);
            },
        },
    });

    // Add Episode 

    $(document).on("submit", "#addEpisodeForm", function (e) {
        e.preventDefault();
        let formData = new FormData($("#addEpisodeForm")[0]);

        $.ajax({
            type: "POST",
            url: `${domainURL}addEpisode`,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {
                    console.log(response.errors);
                } else if (response.status == 200) {
                    $("#addEpisodeModal").modal("hide");
                    swal({
                        title: "Episode Added Succesfully!",
                        icon: "success",
                    });
                    $("#seasonTable").DataTable().ajax.reload(null, false);
                }
            },
        });
    });


});