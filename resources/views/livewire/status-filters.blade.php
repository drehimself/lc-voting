<nav class="hidden md:flex items-center justify-between text-gray-400 text-xs">
    <ul class="flex uppercase font-semibold border-b-4 pb-3 space-x-10">
        <li><a wire:click.prevent="setStatus('All')" href="{{ route('idea.index', ['status' => 'All']) }}" class="border-b-4 pb-3 hover:border-blue @if ($status === 'All') border-blue text-gray-900 @endif">All Ideas ({{ $statusCount['all_statuses'] }})</a></li>
        <li><a wire:click.prevent="setStatus('Considering')" href="{{ route('idea.index', ['status' => 'Considering']) }}" class=" transition duration-150 ease-in border-b-4 pb-3 hover:border-blue @if ($status === 'Considering') border-blue text-gray-900 @endif">Considering ({{ $statusCount['considering'] }})</a></li>
        <li><a wire:click.prevent="setStatus('In Progress')" href="{{ route('idea.index', ['status' => 'In Progress']) }}" class=" transition duration-150 ease-in border-b-4 pb-3 hover:border-blue @if ($status === 'In Progress') border-blue text-gray-900 @endif">In Progress ({{ $statusCount['in_progress'] }})</a></li>
    </ul>

    <ul class="flex uppercase font-semibold border-b-4 pb-3 space-x-10">
        <li><a wire:click.prevent="setStatus('Implemented')" href="{{ route('idea.index', ['status' => 'Implemented']) }}" class=" transition duration-150 ease-in border-b-4 pb-3 hover:border-blue @if ($status === 'Implemented') border-blue text-gray-900 @endif">Implemented ({{ $statusCount['implemented'] }})</a></li>
        <li><a wire:click.prevent="setStatus('Closed')" href="{{ route('idea.index', ['status' => 'Closed']) }}" class=" transition duration-150 ease-in border-b-4 pb-3 hover:border-blue @if ($status === 'Closed') border-blue text-gray-900 @endif">Closed ({{ $statusCount['closed'] }})</a></li>
    </ul>
</nav>
