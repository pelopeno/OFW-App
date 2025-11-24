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
            <a href="{{ route('add-goal') }}">
                <div class="ofw-add-goal-btn">
                    <img src="/assets/plus.png">
                </div>
            </a>
            
            @forelse($goals as $goal)
                <x-saving-goals-card :goal="$goal"/>
            @empty
                <p>No saving goals yet. Create your first goal!</p>
            @endforelse
        </div>

        <div class="goals-ofw-img-cont">
            <img src="/assets/sg-ofw-img.png"/>
        </div>
    </div>

</body>

</html>