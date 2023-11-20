
            </div>
        </section>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                $('[data-sorting="true"]').on('click', function (){
                    $('#user-table th').removeClass('sort_desc');
                    $('#user-table th').removeClass('sort_asc');
                    var sort_type = $(this).data('sort');
                    var sort_column = $(this).data('column');
                    if(sort_type == 'asc') {
                        $(this).data('sort','desc');
                        $(this).addClass('sort_asc');
                        $(this).removeClass('sort_desc');
                    } else if(sort_type == 'desc') {
                        $(this).data('sort','asc');
                        $(this).addClass('sort_desc');
                        $(this).removeClass('sort_asc');
                    }
                    var url = "sorting.php";
                    var data1 = {sort_column: sort_column, sort_type: sort_type};
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: data1,
                    }).done(function(response) {
                        $('#user-tbody').html(response);
                    }).fail(function (jqXHR, status, err) {
                    }).always(function () {
                    });
                })
            });

            function downloadUserImage(user_id, url) {
                var result = confirm("Want to Download Image?");
                if(result) {
                    var data1 = {id: user_id};
                    $.ajax({
                        xhrFields: {
                            responseType: 'blob',
                        },
                        url: url,
                        type: 'post',
                        data: data1,
                    }).done(function(response) {
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(response);
                        link.download = 'user_img_'+user_id+'.jpg';
                        link.click();
                        link.remove();
                    }).fail(function (jqXHR, status, err) {
                    }).always(function () {
                    });
                }
            }
        </script>
    </body>
</html>