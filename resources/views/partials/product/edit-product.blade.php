<!-- Modal Edit untuk tiap produk -->
@foreach ($products as $product)
    <div class="modal fade" id="modalEdit{{ $product->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $product->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel{{ $product->id }}">Ubah Produk atau Jasa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update.product', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Gambar (biarkan kosong jika tidak ingin mengganti)</label>
                    <input type="file" class="form-control" name="picture" accept="image/*">
                    @if ($product->picture)
                    <img src="{{ asset('storage/' . $product->picture) }}" width="100" class="mt-2" alt="{{ $product->product_name }}">
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" name="product_name" value="{{ $product->product_name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select class="form-select" name="category_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" class="form-control" name="stock" min="0" value="{{ $product->stock }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" class="form-control" name="price" min="0" value="{{ $product->price }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="description" rows="3" maxlength="500" required>{{ $product->description }}</textarea>
                </div>
                
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </form>
            </div>
            </div>
        </div>
    </div>

@endforeach