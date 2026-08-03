@if(session('success'))

<div class="toast-container position-fixed top-0 end-0 p-4">

<div
class="toast show rounded-4 shadow border-0">

<div class="toast-body">

<i class="bi bi-check-circle-fill text-success me-2"></i>

{{ session('success') }}

</div>

</div>

</div>

@endif