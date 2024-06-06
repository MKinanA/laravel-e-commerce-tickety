<x-frontend.layout>

@section('title', $event->name)

<section class="container max-w-screen-xl pt-4 lg:pt-10 pb-[100px] overflow-hidden relative">
    <div class="xl:px-[60px]">
        <!-- Breadcrumb -->
        <ul class="inline-flex mb-5">
            <li class="first:before:content-none before:content-['/'] before:mx-6">
                <a href="{{ url('/') }}" class="text-lg text-iron-grey">
                    Home
                </a>
            </li>
            <li class="first:before:content-none before:content-['/'] before:mx-6 text-lg text-iron-grey">
                <a href="#!" class="text-lg text-iron-grey">
                    Browse
                </a>
            </li>
            <li class="first:before:content-none before:content-['/'] before:mx-6 text-lg text-iron-grey">
                <a href="#!" class="text-lg text-iron-grey">
                    Checkout
                </a>
            </li>
        </ul>

        <form action="{{ route('checkout-pay') }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-center justify-center gap-y-[30px] lg:justify-between lg:items-start">
            <div class="max-w-[500px]">
                <img src="{{ asset($event->thumbnail) }}" class="w-[280px] h-[200px] rounded-2xl" alt="tickety-assets">
                <h1 class="text-[32px] font-bold mt-5 mb-[30px]">
                    {{ $event->name }}
                </h1>

                <!-- Visible input fields -->
                <div class="flex flex-col gap-5 mb-[30px]">
                    <div class="flex flex-col gap-[10px]">
                        <label for="name" class="text-lg font-medium">Complete Name</label>
                        <input type="text" name="name" placeholder="Write your complete name"
                            class="px-5 py-[13px] placeholder:text-smoke-purple placeholder:font-normal font-semibold text-base rounded-[50px] bg-primary border-2 border-transparent border-solid focus:border-persian-pink focus:outline-none"
                            value="" id="visibleNameField" required>
                    </div>
                    <div class="flex flex-col gap-[10px]">
                        <label for="email" class="text-lg font-medium">Email Address</label>
                        <input type="email" name="email" placeholder="Write your email address"
                            class="px-5 py-[13px] placeholder:text-smoke-purple placeholder:font-normal font-semibold text-base rounded-[50px] bg-primary border-2 border-transparent border-solid focus:border-persian-pink focus:outline-none"
                            value="" id="visibleEmailField" required>
                    </div>
                </div>

                <!-- Payment details -->
                <div class="flex flex-col gap-4">
                    <h6 class="text-xl font-semibold">
                        Payment Details
                    </h6>
                    <!-- Tickets -->
                    @foreach ($tickets as $ticket)
                    <div class="inline-flex items-center justify-between gap-4">
                        <p class="text-base font-medium">
                            {{ $ticket->quantity }}&Cross; {{ substr($ticket->name, -1) == '.' ? substr($ticket->name, 0, -1) : $ticket->name }} ticket{{ $ticket->quantity > 1 ? 's' : '' }}
                        </p>
                        <p class="text-base font-semibold">
                            ${{ $ticket->total }}
                        </p>
                    </div>
                    @endforeach
                    <!-- Unique code -->
                    <div class="inline-flex items-center justify-between gap-4">
                        <p class="text-base font-medium">
                            Unique code
                        </p>
                        <p class="text-base font-semibold">
                            - ${{ $uniquePrice }}
                        </p>
                    </div>
                    <!-- Tax -->
                    <div class="inline-flex items-center justify-between gap-4">
                        <p class="text-base font-medium">
                            Tax 10%
                        </p>
                        <p class="text-base font-semibold">
                            ${{ $tax }}
                        </p>
                    </div>
                    <!-- Grand total -->
                    <div class="inline-flex items-center justify-between gap-4">
                        <p class="text-base font-medium">
                            Total
                        </p>
                        <p class="text-[32px] text-secondary font-bold underline underline-offset-4">
                            ${{ $totalPrice }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-primary p-5 rounded-2xl flex flex-col gap-5 max-w-[380px] w-full">
                @method('POST')
                @csrf
                <p class="text-xl font-semibold">
                    Payment method
                </p>
                <!-- Manual Transfer -->
                <label for="manualTransfer"
                    class="relative px-5 py-6 cursor-pointer bg-bluish-purple rounded-2xl">
                    <div class="inline-flex items-center justify-between w-full">
                        <div class="relative z-10 block w-full text-base font-semibold cursor-pointer">
                            Manual Transfer
                        </div>
                        <input type="radio" value="manual_transfer" id="manualTransfer" name="payment_method"
                            class="absolute inset-0 z-10 invisible peer/manual-transfer" required>
                        <div class="check-appearance"></div>

                    </div>
                    <!-- Bank Accounts -->
                    <div class="flex flex-col gap-4 mt-4">
                        <!-- Mandiri Account -->
                        <div class="flex items-center gap-5">
                            <img src="{{ asset('assets/svgs/logo-mandiri.svg') }}" alt="tickety-assets">
                            <div>
                                <p class="text-xs font-medium mb-[2px]">
                                    PT SHAYNA TICKET
                                </p>
                                <p class="text-lg font-semibold text-secondary">
                                    1892 0930 0001
                                </p>
                            </div>
                        </div>
                        <!-- BCA Account -->
                        <div class="flex items-center gap-5">
                            <img src="{{ asset('/assets/svgs/logo-bca.svg') }}" alt="tickety-assets">
                            <div>
                                <p class="text-xs font-medium mb-[2px]">
                                    PT SHAYNA TICKET
                                </p>
                                <p class="text-lg font-semibold text-secondary">
                                    2208 1962 9102
                                </p>
                            </div>
                        </div>
                    </div>
                </label>
                <!-- Virtual Account -->
                <label for="virtualAccount"
                    class="relative px-5 py-6 cursor-pointer bg-bluish-purple rounded-2xl">
                    <div class="inline-flex items-center justify-between w-full">
                        <div class="relative z-10 block w-full text-base font-semibold cursor-pointer">
                            Virtual Account
                        </div>
                        <input type="radio" value="virtual_account" id="virtualAccount" name="payment_method"
                            class="absolute inset-0 z-10 invisible peer/virtual-account" required>
                        <div class="check-appearance"></div>
                    </div>
                </label>
                <!-- Credit Card -->
                <label for="creditCard"
                    class="relative px-5 py-6 cursor-pointer bg-bluish-purple rounded-2xl">
                    <div class="inline-flex items-center justify-between w-full">
                        <div class="relative z-10 block w-full text-base font-semibold cursor-pointer">
                            Credit Card
                        </div>
                        <input type="radio" value="credit_card" id="creditCard" name="payment_method"
                            class="absolute inset-0 z-10 invisible peer/credit-card" required>
                        <div class="check-appearance"></div>
                    </div>
                </label>
                <!-- MyWallet -->
                <label for="myWallet"
                    class="relative px-5 py-6 cursor-pointer bg-bluish-purple rounded-2xl">
                    <div class="inline-flex items-center justify-between w-full">
                        <div class="relative z-10 block w-full text-base font-semibold cursor-pointer">
                            MyWallet
                        </div>
                        <input type="radio" value="my_wallet" id="myWallet" name="payment_method"
                            class="absolute inset-0 z-10 invisible peer/my-wallet" required>
                        <div class="check-appearance"></div>
                    </div>
                </label>

                <!-- Hidden name & email input field -->
                <input type="text" name="name" id="completeName" placeholder="name" value="" class="text-black" hidden>
                <input type="email" name="email" id="emailAddress" placeholder="email" value="" class="text-black" hidden>
                {{-- <a href="{{ route('checkout-success') }}" class="btn-secondary">
                    <img src="{{ asset('/assets/svgs/ic-secure-payment.svg') }}" alt="tickety-assets">
                    Make Payment Now
                </a> --}}
                <button type="submit" class="btn-secondary">
                    <img src="{{ asset('/assets/svgs/ic-secure-payment.svg') }}" alt="tickety-assets">
                    Make Payment Now
                </button>
            </div>
        </form>
    </div>
</section>

@push('js')
<script>
    $('#visibleNameField').on('input', function() {
        $('input:hidden[name=name]').val($(this).val())
    })

    $('#visibleEmailField').on('input', function() {
        $('input:hidden[name=email]').val($(this).val())
    })
</script>
@endpush

</x-frontend.layout>