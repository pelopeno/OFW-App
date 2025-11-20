<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    {{-- Inline CSS for Profile Page --}}
    <style>
        /* Container for all profile forms */
        .profile-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border: 3.5px solid black;
            border-radius: 25px;
            box-sizing: border-box;
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
            font-family: "Varela Round", sans-serif;
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
