<div class="modal fade"
id="deleteModal"
tabindex="-1">

<div class="modal-dialog modal-dialog-centered">

<div class="modal-content rounded-4 border-0">

<form action="{{ route('profile.destroy') }}" method="POST">
@csrf
@method('DELETE')
<div class="modal-body p-5 text-center">

<i class="bi bi-trash display-3 text-danger"></i>

<h3 class="mt-3 fw-bold">

Hapus Data?

</h3>

<p class="text-muted">

Data akun dan portfolio akan dihapus permanen. Masukkan password untuk mengonfirmasi.

</p>

<input type="password" name="current_password" class="form-control" autocomplete="current-password" placeholder="Password saat ini" required>
@error('current_password')<small class="text-danger d-block text-start mt-2">{{ $message }}</small>@enderror

<div class="mt-4">

<button
class="btn btn-light rounded-4 px-4"
data-bs-dismiss="modal">

Batal

</button>

<button
type="submit"
class="btn btn-danger rounded-4 px-4">

Ya, Hapus

</button>

</div>

</div>

</form>

</div>

</div>

</div>
