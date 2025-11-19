@props(['client' => null])

@php
    $isEdit = $client !== null;
    $modalId = $isEdit ? 'client-modal-edit-' . $client->id : 'client-modal-create';
@endphp

<!-- Main modal -->
<div id="{{ $modalId }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
            <!-- Modal header -->
            <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                <h3 class="text-lg font-medium text-heading">
                    {{ $isEdit ? 'Edit Client' : 'Create Client' }}
                </h3>
                <button type="button"
                    class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="{{ $modalId }}">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ $isEdit ? route('clients.update', $client) : route('clients.store') }}" method="POST"
                class="pt-4 md:pt-6">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                    <div class="mb-4">
                        <label for="name-{{ $modalId }}" class="block mb-2.5 text-sm font-medium text-heading">Name</label>
                        <input type="text" name="name" id="name-{{ $modalId }}"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                            placeholder="Client name" value="{{ old('name', $client->name ?? '') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="phone-{{ $modalId }}" class="block mb-2.5 text-sm font-medium text-heading">Phone</label>
                        <input type="text" name="phone" id="phone-{{ $modalId }}" maxlength="10"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                            placeholder="Client phone" value="{{ old('phone', $client->phone ?? '') }}" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                    <div class="mb-4">
                        <label for="email-{{ $modalId }}" class="block mb-2.5 text-sm font-medium text-heading">Email</label>
                        <input type="email" name="email" id="email-{{ $modalId }}"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                            placeholder="example@company.com" value="{{ old('email', $client->email ?? '') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="address-{{ $modalId }}"
                            class="block mb-2.5 text-sm font-medium text-heading">Address</label>
                        <input type="text" name="address" id="address-{{ $modalId }}"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                            placeholder="Client address" value="{{ old('address', $client->address ?? '') }}"
                            required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="expiration_date-{{ $modalId }}"
                        class="block mb-2.5 text-sm font-medium text-heading">Expiration date</label>
                    <div class="relative max-w-sm">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                            </svg>
                        </div>
                        <input datepicker name="expiration_date" id="expiration_date-{{ $modalId }}" type="text"
                            datepicker-orientation="top"
                            class="block w-full ps-9 pe-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand px-3 shadow-xs placeholder:text-body"
                            placeholder="Select date"
                            value="{{ old('expiration_date', $client ? \Carbon\Carbon::parse($client->expiration_date)->format('d/m/Y') : '') }}">




                    </div>
                </div>

                <div class="mb-10">
                    <label for="url-{{ $modalId }}" class="block mb-2.5 text-sm font-medium text-heading">Server
                        url</label>
                    <input type="text" name="url" id="url-{{ $modalId }}"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                        placeholder="Client server url" value="{{ old('url', $client->url ?? '') }}" required>
                </div>

                <button type="submit"
                    class="text-white bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none w-full mb-3">
                    {{ $isEdit ? 'Update Client' : 'Create Client' }}
                </button>
            </form>
        </div>
    </div>
</div>
