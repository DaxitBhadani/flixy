$(document).ready(function () {

    var seriesId = $(".series_id").val();
    var episode_id = $(".episode_id").val();
    

    $("#episodeSourceTable").dataTable({
        processing: true,
        serverSide: true,
        serverMethod: "post",
        aaSorting: [
            [0, "desc"]
        ],
        columnDefs: [{
            targets: [0, 1, 2, 3],
            orderable: false,
        }],
        ajax: {
            url: `${domainURL}fetchEpisodeSourceList/` + episode_id,
            data: function (data) {
                data.series_id = seriesId
            },
            error: (error) => {
                console.log(error);
            },
        },
    });

    $(function () {
        $("#source_type").change(function () {
            if ($(".otherSelect").is(":selected")) {
                $(".sourceFile").show();
                $(".sourceURL").hide();
                $("#source_file").attr('required', 'required');
                $("#sourceURL").removeAttr('required', 'required');
            } else {
                $(".sourceURL").show();
                $(".sourceFile").hide();
                $("#sourceURL").attr('required', 'required');
                $("#source_file").removeAttr('required', 'required');
            }
        }).trigger('change');
    });

    $(document).on("submit", "#addEpisodeSourceForm", function (e) {
        e.preventDefault();

        var a = ($('#download_type').is(":checked"));

        let formData = new FormData($("#addEpisodeSourceForm")[0]);
        formData.set('download_type', a ? 1 : 0);
        $.ajax({
            type: "POST",
            url: `${domainURL}addEpisodeSource`,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {
                    console.log(response.errors);
                } else if (response.status == 200) {
                    $("#addEpisodeSourceModal").modal("hide");
                    swal({
                        title: "Episode Source Added Succesfully!",
                        icon: "success",
                    });
                    $("#episodeSourceTable").DataTable().ajax.reload(null, false);
                }
            },
        });
    });

    $(document).on("click", "#video_id", function (e) {
        e.preventDefault();
        var videoUrl = $(this).attr("rel");
        console.log(videoUrl);

        var output = document.getElementById('show_video');
        output.src = `${domainURL}upload/` + videoUrl;
        output.onload = function () {
            URL.revokeObjectURL(output.src)
        }
    });

    $('#episodeSourceTable').on("click", ".edit", function(e){
        e.preventDefault();

        var id = $(this).attr("rel");
        var title = $(this).data("title");
        var quality = $(this).data("quality");
        var size = $(this).data("size");
        var download_type = $(this).data("downloadtype");

        if (download_type == 1) {
            $("#editDownload_type").attr('checked', 'checked');
        } else {
            $("#editDownload_type").removeAttr('checked', 'checked');
        }
        
        var source_type = $(this).data("sourcetype");
        
        if (source_type == 7) {
            $(".sourceFile").show();
            $(".sourceURL").hide();
        } else {
            $(".sourceFile").hide();
            $(".sourceURL").show();
        }

        var source_url = $(this).data("sourceurl");
        var access_type = $(this).data("accesstype");
        
        $("#editSource").val(id);
        $("#editTitle").val(title);
        $("#editQuality").val(quality);
        $("#editSize").val(size);
        $("#editDownload_type").val(download_type);
        $("#editSource_type").val(source_type).selectric('refresh');
        $("#editSourceURL").val(source_url);
        $("#editAccess_type").val(access_type).selectric('refresh');

        $("#editEpisodeSourceModal").modal("show");

    });

    $(document).on('submit', '#editEpisodeSourceForm', function (e) {
        e.preventDefault();
        var id = $('#editSource').val();
        console.log(id);

        var checked = ($('#download_type').is(":checked"));

        let EditformData = new FormData($('#editEpisodeSourceForm')[0]);
        EditformData.set('download_type', checked ? 1 : 0);
        $.ajax({
            type: "POST",
            url: `${domainURL}updateEpisodeSource/` + id,
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
                        title: "Episode Source Updated Succesfully!",
                        icon: "success",
                    });
                    $("#episodeSourceTable").DataTable().ajax.reload(null, false);
                    $('#editEpisodeSourceModal').modal('hide');

                }
            }
        });
    });

    $("#episodeSourceTable").on('click', '.delete', function (e) {
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
                        url: `${domainURL}deleteEpisodeSource/` + id,
                        dataType: "json",
                        success: function (response) {
                            if (response.status == 404) {
                                console.log(response.message);
                            } else if (response.status == 200) {
                                swal(
                                    `Episode Source Deleted Successfully`, {
                                    icon: "success",
                                });
                                $("#episodeSourceTable").DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            }
        });
    });


    $("#episodeSubtitleTable").dataTable({
        processing: true,
        serverSide: true,
        serverMethod: "post",
        aaSorting: [
            [0, "desc"]
        ],
        columnDefs: [{
            targets: [],
            orderable: false,
        }],
        ajax: {
            url: `${domainURL}fetchEpisodeSubtitle/` + episode_id,
            data: function (data) {
                data.series_id = seriesId
            },
            error: (error) => {
                console.log(error);
            },
        },
    });
    
    $(document).on("submit", "#addEpisodeSubtitleForm", function (e) {
        e.preventDefault();

        let formData = new FormData($("#addEpisodeSubtitleForm")[0]);

        $.ajax({
            type: "POST",
            url: `${domainURL}addEpisodeSubtitle`,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {
                    console.log(response.errors);
                } else if (response.status == 200) {
                    $("#addEpisodeSubtitleModal").modal("hide");
                    swal({
                        title: "Episode Subtitle Added Succesfully!",
                        icon: "success",
                    });
                    $("#episodeSubtitleTable").DataTable().ajax.reload(null, false);
                }
            },
        });
    });

    $("#episodeSubtitleTable").on('click', '.delete', function (e) {
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
                        url: `${domainURL}deleteEpisodeSubtitle/` + id,
                        dataType: "json",
                        success: function (response) {
                            if (response.status == 404) {
                                console.log(response.message);
                            } else if (response.status == 200) {
                                swal(
                                    `Episode Subtitle Deleted Successfully`, {
                                    icon: "success",
                                });
                                $("#episodeSubtitleTable").DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            }
        });
    });

});