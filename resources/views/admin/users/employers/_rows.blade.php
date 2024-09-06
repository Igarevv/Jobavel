@forelse($employers as $employer)
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <th scope="row"
            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ $loop->iteration + ($employers->currentPage() - 1) * $employers->perPage() }}
        </th>
        <td class="px-3 py-4">
            {{ $employer->idEncrypted }}
        </td>
        <td class="px-3 py-4">
            {{ $employer->company }}
        </td>
        <td class="px-3 py-4">
            {{ $employer->companyType }}
        </td>
        <td class="px-3 py-4">
            {{ $employer->accountEmail }}
        </td>
        <td class="px-3 py-4">
            {{ $employer->contactEmail }}
        </td>
        <td class="px-3 py-4">
            {{ $employer->createdAt }}
        </td>
        <td class="px-3 py-4">
            <button type="submit" data-modal-target="static-modal" data-modal-toggle="static-modal"
                    data-employer-id="{{ $employer->id }}" data-employer-name="{{ $employer->company }}"
                    class="open-modal-btn unstyled-button font-medium text-blue-600 dark:text-blue-500 hover:underline">
                View vacancies
            </button>
        </td>
        <td class="px-3 py-4">
            <form action=""
                  method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="unstyled-button font-medium text-red-600 dark:text-blue-500 hover:underline">
                    Ban
                </button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center py-6">
                    <span class="text-xl text-gray-500 dark:text-gray-400">
                        @isset($input)
                            Employer with key:
                            <span class="font-bold underline">{{ $input->searchByValue }}</span>
                            and search value:
                            <span class="font-bold underline">{{ $input->search }}</span>
                            not found
                        @else
                            Employers not found
                        @endisset
                    </span>
        </td>
    </tr>
@endforelse