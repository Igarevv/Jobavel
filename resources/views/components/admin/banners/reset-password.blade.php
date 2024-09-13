@if(auth('admin')->user()?->account_status === \App\Enums\Admin\AdminAccountStatusEnum::PENDING_TO_AUTHORIZE)
    <div id="reset-password-banner" tabindex="-1" class="fixed z-50 flex flex-col md:flex-row justify-between w-[calc(100%-2rem)] p-4 -translate-x-1/2 bg-[#ffdad9] border border-red-100 rounded-lg shadow-sm lg:max-w-7xl left-1/2 top-6 dark:bg-[#ffdad9] dark:border-red-600">
        <div class="flex flex-col items-start mb-3 me-4 md:items-center md:flex-row md:mb-0">
            <a href="{{ route('admin.island') }}" class="flex items-center mb-2 border-red-200 md:pe-4 md:me-4 md:border-e md:mb-0 dark:border-red-600">
                <span class="self-center text-lg font-semibold whitespace-nowrap text-gray-900">Job<span class="text-red-100">avel</span> Admin</span>
            </a>
            <p class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-700">
                {{ session('user.name') }}! Change your temporarily password. If you&nbsp;<span class="underline font-bold">do not</span>&nbsp;do this, your account will be&nbsp;<span class="underline font-bold">deactivated</span>&nbsp;next time you log in.
            </p>
        </div>
        <div class="flex items-center flex-shrink-0">
            <button class="open-settings-modal px-5 py-2 me-2 text-xs font-medium text-white bg-red-700 rounded-lg hover:bg-white hover:text-black focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-white dark:hover:text-black focus:outline-none dark:focus:ring-red-800"
                    data-modal-target="settings-modal" data-modal-toggle="settings-modal" onclick="customHide()">
                Account Setting
            </button>
            <button id="hide-banner-btn" data-dismiss-target="#reset-password-banner" type="button" class="flex-shrink-0 inline-flex justify-center w-7 h-7 items-center text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close banner</span>
            </button>
        </div>
    </div>

    <script nonce="{{ csp_nonce() }}">
        function customHide() {
            const banner = document.getElementById('reset-password-banner');
            const modal = document.getElementById('settings-modal');

            if (modal && modal.classList.contains('hidden')) {
                banner.classList.add('hidden');
            } else {
                banner.classList.remove('hidden');
                banner.classList.add('opacity-100');
            }
        }

        document.getElementById('hide-banner-btn').addEventListener('click', () => {
            const banner = document.getElementById('reset-password-banner');
            setTimeout(function (){
                const modal = document.getElementById('settings-modal');
                if (modal && !modal.classList.contains('hidden')) {
                    banner.classList.add('hidden');
                } else {
                    banner.classList.remove('hidden');
                    banner.classList.add('opacity-100')
                }
            }, 5000);
        });
    </script>
@endif
