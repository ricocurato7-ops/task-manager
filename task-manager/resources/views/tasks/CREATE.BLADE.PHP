<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Task</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #E9F0FB;
            --paper: #FFFFFF;
            --paper-line: #E1EBFB;
            --margin-rule: #E1595A;
            --ink: #263252;
            --ink-muted: #5C6A8C;
            --ink-faint: #96A3C4;
            --accent: #2F5FDE;
            --accent-hover: #2148B0;
            --highlight: #FFD34D;
        }

        * { box-sizing: border-box; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--ink);
            font-family: 'Inter', -apple-system, sans-serif;
            font-size: 15px;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        .wrap {
            max-width: 560px;
            margin: 0 auto;
            padding: 56px 24px 90px;
        }

        .back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--ink-muted);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: color 0.15s ease;
        }
        .back svg { width: 13px; height: 13px; }
        .back:hover { color: var(--accent); }

        h1 {
            font-family: 'Baloo 2', 'Inter', sans-serif;
            font-weight: 700;
            font-size: 32px;
            letter-spacing: -0.01em;
            margin: 20px 0 6px;
            color: var(--ink);
        }

        .subtitle {
            color: var(--ink-muted);
            font-size: 14px;
            margin: 0 0 30px;
        }

        /* The page: a ruled sheet of paper with a red margin line and a paperclip */
        .page {
            position: relative;
            background:
                repeating-linear-gradient(
                    to bottom,
                    transparent 0,
                    transparent 33px,
                    var(--paper-line) 33px,
                    var(--paper-line) 34px
                ),
                var(--paper);
            background-position: 0 78px;
            border-radius: 10px;
            box-shadow: 0 18px 40px -22px rgba(38, 50, 82, 0.35), 0 1px 0 rgba(38, 50, 82, 0.06);
            padding: 34px 30px 34px 52px;
        }

        .margin-rule {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 30px;
            width: 2px;
            background: var(--margin-rule);
            opacity: 0.55;
            border-radius: 1px;
        }

        .paperclip {
            position: absolute;
            top: -16px;
            right: 28px;
            width: 30px;
            height: 44px;
            transform: rotate(8deg);
        }

        .field { margin-bottom: 21px; position: relative; }
        .field:last-of-type { margin-bottom: 0; }

        label {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--ink-muted);
            margin-bottom: 7px;
            letter-spacing: 0.01em;
        }

        input[type="text"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            background: #FBFCFE;
            border: 1.5px solid #D7E1F5;
            border-radius: 8px;
            padding: 11px 13px;
            color: var(--ink);
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            position: relative;
        }

        input[type="text"]::placeholder,
        textarea::placeholder { color: var(--ink-faint); }

        input[type="text"]:focus,
        input[type="date"]:focus,
        textarea:focus,
        select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(47, 95, 222, 0.14);
        }

        textarea { resize: vertical; min-height: 92px; }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%235C6A8C' stroke-width='1.5' fill='none' fill-rule='evenodd'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
            cursor: pointer;
        }

        .actions {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-cancel {
            display: inline-flex;
            align-items: center;
            color: var(--ink-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            padding: 11px 16px;
            border-radius: 8px;
            transition: color 0.15s ease, background 0.15s ease;
        }
        .btn-cancel:hover { color: var(--ink); background: #F1F5FC; }

        button[type="submit"] {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--accent);
            color: #FFFFFF;
            border: none;
            font-weight: 700;
            font-family: 'Baloo 2', 'Inter', sans-serif;
            font-size: 14.5px;
            padding: 11px 22px;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 10px 22px -10px rgba(47, 95, 222, 0.55);
            transition: background 0.15s ease, transform 0.15s ease, box-shadow 0.15s ease;
        }
        button[type="submit"]:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
            box-shadow: 0 12px 26px -10px rgba(47, 95, 222, 0.65);
        }
        button[type="submit"] svg { width: 14px; height: 14px; }
    </style>
</head>
<body>
    <div class="wrap">
        <a href="{{ route('tasks.index') }}" class="back">
            <svg viewBox="0 0 16 16" fill="none"><path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Back to tasks
        </a>
        <h1>Create a new task</h1>
        <p class="subtitle">Add the details below to track a new task.</p>

        <div class="page">
            <div class="margin-rule"></div>
            <svg class="paperclip" viewBox="0 0 30 44" fill="none">
                <path d="M9 8v22a6 6 0 0012 0V11a4 4 0 00-8 0v17a2 2 0 004 0V13" stroke="#B9C4DE" stroke-width="2.4" stroke-linecap="round"/>
            </svg>

            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="field">
                    <label for="task_name">Task name</label>
                    <input type="text" id="task_name" name="task_name" placeholder="e.g. Draft quarterly report" required>
                </div>

                <div class="field">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Add any extra detail or context"></textarea>
                </div>

                <div class="field">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>

                <div class="field">
                    <label for="due_date">Due date</label>
                    <input type="date" id="due_date" name="due_date">
                </div>

                <div class="actions">
                    <a href="{{ route('tasks.index') }}" class="btn-cancel">Cancel</a>
                    <button type="submit">
                        <svg viewBox="0 0 16 16" fill="none"><path d="M8 2.5v11M2.5 8h11" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        Save task
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>