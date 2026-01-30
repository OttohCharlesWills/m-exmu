@extends('layouts.admin')

@section('admincontent')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">All Users</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($users->count() === 0)
        <div class="alert alert-info">No users found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $i => $user)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $user->is_active ? 'Active' : 'Suspended' }}
                            </span>
                        </td>
                        <td class="d-flex gap-1 flex-wrap">
                            {{-- VIEW --}}
                            <button class="btn btn-info btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#userModal"
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"
                                    data-role="{{ ucfirst($user->role) }}"
                                    data-phone="{{ $user->phone ?? 'N/A' }}"
                                    data-state="{{ $user->state ?? 'N/A' }}"
                                    data-about="{{ $user->about ?? 'N/A' }}"
                                    data-status="{{ $user->is_active ? 'Active' : 'Suspended' }}">
                                👁 View
                            </button>

                            {{-- SUSPEND / ACTIVATE --}}
                            <form method="POST" action="{{ route('admin.users.toggle', $user->id) }}">
                                @csrf
                                <button type="submit" class="btn {{ $user->is_active ? 'btn-danger' : 'btn-success' }} btn-sm">
                                    {{ $user->is_active ? 'Suspend' : 'Activate' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

{{-- USER DETAILS MODAL --}}
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="userModalLabel">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body">
                {{-- Avatar --}}
                <div class="text-center mb-4">
                    <img id="modalAvatar" 
                         src="https://via.placeholder.com/120" 
                         class="rounded-circle border" 
                         width="120" 
                         height="120" 
                         style="object-fit: cover;" 
                         alt="Avatar">
                </div>

                {{-- User Info --}}
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> <span id="modalName"></span></p>
                        <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                        <p><strong>Phone:</strong> <span id="modalPhone"></span></p>
                        <p><strong>State:</strong> <span id="modalState"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Role:</strong> <span id="modalRole"></span></p>
                        <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                        <p><strong>About:</strong></p>
                        <p id="modalAbout" class="text-muted small"></p>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- JS to populate modal --}}
<script>
    var userModal = document.getElementById('userModal')
    userModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget

        document.getElementById('modalAvatar').src = button.getAttribute('data-avatar')
        document.getElementById('modalName').textContent = button.getAttribute('data-name')
        document.getElementById('modalEmail').textContent = button.getAttribute('data-email')
        document.getElementById('modalRole').textContent = button.getAttribute('data-role')
        document.getElementById('modalPhone').textContent = button.getAttribute('data-phone')
        document.getElementById('modalState').textContent = button.getAttribute('data-state')
        document.getElementById('modalAbout').textContent = button.getAttribute('data-about')
        document.getElementById('modalStatus').textContent = button.getAttribute('data-status')
    })
</script>

@endsection

