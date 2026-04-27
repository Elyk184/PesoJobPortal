<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $resumeName ?: 'Resume' }} - Harvard Style CV</title>
    <style>
        @page {
            margin: 20px;
        }

        body {
            margin: 0;
            padding: 0;
            background: #ffffff;
            font-family: Georgia, 'Times New Roman', Times, serif;
            color: #111827;
            font-size: 14px;
            line-height: 1.55;
        }

        .resume-preview {
            background: #ffffff;
            border: 1px solid #d8dde5;
            padding: 36px 42px;
        }

        .resume-header {
            text-align: center;
            padding-bottom: 12px;
            margin-bottom: 24px;
            border-bottom: 1px solid #111827;
        }

        .resume-name {
            font-size: 34px;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.02em;
        }

        .resume-contact {
            text-align: center;
            font-size: 13px;
            color: #374151;
            margin-top: 8px;
        }

        .resume-section {
            margin-bottom: 16px;
        }

        .resume-section h2 {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border-bottom: 1px solid #111827;
            padding-bottom: 4px;
            margin: 0 0 10px;
        }

        .resume-section p {
            margin: 0;
            font-size: 14px;
            line-height: 1.55;
            color: #111827;
        }

        .resume-item {
            margin-bottom: 12px;
            font-size: 14px;
        }

        .resume-item-head {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 1px;
        }

        .resume-item-head td {
            vertical-align: top;
        }

        .resume-item-head-left {
            width: 72%;
            font-weight: 700;
            text-align: left;
            padding-right: 10px;
        }

        .resume-item-head-right {
            width: 28%;
            text-align: right;
            color: #6b7280;
            white-space: nowrap;
        }

        .resume-muted {
            color: #4b5563;
            font-style: italic;
            margin-bottom: 2px;
        }

        .resume-skills {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="resume-preview">
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
                        <table class="resume-item-head" role="presentation">
                            <tr>
                                <td class="resume-item-head-left">{{ $item['school'] ?? '' }}</td>
                                <td class="resume-item-head-right">{{ $item['year'] ?? '' }}</td>
                            </tr>
                        </table>
                        <div class="resume-muted">{{ $item['course'] ?? '' }}</div>
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
                        <table class="resume-item-head" role="presentation">
                            <tr>
                                <td class="resume-item-head-left">{{ $item['course'] ?? '' }}</td>
                                <td class="resume-item-head-right">{{ $item['dates'] ?? '' }}</td>
                            </tr>
                        </table>
                        <div class="resume-muted">{{ $item['institution'] ?? '' }}</div>
                        <p>{{ collect([$item['hours'] ?? '', $item['skills'] ?? '', $item['certificates'] ?? ''])->filter()->join(' | ') }}</p>
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
                        <table class="resume-item-head" role="presentation">
                            <tr>
                                <td class="resume-item-head-left">{{ $item['title'] ?? '' }}</td>
                                <td class="resume-item-head-right">{{ $item['period'] ?? '' }}</td>
                            </tr>
                        </table>
                        <div class="resume-muted">{{ $item['company'] ?? '' }}</div>
                        <p>{{ $item['details'] ?? '' }}</p>
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
                        <table class="resume-item-head" role="presentation">
                            <tr>
                                <td class="resume-item-head-left">{{ $item['eligibility'] ?? '' }}</td>
                                <td class="resume-item-head-right">{{ $item['valid_until'] ?? '' }}</td>
                            </tr>
                        </table>
                        <div class="resume-muted">{{ $item['license'] ?? '' }}</div>
                        <p>{{ $item['date_taken'] ?? '' }}</p>
                    </div>
                @endif
            @empty
            @endforelse
        </section>

        <section class="resume-section">
            <h2>Skills</h2>
            <p class="resume-skills">{{ $skillsPreview->count() ? $skillsPreview->join(', ') : ' ' }}</p>
        </section>
    </div>
</body>
</html>
