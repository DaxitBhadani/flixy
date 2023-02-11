$(document).ready(function () {
   
    $("#tvCategoryTable").dataTable({
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
            url: `fetchTvCategoryList`,
            data: function (data) { },
            error: (error) => {
                console.log(error);
            },
        },
    });

    $(document).on("submit", "#addTvCategoryForm", function (e) {
        e.preventDefault();
        let formData = new FormData($("#addTvCategoryForm")[0]);

        $.ajax({
            type: "POST",
            url: `${domainURL}storeTvCategory`,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {
                    console.log(response.errors);
                } else if (response.status == 200) {
                    $("#addTvCategoryModal").modal("hide");
                    // $("#addTvCategoryModal").find('form').trigger('reset');
                    $('#addTvCategoryModal').on('hidden.bs.modal', function () {
                        $('#addTvCategoryForm')[0].reset();
                    });
                    swal({
                        title: "TV Category Added Succesfully!",
                        icon: "success",
                    });
                    $("#tvCategoryTable").DataTable().ajax.reload(null, false);
                }
            },
        });
    });

    $("#tvCategoryTable").on("click", ".edit", function (e) {
        e.preventDefault();

        var id = $(this).attr("rel");
        var image = $(this).data("image");
        var title = $(this).data("title");

        $("#category_id").val(id);
        $('#editTvCategoryImage').attr('src', `upload/${image}`);
        $("#editTvCategoryName").val(title);

        $("#editTvCategoryModal").modal("show");

    });

    $(document).on('submit', '#editTvCategoryForm', function (e) {
        e.preventDefault();
        var id = $('#category_id').val();
        console.log(id);
        let EditformData = new FormData($('#editTvCategoryForm')[0]);

        $.ajax({
            type: "POST",
            url: `${domainURL}updateTvCategory/` + id,
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
                        title: "TV Category Updated Succesfully!",
                        icon: "success",
                    });
                    $("#tvCategoryTable").DataTable().ajax.reload(null, false);
                    $('#editTvCategoryModal').modal('hide');

                }
            }
        });
    });

    $("#tvCategoryTable").on('click', '.delete', function (e) {
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
                        url: `${domainURL}deleteTvCategory/` + id,
                        dataType: "json",
                        success: function (response) {
                            if (response.status == 404) {
                                console.log(response.message);
                            } else if (response.status == 200) {
                                swal(
                                    `Tv Category Delete Successfully`, {
                                    icon: "success",
                                });
                                console.log(response.message);
                                $("#tvCategoryTable").DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            }
        });
    });


});