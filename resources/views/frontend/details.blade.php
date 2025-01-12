<x-frontend.layout>

@section('title', $event->name)

<section class="container relative max-w-screen-xl pt-10 overflow-hidden">
    <div class="flex items-center flex-wrap mb-[38px] justify-between gap-5">
        <!-- Page Header -->
        <div class="flex flex-col gap-4 max-w-[430px]">

            @if ($event->is_popular)
            <div class="inline-flex gap-[6px] items-center bg-butter-yellow rounded-full px-4 py-[6px] w-max">
                <img src="{{ asset('/assets/svgs/ic-champion-cup.svg') }}" alt="tickety-assets">
                <p class="text-sm font-semibold text-dark-indigo">
                    Popular Event
                </p>
            </div>
            @endif

            <h1 class="text-5xl font-bold leading-normal">
                {{ $event->name }}
            </h1>
            <p class="text-lg text-iron-grey">
                {{ $event->headline }}
            </p>
        </div>

        <!-- Rating Star -->
        <div>
            <p class="mb-2 text-lg font-semibold text-iron-grey md:text-end">
                {{ number_format($event->tickets_count) }} people
            </p>
            <div class="flex items-center gap-[2px]">
                @for ($i = 0; $i < 5; $i++)
                <img src="{{ asset('/assets/svgs/ic-star.svg') }}" alt="tickety-assets">
                @endfor
            </div>
        </div>
    </div>
</section>

@if ($event->photos)
<section class="relative overflow-hidden">
    <div class="container relative max-w-screen-xl">
        <div id="galleryCarousel">
            @foreach ($event->photos as $photo)
            <img src="{{ Storage::url($photo) }}" class="w-[433px] h-[310px] rounded-2xl mr-[30px]" alt="tickety-assets">
            @endforeach
        </div>
        <!-- Prev Button -->
        <div class="absolute hidden -translate-y-1/2 top-1/2 right-4 lg:right-[200px] cursor-pointer" id="carouselRightButton">
            <img src="{{ asset('/assets/svgs/ic-right-rounded.svg') }}" alt="tickety-assets">
        </div>
        <!-- Next Button -->
        <div class="absolute -translate-y-1/2 cursor-pointer top-1/2 lg:left-20" id="carouselLeftButton">
            <img src="{{ asset('/assets/svgs/ic-left-rounded.svg') }}" alt="tickety-assets">
        </div>
    </div>
</section>
@endif
<!-- Wavy line ornament -->
<img src="{{ asset('/assets/svgs/wavy-line-3.svg') }}"
    class="absolute w-full -z-10 top-[380px]" alt="tickety-assets">

<section id="eventDescription" class="container max-w-screen-xl pt-[70px] relative pb-[156px]">
    <div class="flex flex-wrap items-start justify-between gap-y-[30px]">
        <div>
            <h5 class="text-[24px] md:text-[38px] font-bold">
                What's <span class="text-butter-yellow">This</span> <br>
                <span class="text-butter-yellow">Event</span> About?
            </h5>
            <p class="text-iron-grey text-lg leading-8 max-w-[640px] mt-4 mb-[30px]">
                {{ $event->description }}
            </p>

            <div class="max-w-[500px]">
                <div class="grid md:grid-cols-2 gap-x-[50px] gap-y-[30px]">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('/assets/svgs/ic-location.svg') }}" alt="tickety-assets">
                        <div>
                            <p class="text-pastel-purple text-sm mb-[2px]">
                                Location
                            </p>
                            <p class="text-base font-semibold">
                                {{ $event->location }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('/assets/svgs/ic-circles.svg') }}" alt="tickety-assets">
                        <div>
                            <p class="text-pastel-purple text-sm mb-[2px]">
                                Type
                            </p>
                            <p class="text-base font-semibold capitalize">
                                {{ $event->type }} Event
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('/assets/svgs/ic-calendar.svg') }}" alt="tickety-assets">
                        <div>
                            <p class="text-pastel-purple text-sm mb-[2px]">
                                Date
                            </p>
                            <p class="text-base font-semibold">
                                {{ $event->start_time->format('d M Y H:i A') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('/assets/svgs/ic-watch.svg') }}" alt="tickety-assets">
                        <div>
                            <p class="text-pastel-purple text-sm mb-[2px]">
                                Duration
                            </p>
                            <p class="text-base font-semibold">
                                {{ $event->duration >= 60 ? ($event->duration >= 3600 ? round($event->duration / 3600, floor($event->duration / 3600) == $event->duration / 3600 ? 0 : 1).' hours' : round($event->duration / 3600, floor($event->duration / 60) == $event->duration / 60 ? 0 : 1).' minutes') : $event->duration.' seconds' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('checkout', $event->slug) }}" method="POST" class="bg-primary p-5 rounded-2xl flex flex-col gap-5 max-w-[380px] w-full md:-mt-[120px] z-10 relative">
            @method('POST')
            @csrf
            <p class="text-xl font-semibold">
                Let's get your tickets
            </p>
            @foreach ($event->tickets as $ticket)
            <div class="px-5 py-6 bg-bluish-purple rounded-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="mb-1 text-base font-semibold">
                            {{ $ticket->name }}
                        </p>
                        <p class="text-[22px] font-semibold text-secondary">
                            {{ $ticket->price != 0 ? '$' : '' }}{{ $ticket->price != 0 ? number_format($ticket->price) : 'Free' }}
                        </p>
                    </div>
                    <div class="inline-flex items-center justify-between max-w-[150px]">
                        <button type="button" class="minusButton" id="of-ticket-{{ $ticket->id }}">
                            <img src="{{ asset('/assets/svgs/ic-minus.svg') }}" alt="tickety-assets">
                        </button>
                        <input type="number" name="tickets[{{ $ticket->id }}]" id="{{ $ticket->id }}" data-price="{{ $ticket->price }}" class="text-center bg-transparent focus:outline-none focus:border-none outline-none border-none" value="0" min="0" max="{{ $ticket->quantity > $ticket->max_buy ? $ticket->max_buy : $ticket->quantity }}" disabled>
                        <button type="button" class="plusButton" id="of-ticket-{{ $ticket->id }}">
                            <img src="{{ asset('/assets/svgs/ic-plus.svg') }}" alt="tickety-assets">
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="inline-flex items-center justify-between">
                <p class="text-base font-semibold">
                    <span id="totalTickets">0</span> tickets
                </p>
                <p class="text-[22px] font-semibold text-secondary">
                    $<span id="totalPrice">0</span>
                </p>
            </div>
            {{-- <a href="{{ route('checkout') }}" class="btn-secondary">
                Book Tickets Now
            </a> --}}
            <button type="submit" class="btn-secondary" id="bookTicket">
                Book Tickets Now
            </button>
        </form>
    </div>
