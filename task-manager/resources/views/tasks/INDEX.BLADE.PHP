<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Manager</title>
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
            --success: #2F9E58;
            --success-bg: #E6F5EB;
            --warning: #E8912B;
            --warning-bg: #FDF0E0;
            --danger: #D14B4B;
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
            max-width: 980px;
            margin: 0 auto;
            padding: 56px 28px 90px;
        }

        .top {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 28px;
            flex-wrap: wrap;
        }

        h1 {
            font-family: 'Baloo 2', 'Inter', sans-serif;
            font-weight: 700;
            font-size: 34px;
            letter-spacing: -0.01em;
            margin: 0;
            color: var(--ink);
        }

        .subtitle {
            color: var(--ink-muted);
            margin: 6px 0 0;
            font-size: 14px;
        }

        .btn-new {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--accent);
            color: #FFFFFF;
            text-decoration: none;
            font-weight: 700;
            font-family: 'Baloo 2', 'Inter', sans-serif;
            font-size: 14.5px;
            padding: 11px 20px;
            border-radius: 8px;
            box-shadow: 0 10px 22px -10px rgba(47, 95, 222, 0.55);
            transition: background 0.15s ease, transform 0.15s ease;
            white-space: nowrap;
        }
        .btn-new:hover { background: var(--accent-hover); transform: translateY(-1px); }
        .btn-new svg { width: 15px; height: 15px; flex-shrink: 0; }

        /* The page: ruled paper sheet holding the table, red margin rule + paperclip */
        .page {
            position: relative;
            background:
                repeating-linear-gradient(
                    to bottom,
                    transparent 0,
                    transparent 43px,
                    var(--paper-line) 43px,
                    var(--paper-line) 44px
                ),
                var(--paper);
            background-position: 0 118px;
            border-radius: 12px;
            box-shadow: 0 18px 40px -22px rgba(38, 50, 82, 0.35), 0 1px 0 rgba(38, 50, 82, 0.06);
            overflow: hidden;
        }

        .margin-rule {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 46px;
            width: 2px;
            background: var(--margin-rule);
            opacity: 0.5;
            border-radius: 1px;
        }

        .paperclip {
            position: absolute;
            top: -16px;
            right: 34px;
            width: 30px;
            height: 44px;
            transform: rotate(8deg);
            z-index: 2;
        }

        .table-scroll { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            text-align: left;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--ink-muted);
            padding: 18px 22px 14px 62px;
            white-space: nowrap;
        }
        thead th:first-child { padding-left: 62px; }
        thead th:not(:first-child) { padding-left: 20px; }

        tbody td {
            padding: 15px 20px;
            vertical-align: top;
            font-size: 14px;
        }
        tbody td:first-child { padding-left: 62px; }

        tbody tr:hover { background: rgba(47, 95, 222, 0.035); }

        .id-cell { color: var(--ink-faint); font-variant-numeric: tabular-nums; }

        .task-name { font-weight: 700; color: var(--ink); }

        .desc-cell {
            color: var(--ink-muted);
            max-width: 240px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .status-row {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px 4px 8px;
            border-radius: 20px;
        }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
        .status-pill--completed { color: var(--success); background: var(--success-bg); }
        .status-pill--completed .status-dot { background: var(--success); }
        .status-pill--pending { color: var(--warning); background: var(--warning-bg); }
        .status-pill--pending .status-dot { background: var(--warning); }

        .toggle-btn {
            border: 1.5px solid #D7E1F5;
            background: transparent;
            color: var(--ink-muted);
            font-size: 11px;
            font-weight: 600;
            font-family: inherit;
            padding: 4px 10px;
            border-radius: 20px;
            cursor: pointer;
            transition: border-color 0.15s ease, color 0.15s ease;
        }
        .toggle-btn:hover { border-color: var(--accent); color: var(--accent); }

        .due-cell { color: var(--ink-muted); white-space: nowrap; }

        .actions-cell { white-space: nowrap; padding-right: 62px !important; }
        .actions-cell form { display: inline-block; margin: 0; }

        .link-edit {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            margin-right: 16px;
        }
        .link-edit:hover { text-decoration: underline; }

        .link-delete {
            border: none;
            background: transparent;
            color: var(--danger);
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
        }
        .link-delete:hover { text-decoration: underline; }

        .empty {
            padding: 60px 20px 52px 62px;
            text-align: center;
        }
        .empty svg { opacity: 0.5; margin-bottom: 16px; }
        .empty-title {
            font-family: 'Baloo 2', 'Inter', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--ink);
            margin: 0 0 6px;
        }
        .empty-sub {
            color: var(--ink-muted);
            font-size: 13.5px;
            margin: 0;
        }

        /* Tally row: stats now live as a footer beneath the table, like totals on a gradebook */
        .tally {
            display: flex;
            border-top: 2px solid var(--paper-line);
            padding: 18px 30px 18px 62px;
            gap: 32px;
            flex-wrap: wrap;
            background: #FBFCFE;
        }
        .tally-item {
            display: flex;
            align-items: baseline;
            gap: 8px;
        }
        .tally-value {
            font-family: 'Baloo 2', 'Inter', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--ink);
        }
        .tally-label {
            font-size: 12.5px;
            color: var(--ink-muted);
        }
        .tally-item--pending .tally-value { color: var(--warning); }
        .tally-item--completed .tally-value { color: var(--success); }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="top">
            <div>
                <h1>Task Manager</h1>
                <p class="subtitle">Track and manage your tasks in one place.</p>
            </div>
            <a href="{{ route('tasks.create') }}" class="btn-new">
                <svg viewBox="0 0 16 16" fill="none"><path d="M8 2.5v11M2.5 8h11" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                New task
            </a>
        </div>

        @php
            $total = isset($tasks) ? count($tasks) : 0;
            $completedCount = isset($tasks) ? collect($tasks)->where('status', 'Completed')->count() : 0;
            $pendingCount = $total - $completedCount;
        @endphp

        <div class="page">
            <div class="margin-rule"></div>
            <svg class="paperclip" viewBox="0 0 30 44" fill="none">
                <path d="M9 8v22a6 6 0 0012 0V11a4 4 0 00-8 0v17a2 2 0 004 0V13" stroke="#B9C4DE" stroke-width="2.4" stroke-linecap="round"/>
            </svg>

            <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Task name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Due date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr>
                            <td class="id-cell">{{ $task->id }}</td>
                            <td class="task-name">{{ $task->task_name }}</td>
                            <td class="desc-cell">{{ $task->description }}</td>
                            <td>
                                <div class="status-row">
                                    <span class="status-pill {{ $task->status == 'Completed' ? 'status-pill--completed' : 'status-pill--pending' }}">
                                        <span class="status-dot"></span>
                                        {{ $task->status }}
                                    </span>
                                    <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="toggle-btn">Toggle</button>
                                    </form>
                                </div>
                            </td>
                            <td class="due-cell">{{ $task->due_date }}</td>
                            <td class="actions-cell">
                                <a href="{{ route('tasks.edit', $task->id) }}" class="link-edit">Edit</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="link-delete" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty">
                                    <svg width="52" height="52" viewBox="0 0 56 56" fill="none">
                                        <rect x="10" y="8" width="36" height="42" rx="4" stroke="#96A3C4" stroke-width="1.6"/>
                                        <path d="M18 20h20M18 28h20M18 36h12" stroke="#96A3C4" stroke-width="1.6" stroke-linecap="round"/>
                                    </svg>
                                    <p class="empty-title">No tasks yet</p>
                                    <p class="empty-sub">Create your first task to start tracking it here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>

            @if($total > 0)
            <div class="tally">
                <div class="tally-item">
                    <span class="tally-value">{{ $total }}</span>
                    <span class="tally-label">total</span>
                </div>
                <div class="tally-item tally-item--pending">
                    <span class="tally-value">{{ $pendingCount }}</span>
                    <span class="tally-label">pending</span>
                </div>
                <div class="tally-item tally-item--completed">
                    <span class="tally-value">{{ $completedCount }}</span>
                    <span class="tally-label">completed</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</body>
</html>