<x-app-layout>
    @if (auth()->user()->user_type === 'ofw')
        <x-navbar-ofw />
    @elseif (auth()->user()->user_type === 'business_owner')
        <x-navbar-business />
    @endif

    <style>
        .profile-container {
            max-width: 900px;
            padding: 20px;
            background-color: white;
            border: 3.5px solid black;
            border-radius: 25px;
            box-sizing: border-box;
            margin: 25px auto;
        }

        /* Each Livewire section */
        .profile-section {
            margin-bottom: 25px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 20px;
            border: 2px solid #ccc;
        }

        /* Section headings */
        .profile-section h2,
        .profile-section h3 {
            line-height: 40px;
            letter-spacing: -3px;
            font-size: 48px;
            font-family: "Tilt Warp", sans-serif;
            color: #282828;
            margin-bottom: 15px;
        }

        /* Buttons inside profile forms */
        .profile-section button {
            font-family: "Varela Round", sans-serif;
            border-radius: 10px;
            border: 2px solid transparent;
            padding: 5px 12px;
            cursor: pointer;
            transition: 0.15s ease-in-out;
        }

        .profile-section button.save-btn {
            background-color: #edbe52;
            color: black;
        }

        .profile-section button.cancel-btn {
            background-color: #AB3F4C;
            color: white;
        }

        /* Section border (x-section-border) */
        x-section-border {
            display: block;
            border-top: 2px solid #cfcfcf;
            margin: 30px 0;
        }
    </style>

    <div class="profile-container">
        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
        <div class="profile-section">
            @livewire('profile.update-profile-information-form')
        </div>

        <x-section-border />
        @endif

        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
        <div class="profile-section">
            @livewire('profile.update-password-form')
        </div>

        <x-section-border />
        @endif

        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
        <div class="profile-section">
            @livewire('profile.two-factor-authentication-form')
        </div>

        <x-section-border />
        @endif

        <div class="profile-section">
            @livewire('profile.logout-other-browser-sessions-form')
        </div>

        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
        <x-section-border />

        <div class="profile-section">
            @livewire('profile.delete-user-form')
        </div>
        @endif
    </div>
</x-app-layout>