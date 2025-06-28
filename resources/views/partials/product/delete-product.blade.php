    <!-- Modal Konfirmasi Hapus -->
    @foreach ($products as $product)
    <div class="modal fade" id="confirmDeleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="confirmDeleteLabel{{ $product->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3">
            
            <div class="modal-header">
            <h5 class="modal-title" id="confirmDeleteLabel{{ $product->id }}">Konfirmasi Hapus</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            
            <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus produk <strong>{{ $product->product_name }}</strong>? Data yang dihapus tidak dapat dikembalikan.</p>
            </div>
            
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            
            <form action="{{ route('destroy.product', $product->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </form>
            </div>
    
        </div>
        </div>
    </div>
    @endforeach