<?php
    $userADM = \App\Models\User::find(1);
    $countNewUsers = $userADM->unreadNotifications->count();
?>
    <span class="dropdown-item dropdown-header">{{ $countNewUsers }} User(s) Created</span>
    <div class="dropdown-divider"></div>
    @foreach ($userADM->unreadNotifications->take(5) as $notification) 
        @if($notification->type == 'App\Notifications\UserNewAdd')
            <a href="{{ route("admin.users.show", [$notification->data['user_id']]) }}" class="dropdown-item">
                <i class="fas fa-user mr-2"></i> {{ $notification->data['user_name'] }}
                <span class="float-right text-muted text-sm">{{  timeago($notification->created_at) }}</span>
            </a>
        @endif
    @endforeach
    {{-- <div class="dropdown-divider"></div>
    <a href="#" class="dropdown-item">
        <i class="fas fa-users mr-2"></i> 8 friend requests
        <span class="float-right text-muted text-sm">12 hours</span>
    </a>
    <div class="dropdown-divider"></div>
    <a href="#" class="dropdown-item">
        <i class="fas fa-file mr-2"></i> 3 new reports
        <span class="float-right text-muted text-sm">2 days</span>
    </a> --}}
    <div class="dropdown-divider"></div>
    <a href="{{ route('admin.notifications.list') }}" class="dropdown-item dropdown-footer">See All Notifications</a>