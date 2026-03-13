<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dayúnan</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Khula:wght@300;400;700&family=Tenor+Sans&display=swap" rel="stylesheet">

    <style>
        :root {
            --coconut-white: #F5F1EC;
            --jungle-green: #3A5F41;
            --sandstorm-beige: #D8CAB8;
            --terracotta: #C26B4E;
            --soft-bronze: #B08D57;
        }

        body {
            background-color: var(--coconut-white);
            color: var(--jungle-green);
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        /* Typography */
        h1, h2, h3, h4, .tenor-sans {
            font-family: 'Tenor Sans', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
        }

        label, .btn, .khula, .nav-link {
            font-family: 'Khula', sans-serif;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.05rem;
        }

        /* Elements */
        .navbar {
            background-color: var(--coconut-white);
            border-bottom: 1px solid var(--sandstorm-beige);
            padding: 1.5rem 0;
        }

        .navbar-brand {
            font-family: 'Tenor Sans', sans-serif;
            font-size: 1.5rem;
            color: var(--jungle-green) !important;
        }

        .card-minimal {
            background: #ffffff;
            border: 1px solid var(--sandstorm-beige);
            border-radius: 0px; 
            transition: all 0.4s ease;
        }

        .card-minimal:hover {
            border-color: var(--soft-bronze);
        }

        .btn-dayunan {
            background-color: var(--jungle-green);
            color: white;
            border: none;
            padding: 12px 30px;
            transition: background-color 0.3s ease;
        }

        .btn-dayunan:hover {
            background-color: var(--soft-bronze);
            color: white;
        }

        .btn-outline-dayunan {
            border: 1px solid var(--terracotta);
            color: var(--terracotta);
            padding: 12px 30px;
            background: transparent;
        }

        .btn-outline-dayunan:hover {
            background-color: var(--terracotta);
            color: white;
        }

        .text-terracotta { color: var(--terracotta); }
        .text-jungle { color: var(--jungle-green); }
    </style>
</head>
<body>

    @include('layouts.navbar')

    <main class="py-5">
        <div class="container">
            @yield('content') 
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>