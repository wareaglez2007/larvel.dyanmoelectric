<div class="tab-pane" id="draft" role="tabpanel" aria-labelledby="draft-tab">
    <!--This is the main pages view which will have a table that will show Dreft pagaes.-->
    <table class="table table-hover" id="drafts">
        <thead>
            <tr>
                <th scope="col">Position</th>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">
                    <!-- Bulk Actions -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-success" >Actions</button>
                        <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" onclick="event.preventDefault();BulkPublish();">Bulk
                                publish</a>
                            <a class="dropdown-item" href="#">Bulk delete</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('admin.pages.create') }}">Create new page</a>
                        </div>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($draftcount != 0)

                @foreach ($draftpages as $k => $page)

                    <tr id="activeid{{ $page->id }}" class="eachdraftrow">
                        <!---Position field-->
                        <th scope="row" id="page_position_clone{{ $page->id }}">
                            <form action="admin/pages/update/updateposition" method="post">
                                @csrf
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <a href="" class="text-muted btn-group btn-group-sm"
                                    id="position_updated{{ $page->id }}"
                                    onclick="event.preventDefault();DoUpdatePosition({{ $page->position }}, {{ $page->id }} )"><i
                                        class="bi bi-arrow-down-up"></i></a>
                                <select class="form-control btn-group btn-group-sm" style="width: auto;" name="position"
                                    id="position{{ $page->id }}"
                                    onchange="event.preventDefault();DoUpdatePosition({{ $page->position }}, {{ $page->id }} , {{ $draftpages->currentPage() }}, '/admin/pages/drafts')">
                                    @for ($i = 1; $i <= $allcount; $i++)
                                        @if ($i == $page->position)

                                            <option value="{{ $page->position }}" {{ $selected = 'selected' }}>
                                                {{ $page->position }}
                                            </option>
                                        @else
                                            <option value="{{ $i }}">{{ $i }}
                                            </option>

                                        @endif
                                    @endfor
                                </select>

                            </form>
                        </th>
                        <th scope="row"><a href="{{ route('admin.pages.edit', $page->id) }}"
                                class="text-muted">{{ $page->id }}</a></th>
                        <td><a href="{{ route('admin.pages.edit', $page->id) }}"
                                class="text-muted">{{ $page->title }}</a>
                        </td>
                        <td style="text-align: center">
                            <div class="dropdown show">
                                <a class="btn btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-toggle-off"></i>
                                </a>
                                <!--Edit action-->
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="{{ route('admin.pages.edit', $page->id) }}">Edit</a>
                                    <!--Publish action -->
                                    <a href=""
                                        onclick="event.preventDefault();PublishPage({{ $page->id }}, {{ $draftpages->currentPage() }},{{ $draftpages->firstItem() }},{{ $draftpages->lastItem() }} )"
                                        class="dropdown-item" id="publish_function{{ $page->id }}">Publish</a>
                                    <!--Delete action--->
                                    <a href=""
                                        onclick="event.preventDefault();DeleteAnyPage({{ $page->id }},{{ $page->parent_id != null ? $page->parent_id : 0 }},{{ $draftpages->currentPage() }},{{ $draftpages->firstItem() }},{{ $draftpages->lastItem() }} ,'/drafts' )"
                                        class="dropdown-item">Delete</a>
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
    <hr />
    <div id="draft_pagination">
        {{ $draftpages->withpath('/admin/pages/drafts') }}
    </div>
</div>
<script>
    $(function() {
        $('#draft_pagination .pagination a').on('click', function(e) {
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

            });
        }
    });

</script>
