import re

with open('d:\\Server\\www\\layout_default.html.twig', 'r', encoding='utf-8') as f:
    html = f.read()

fonts = """
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
"""
html = html.replace('</head>', fonts + '\n</head>')

premium_css = """
    <style>
        /* PREMIUM MODERN OVERRIDES */
        body {
            font-family: 'Outfit', sans-serif !important;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%) !important;
            background-attachment: fixed !important;
            color: #333 !important;
            -webkit-font-smoothing: antialiased;
        }
        
        html[data-bs-theme="dark"] body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
            color: #f8fafc !important;
        }

        /* Glassmorphism Cards */
        .card, .box, .panel, .accordion-item {
            background: rgba(255, 255, 255, 0.7) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            border-radius: 16px !important;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15) !important;
            transition: all 0.3s ease !important;
            overflow: hidden !important;
        }
        
        html[data-bs-theme="dark"] .card, 
        html[data-bs-theme="dark"] .box, 
        html[data-bs-theme="dark"] .panel, 
        html[data-bs-theme="dark"] .accordion-item {
            background: rgba(30, 41, 59, 0.7) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3) !important;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.2) !important;
        }

        .card-header, .accordion-button {
            background: transparent !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-weight: 600 !important;
            letter-spacing: 0.5px;
        }
        
        html[data-bs-theme="dark"] .card-header,
        html[data-bs-theme="dark"] .accordion-button {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #f8fafc !important;
        }

        /* Buttons */
        .btn-primary, .btn-dark, .btn {
            border-radius: 8px !important;
            font-weight: 600 !important;
            padding: 10px 24px !important;
            transition: all 0.3s ease !important;
            border: none !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
        }
        
        .btn-primary, .btn-dark {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
        }
        
        .btn-primary:hover, .btn-dark:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(118, 75, 162, 0.4) !important;
        }

        /* Accordion */
        .accordion-button:not(.collapsed) {
            color: #764ba2 !important;
            background: rgba(118, 75, 162, 0.05) !important;
            box-shadow: none !important;
        }
        html[data-bs-theme="dark"] .accordion-button:not(.collapsed) {
            color: #a78bfa !important;
            background: rgba(167, 139, 250, 0.1) !important;
        }

        /* Inputs & Form Elements */
        .form-control, .form-select {
            border-radius: 8px !important;
            border: 1px solid rgba(0,0,0,0.1) !important;
            padding: 12px 16px !important;
            background: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s ease !important;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(118, 75, 162, 0.2) !important;
            border-color: #764ba2 !important;
        }
        html[data-bs-theme="dark"] .form-control, 
        html[data-bs-theme="dark"] .form-select {
            background: rgba(15, 23, 42, 0.8) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            color: white !important;
        }

        /* Lists */
        .list-group-item {
            background: transparent !important;
            border: 1px solid rgba(0,0,0,0.05) !important;
            margin-bottom: 8px !important;
            border-radius: 8px !important;
            transition: all 0.2s ease !important;
        }
        .list-group-item:hover {
            background: rgba(118, 75, 162, 0.05) !important;
            transform: translateX(5px);
            border-color: rgba(118, 75, 162, 0.2) !important;
        }
        html[data-bs-theme="dark"] .list-group-item {
            border: 1px solid rgba(255,255,255,0.05) !important;
        }
        html[data-bs-theme="dark"] .list-group-item:hover {
            background: rgba(167, 139, 250, 0.1) !important;
            border-color: rgba(167, 139, 250, 0.3) !important;
        }

        /* Mobile Responsiveness Fixes */
        @media (max-width: 768px) {
            .input-group {
                flex-direction: column !important;
                max-width: 100% !important;
                width: 100% !important;
            }
            .input-group > .form-control,
            .input-group > .form-select,
            .input-group > .btn {
                width: 100% !important;
                max-width: 100% !important;
                margin-bottom: 8px !important;
                border-radius: 8px !important;
            }
            .nav-pills {
                flex-direction: row !important;
                flex-wrap: wrap !important;
                border-end: none !important;
                border-bottom: 1px solid rgba(0,0,0,0.1) !important;
                margin-bottom: 16px !important;
                margin-right: 0 !important;
            }
            .nav-pills .nav-link {
                margin-right: 8px !important;
                margin-bottom: 8px !important;
            }
            .d-flex.mb-3 {
                flex-direction: column !important;
            }
        }
    </style>
"""

html = html.replace('</head>', premium_css + '\n</head>')

with open('d:\\Server\\www\\layout_default_updated.html.twig', 'w', encoding='utf-8') as f:
    f.write(html)
