@extends('layouts.app')

@section('title', 'Brief Historical Background')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/history-section.css') }}">
@endpush

@section('content')
<section class="history-section">
    <div class="history-container">
        <div class="history-card">
            <div class="history-image-col">
                <div class="history-image-banner">
                    <h2>Welcome to Manolo Fortich, Bukidnon</h2>
                    <p>Gateway to the Northern Highlands</p>
                </div>
                <img src="{{ asset('images/bg.png') }}" alt="Manolo Fortich History">
            </div>

            <div class="history-text-col">
                <h1>Brief Historical Background</h1>

                <p>
                    Manolo Fortich is a municipality located in the province of Bukidnon, in the
                    northern region of Mindanao, Philippines. It was named after the late Don
                    Manolo Fortich, a notable and respected figure in the province.
                </p>

                <p>
                    During the pre-historic era, the Bukidnons, also called Montesses or mountain
                    people, settled in the area of what is now called the Province of Bukidnon.
                    These people have remained traditional till 1860 preserving most of their
                    customs and tradition. Furthermore, these people had not been significantly
                    influenced by the Spanish colonizers because of their isolation. The rugged
                    mountain ranges and high plateaus serve as home to these people presented
                    an overwhelming obstacle to these colonizers.
                </p>

                <p>
                    The Bukidnons undoubtedly have links to the culture predominant in the
                    Southeast Asian region as evidenced by the similar customs and traditions.
                    Their presence here can be traced to the early migrations of these Asians
                    throughout the region. It was theorized that they came from places of what is
                    now known as Indonesia. Traveling by the sea, these migrants reached the
                    gulf of Davao where some ventured further to areas of what is presently
                    known as Bukidnon and Misamis Oriental..
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
