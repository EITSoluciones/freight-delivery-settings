<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-gray-100">

    <x-toast type="success" :message="session('success')" />
    <x-toast type="danger" :message="session('danger')" />
    <x-toast type="warning" :message="session('warning')" />

    <div class="container px-5 mx-auto mt-10 ">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Clients</h1>
            <button type="button" data-modal-target="client-modal-create" data-modal-toggle="client-modal-create"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create
            </button>
        </div>
        <div class="overflow-x-auto bg-white shadow-md rounded ">
            <table class="min-w-full ">
                <thead>
                    <tr
                        class="border-b-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-gray-200 bg-gray-100">
                        <th class="px-6 py-3 font-medium">
                            Name
                        </th>
                        <th class="px-6 py-3 font-medium">
                            Email
                        </th>
                        <th class="px-6 py-3 font-medium">
                            Phone
                        </th>
                        <th class="px-6 py-3 font-medium">
                            Expiration Date
                        </th>
                        <th class="px-6 py-3 font-medium">
                            Server url
                        </th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)
                        <tr class="border-b border-gray-200 bg-white hover:bg-neutral-100 text-gray-700">
                            <td class="px-5 py-5">
                                <p class=" whitespace-no-wrap">{{ $client->name }}</p>
                            </td>
                            <td class="px-5 py-5 ">
                                <p class=" whitespace-no-wrap">{{ $client->email }}</p>
                            </td>
                            <td class="px-5 py-5 ">
                                <p class=" whitespace-no-wrap">{{ $client->phone }}</p>
                            </td>
                            <td class="px-5 py-5 ">
                                <p class=" whitespace-no-wrap">
                                    {{ \Carbon\Carbon::parse($client->expiration_date)->format('d-m-Y') }}</p>
                            </td>

                            <td class="px-5 py-5 ">
                                <p class=" whitespace-no-wrap">{{ $client->url }}</p>
                            </td>

                            <!-- options -->
                            <td class="px-5 py-5 flex gap-x-2">
                                <button onclick="showActivationCode('{{ $client->activation_code }}')"
                                    class="text-indigo-600 hover:text-indigo-900 mr-4 btn cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                                    </svg>
                                </button>
                                <button type="button" data-modal-target="client-modal-edit-{{ $client->id }}"
                                    data-modal-toggle="client-modal-edit-{{ $client->id }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-4 btn cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </button>

                                <button type="button" class="text-red-600 hover:text-red-900 cursor-pointer"
                                    data-modal-target="delete-client-modal" data-modal-toggle="delete-client-modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <x-client-modal :client="$client" />

                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-5 text-center text-gray-500">
                                No information available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- <div class="px-5 py-5 flex flex-col xs:flex-row items-center xs:justify-between">
                {{ $clients->links('components.pagination') }}
            </div> --}}
        </div>
    </div>
    <x-client-modal />


    <div id="delete-client-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
                <button type="button"
                    class="absolute top-3 end-2.5 text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="delete-client-modal">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-fg-disabled w-12 h-12" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-6 text-body">Are you sure you want to delete this client?</h3>
                    <div class="flex items-center space-x-4 justify-center">
                        <button data-modal-hide="popup-modal" type="button"
                            class="text-white bg-danger box-border border border-transparent hover:bg-danger-strong focus:ring-4 focus:ring-danger-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                            Yes, I'm sure
                        </button>
                        <button data-modal-hide="popup-modal" type="button"
                            class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">No,
                            cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

</html>
