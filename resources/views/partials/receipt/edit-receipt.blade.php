<!-- Modal Edit -->

<div class="modal fade" id="editModal{{ $receipt->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('receipt.update', $receipt->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Resi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Customer</label>
                        <input type="text" name="customer_name" class="form-control" value="{{ $receipt->customer_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Kode</label>
                        <input type="text" name="code" class="form-control" value="{{ $receipt->code }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Produk</label>
                        <select name="product_id" class="form-select" required>
                            <option value="">Pilih Produk</option>
                            @foreach($products as $product)
                                @if (str_contains($product->product_name, 'Jasa'))
                                    <option value="{{ $product->id }}" {{ $product->id == $receipt->product_id ? 'selected' : '' }}>
                                        {{ $product->product_name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select" required>
                            <option value="Terima Hp" {{ $receipt->status == 'Terima Hp' ? 'selected' : '' }}>Terima Hp</option>
                            <option value="Proses" {{ $receipt->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                            <option value="Selesai" {{ $receipt->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Estimasi</label>
                        <input type="date" name="estimate" class="form-control" value="{{ $receipt->estimate }}" required>
                    </div>
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
