<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $resumeName ?: 'Resume' }}</title>
    <style>
        @page {
            margin: 40px 44px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            background: #f3f4f6;
        }

        body {
            font-family: Georgia, 'Times New Roman', Times, serif;
            color: #111827;
            font-size: 0.98rem;
            line-height: 1.55;
        }

        .resume-page {
            background: #ffffff;
            border: 1px solid #d8dde5;
            padding: 34px 40px;
        }

        .resume-header {
            text-align: center;
            padding-bottom: 14px;
            margin-bottom: 20px;
            border-bottom: 1px solid #111827;
        }

        .resume-name {
            font-size: 2.15rem;
            margin-bottom: 0;
            letter-spacing: 0.02em;
            font-weight: 700;
        }

        .resume-contact {
            font-size: 0.95rem;
            color: #374151;
            margin-top: 6px;
        }

        .resume-section {
            margin-bottom: 20px;
        }

        .resume-section h2 {
            font-size: 1.02rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 9px;
            padding-bottom: 4px;
            border-bottom: 1px solid #111827;
        }

        .resume-section p {
            font-size: 0.98rem;
            line-height: 1.55;
            color: #111827;
            margin: 0;
        }

        .resume-item {
            font-size: 0.98rem;
            margin-bottom: 16px;
        }

        .item-header {
            display: table;
            width: 100%;
            table-layout: fixed;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .item-title,
        .item-year {
            display: table-cell;
            vertical-align: top;
        }

        .item-year {
            text-align: right;
            white-space: nowrap;
            padding-left: 12px;
        }

        .item-company {
            font-style: italic;
            color: #4b5563;
            margin-bottom: 4px;
        }

        .item-details {
            margin: 0;
            line-height: 1.5;
        }

        .skills-list {
            font-size: 0.98rem;
            line-height: 1.55;
            color: #111827;
            margin-top: 2px;
        }

        ul {
            margin: 0;
            padding-left: 18px;
        }

        li {
            margin-bottom: 4px;
        }
    </style>
</head>
<body>
    <div class="resume-page">
        <div class="resume-header">
            <h1 class="resume-name">{{ $resumeName }}</h1>
            <div class="resume-contact">{{ collect([$resumeAddress, $resumePhone, $resumeEmail])->filter()->join(' | ') }}</div>
        </div>

        <section class="resume-section">
            <h2>Objective</h2>
            <p>{{ $resumeObjective ?: ' ' }}</p>
        </section>

        <section class="resume-section">
            <h2>Education</h2>
            @forelse ($educationRows as $item)
                @if(collect($item)->filter()->isNotEmpty())
                    <div class="resume-item">
                        <div class="item-header">
                            <div class="item-title">{{ $item['school'] ?? '' }}</div>
                            <div class="item-year">{{ $item['year'] ?? '' }}</div>
                        </div>
                        <div class="item-company">{{ $item['course'] ?? '' }}</div>
                    </div>
                @endif
            @empty
            @endforelse
        </section>

        <section class="resume-section">
            <h2>Training</h2>
            @forelse ($trainingRows ?? [] as $item)
                @if(collect($item)->filter()->isNotEmpty())
                    <div class="resume-item">
                        <div class="item-header">
                            <div class="item-title">{{ $item['course'] ?? '' }}</div>
                            <div class="item-year">{{ $item['dates'] ?? '' }}</div>
                        </div>
                        <div class="item-company">{{ $item['institution'] ?? '' }}</div>
                        <p class="item-details">{{ collect([$item['hours'] ?? '', $item['skills'] ?? '', $item['certificates'] ?? ''])->filter()->join(' | ') }}</p>
                    </div>
                @endif
            @empty
            @endforelse
        </section>

        <section class="resume-section">
            <h2>Experience</h2>
            @forelse ($experienceRows as $item)
                @if(collect($item)->filter()->isNotEmpty())
                    <div class="resume-item">
                        <div class="item-header">
                            <div class="item-title">{{ $item['title'] ?? '' }}</div>
                            <div class="item-year">{{ $item['period'] ?? '' }}</div>
                        </div>
                        <div class="item-company">{{ $item['company'] ?? '' }}</div>
                        <p class="item-details">{{ $item['details'] ?? '' }}</p>
                    </div>
                @endif
            @empty
            @endforelse
        </section>

        <section class="resume-section">
            <h2>Eligibility</h2>
            @forelse ($eligibilityRows ?? [] as $item)
                @if(collect($item)->filter()->isNotEmpty())
                    <div class="resume-item">
                        <div class="item-header">
                            <div class="item-title">{{ $item['eligibility'] ?? '' }}</div>
                            <div class="item-year">{{ $item['valid_until'] ?? '' }}</div>
                        </div>
                        <div class="item-company">{{ $item['license'] ?? '' }}</div>
                        <p class="item-details">{{ $item['date_taken'] ?? '' }}</p>
                    </div>
                @endif
            @empty
            @endforelse
        </section>

        <section class="resume-section">
            <h2>Skills</h2>
            @if($skillsPreview->count())
                <p class="skills-list">{{ $skillsPreview->join(', ') }}</p>
            @else
                <p class="skills-list"> </p>
            @endif
        </section>
    </div>
</body>
</html>
