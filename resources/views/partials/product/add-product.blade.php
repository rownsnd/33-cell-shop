<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="productModalLabel">Tambah Produk atau Jasa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('store.product') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- Picture --}}
            <div class="mb-3">
              <label for="picture" class="form-label">Gambar</label>
              <input type="file" class="form-control" id="picture" name="picture" accept="image/*" required>
            </div>
  
            {{-- Product Name --}}
            <div class="mb-3">
              <label for="product_name" class="form-label">Nama Produk</label>
              <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select class="form-select" name="category_id" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            {{-- Stock --}}
            <div class="mb-3">
              <label for="stock" class="form-label">Stok</label>
              <input type="number" class="form-control" id="stock" name="stock" min="0" required>
            </div>
  
            {{-- Price --}}
            <div class="mb-3">
              <label for="price" class="form-label">Harga</label>
              <input type="number" class="form-control" id="price" name="price" min="0" required>
            </div>
            {{-- Description --}}
            <div class="mb-3">
              <label for="description" class="form-label">Deskripsi</label>
              <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            {{-- User ID (hidden, misal user login) --}}
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
  
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>