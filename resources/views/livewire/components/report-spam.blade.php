<div class="flex flex-1 items-end justify-end">
    <div class="opacity-0 group-hover:opacity-100">
        <flux:button size="xs" variant="danger" wire:click="confirmReport">
            {{ __('pages/forum.report_spam') }}
        </flux:button>
    </div>

    <flux:modal name="confirm-report-spam" class="max-w-md">
        <div>
            <flux:heading size="lg">{{ __('pages/forum.report_spam') }}</flux:heading>
            <flux:subheading>
                <p class="mt-2">
                    {{ __('pages/forum.report_spam_confirmation') }}
                </p>
            </flux:subheading>
        </div>

        <div class="mt-4">
            <flux:textarea
                wire:model="reason"
                :label="__('pages/forum.report_spam_reason')"
                :placeholder="__('pages/forum.report_spam_reason_placeholder')"
                rows="4"
            />
        </div>

        <div class="mt-6 flex gap-2 justify-end">
            <flux:modal.close>
                <flux:button variant="ghost">{{ __('actions.cancel') }}</flux:button>
            </flux:modal.close>

            <flux:button variant="danger" wire:click="report" class="border-0">
                {{ __('pages/forum.report_spam') }}
            </flux:button>
        </div>
    </flux:modal>
</div>
