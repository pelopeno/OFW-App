<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="admin-body">
    <x-navbar-admin/>

    <div class="admin-main">
        <h2>Dashboard</h2>
        <div class="admin-overview">
            <div class="admin-active-projects" style="width: 50%">
                <img src="/assets/admin-active-card.png"/>
                <h3>Active Projects</h3>
                <h4>45</h4>
            </div>

            <div class="admin-pending-projects" style="width: 50%">
                <img src="/assets/admin-pending2-card.png"/>
                <h3>Pending Projects</h3>
                <h4>67</h4>
            </div>
        </div>

        <div class="admin-table-cont">
            <p>Active Projects</p>

            <table>
                <tr class="admin-th-row">
                    <th>PROJECT NAME</th>
                    <th>TITLE</th>
                    <th>DESCRIPTION</th>
                    <th>ACTIONS</th>
                </tr>

                <tr>
                    <td>Expansion for a Small Business</td>
                    <td>Ed Jerome Manalo Corp.</td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</td>
                    <td> <button class="pa-admin-approve-btn">Approve</button> <button class="pa-admin-decline-btn">Decline</button> </td>
                </tr>

                <tr>
                    <td>Small Cafe Startup</td>
                    <td>Ram Jiro Aba Foundation</td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</td>
                    <td> <button class="pa-admin-approve-btn">Approve</button> <button class="pa-admin-decline-btn">Decline</button> </td>
                </tr>
                    
                <tr>
                    <td>Cafe Kabayan Expansion</td>
                    <td>Ram Jiro Aba Foundation</td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</td>
                    <td> <button class="pa-admin-approve-btn">Approve</button> <button class="pa-admin-decline-btn">Decline</button> </td>
                </tr>

                <tr>
                    <td>Pambili Kape</td>
                    <td>Ram Jiro Aba Foundation</td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</td>
                    <td> <button class="pa-admin-approve-btn">Approve</button> <button class="pa-admin-decline-btn">Decline</button> </td>
                </tr>

                <tr>
                    <td>Starbucks New Branch</td>
                    <td>Ram Jiro Aba Foundation</td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</td>
                    <td> <button class="pa-admin-approve-btn">Approve</button> <button class="pa-admin-decline-btn">Decline</button> </td>
                </tr>
            </table>
        </div>
</body>

</html>
    