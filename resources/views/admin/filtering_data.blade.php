<div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Purpose</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($salesData as $key => $data)
                <tr>
                    <td>{{ ($salesData->currentPage() - 1) * $salesData->perPage() + $key + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d F Y h:i A') }}</td>
                    <td>{{ $data->purpose }}</td>
                    <td>৳ {{ $data->amount }}</td>
                    <td>
                        <a href="#" data-toggle="modal" data-target="#{{ $data->id }}"
                            class="btn btn-success">Update</a>
                    </td>
                </tr>

                <!-- Modal for updating -->
                <div class="modal fade" id="{{ $data->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="display: flex; justify-content:space-between">
                                <h5 style="font-size: 20px">Update Sale</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.sale.update', $data->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="amount"><b>Amount</b></label>
                                        <input type="number" name="amount" id="amount" class="form-control"
                                            min="1" value="{{ $data->amount }}" step="0.1">
                                    </div>
                                    <div class="form-group my-3">
                                        <label for="purpose"><b>Purpose</b></label>
                                        <textarea name="purpose" id="purpose" class="form-control" cols="30" rows="5">{{ $data->purpose }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success"><b>Update</b></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">
        {{ $salesData->links() }}
    </div>
</div>