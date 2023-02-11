$(document).ready(function () {
   
    $("#tvChannelTable").dataTable({
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
            url: `fetchTvChannelList`,
            data: function (data) { },
            error: (error) => {
                console.log(error);
            },
        },
    });

    $(document).on("submit", "#addTvChannelForm", function (e) {
        e.preventDefault();
        let formData = new FormData($("#addTvChannelForm")[0]);
        
        $.ajax({
            type: "POST",
            url: `${domainURL}storeTvChannel`,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {
                    console.log(response.errors);
                } else if (response.status == 200) {

                    $("#addTvChannelModal").modal("hide");
                    swal({
                        title: "TV Channel Added Succesfully!",
                        icon: "success",
                    });
                    $("#tvChannelTable").DataTable().ajax.reload(null, false);
                }
            },
        });
    });

    $("#tvChannelTable").on("click", ".edit", function (e) {
        e.preventDefault();

        var id = $(this).attr("rel");
        var image = $(this).data("image");
        var title = $(this).data("title");
        var accessType = $(this).data("accesstype");
        var sourceType = $(this).data("sourcetype");
        var sourceURL = $(this).data("sourceurl");
        var categoryids = $(this).data("categoryids");
    
        $("#channel_id").val(id);
        $('#editTvChannelImage').attr('src', `upload/${image}`);
        $("#editTvChannelName").val(title);
        $("#editAccessType").val(accessType).selectric('refresh');
        $("#editSourceType").val(sourceType).selectric('refresh');
        $("#editSourceURL").val(sourceURL);
        $("#editCategory_ids").val((categoryids + ",").split(',')).selectric('refresh');

        $("#editTvChannelModal").modal("show");

    });


    $(document).on('submit', '#editTvChannelForm', function (e) {
        e.preventDefault();
        var id = $('#channel_id').val();
        console.log(id);
        let EditformData = new FormData($('#editTvChannelForm')[0]);

        $.ajax({
            type: "POST",
            url: `${domainURL}updateTvChannel/` + id,
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
                        title: "TV Channel Updated Succesfully!",
                        icon: "success",
                    });
                    $("#tvChannelTable").DataTable().ajax.reload(null, false);
                    $('#editTvChannelModal').modal('hide');

                }
            }
        });
    });

    
    $("#tvChannelTable").on('click', '.delete', function (e) {
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
                        url: `${domainURL}deleteTvChannel/` + id,
                        dataType: "json",
                        success: function (response) {
                            if (response.status == 404) {
                                console.log(response.message);
                            } else if (response.status == 200) {
                                swal(
                                    `Tv Channel Delete Successfully`, {
                                    icon: "success",
                                });
                                console.log(response.message);
                                $("#tvChannelTable").DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            }
        });
    });

});