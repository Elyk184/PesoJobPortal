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
            font-family: 'Times New Roman', Times, serif;
            color: #111827;
            font-size: 12pt;
            line-height: 1.5;
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
            font-size: 24pt;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
        }

        .resume-contact {
            text-align: center;
            font-size: 11pt;
            color: #374151;
            margin-top: 8px;
        }

        .resume-section {
            margin-bottom: 16px;
        }

        .resume-section h2 {
            font-size: 12pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-bottom: 1px solid #111827;
            padding-bottom: 4px;
            margin: 0 0 10px;
        }

        .resume-section p {
            margin: 0;
            font-size: 12pt;
            line-height: 1.5;
            color: #111827;
        }

        .resume-item {
            margin-bottom: 12px;
            font-size: 12pt;
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
    @php
        $educationPreviewRows = collect($educationRows ?? [])->filter(fn ($item) => collect($item)->filter()->isNotEmpty())->values();
        $trainingPreviewRows = collect($trainingRows ?? [])->filter(fn ($item) => collect($item)->filter()->isNotEmpty())->values();
        $experiencePreviewRows = collect($experienceRows ?? [])->filter(fn ($item) => collect($item)->filter()->isNotEmpty())->values();
        $eligibilityPreviewRows = collect($eligibilityRows ?? [])->filter(fn ($item) => collect($item)->filter()->isNotEmpty())->values();
        $hasObjective = trim((string) ($resumeObjective ?? '')) !== '';
    @endphp

    <div class="resume-preview">
        <div class="resume-header">
            <h1 class="resume-name">{{ $resumeName }}</h1>
            <div class="resume-contact">{{ collect([$resumeAddress, $resumePhone, $resumeEmail])->filter()->join(' | ') }}</div>
        </div>

        @if ($hasObjective)
            <section class="resume-section">
                <h2>Objective</h2>
                <p>{{ $resumeObjective }}</p>
            </section>
        @endif

        @if ($educationPreviewRows->isNotEmpty())
            <section class="resume-section">
                <h2>Education</h2>
                @foreach ($educationPreviewRows as $item)
                    <div class="resume-item">
                        <table class="resume-item-head" role="presentation">
                            <tr>
                                <td class="resume-item-head-left">{{ $item['school'] ?? '' }}</td>
                                <td class="resume-item-head-right">{{ $item['year'] ?? '' }}</td>
                            </tr>
                        </table>
                        <div class="resume-muted">{{ $item['course'] ?? '' }}</div>
                    </div>
                @endforeach
            </section>
        @endif

        @if ($trainingPreviewRows->isNotEmpty())
            <section class="resume-section">
                <h2>Training</h2>
                @foreach ($trainingPreviewRows as $item)
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
                @endforeach
            </section>
        @endif

        @if ($experiencePreviewRows->isNotEmpty())
            <section class="resume-section">
                <h2>Experience</h2>
                @foreach ($experiencePreviewRows as $item)
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
                @endforeach
            </section>
        @endif

        @if ($eligibilityPreviewRows->isNotEmpty())
            <section class="resume-section">
                <h2>Eligibility</h2>
                @foreach ($eligibilityPreviewRows as $item)
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
                @endforeach
            </section>
        @endif

        @if (($skillsPreview ?? collect())->isNotEmpty())
            <section class="resume-section">
                <h2>Skills</h2>
                <p class="resume-skills">{{ $skillsPreview->join(', ') }}</p>
            </section>
        @endif
    </div>
</body>
</html>
