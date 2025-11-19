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
        <h2>Monitoring</h2>
        <div class="admin-table-cont">
            <p>Pending Actions: Projects to be Approved</p>

            <table>
                <tr class="admin-th-row">
                    <th>LOG ID</th>
                    <th>USER ID</th>
                    <th>ACTION TYPE</th>
                    <th>REMARKS</th>
                    <th>TIMESTAMP</th>
                </tr>

                <tr>
                    <td>21</td>
                    <td>21</td>
                    <td>Investment Made</td>
                    <td>(UserID: 21) invested P5,000 in blah blah blah blah blah blah</td>
                    <td>2025-08-12 12:45:20</td>
                </tr>

                <tr>
                    <td>20</td>
                    <td>22</td>
                    <td>Password Reset</td>
                    <td>(UserID: 22) changed their password</td>
                    <td>2025-08-12 11:27:09</td>
                </tr>
                    
                <tr>
                    <td>19</td>
                    <td>23</td>
                    <td>Investment Made</td>
                    <td>(UserID: 23) created a project blah blah blah blah</td>
                    <td>2025-08-12 08:30:40</td>
                </tr>

                <tr>
                    <td>18</td>
                    <td>24</td>
                    <td>Project Approve/Rejected</td>
                    <td>(UserID: 24) approved ProjectID: 7</td>
                    <td>2025-08-12 06:43:17</td>
                </tr>

                <tr>
                    <td>17</td>
                    <td>28</td>
                    <td>Password Reset</td>
                    <td>(UserID: 28) changed their password</td>
                    <td>2025-08-12 03:56:18</td>
                </tr>
            </table>
        </div>
</body>

</html>
    