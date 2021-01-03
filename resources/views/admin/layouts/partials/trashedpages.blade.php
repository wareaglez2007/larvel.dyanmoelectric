<div class="tab-pane" id="trashed" role="tabpanel" aria-labelledby="trashed-tab">
    <!--This is the main pages view which will have a table that will show Trashed pages.-->
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Create At</th>
                <th scope="col">Deleted At</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if ($trashed != 0)


                @foreach ($deleted_pages as $k => $page)
                    <tr id="activeid{{ $page->id }}">
                        <th>{{ $page->id }}</th>
                        <td>{{ $page->title }}</td>
                        <td>{{ date_format($page->created_at, 'n/j/Y') }}</td>
                        <td>{{ date_format($page->deleted_at, 'n/j/Y') }}</td>
                        <td style="text-align: center">

                            <div class="dropdown show">
                                <a class="btn btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-toggle-off"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <!--Restore action-->
                                    <a href="javascript:void(0)"
                                        onclick="RestorePage({{ $page->id }}, {{ $deleted_pages->currentPage() }},{{ $deleted_pages->firstItem() }},{{ $deleted_pages->lastItem() }})"
                                        class="dropdown-item" id="in_trash_restore{{ $page->id }}">Restore</a>
                                    <!--Perm DELETE action-->
                                    <a href="javascript:void(0)" onclick="PermDeletePage(
                                            {{ $page->id }},
                                        {{ $page->parent_id != null ? $page->parent_id : 0 }},
                                        {{ $deleted_pages->currentPage() }},
                                        {{ $deleted_pages->firstItem() }},
                                        {{ $deleted_pages->lastItem() }},
                                        {{ $page->position }}
                                        )" class="dropdown-item" id="in_trash_permdel{{ $page->id }}">Permanent
                                        Delete</a>
                                </div>

                            </div>

                        </td>
                    </tr>

                @endforeach
            @else
                <tr id="notrashpages">
                    <th class="text-muted">There is no item here yer.</th>
                </tr>
            @endif
        </tbody>

    </table>
    <div id="trashed_pagination">
        {{ $deleted_pages->withPath('/admin/pages/trashed') }}
    </div>

</div>


<script>
    $(function() {
        $('#trashed_pagination .pagination a').on('click', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            getPublished(url);
            // window.history.pushState("", "", url);
        });
        function getPublished(url) {
            $.ajax({
                url: url
            }).done(function(data) {
                $('#some_ajax').html(data);
            }).fail(function() {
                //Do some error
            });
        }
    });

</script>
