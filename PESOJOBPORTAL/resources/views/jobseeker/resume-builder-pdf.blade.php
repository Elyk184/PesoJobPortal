<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $resumeName ?: 'Resume' }} - Harvard Style CV</title>
    <style>
        @page {
            margin: 42px 48px;
        }

        body {
            font-family: Georgia, 'Times New Roman', Times, serif;
            color: #111827;
            font-size: 12px;
            line-height: 1.55;
        }

        .name {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            text-align: center;
            letter-spacing: 0.02em;
        }

        .contact {
            text-align: center;
            font-size: 11px;
            color: #374151;
            margin-top: 6px;
        }

        .section {
            margin-top: 18px;
        }

        .section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border-bottom: 1px solid #111827;
            padding-bottom: 3px;
            margin-bottom: 8px;
        }

        .item {
            margin-bottom: 10px;
        }

        .item-head {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            font-weight: 700;
        }

        .muted {
            color: #4b5563;
            font-style: italic;
        }

        .skills {
            margin: 0;
            padding-left: 18px;
        }

        .skills li {
            margin-bottom: 4px;
        }
    </style>
</head>
<body>
    <h1 class="name">{{ $resumeName }}</h1>
    <div class="contact">{{ collect([$resumeAddress, $resumePhone, $resumeEmail])->filter()->join(' | ') }}</div>

    <div class="section">
        <div class="section-title">Objective</div>
        <div>{{ $resumeObjective ?: ' ' }}</div>
    </div>

    <div class="section">
        <div class="section-title">Education</div>
        @forelse ($educationRows as $item)
            @if(collect($item)->filter()->isNotEmpty())
                <div class="item">
                    <div class="item-head">
                        <div>{{ $item['school'] ?? '' }}</div>
                        <div>{{ $item['year'] ?? '' }}</div>
                    </div>
                    <div class="muted">{{ $item['course'] ?? '' }}</div>
                </div>
            @endif
        @empty
        @endforelse
    </div>

    <div class="section">
        <div class="section-title">Experience</div>
        @forelse ($experienceRows as $item)
            @if(collect($item)->filter()->isNotEmpty())
                <div class="item">
                    <div class="item-head">
                        <div>{{ $item['title'] ?? '' }}</div>
                        <div>{{ $item['period'] ?? '' }}</div>
                    </div>
                    <div class="muted">{{ $item['company'] ?? '' }}</div>
                    <div>{{ $item['details'] ?? '' }}</div>
                </div>
            @endif
        @empty
        @endforelse
    </div>

    <div class="section">
        <div class="section-title">Skills</div>
        @if($skillsPreview->count())
            <ul class="skills">
                @foreach ($skillsPreview as $skill)
                    <li>{{ $skill }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</body>
</html>
