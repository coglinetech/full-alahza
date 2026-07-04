<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --gold: #B8933F;
            --gold-soft: #C5A04E;
            --gold-pale: #F5EDD8;
            --gold-dim: rgba(184, 147, 63, 0.10);
            --text-1: #18181b;
            --text-2: #71717a;
            --text-3: #a1a1aa;
            --line: #e4e4e7;
            --line-soft: #f4f4f5;
            --bg: #f8f8f8;
            --white: #ffffff;
            --sb-bg: #0e0d0b;
            --sb-w: 260px;
            --tb-h: 54px;
            --red: #dc2626;
            --red-pale: #fef2f2;
            --green: #16a34a;
            --green-pale: #f0fdf4;
            --r: 8px;
            --rl: 10px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            height: 100%;
            -webkit-font-smoothing: antialiased;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13.5px;
            background: var(--bg);
            color: var(--text-1);
            min-height: 100vh;
            display: flex;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sb-w);
            min-height: 100vh;
            background: var(--sb-bg);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 200;
            transition: transform 0.25s ease;
            border-right: 1px solid rgba(255, 255, 255, 0.04);
        }

        .sb-brand {
            height: 72px;
            display: flex;
            align-items: center;
            padding: 0 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            text-decoration: none;
            gap: 10px;
            flex-shrink: 0;
        }

        .sb-logo {
            width: 36px;
            height: 28px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .sb-logo-fb {
            width: 28px;
            height: 28px;
            background: var(--gold);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
            color: white;
            flex-shrink: 0;
            display: none;
        }

        .sb-name {
            font-size: 13.5px;
            font-weight: 600;
            color: white;
            line-height: 1.1;
        }

        .sb-sub {
            font-size: 10px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.22);
            letter-spacing: 0.4px;
            margin-top: 1px;
        }

        .sb-nav {
            flex: 1;
            padding: 10px 8px;
            overflow-y: auto;
        }

        .sb-nav::-webkit-scrollbar {
            width: 2px;
        }

        .sb-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.07);
        }

        .sb-grp {
            margin-bottom: 2px;
        }

        .sb-grp-label {
            font-size: 9.5px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.16);
            padding: 10px 8px 5px;
            display: block;
        }

        .sb-nav ul {
            list-style: none;
        }

        .sb-nav ul li {
            margin-bottom: 1px;
        }

        .sb-nav ul li a {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 9px;
            border-radius: var(--r);
            color: rgba(255, 255, 255, 0.4);
            text-decoration: none;
            font-size: 12.5px;
            font-weight: 400;
            transition: color 0.15s, background 0.15s;
            white-space: nowrap;
        }

        .sb-nav ul li a svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.75;
            opacity: 0.65;
            transition: opacity 0.15s;
        }

        .sb-nav ul li a:hover {
            color: rgba(255, 255, 255, 0.75);
            background: rgba(255, 255, 255, 0.04);
        }

        .sb-nav ul li a:hover svg {
            opacity: 1;
        }

        .sb-nav ul li a.active {
            color: var(--gold-soft);
            background: rgba(184, 147, 63, 0.11);
            font-weight: 500;
        }

        .sb-nav ul li a.active svg {
            opacity: 1;
        }

        .sb-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding: 10px 8px;
            flex-shrink: 0;
        }

        .sb-user {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 9px;
            margin-bottom: 2px;
        }

        .sb-avatar {
            width: 26px;
            height: 26px;
            border-radius: 6px;
            background: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 600;
            color: white;
            flex-shrink: 0;
        }

        .sb-uname {
            font-size: 12px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.65);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sb-urole {
            font-size: 10.5px;
            color: rgba(255, 255, 255, 0.22);
        }

        .sb-logout {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 9px;
            border-radius: var(--r);
            color: rgba(255, 255, 255, 0.28);
            font-size: 12px;
            cursor: pointer;
            transition: color 0.15s, background 0.15s;
            border: none;
            background: none;
            font-family: inherit;
            width: 100%;
            text-align: left;
        }

        .sb-logout svg {
            width: 13px;
            height: 13px;
            flex-shrink: 0;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.75;
        }

        .sb-logout:hover {
            color: #fca5a5;
            background: rgba(220, 38, 38, 0.07);
        }

        .sb-user-menu {
            position: relative;
            flex-shrink: 0;
        }
        .sb-user-btn {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: none;
            background: transparent;
            color: rgba(255,255,255,0.3);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s, color 0.15s;
        }
        .sb-user-btn:hover {
            background: rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.6);
        }
        .sb-user-btn svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
            stroke: none;
        }
        .sb-user-dropdown {
            display: none;
            position: absolute;
            bottom: calc(100% + 6px);
            right: 0;
            background: #1c1b19;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 8px;
            padding: 4px;
            min-width: 170px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.4);
            z-index: 300;
            overflow: hidden;
        }
        .sb-user-dropdown.open {
            display: block;
        }
        .sb-dropdown-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 10px;
            border-radius: 6px;
            font-size: 12px;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            transition: background 0.12s, color 0.12s;
            border: none;
            background: none;
            font-family: inherit;
            width: 100%;
            text-align: left;
            cursor: pointer;
            white-space: nowrap;
        }
        .sb-dropdown-item svg {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.75;
            flex-shrink: 0;
        }
        .sb-dropdown-item:hover {
            background: rgba(255,255,255,0.05);
            color: rgba(255,255,255,0.75);
        }
        .sb-dropdown-danger:hover {
            color: #fca5a5;
            background: rgba(220,38,38,0.1);
        }

        /* overlay mobile */
        .sb-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            z-index: 199;
        }

        /* ── MAIN ── */
        .main {
            margin-left: var(--sb-w);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* TOPBAR */
        .topbar {
            height: var(--tb-h);
            background: var(--white);
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 22px;
            position: sticky;
            top: 0;
            z-index: 100;
            flex-shrink: 0;
        }

        .tb-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tb-hamburger {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            border-radius: var(--r);
            color: var(--text-2);
            transition: background 0.15s;
        }

        .tb-hamburger:hover {
            background: var(--line-soft);
        }

        .tb-hamburger svg {
            width: 17px;
            height: 17px;
            display: block;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.75;
        }

        .tb-sep {
            width: 1px;
            height: 14px;
            background: var(--line);
            display: none;
        }

        .tb-page {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-1);
            line-height: 1;
        }

        .tb-crumb {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 11.5px;
            color: var(--text-3);
            margin-top: 2px;
        }

        .tb-crumb a {
            color: var(--text-3);
            text-decoration: none;
            transition: color 0.15s;
        }

        .tb-crumb a:hover {
            color: var(--gold);
        }

        .tb-crumb-sep {
            font-size: 9px;
            opacity: 0.5;
        }

        .tb-crumb-cur {
            color: var(--gold);
            font-weight: 500;
        }

        .tb-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tb-site-btn {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 6px 11px;
            border: 1px solid var(--line);
            border-radius: var(--r);
            font-size: 12px;
            font-weight: 500;
            color: var(--text-2);
            text-decoration: none;
            transition: all 0.15s;
            background: var(--white);
        }

        .tb-site-btn svg {
            width: 12px;
            height: 12px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.75;
        }

        .tb-site-btn:hover {
            border-color: var(--gold);
            color: var(--gold);
        }

        /* CONTENT */
        .content {
            flex: 1;
            padding: 22px;
        }

        /* ── COMPONENTS ── */

        /* page header */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .page-header h1 {
            font-size: 17px;
            font-weight: 600;
            color: var(--text-1);
            line-height: 1.3;
        }

        .page-header p {
            font-size: 12px;
            color: var(--text-3);
            margin-top: 2px;
        }

        .page-header-actions {
            display: flex;
            gap: 7px;
            align-items: center;
            flex-shrink: 0;
        }

        /* buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 14px;
            border-radius: var(--r);
            font-size: 12.5px;
            font-weight: 500;
            font-family: inherit;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s;
            border: 1px solid transparent;
            line-height: 1;
            white-space: nowrap;
        }

        .btn svg {
            width: 12px;
            height: 12px;
            flex-shrink: 0;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
        }

        .btn-primary {
            background: var(--gold);
            color: white;
            border-color: var(--gold);
        }

        .btn-primary:hover {
            background: var(--gold-soft);
            border-color: var(--gold-soft);
        }

        .btn-secondary {
            background: var(--white);
            color: var(--text-1);
            border-color: var(--line);
        }

        .btn-secondary:hover {
            background: var(--line-soft);
        }

        .btn-ghost {
            background: transparent;
            color: var(--text-2);
            border-color: transparent;
        }

        .btn-ghost:hover {
            background: var(--line-soft);
            color: var(--text-1);
        }

        .btn-danger {
            background: var(--red-pale);
            color: var(--red);
            border-color: rgba(220, 38, 38, 0.15);
        }

        .btn-danger:hover {
            background: #fee2e2;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 11.5px;
        }

        .btn-icon {
            padding: 6px;
            width: 30px;
            height: 30px;
            justify-content: center;
        }

        .btn-icon svg {
            width: 13px;
            height: 13px;
        }

        /* card */
        .card {
            background: var(--white);
            border-radius: var(--rl);
            border: 1px solid var(--line);
            overflow: hidden;
        }

        .card-header {
            padding: 13px 16px;
            border-bottom: 1px solid var(--line-soft);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .card-header-title {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-1);
        }

        .card-body {
            padding: 16px;
        }

        /* stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--rl);
            border: 1px solid var(--line);
            padding: 16px 18px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .stat-label {
            font-size: 10.5px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-3);
            margin-bottom: 7px;
        }

        .stat-value {
            font-size: 26px;
            font-weight: 600;
            color: var(--text-1);
            line-height: 1;
            letter-spacing: -0.5px;
        }

        .stat-sub {
            font-size: 11px;
            color: var(--text-3);
            margin-top: 4px;
        }

        .stat-icon {
            width: 34px;
            height: 34px;
            border-radius: var(--r);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.75;
        }

        .icon-gold {
            background: var(--gold-dim);
            color: var(--gold);
        }

        .icon-green {
            background: rgba(22, 163, 74, 0.07);
            color: var(--green);
        }

        .icon-slate {
            background: rgba(100, 116, 139, 0.07);
            color: #64748b;
        }

        .icon-blue {
            background: rgba(59, 130, 246, 0.07);
            color: #3b82f6;
        }

        /* table */
        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            padding: 9px 14px;
            text-align: left;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 0.4px;
            text-transform: uppercase;
            color: var(--text-3);
            background: var(--line-soft);
            border-bottom: 1px solid var(--line);
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid var(--line-soft);
            transition: background 0.1s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #fafafa;
        }

        tbody td {
            padding: 11px 14px;
            font-size: 13px;
            vertical-align: middle;
        }

        .td-muted {
            color: var(--text-3);
            font-size: 12px;
        }

        .td-actions {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* badge */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 500;
        }

        .badge-gold {
            background: rgba(184, 147, 63, 0.09);
            color: var(--gold);
        }

        .badge-green {
            background: rgba(22, 163, 74, 0.07);
            color: var(--green);
        }

        .badge-gray {
            background: var(--line-soft);
            color: var(--text-3);
        }

        .badge-red {
            background: var(--red-pale);
            color: var(--red);
        }

        /* form */
        .form-grid {
            display: grid;
            gap: 14px;
        }

        .form-grid-2 {
            grid-template-columns: 1fr 1fr;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .form-group.span-2 {
            grid-column: span 2;
        }

        label {
            font-size: 11.5px;
            font-weight: 500;
            color: var(--text-2);
        }

        label .req {
            color: var(--red);
            margin-left: 2px;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="url"],
        input[type="password"],
        select,
        textarea {
            width: 100%;
            padding: 8px 11px;
            border: 1px solid var(--line);
            border-radius: var(--r);
            font-size: 13px;
            font-family: inherit;
            color: var(--text-1);
            background: var(--white);
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
            font-weight: 400;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--gold-soft);
            box-shadow: 0 0 0 3px rgba(184, 147, 63, 0.09);
        }

        textarea {
            resize: vertical;
            min-height: 88px;
            line-height: 1.6;
        }

        .form-hint {
            font-size: 11px;
            color: var(--text-3);
            line-height: 1.5;
        }

        .form-error {
            font-size: 11px;
            color: var(--red);
        }

        /* upload */
        .upload-zone {
            border: 1.5px dashed var(--line);
            border-radius: var(--r);
            padding: 20px 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.15s;
            background: var(--line-soft);
            position: relative;
        }

        .upload-zone:hover {
            border-color: var(--gold-soft);
            background: var(--gold-pale);
        }

        .upload-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
            border: none;
            box-shadow: none;
            padding: 0;
        }

        .upload-zone input[type="file"]:focus {
            border: none;
            box-shadow: none;
        }

        .upload-icon {
            width: 32px;
            height: 32px;
            margin: 0 auto 7px;
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: var(--r);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-3);
        }

        .upload-icon svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.75;
        }

        .upload-title {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-2);
            margin-bottom: 2px;
        }

        .upload-sub {
            font-size: 11px;
            color: var(--text-3);
        }

        .img-preview-wrap {
            display: inline-block;
            border-radius: var(--r);
            overflow: hidden;
            border: 1px solid var(--line);
            position: relative;
        }

        .img-preview-wrap img {
            display: block;
            max-height: 130px;
            max-width: 100%;
            object-fit: contain;
        }

        .img-preview-remove {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 20px;
            height: 20px;
            background: rgba(220, 38, 38, 0.85);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        /* stars */
        .stars-input {
            display: flex;
            gap: 3px;
        }

        .stars-input button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color: var(--line);
            transition: color 0.1s;
            padding: 0;
            line-height: 1;
        }

        .stars-input button.active,
        .stars-input button:hover {
            color: #f59e0b;
        }

        /* alert */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 10px 13px;
            border-radius: var(--r);
            font-size: 12.5px;
            margin-bottom: 16px;
        }

        .alert svg {
            width: 13px;
            height: 13px;
            flex-shrink: 0;
            margin-top: 1px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
        }

        .alert-success {
            background: var(--green-pale);
            color: #15803d;
            border: 1px solid rgba(22, 163, 74, 0.13);
        }

        .alert-error {
            background: var(--red-pale);
            color: var(--red);
            border: 1px solid rgba(220, 38, 38, 0.13);
        }

        /* empty */
        .empty-state {
            padding: 44px 24px;
            text-align: center;
        }

        .empty-icon {
            width: 40px;
            height: 40px;
            background: var(--line-soft);
            border-radius: var(--rl);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            color: var(--text-3);
        }

        .empty-icon svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.75;
        }

        .empty-state h3 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-1);
            margin-bottom: 4px;
        }

        .empty-state p {
            font-size: 12px;
            color: var(--text-3);
            margin-bottom: 14px;
        }

        /* toggle */
        .toggle {
            position: relative;
            display: inline-block;
            width: 34px;
            height: 19px;
        }

        .toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background: var(--line);
            border-radius: 19px;
            transition: 0.18s;
        }

        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 13px;
            height: 13px;
            left: 3px;
            bottom: 3px;
            background: white;
            border-radius: 50%;
            transition: 0.18s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
        }

        .toggle input:checked+.toggle-slider {
            background: var(--gold);
        }

        .toggle input:checked+.toggle-slider::before {
            transform: translateX(15px);
        }

        /* thumb */
        .thumb {
            width: 46px;
            height: 34px;
            border-radius: 5px;
            object-fit: cover;
            background: var(--line-soft);
            border: 1px solid var(--line);
        }

        .thumb-placeholder {
            width: 46px;
            height: 34px;
            border-radius: 5px;
            background: var(--line-soft);
            border: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-3);
        }

        .thumb-placeholder svg {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            fill: none;
        }

        /* modal */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal {
            background: var(--white);
            border-radius: var(--rl);
            width: 90%;
            max-width: 360px;
            padding: 22px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
            border: 1px solid var(--line);
        }

        .modal-icon {
            width: 38px;
            height: 38px;
            background: var(--red-pale);
            border-radius: var(--r);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            color: var(--red);
        }

        .modal-icon svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.75;
        }

        .modal h3 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-1);
            margin-bottom: 5px;
        }

        .modal p {
            font-size: 12.5px;
            color: var(--text-3);
            margin-bottom: 18px;
            line-height: 1.6;
        }

        .modal-actions {
            display: flex;
            gap: 7px;
            justify-content: flex-end;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <div class="sb-overlay" id="sbOverlay" onclick="closeSidebar()"></div>

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="sidebar">

        <a href="{{ route('admin.dashboard') }}" class="sb-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Al-Ahza" class="sb-logo"
                onerror="this.style.display='none'; document.getElementById('sbLogoFb').style.display='flex';">
            <div class="sb-logo-fb" id="sbLogoFb">A</div>
            <div class="sb-sub"
                style="font-size:10px;color:rgba(197,160,78,0.6);letter-spacing:1.5px;text-transform:uppercase;">
                Admin Panel
            </div>
        </a>

        <nav class="sb-nav">
            <div class="sb-grp">
                <span class="sb-grp-label">Utama</span>
                <ul>
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="3" width="7" height="7" rx="1" />
                                <rect x="14" y="3" width="7" height="7" rx="1" />
                                <rect x="3" y="14" width="7" height="7" rx="1" />
                                <rect x="14" y="14" width="7" height="7" rx="1" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                </ul>
            </div>
            <div class="sb-grp">
                <span class="sb-grp-label">Jamaah</span>
                <ul>
                    <li>
                        <a href="{{ route('admin.registrants.index') }}"
                            class="{{ request()->routeIs('admin.registrants.*') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 12a4 4 0 100-8 4 4 0 000 8z" />
                                <path d="M6 20a6 6 0 0112 0" />
                            </svg>
                            Pendaftaran Jamaah
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.receipts.index') }}"
                            class="{{ request()->routeIs('admin.receipts.*') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24">
                                <path d="M4 5h16v14H4z" />
                                <path d="M8 9h8" />
                                <path d="M8 13h8" />
                            </svg>
                            Cetak Kuitansi
                        </a>
                    </li>

                </ul>
            </div>
            <div class="sb-grp">
                <span class="sb-grp-label">Konten</span>
                <ul>
                    <li>
                        <a href="{{ route('admin.packages.index') }}"
                            class="{{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" />
                            </svg>
                            Paket Perjalanan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.testimonials.index') }}"
                            class="{{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24">
                                <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                            </svg>
                            Testimoni
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.gallery.index') }}"
                            class="{{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                            Galeri
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.banners.index') }}"
                            class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24">
                                <rect x="2" y="3" width="20" height="14" rx="2" />
                                <path d="M8 21h8M12 17v4" />
                            </svg>
                            Banner Iklan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.about.index') }}"
                            class="{{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                            </svg>
                            Tentang
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="sb-footer">
            <div class="sb-user">
                <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                <div style="overflow:hidden;flex:1;min-width:0;">
                    <div class="sb-uname">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="sb-urole">Administrator</div>
                </div>
                <div class="sb-user-menu" id="sbUserMenu">
                    <button class="sb-user-btn" onclick="toggleUserMenu()" title="Menu">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                    </button>
                    <div class="sb-user-dropdown" id="sbUserDropdown">
                        <a href="{{ route('admin.password') }}" class="sb-dropdown-item">
                            <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                            Ganti Password
                        </a>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="sb-dropdown-item sb-dropdown-danger">
                                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="main">

        <header class="topbar">
            <div class="tb-left">
                <button class="tb-hamburger" onclick="openSidebar()">
                    <svg viewBox="0 0 24 24">
                        <line x1="3" y1="6" x2="21" y2="6" />
                        <line x1="3" y1="12" x2="21" y2="12" />
                        <line x1="3" y1="18" x2="21" y2="18" />
                    </svg>
                </button>
                <div class="tb-sep"></div>
                <div>
                    <div class="tb-page">@yield('page-title', 'Dashboard')</div>
                    <div class="tb-crumb">
                        <a href="{{ route('admin.dashboard') }}">Admin</a>
                        @yield('breadcrumb')
                    </div>
                </div>
            </div>
            <div class="tb-right">
                <a href="{{ route('home') }}" target="_blank" class="tb-site-btn">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6" />
                        <polyline points="15 3 21 3 21 9" />
                        <line x1="10" y1="14" x2="21" y2="3" />
                    </svg>
                    Lihat Website
                </a>
            </div>
        </header>

        <main class="content">

            @if (session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    {{-- DELETE MODAL --}}
    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <div class="modal-icon">
                <svg viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6" />
                    <path
                        d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6M10 11v6M14 11v6M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2" />
                </svg>
            </div>
            <h3>Hapus data ini?</h3>
            <p id="deleteModalMsg">Tindakan ini tidak dapat dibatalkan. Data yang sudah dihapus tidak bisa
                dikembalikan.</p>
            <div class="modal-actions">
                <button class="btn btn-secondary btn-sm" onclick="closeDeleteModal()">Batal</button>
                <form id="deleteForm" method="POST" style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleUserMenu() {
            const el = document.getElementById('sbUserDropdown');
            el.classList.toggle('open');
        }
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('sbUserMenu');
            if (menu && !menu.contains(e.target)) {
                document.getElementById('sbUserDropdown')?.classList.remove('open');
            }
        });

        function openSidebar() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('sbOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sbOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }

        function confirmDelete(url, label) {
            document.getElementById('deleteForm').action = url;
            if (label) {
                document.getElementById('deleteModalMsg').textContent =
                    'Anda akan menghapus "' + label + '". Tindakan ini tidak dapat dibatalkan.';
            }
            document.getElementById('deleteModal').classList.add('open');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('open');
        }
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });
        // Auto-hide flash
        document.querySelectorAll('.alert').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity 0.4s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 400);
            }, 4000);
        });

        // Cek sesi setiap 2 menit via fetch
        setInterval(function() {
            fetch('{{ route('admin.session.check') }}', {
                method: 'GET',
                credentials: 'same-origin'
            }).then(res => {
                if (res.redirected || res.status === 401 || res.url.includes('login')) {
                    showSessionExpiredBanner();
                }
            }).catch(() => {});
        }, 120000);

        function showSessionExpiredBanner() {
            if (document.getElementById('sessionBanner')) return;
            const banner = document.createElement('div');
            banner.id = 'sessionBanner';
            banner.innerHTML = `
        <div style="
            position:fixed;top:0;left:0;right:0;z-index:9999;
            background:linear-gradient(135deg,#92400e,#b45309);
            padding:14px 24px;
            display:flex;align-items:center;justify-content:space-between;
            gap:16px;
            box-shadow:0 4px 20px rgba(0,0,0,0.2);
            animation:slideDown 0.3s ease;
        ">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:32px;height:32px;background:rgba(255,255,255,0.15);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div>
                    <div style="font-size:13px;font-weight:600;color:white;">Sesi Anda telah berakhir</div>
                    <div style="font-size:12px;color:rgba(255,255,255,0.7);">Simpan pekerjaan Anda lalu masuk kembali.</div>
                </div>
            </div>
            <a href="{{ route('admin.login') }}"
               style="
                background:white;color:#92400e;
                padding:8px 18px;border-radius:7px;
                font-size:12.5px;font-weight:600;
                text-decoration:none;white-space:nowrap;
                transition:opacity 0.2s;flex-shrink:0;
               "
               onmouseover="this.style.opacity='0.85'"
               onmouseout="this.style.opacity='1'">
                Masuk Kembali
            </a>
        </div>
    `;
            document.body.prepend(banner);
        }
    </script>

    @stack('scripts')
</body>

</html>
