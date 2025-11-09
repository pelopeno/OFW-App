


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Pundar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="ofw-body">
    <x-navbar-ofw/>

    <div class="goals-ofw-main">
        <div class="goals-ofw-content-cont">
            <h2>Saving Goals</h2>
            <x-saving-goals-card 
                goal_name="House Renovation" 
                current_savings_amt="50000" 
                goal_savings_amt="100000"/>
            <x-saving-goals-card 
                goal_name="Boracay Trip" 
                current_savings_amt="0" 
                goal_savings_amt="100000"/>
            <x-saving-goals-card 
                goal_name="New Phone" 
                current_savings_amt="0" 
                goal_savings_amt="15000"/>
            <x-saving-goals-card 
                goal_name="Tuition" 
                current_savings_amt="30000" 
                goal_savings_amt="60000"/>
        </div>

        <div class="goals-ofw-img-cont">
            <img src="/assets/sg-ofw-img.png"/>
        </div>
    </div>

</body>

</html>