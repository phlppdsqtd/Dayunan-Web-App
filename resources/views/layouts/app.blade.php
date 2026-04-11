<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dayúnan</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Khula:wght@300;400;700&family=Tenor+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <style>
        :root {
            --coconut-white: #F5F1EC;
            --jungle-green: #3A5F41;
            --sandstorm-beige: #D8CAB8;
            --terracotta: #C26B4E;
        }

        /* --- FOOTER AT BOTTOM LOGIC --- */
        html, body {
            height: 100%; 
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column; 
            background-color: var(--coconut-white);
            color: var(--jungle-green);
            font-family: 'Cormorant Garamond', serif;
            -webkit-font-smoothing: antialiased;
        }

        main {
            flex: 1 0 auto; 
        }

        footer {
            flex-shrink: 0; 
        }

        /* --- Typography & Buttons (Preserved) --- */
        h1, h2, h3, .tenor-sans {
            font-family: 'Tenor Sans', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.25rem;
        }

        .khula {
            font-family: 'Khula', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.15rem;
            font-size: 0.7rem;
        }

        .btn-dayunan {
            background-color: var(--jungle-green) !important;
            color: white !important;
            border: 1px solid var(--jungle-green) !important;
            padding: 14px 35px;
            border-radius: 0;
            font-family: 'Khula', sans-serif;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.25rem;
            transition: all 0.4s ease;
            display: inline-block;
            text-decoration: none;
        }
    .btn-dayunan:hover {
        background-color: #C04000 !important;
        border-color: #C04000 !important;
        color: white !important;
        transform: translateY(-2px); 
        box-shadow: 0 4px 12px rgba(192, 64, 0, 0.3); 
    }
    .flatpickr-day.disabled,
    .flatpickr-day.disabled:hover,
    .flatpickr-day.prevMonthDay.disabled,
    .flatpickr-day.nextMonthDay.disabled {
        background: #9aa0a6 !important;
        color: #fff !important;
        border-radius: 50% !important;
        opacity: 1 !important;
        cursor: not-allowed !important;
    }
    </style>
</head>
<body class="{{ Request::is('/') ? 'is-home' : 'is-inner' }}">
    
    @include('layouts.navbar')

    <main style="{{ Request::is('/') ? '' : 'padding-top: 100px;' }}">
        @yield('content')
    </main>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>