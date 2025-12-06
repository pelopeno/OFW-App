<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="admin-body">
    <x-navbar-admin />

    <div class="admin-main">
        <h2>User Management</h2>

        <div class="admin-table-cont">

            <!-- FILTER + TITLE -->
            <div class="admin-users-header">
                <p>Users</p>

                <div class="admin-filter">
                    <button class="admin-filter-btn">Filter ▾</button>

                    <div class="admin-filter-dropdown">
                        <a href="#">All</a>
                        <a href="#">Active</a>
                        <a href="#">Disabled</a>
                        <a href="#">OFW</a>
                        <a href="#">Business Owner</a>
                        <a href="#">Admin</a>
                    </div>
                </div>
            </div>

          <table>
    <tr class="admin-th-row">
        <th>USER ID</th>
        <th>NAME</th>
        <th>EMAIL</th>
        <th>STATUS</th>
        <th>ROLE</th>
        <th>ACTIONS</th>
    </tr>

    @foreach ($users as $user)
        <tr data-status="{{ $user->status }}" data-role="{{ $user->role }}">
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->status }}</td>
            <td>{{ $user->user_type }}</td>
            <td>
                <form action="{{ route('admin.archive', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="um-admin-archive-btn">Archive</button>
                </form>

                @if ($user->status === 'Active')
                    <form action="{{ route('admin.disable', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="um-admin-disable-btn">Disable</button>
                    </form>
                @else
                    <form action="{{ route('admin.activate', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="um-admin-activate-btn">Activate</button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
</table>
        </div>
</body>

</html>

<script>
    // ===============================
    // FILTER DROPDOWN FUNCTIONALITY
    // ===============================

    const filterBtn = document.querySelector(".admin-filter-btn");
    const dropdown = document.querySelector(".admin-filter-dropdown");
    const rows = document.querySelectorAll(".admin-table-cont table tr:not(.admin-th-row)"); 

    // Show / hide dropdown
    filterBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        dropdown.classList.toggle("show");
    });

    // Click a filter option
    dropdown.querySelectorAll("a").forEach(option => {
        option.addEventListener("click", (e) => {
            e.preventDefault();
            dropdown.classList.remove("show");

            const filter = option.textContent.trim();

            rows.forEach(row => {
                const status = row.dataset.status;
                const role = row.dataset.role;

                if (filter === "All") {
                    row.style.display = "";
                } 
                else if (filter === "Active" || filter === "Disabled") {
                    row.style.display = (status === filter) ? "" : "none";
                }
                else if (["OFW", "Business Owner", "Admin"].includes(filter)) {
                    row.style.display = (role === filter) ? "" : "none";
                }
            });
        });
    });

    // Click outside to close dropdown
    document.addEventListener("click", () => {
        dropdown.classList.remove("show");
    });
</script>
