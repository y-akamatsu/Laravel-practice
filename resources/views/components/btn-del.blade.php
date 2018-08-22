<form style="display:inline" action="{{ url($table.'/'.$id) }}" method="post">
   {{ csrf_field() }}
   {{ method_field('DELETE') }}
    <button type="submit" class="btn btn-danger">
        {{ __('Delete') }}
    </button>
</form>