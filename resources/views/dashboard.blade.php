<x-app-layout>

    <section class="flex w-full">
        <div class="w-full sm:px-6 lg:px-8">

            <div class="p-3 sm:p-5 text-gray-900 ">

                <!-- Display greeting according to time of day -->
                <div class="mb-4">
                    <h3 class="text-lg font-semibold">{{ __('Welcome') }}</h3>
                    <p>
                        @php
                            $hour = date('H');
                            if ($hour >= 5 && $hour <= 11) {
                                echo "Good Morning";
                            } else if ($hour >= 12 && $hour <= 18) {
                                echo "Good Afternoon";
                            } else if ($hour >= 19 || $hour <= 4) {
                                echo "Good Evening";
                            }
                        @endphp
                        {{ Auth::user()->first_name  }} {{ Auth::user()->last_name  }}
                    </p>

                    <!-- Display User Balance -->
                    <div class="mb-4">
                    </div>

                    <div class="mb-4 w-full flex flex-wrap gap-4">

                        <div class="card w-full sm:w-5/12 p-0 rounded bg-base-100 shadow-sm">
                            <div class="card-body m-[-10px]">
                                <h2 class="card-title">Balance</h2>
                                <p>Total CODE points Balance <span class="font-sans font-bold text-orange-700 text-2xl">{{ Auth::user()->balance }}</span> CPS</p>
                                <div class="card-actions gap-3 justify-end">
                                    <button class="btn ring ring-blue-700 btn-circle hover:bg-base-100">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                    </button>
                                    <button class="btn hover:bg-base-100 ring ring-orange-700 btn-circle">
                                        <i class="fa-solid fa-code"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card w-full sm:w-5/12 p-0 rounded bg-base-100 shadow-sm">
                            <div class="card-body m-[-10px]">
                                <h2 class="card-title">Activity</h2>
                                <p>You have been online for
                                    <span id="timeOnline" class="font-sans font-bold text-orange-700 text-2xl"></span>
                                </p>
                                <div class="card-actions justify-end">
                                    <button class="btn ring ring-orange-700 btn-circle">
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Display User Referrals -->
            <div class="mb-4">
                <h3 class="text-lg mx-2 sm:mx-6 font-semibold">{{ __('Referrals') }}</h3>
                <section>

                    <div class="overflow-x-auto mx-1 sm:mx-5">
                        <table class="min-w-full table divide-y divide-gray-200">
                            <!-- head -->
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th class="hidden sm:table-cell">Email</th>
                                <th class="hidden sm:table-cell">Date</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach(Auth::user()->referrals as $referral)
                                <!-- row 1 -->
                                <tr>
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <div>
                                                <div class="font-bold">{{ $referral->first_name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="hidden sm:table-cell">
                                        <span class="text-sm">{{ $referral->email }}</span>
                                    </td>
                                    <td class="hidden sm:table-cell">
                                                <span class="text-sm">
                                                    {{ $referral->created_at->diffForHumans() }}
                                                </span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <!-- foot -->
                        </table>
                    </div>

                        <div class="text-center p-1 m-2 sm:p-6 sm:m-6 rounded-lg shadow-sm border border-base-100 hover:bg-base-100">
                            <div class="my-3 text-lg">You have {{ Auth::user()->referrals->count() }} referral[s]</div>
                            <div class="text-gray-500">
                                You can use your referral link or code to invite your friends to join the platform. You will earn 5 CPS for every friend that joins using your referral link or code.
                                <div class="mt-4">
                                    <div class="mb-2">Your Referral Code is: <span class="font-bold text-blue-600">{{ Auth::user()->referral_code }}</span></div>
                                    <button class="btn btn-blue btn-circle ring ring-orange-700" onclick="copyToClipboard('{{ Auth::user()->referral_code }}')"><i class="fas fa-copy"></i></button>
                                    <div class="mt-4">You can also use the link below to invite your friends.</div>
                                    <p class="mt-2">{{ route('register', ['ref' => Auth::user()->referral_code]) }}</p>
                                    <button class="btn btn-blue btn-circle ring ring-blue-700 mt-2" onclick="copyToClipboard('{{ route('register', ['ref' => Auth::user()->referral_code]) }}')"><i class="fas fa-copy"></i></button>
                                </div>
                            </div>
                        </div>


                        <script>
                            function copyToClipboard(text) {
                                navigator.clipboard.writeText(text)
                                    .then(() => alert('Copied to clipboard ⚡'))
                                    .catch((error) => console.log('Failed to copy to clipboard: ', error));
                            }
                        </script>

                </section>
            </div>
        </div>

    </section>

    <script>
        var startTime = new Date('{{ Auth::user()->last_login_at }}');

        function updateTime() {
            var currentTime = new Date();
            var timeDiff = Math.floor((currentTime - startTime) / 1000); // in seconds

            var seconds = (timeDiff % 60).toString().padStart(2, "0"); // extract seconds
            timeDiff = Math.floor(timeDiff / 60); // convert to minutes
            var minutes = (timeDiff % 60).toString().padStart(2, "0"); // extract minutes
            timeDiff = Math.floor(timeDiff / 60); // convert to hours
            var hours = (timeDiff % 24).toString().padStart(2, "0"); // extract hours
            var days = Math.floor(timeDiff / 24); // extract days

            var timeOnline = '';
            if(days > 0) {
                timeOnline += days + 'd ';
            }
            timeOnline += hours + 'h ' + minutes + 'm ' + seconds + 's';

            document.getElementById('timeOnline').textContent = timeOnline;
        }

        setInterval(updateTime, 1000); // update every second
    </script>



</x-app-layout>
