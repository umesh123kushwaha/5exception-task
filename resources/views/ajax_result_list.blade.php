<table class="table">
    <tr>
        <th>Image</th>
        <th>Title</th>
        <th>Description</th>
        <th>Price</th>
        <th>QTy</th>
        <th>Date</th>

    </tr>
    @foreach ($items as $item)
        <tr>
            <td>
                @if ($item->file != '' && file_exists('storage/media/items/' . $item->file))
                    <img src="{{ asset('storage/media/items/' . $item->file) }}"
                        class="mt-1" width="200px" height="100px" alt="brand Image">
                @endif

            </td>
            <td>
                <b>{{ $item->title }}</b>
            </td>
            <td>
                <p>{{ $item->description }}</p>
            </td>
            <td>
                {{ $item->price }}
            </td>
            <td>
                {{ $item->qty }}
            </td>
            <td>
                {{ $item->date }}
            </td>
        </tr>
    @endforeach
</table>
<div class="row mt-2 justify-content-end">
    <div class="col-md-12 result-pagination d-flex justify-content-end text-lg-end">
        {{ $items->links('pagination::bootstrap-4') }}
    </div>
</div>
