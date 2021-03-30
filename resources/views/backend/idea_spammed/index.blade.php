@extends('backend.layouts.app',[
    'page' => 'Spams'
])

@section('content')
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <form action="{{ request()->url() }}" method="GET" id="filter_form">
                <label for="">Filter</label>
                <select name="filter" id="" class="form-control" onchange="document.getElementById('filter_form').submit()">
                    <option value="idea" {{ isSelected('filter','idea') }}>Idea</option>
                    <option value="challenge" {{ isSelected('filter','challenge') }}>challenge</option>
                </select>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ ucfirst(request()->filter) }} Spams | List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Spam Count</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ideas as $idea)
                            <tr>
                                <td>
                                    <a href="{{ route('idea.show',['idea' => $idea->slug]) }}">
                                        {{ $idea->title }}
                                    </a>
                                </td>
                                <td>
                                    <span class="btn btn-danger">
                                        {{ $idea->spams_count }}
                                    </span>
                                </td>
                                <td>{{ $idea->created_at->format('m/d/Y') }}</td>
                                <td>
                                    <a href="javascript:;" class="btn btn-danger btn-icon-split delete-row"
                                    data-id="{{ $idea->id }}"
                                    @if (request()->filter == 'idea')    
                                        data-url="{{ route('spam.ideas.destroy',['idea' => $idea->id]) }}" 
                                    @else
                                        data-url="{{ route('spam.challengs.destroy',['challenge' => $idea->id]) }}"
                                    @endif 
                                    data-method="DELETE">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text">Delete</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $ideas->links() }}
        </div>
    </div>
@endsection