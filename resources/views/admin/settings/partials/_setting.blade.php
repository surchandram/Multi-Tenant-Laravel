<tr>
    <td>{{ $key }}</td>
    <td>{{ $value }}</td>
    <td>
        <div class="btn-group btn-group-sm">
            <a href="#"
               class="btn btn-primary"
               onclick="event.preventDefault(); editSetting('{{ $id }}', '{{ $value }}');"
            >
                Edit
            </a>
            <a href="{{ route('admin.settings.destroy', $id) }}"
               class="btn btn-danger"
               onclick="event.preventDefault(); confirmDelete('{{ str_replace('.', '_', $id) }}_del_form', '{{ $id }}');"
            >
                Delete
            </a>
        </div>

        <!-- Setting Delete Form -->
        <form id="{{ str_replace('.', '_', $id) }}_del_form"
              action="{{ route('admin.settings.destroy', $id) }}"
              method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </td>
</tr><!-- /tr -->