</section>

@push('css')
<link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
@endpush

@push('js')
<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>

<!-- Carousel -->
<script>
    $carousel = $('#galleryCarousel')
    let flickityPrevButton = $('#galleryCarousel .flickity-prev-next-button.previous')
    let flickityNextButton = $('#galleryCarousel .flickity-prev-next-button.next')
    let rightButton = $('#carouselRightButton')
    let leftButton = $('#carouselLeftButton')
    let flktyPrevNextButtons = $(window).width() > 991 ? true : false

    $carousel.flickity({
        cellAlign: 'center',
        contain: true,
        pageDots: false,
        imagesLoaded: true,
        groupCells: false,
        prevNextButtons: false
    })

    if ($(window).width() > 991) {
        $('#galleryCarousel .flickity-viewport').css({
            overflow: 'visible'
        })
    }

    $carousel.on('change.flickity', function (event, index) {
        let len = $('#galleryCarousel .flickity-slider').children().length
        // console.log(len, index)
        
        if (index === len-1) {
            leftButton.addClass('hidden')
        }

        if (index > 0) {
            rightButton.removeClass('hidden')
        }  else {
            rightButton.addClass('hidden')
            leftButton.removeClass('hidden')
        }
    });

    leftButton.on('click', function(e) {
        $carousel.flickity('next')
    })

    rightButton.on('click', function(e) {
        $carousel.flickity('previous')
    })
</script>

<!-- Input ticket increment -->
<script>
    $(function() {
        // Check if initial totalTickets is 0 and update button state
        if ($('#totalTickets').text() == 0) {
          $('#bookTicket').addClass('opacity-50 cursor-not-allowed').text('Please select at least 1 ticket');
        }

        // Decrease quantity when minus button is clicked
        $('.minusButton').on('click', function() {
          let inputElement = $(this).siblings('input[type=number]');
          let currentValue = inputElement.val();
          if (currentValue != 0) {
            inputElement.val(--currentValue).trigger('change');
          }
        });

        // Increase quantity when plus button is clicked
        $('.plusButton').on('click', function() {
          let inputElement = $(this).siblings('input[type=number]');
          let currentValue = inputElement.val();
          let maxValue = inputElement.attr('max');
          if (currentValue < maxValue) {
            inputElement.val(++currentValue).trigger('change');
          }
        });

        // Update total tickets and total price when input value changes
        $('input[type=number]').on('change keyup mouseup mousewheel', function() {
          let totalTickets = 0;
          let totalPrice = 0;
        //   if ($(this).val() >= $(this).data('max')) {
        //     $(`.plusButton#of-ticket-${$(this).data('id')}`)addClass('opacity-50 cursor-not-allowed')
        //   } else {
        //     $(`.plusButton#of-ticket-${$(this).data('id')}`)removeClass('opacity-50 cursor-not-allowed')
        //   }
          $('input[type=number]').each(function() {
            let price = $(this).data('price');
            let quantity = $(this).val();
            totalTickets += parseInt(quantity);
            totalPrice += parseInt(quantity) * parseInt(price);
          });
          $('#totalTickets').text(totalTickets);
          $('#totalPrice').text(totalPrice);

          // Update button state based on totalTickets
          if (totalTickets > 0) {
            $('#bookTicket').removeClass('opacity-50 cursor-not-allowed').text('Book Tickets Now');
          } else {
            $('#bookTicket').addClass('opacity-50 cursor-not-allowed').text('Please select at least 1 ticket');
          }
        });

        // Prevent form submission and update button state if totalTickets is 0
        $('#bookTicket').on('click', function(e) {
          if ($('#totalTickets').text() == 0) {
            e.preventDefault();
            $(this).addClass('opacity-50 cursor-not-allowed').text('Please select at least 1 ticket');
          } else {
            $('input[type=number]').each(function () {
                $(this).removeAttr('disabled');
            })
          }
        });
      });
</script>
@endpush

</x-frontend.layout>