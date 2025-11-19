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

                <tr>
                    <td>24</td>
                    <td>Ram Jiro Aba</td>
                    <td>ramjiro.aba@gmail.com</td>
                    <td>Disabled</td>
                    <td>OFW</td>
                    <td>
                        <button class="um-admin-archive-btn">Archive</button>
                        <button class="um-admin-activate-btn">Activate</button>
                    </td>
                </tr>

                <tr>
                    <td>23</td>
                    <td>Daryl Doctora</td>
                    <td>darylchristien.doctora@gmail.com</td>
                    <td>Active</td>
                    <td>OFW</td>
                    <td>
                        <button class="um-admin-archive-btn">Archive</button>
                        <button class="um-admin-disable-btn">Disable</button>
                    </td>
                </tr>

                <tr>
                    <td>22</td>
                    <td>Luis Erpelo</td>
                    <td>luischristian.erpelo@gmail.com</td>
                    <td>Active</td>
                    <td>Business Owner</td>
                    <td>
                        <button class="um-admin-archive-btn">Archive</button>
                        <button class="um-admin-disable-btn">Disable</button>
                    </td>
                </tr>

                <tr>
                    <td>21</td>
                    <td>Jerome Manalo</td>
                    <td>jerome.manalo@gmail.com</td>
                    <td>Active</td>
                    <td>Admin</td>
                    <td>
                        <button class="um-admin-archive-btn">Archive</button>
                        <button class="um-admin-disable-btn">Disable</button>
                    </td>
                </tr>

            </table>
        </div>
</body>

</html>

<script>
    // if Status=Disabled, show Activate button, else Disable button
    document.querySelectorAll(".admin-table-cont tr").forEach(row => {
        const status = row.querySelector(".status");
        const actionBtn = row.querySelector(".um-admin-action-btn");

        if (status && actionBtn) {
            if (status.textContent.trim() === "Disabled") {
                actionBtn.textContent = "Activate";
                actionBtn.className = "um-admin-activate-btn";
            } else {
                actionBtn.textContent = "Disable";
                actionBtn.className = "um-admin-disable-btn";
            }
        }
    });

    // Dropdown Stuff
    const filterBtn = document.querySelector(".admin-filter-btn");
    const dropdown = document.querySelector(".admin-filter-dropdown");


    filterBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        dropdown.classList.toggle("show");
    });


    dropdown.addEventListener("click", (e) => {
        if (e.target.tagName === 'A') {
            e.preventDefault();
            dropdown.classList.remove("show");
            console.log("Filter selected:", e.target.dataset.filter);
        }
    });


    document.addEventListener("click", () => {
        dropdown.classList.remove("show");
    });


    dropdown.addEventListener("click", (e) => {
        if (e.target !== dropdown.querySelector('a')) {
            e.stopPropagation();
        }
    });
</script>