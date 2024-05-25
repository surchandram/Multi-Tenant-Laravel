<form id="impersonate-stop-form" action="{{ route('admin.users.impersonate.destroy') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
