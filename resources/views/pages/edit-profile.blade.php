<x-filament-panels::page>
    <x-filament-panels::form wire:submit="updateProfile">
        {{ $this->editProfileForm }}

        <x-filament-panels::form.actions
            alignment="right"
            :actions="$this->getUpdateProfileFormActions()"
        />
    </x-filament-panels::form>


    <x-filament-panels::form wire:submit="updatePublicProfile">
        {{ $this->editPublicProfile }}

        <x-filament-panels::form.actions
            alignment="right"
            :actions="$this->getUpdatePublicProfileAction()"
        />
    </x-filament-panels::form>



    <x-filament-panels::form wire:submit="updatePassword">
        {{ $this->editPasswordForm }}

        <x-filament-panels::form.actions
            alignment="right"
            :actions="$this->getUpdatePasswordFormActions()"
        />
    </x-filament-panels::form>

    <x-filament-panels::form>
        {{ $this->browserSessionsForm }}
    </x-filament-panels::form>

    <x-filament-panels::form>
        {{ $this->deleteAccountForm }}
    </x-filament-panels::form>
</x-filament-panels::page>
