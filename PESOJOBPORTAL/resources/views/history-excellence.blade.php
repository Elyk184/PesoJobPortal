@extends('layouts.app')

@section('title', 'History of Excellence - PESO Manolo Fortich')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/history-timeline.css') }}">
@endpush

@section('content')
<section id="history" class="py-20 bg-white relative overflow-hidden">
    <div class="nav-container relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">The History of Excellence</h2>
            <div class="w-24 h-1 bg-blue-600 mx-auto mb-6"></div>
            <p class="text-gray-600 max-w-3xl mx-auto text-lg">
                The journey of PESO Manolo Fortich — dedicated to bridging the gap between jobseekers and employers in our community since 2005.
            </p>
        </div>

        <div class="history-timeline">

            <div class="history-event left">
                <div class="history-event-content">
                    <h3>April 13, 2005</h3>
                    <h4>The Beginning</h4>
                    <div class="history-event-description">
                        <p>The Public Employment Service Office (PESO) of Manolo Fortich commenced its dynamic operations following the approval of Resolution No. 2005-08, which sanctioned the creation of Plantilla positions under the PESO of the Local Government Unit.</p>
                    </div>
                </div>
                <div class="history-event-dot"></div>
                <div class="history-event-spacer"></div>
            </div>

            <div class="history-event right">
                <div class="history-event-content">
                    <h3>July 2005</h3>
                    <h4>Institutionalization</h4>
                    <div class="history-event-description">
                        <p>Recognizing the need for a dedicated institution to address employment challenges, the Manolo Fortich Municipal Mayor's office institutionalized the PESO through an ordinance under Sangguniang Bayan Resolution No. 2005-94, under the leadership of Mayor Socorro O. Acosta. This marked a significant step towards formalizing the office's role in facilitating employment opportunities and supporting workforce development.</p>
                    </div>
                </div>
                <div class="history-event-dot"></div>
                <div class="history-event-spacer"></div>
            </div>

            <div class="history-event left">
                <div class="history-event-content">
                    <h3>October 26, 2005</h3>
                    <h4>DOLE Accreditation</h4>
                    <div class="history-event-description">
                        <p>A pivotal resolution authorized Mayor Acosta to enter into an agreement with the Department of Labor and Employment (DOLE), culminating in the official accreditation of the PESO. This accreditation opened doors for collaboration with DOLE and other government agencies, enhancing the office's capacity to serve the community.</p>
                    </div>
                </div>
                <div class="history-event-dot"></div>
                <div class="history-event-spacer"></div>
            </div>

            <div class="history-event right">
                <div class="history-event-content">
                    <h3>January 2013</h3>
                    <h4>Manpower Skills Registration System</h4>
                    <div class="history-event-description">
                        <p>As leadership transitioned to Hon. Rogelio N. Guo, the PESO continued its mission to provide quality employment services. A resolution supporting the establishment of the Manpower Skills Registration System underscored the office's commitment to addressing the evolving needs of job seekers.</p>
                    </div>
                </div>
                <div class="history-event-dot"></div>
                <div class="history-event-spacer"></div>
            </div>

            <div class="history-event left">
                <div class="history-event-content">
                    <h3>2013</h3>
                    <h4>Youth Empowerment &amp; Scholarship</h4>
                    <div class="history-event-description">
                        <p>Beyond traditional employment services, the PESO of Manolo Fortich prioritized education and youth empowerment. The Mayor's Scholarship Program, initiated under Mayor Acosta's tenure, provided opportunities for economically disadvantaged students to pursue higher education, breaking down barriers to academic achievement.</p>
                    </div>
                </div>
                <div class="history-event-dot"></div>
                <div class="history-event-spacer"></div>
            </div>

            <div class="history-event right">
                <div class="history-event-content">
                    <h3>October 2013</h3>
                    <h4>SPES Implementation</h4>
                    <div class="history-event-description">
                        <p>The implementation of the Special Program for the Employment of Students (SPES), supported by a 40% counterpart from DOLE, provided short-term employment opportunities to hundreds of students, allowing them to earn while gaining valuable work experience.</p>
                    </div>
                </div>
                <div class="history-event-dot"></div>
                <div class="history-event-spacer"></div>
            </div>

            <div class="history-event left">
                <div class="history-event-content">
                    <h3>2016</h3>
                    <h4>JobStart Philippines Program</h4>
                    <div class="history-event-description">
                        <p>The signing of a Memorandum of Agreement with DOLE for the JobStart Philippines Program marked another milestone. This initiative aimed to bridge the gap between education and employment by providing training and job placement assistance to young graduates.</p>
                    </div>
                </div>
                <div class="history-event-dot"></div>
                <div class="history-event-spacer"></div>
            </div>

            <div class="history-event right">
                <div class="history-event-content">
                    <h3>2013–2023</h3>
                    <h4>Regional Recognition</h4>
                    <div class="history-event-description">
                        <p>Throughout its existence, the PESO of Manolo Fortich has been recognized as one of the top-performing PESO offices in the region, receiving awards in 2013, 2014, 2015, 2016, 2018, 2022, and 2023. These achievements highlight the dedication and teamwork of the PESO Manager and staff in delivering exemplary public service.</p>
                    </div>
                </div>
                <div class="history-event-dot"></div>
                <div class="history-event-spacer"></div>
            </div>

            <div class="history-event left">
                <div class="history-event-content">
                    <h3>Today</h3>
                    <h4>Continuing the Mission</h4>
                    <div class="history-event-description">
                        <p>Like a soaring eagle upon the sky, the PESO of Manolo Fortich, as part of a first-class municipality, continues its journey toward inclusive development. The office constantly evolves to adapt to changing economic landscapes, serving as a testament to the power of public service in empowering individuals and strengthening the community.</p>
                    </div>
                </div>
                <div class="history-event-dot"></div>
                <div class="history-event-spacer"></div>
            </div>

        </div>
    </div>
</section>
@endsection
