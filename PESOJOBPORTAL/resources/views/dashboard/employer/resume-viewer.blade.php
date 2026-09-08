<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $fileName }} - Resume Viewer</title>
    <style>
        :root {
            --bg: #f8fafc;
            --panel: #ffffff;
            --border: #e2e8f0;
            --text: #0f172a;
            --muted: #475569;
            --accent: #2563eb;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .viewer-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            background: var(--panel);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .viewer-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .viewer-open {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            white-space: nowrap;
        }

        .viewer-shell {
            width: 100%;
            height: calc(100vh - 73px);
            padding: 0;
            background: var(--bg);
        }

        iframe {
            width: 100%;
            height: 100%;
            border: 0;
            background: white;
        }

        @media (max-width: 640px) {
            .viewer-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="viewer-header">
        <div class="viewer-title">Viewing: {{ $fileName }}</div>
        <a class="viewer-open" href="{{ $resumeUrl }}" target="_blank" rel="noopener">Open original</a>
    </div>

    <div class="viewer-shell">
        @if($useGoogleViewer)
            <iframe
                src="https://docs.google.com/viewer?embedded=true&url={{ urlencode($resumeUrl) }}"
                title="Resume viewer"
                loading="lazy"
                allow="fullscreen">
            </iframe>
        @else
            <iframe
                src="{{ $resumeUrl }}"
                title="Resume viewer"
                loading="lazy"
                allow="fullscreen">
            </iframe>
        @endif
    </div>
</body>
</html>
