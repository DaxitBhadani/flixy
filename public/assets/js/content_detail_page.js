$(document).ready(function () {

    var movieId = $(".movie_id").val();

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

        $("#editSource_type").change(function () {
            if ($(".otherSelect").is(":selected")) {
                $(".sourceFile").show();
                $(".sourceURL").hide();
            } else {
                $(".sourceURL").show();
                $(".sourceFile").hide();
            }
        }).trigger('change');
    });

    $(document).on("click", "#video_id", function (e) {
        e.preventDefault();
        var videoUrl = $(this).attr("rel");
        console.log(videoUrl);

        var output = document.getElementById('show_video');
        output.src = "../upload/" + videoUrl;
        output.onload = function () {
            URL.revokeObjectURL(output.src)
        }
    });

    $("#sourceTable").dataTable({
        processing: true,
        serverSide: true,
        serverMethod: "post",
        aaSorting: [
            [0, "desc"]
        ],
        columnDefs: [{
            targets: [0, 1, 2, 3],
            orderable: false,
        },],
        ajax: {
            url: `sourceList`,
            data: function (data) {
                data.movie_id = movieId
            },
            error: (error) => {
                console.log(error);
            },
        },
    });

    $(document).on("submit", "#addSourceForm", function (e) {
        e.preventDefault();

        var a = ($('#download_type').is(":checked"));

        let formData = new FormData($("#addSourceForm")[0]);
        formData.set('download_type', a ? 1 : 0);
        $.ajax({
            type: "POST",
            url: `${domainURL}addSource`,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {
                    console.log(response.errors);
                } else if (response.status == 200) {
                    $("#addSourceModal").modal("hide");
                    swal({
                        title: "Source Added Succesfully!",
                        icon: "success",
                    });
                    $("#sourceTable").DataTable().ajax.reload(null, false);
                }
            },
        });
    });

    $('#sourceTable').on("click", ".edit", function(e){
        e.preventDefault();

        var id = $(this).attr("rel");
        var title = $(this).data("title");
        var quality = $(this).data("quality");
        var size = $(this).data("size");
        var download_type = $(this).data("download");

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

        $("#editSourceModal").modal("show");

    });

    $(document).on('submit', '#editSourceForm', function (e) {
        e.preventDefault();
        var id = $('#editSource').val();
        console.log(id);

        var checked = ($('#download_type').is(":checked"));

        let EditformData = new FormData($('#editSourceForm')[0]);
        EditformData.set('download_type', checked ? 1 : 0);
        $.ajax({
            type: "POST",
            url: `${domainURL}updateSource/` + id,
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
                        title: "Source Updated Succesfully!",
                        icon: "success",
                    });
                    $("#sourceTable").DataTable().ajax.reload(null, false);
                    $('#editSourceModal').modal('hide');

                }
            }
        });
    });

    $("#sourceTable").on('click', '.delete', function (e) {
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
                        url: `${domainURL}deleteSource/` + id,
                        dataType: "json",
                        success: function (response) {
                            if (response.status == 404) {
                                console.log(response.message);
                            } else if (response.status == 200) {
                                swal(
                                    `Source Deleted Successfully`, {
                                    icon: "success",
                                });
                                $("#sourceTable").DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            }
        });
    });

    // Cast Table

    $("#castTable").dataTable({
        processing: true,
        serverSide: true,
        serverMethod: "post",
        aaSorting: [
            [0, "desc"]
        ],
        columnDefs: [{
            targets: [0, 1, 2, 3],
            orderable: false,
        },],
        ajax: {
            url: `castList`,
            data: function (data) {
                data.movie_id = movieId
            },
            error: (error) => {
                console.log(error);
            },
        },
    });

    $(document).on("submit", "#addCastForm", function (e) {
        e.preventDefault();

        let formData = new FormData($("#addCastForm")[0]);

        $.ajax({
            type: "POST",
            url: `${domainURL}storeNewCast`,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {
                    console.log(response.errors);
                } else if (response.status == 200) {
                    $("#addCastModal").modal("hide");
                    swal({
                        title: "Cast Added Succesfully!",
                        icon: "success",
                    });
                    $("#castTable").DataTable().ajax.reload(null, false);
                }
            },
        });
    });

    $('#castTable').on("click", ".edit", function(e){
        e.preventDefault();

        var id = $(this).attr("rel");
        var title = $(this).data("title");
        var role = $(this).data("role");
        
        $("#editCast").val(id);
        $("#editSelectActor").val(title).selectric('refresh');
        $("#editRole").val(role);

        $("#editCastModal").modal("show");

    });

    $(document).on('submit', '#editCastForm', function (e) {
        e.preventDefault();
        var id = $('#editCast').val();
        console.log(id);
 
        let EditformData = new FormData($('#editCastForm')[0]);
        $.ajax({
            type: "POST",
            url: `${domainURL}updateCast/` + id,
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
                        title: "Cast Updated Succesfully!",
                        icon: "success",
                    });
                    $("#castTable").DataTable().ajax.reload(null, false);
                    $('#editCastModal').modal('hide');

                }
            }
        });
    });

    $("#castTable").on('click', '.delete', function (e) {
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
                        url: `${domainURL}deleteCast/` + id,
                        dataType: "json",
                        success: function (response) {
                            if (response.status == 404) {
                                console.log(response.message);
                            } else if (response.status == 200) {
                                swal(
                                    `Cast Deleted Successfully`, {
                                    icon: "success",
                                });
                                $("#castTable").DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            }
        });
    });

    // Subtitle Table

    $("#subtitleTable").dataTable({
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
            url: `SubtitleList`,
            data: function (data) {
                data.movie_id = movieId
            },
            error: (error) => {
                console.log(error);
            },
        },
    });

    $(document).on("submit", "#addSubtitleForm", function (e) {
        e.preventDefault();

        let formData = new FormData($("#addSubtitleForm")[0]);

        $.ajax({
            type: "POST",
            url: `${domainURL}storeSubtitle`,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {
                    console.log(response.errors);
                } else if (response.status == 200) {
                    $("#addSubtitleModal").modal("hide");
                    swal({
                        title: "Subtitle Added Succesfully!",
                        icon: "success",
                    });
                    $("#subtitleTable").DataTable().ajax.reload(null, false);
                }
            },
        });
    });

    $("#subtitleTable").on('click', '.delete', function (e) {
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
                        url: `${domainURL}deleteSubtitle/` + id,
                        dataType: "json",
                        success: function (response) {
                            if (response.status == 404) {
                                console.log(response.message);
                            } else if (response.status == 200) {
                                swal(
                                    `Subtitle Deleted Successfully`, {
                                    icon: "success",
                                });
                                $("#subtitleTable").DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            }
        });
    });


});