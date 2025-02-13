<div class="user">
    <a href="/"><i class="fas fa-home"></i> Home</a>
    <a href="/admin/media"><i class="fas fa-image"></i> Media</a>
    <a href="/admin/settings"><i class="fas fa-cog"></i> Settings</a>
    <a href="/admin/user"><i class="fas fa-user"></i> User</a>

    <form method="POST" action="/admin/page">
        @csrf
        <button type="submit"><i class="far fa-file"></i> New Page</button>
    </form>

    @if (isset($settings->projects) && $settings->projects === 1)
    <form method="POST" action="/admin/project">
        @csrf
        <button type="submit"><i class="fas fa-hammer"></i> New Project</button>
    </form>
    @endif

    <form action="/logout" method="POST" class="logout">
        @csrf
        <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </form>
</div>
