<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Chat') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">
        {{ __('Manage your profile and account settings') }}
    </flux:subheading>
    <flux:separator variant="subtle" />

    {{-- User Count --}}
    <div class="mb-4 text-gray-700 font-medium">
        Total Users: {{ $users->count() }}
    </div>

    {{-- User List --}}
    <h2 class="text-lg font-semibold mb-2">All Users</h2>
    <ul class="list-disc pl-5">
        @forelse($users as $user)
            <li>{{ $user->name }} - {{ $user->email }}</li>
        @empty
            <li>No users found.</li>
        @endforelse
    </ul>
</div>
