<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechZone - Máy Tính & Thiết Bị Công Nghệ Chính Hãng</title>
    <meta name="description" content="TechZone - Hệ thống bán lẻ laptop, PC gaming, linh kiện máy tính chính hãng hàng đầu.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary:      #2563eb;
            --primary-dark: #1d4ed8;
            --accent:       #0284c7;
            --navy:         #0f172a;
            --bg-main:      #f1f5f9;
            --bg-card:      #ffffff;
            --border:       #e2e8f0;
            --text-dark:    #0f172a;
            --text-muted:   #64748b;
            --sale-red:     #e53935;
            --sale-red-dk:  #b71c1c;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-main); color: var(--text-dark); min-height: 100vh; }

        /* ===== TOP HEADER ===== */
        .header {
            background: var(--navy);
            position: sticky; top: 0; z-index: 200;
            box-shadow: 0 4px 20px rgba(15,23,42,0.15);
        }
        .header-inner {
            max-width: 1280px; margin: 0 auto;
            padding: 0 24px; display: flex; align-items: center;
            gap: 24px; height: 68px;
        }

        /* Logo */
        .logo {
            font-family: 'Rajdhani', sans-serif;
            font-size: 26px; font-weight: 700;
            text-decoration: none; letter-spacing: 1px;
            white-space: nowrap; flex-shrink: 0;
            display: flex; align-items: center; gap: 0;
        }
        .logo-icon {
            background: linear-gradient(135deg, #2563eb, #0284c7);
            color: #fff; border-radius: 8px;
            width: 36px; height: 36px;
            display: flex; align-items: center; justify-content: center;
            font-size: 17px; margin-right: 9px; flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(37,99,235,0.4);
        }
        .logo-txt-tech { color: #ffffff; }
        .logo-txt-zone {
            color: transparent;
            background: linear-gradient(90deg, #38bdf8, #818cf8);
            -webkit-background-clip: text; background-clip: text;
        }

        /* Search Form */
        .search-wrap { flex: 1; max-width: 560px; }
        .search-form {
            display: flex; background: #ffffff;
            border: 2px solid #38bdf8; border-radius: 10px;
            overflow: hidden; box-shadow: 0 2px 10px rgba(56,189,248,0.25);
            transition: all 0.3s;
        }
        .search-form:focus-within {
            border-color: #0284c7; box-shadow: 0 0 16px rgba(2,132,199,0.35);
        }
        .search-select {
            border: none; background: #f8fafc;
            padding: 0 14px; font-size: 13px; font-weight: 600;
            color: var(--navy); outline: none;
            border-right: 1px solid #cbd5e1; cursor: pointer; max-width: 140px;
        }
        .search-select option { background: #ffffff; color: var(--navy); }
        .search-input {
            flex: 1; border: none; background: transparent;
            padding: 11px 16px; font-size: 14px;
            color: var(--navy); outline: none;
            font-family: 'Inter', sans-serif; font-weight: 500;
        }
        .search-input::placeholder { color: #94a3b8; }
        .search-btn {
            border: none; background: linear-gradient(135deg, var(--primary), var(--accent));
            padding: 0 22px; color: #ffffff; font-size: 16px;
            cursor: pointer; transition: opacity 0.2s;
        }
        .search-btn:hover { opacity: 0.9; }

        /* Header Right */
        .hdr-right { display: flex; align-items: center; gap: 14px; margin-left: auto; white-space: nowrap; }
        .user-chip {
            display: flex; align-items: center; gap: 8px;
            font-size: 13.5px; color: #e2e8f0; font-weight: 500;
        }
        .user-chip i { color: #38bdf8; font-size: 16px; }
        .hdr-btn {
            padding: 8px 18px; border-radius: 8px; font-size: 13px;
            font-weight: 600; text-decoration: none; display: inline-flex;
            align-items: center; gap: 6px; transition: all 0.2s;
        }
        .hdr-btn.login {
            background: rgba(255,255,255,0.12); color: #ffffff;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .hdr-btn.login:hover { background: rgba(255,255,255,0.22); }
        .hdr-btn.logout {
            background: rgba(239,68,68,0.15); color: #fca5a5;
            border: 1px solid rgba(239,68,68,0.3);
        }
        .hdr-btn.logout:hover { background: rgba(239,68,68,0.3); }
        .hdr-btn.admin {
            background: #10b981; color: #ffffff; font-weight: 700;
        }
        .hdr-btn.admin:hover { background: #059669; }

        /* ===== NAVIGATION BAR ===== */
        .nav-bar {
            background: #1e293b;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .nav-inner {
            max-width: 1280px; margin: 0 auto;
            padding: 0 24px; display: flex; gap: 4px;
            overflow-x: auto;
        }
        .nav-inner::-webkit-scrollbar { display: none; }
        .nav-link {
            color: #cbd5e1; text-decoration: none;
            font-size: 13.5px; font-weight: 500;
            padding: 12px 18px; white-space: nowrap;
            transition: all 0.2s; border-bottom: 3px solid transparent;
            display: flex; align-items: center; gap: 8px;
        }
        .nav-link:hover, .nav-link.active {
            color: #ffffff; border-bottom-color: #38bdf8;
            background: rgba(255,255,255,0.04);
        }

        /* ===== MAIN CONTAINER ===== */
        .container { max-width: 1280px; margin: 28px auto; padding: 0 24px; }

        /* ===== HERO BANNER ===== */
        .hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #1e3a8a 100%);
            border-radius: 16px; padding: 44px 56px;
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 30px; position: relative; overflow: hidden;
            box-shadow: 0 10px 30px rgba(15,23,42,0.12);
        }
        .hero-text { position: relative; z-index: 2; }
        .hero-badge {
            display: inline-block; background: #38bdf8; color: var(--navy);
            font-size: 11px; font-weight: 700; padding: 4px 12px;
            border-radius: 20px; text-transform: uppercase; letter-spacing: 1px;
            margin-bottom: 14px;
        }
        .hero-title {
            font-family: 'Rajdhani', sans-serif;
            font-size: 40px; font-weight: 700; color: #ffffff;
            line-height: 1.15; margin-bottom: 12px; letter-spacing: 0.5px;
        }
        .hero-title span { color: #38bdf8; }
        .hero-sub { font-size: 14.5px; color: #94a3b8; margin-bottom: 24px; }
        .btn-hero {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #ffffff; padding: 13px 30px; border-radius: 10px;
            text-decoration: none; font-size: 14px; font-weight: 700;
            transition: all 0.25s; box-shadow: 0 6px 20px rgba(37,99,235,0.4);
        }
        .btn-hero:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(37,99,235,0.55); }
        .hero-icon { font-size: 120px; color: rgba(255,255,255,0.08); position: relative; z-index: 2; }

        /* ===== FEATURES STRIP ===== */
        .features {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 16px; margin-bottom: 32px;
        }
        .feature-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 12px; padding: 18px 20px;
            display: flex; align-items: center; gap: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03); transition: transform 0.2s;
        }
        .feature-card:hover { transform: translateY(-2px); }
        .feat-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .fi-blue   { background: #e0f2fe; color: #0284c7; }
        .fi-purple { background: #f3e8ff; color: #9333ea; }
        .fi-green  { background: #dcfce7; color: #16a34a; }
        .fi-orange { background: #ffedd5; color: #ea580c; }
        .feat-text h4 { font-size: 14px; font-weight: 700; color: var(--text-dark); }
        .feat-text p  { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

        /* ===== FLASH SALE SECTION ===== */
        .flash-sale-section {
            margin-bottom: 40px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(229,57,53,0.18);
        }

        .flash-sale-header {
            background: linear-gradient(90deg, var(--sale-red-dk) 0%, var(--sale-red) 50%, #ff6f00 100%);
            padding: 0 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 62px;
            gap: 20px;
        }
        .flash-sale-title {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }
        .flash-sale-title .lightning-icon {
            font-size: 26px;
            color: #FFD600;
            filter: drop-shadow(0 0 6px #FFD600);
            animation: pulse-icon 1.4s ease-in-out infinite;
        }
        @keyframes pulse-icon {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.18); }
        }
        .flash-sale-title h2 {
            font-family: 'Rajdhani', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 1px;
            text-shadow: 0 2px 8px rgba(0,0,0,0.2);
            white-space: nowrap;
        }
        .flash-sale-title .sale-sub {
            font-size: 12px;
            color: rgba(255,255,255,0.85);
            font-weight: 500;
            white-space: nowrap;
        }

        .sale-wave {
            flex: 1;
            height: 3px;
            background: repeating-linear-gradient(90deg, rgba(255,255,255,0.6) 0, rgba(255,255,255,0.6) 8px, transparent 8px, transparent 16px);
            background-size: 200% 100%;
            animation: wave-move 2s linear infinite;
            border-radius: 4px;
            margin: 0 16px;
        }
        @keyframes wave-move {
            0% { background-position: 0 0; }
            100% { background-position: 200% 0; }
        }

        .flash-see-all {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.18);
            border: 1.5px solid rgba(255,255,255,0.5);
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            padding: 7px 18px;
            border-radius: 8px;
            text-decoration: none;
            white-space: nowrap;
            transition: background 0.2s;
            flex-shrink: 0;
        }
        .flash-see-all:hover { background: rgba(255,255,255,0.30); }

        .flash-sale-body {
            background: linear-gradient(180deg, #fff3e0 0%, #ffffff 60%);
            padding: 20px 24px 24px;
            border: 2px solid var(--sale-red);
            border-top: none;
            border-radius: 0 0 16px 16px;
        }

        .flash-sale-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
        }

        /* Sale Card */
        .sale-card {
            background: #ffffff;
            border: 1.5px solid #ffcdd2;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            position: relative;
            transition: all 0.25s ease;
            box-shadow: 0 2px 10px rgba(229,57,53,0.06);
            display: flex;
            flex-direction: column;
        }
        .sale-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(229,57,53,0.18);
            border-color: var(--sale-red);
        }

        .sale-discount-badge {
            position: absolute;
            top: 10px; left: 10px;
            z-index: 2;
            background: linear-gradient(135deg, var(--sale-red-dk), var(--sale-red));
            color: #ffffff;
            font-size: 11px; font-weight: 800;
            padding: 3px 9px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(229,57,53,0.35);
        }

        .sale-card-img-wrap {
            height: 160px;
            background: #fff;
            display: flex; align-items: center; justify-content: center;
            padding: 14px;
            border-bottom: 1px solid #ffebee;
        }
        .sale-card-img {
            max-width: 100%; max-height: 132px; object-fit: contain;
            transition: transform 0.3s;
        }
        .sale-card:hover .sale-card-img { transform: scale(1.07); }

        .sale-card-body { padding: 12px 14px; flex: 1; display: flex; flex-direction: column; }
        .sale-card-cat {
            font-size: 10px; font-weight: 700; color: var(--sale-red);
            text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;
        }
        .sale-card-name {
            font-size: 13px; font-weight: 600; color: var(--text-dark);
            line-height: 1.4; height: 36px; overflow: hidden;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
            margin-bottom: 8px;
        }
        .sale-price-row { display: flex; align-items: baseline; gap: 6px; flex-wrap: wrap; margin-bottom: 3px; }
        .sale-price-new {
            font-family: 'Rajdhani', sans-serif;
            font-size: 19px; font-weight: 700; color: var(--sale-red);
        }
        .sale-price-old {
            font-size: 11.5px; color: #9e9e9e;
            text-decoration: line-through;
        }

        .sale-stock-bar { margin-top: 8px; }
        .sale-stock-label {
            display: flex; justify-content: space-between;
            font-size: 10.5px; color: var(--text-muted); margin-bottom: 4px;
        }
        .sale-stock-label .sold-txt { color: var(--sale-red); font-weight: 600; }
        .progress-track {
            height: 5px; background: #ffcdd2; border-radius: 10px; overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--sale-red), #ff6f00);
            border-radius: 10px; transition: width 0.6s ease;
        }

        .sale-card-btn { margin-top: 10px; display: flex; gap: 5px; }
        .sale-btn {
            flex: 1; display: inline-flex; align-items: center; justify-content: center;
            gap: 5px; padding: 8px 6px;
            border-radius: 7px; font-size: 12px; font-weight: 600;
            text-decoration: none; transition: all 0.2s; font-family: 'Inter', sans-serif;
        }
        .sale-btn.detail {
            background: #fff3e0; color: var(--sale-red); border: 1.5px solid #ffccbc;
        }
        .sale-btn.detail:hover { background: #ffe0b2; }
        .sale-btn.cart {
            background: var(--sale-red); color: #ffffff; border: 1.5px solid var(--sale-red);
        }
        .sale-btn.cart:hover { background: var(--sale-red-dk); }

        /* ===== SECTION TITLE ===== */
        .section-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 20px; padding-bottom: 12px;
            border-bottom: 2px solid var(--border);
        }
        .section-title {
            font-size: 20px; font-weight: 700; color: var(--text-dark);
            display: flex; align-items: center; gap: 10px;
        }
        .section-title i { color: var(--primary); }
        .see-all {
            font-size: 13.5px; color: var(--primary); text-decoration: none;
            font-weight: 600; display: flex; align-items: center; gap: 6px;
        }
        .see-all:hover { text-decoration: underline; }

        /* ===== PRODUCT GRID ===== */
        .product-grid {
            display: grid; grid-template-columns: repeat(5, 1fr);
            gap: 18px; margin-bottom: 44px;
        }

        /* ===== PRODUCT CARD ===== */
        .product-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 14px; overflow: hidden; cursor: pointer;
            position: relative; transition: all 0.25s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            display: flex; flex-direction: column;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(37,99,235,0.15);
            border-color: #93c5fd;
        }
        .card-hot-badge {
            position: absolute; top: 12px; left: 12px; z-index: 2;
            background: #ef4444; color: #ffffff;
            font-size: 11px; font-weight: 700; padding: 3px 9px;
            border-radius: 6px; box-shadow: 0 2px 6px rgba(239,68,68,0.3);
        }
        .card-img-wrap {
            height: 180px; background: #ffffff;
            display: flex; align-items: center; justify-content: center;
            padding: 16px; border-bottom: 1px solid #f1f5f9;
        }
        .card-img {
            max-width: 100%; max-height: 148px; object-fit: contain;
            transition: transform 0.3s;
        }
        .product-card:hover .card-img { transform: scale(1.06); }
        .card-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
        .card-cat {
            font-size: 11px; font-weight: 600; color: #0284c7;
            text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;
        }
        .card-name {
            font-size: 14px; font-weight: 600; color: var(--text-dark);
            line-height: 1.45; height: 40px; overflow: hidden;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
            margin-bottom: 10px;
        }
        .card-price {
            font-family: 'Rajdhani', sans-serif;
            font-size: 20px; font-weight: 700; color: #dc2626; margin-bottom: 4px;
        }
        .card-price-original {
            font-size: 12.5px; color: #94a3b8;
            text-decoration: line-through; margin-bottom: 4px;
        }
        .card-sale-badge {
            display: inline-block; background: #ef4444; color: #fff;
            font-size: 10px; font-weight: 800; padding: 2px 7px;
            border-radius: 4px; margin-left: 4px; vertical-align: middle;
        }
        .card-stock { font-size: 11.5px; color: var(--text-muted); margin-bottom: 14px; }
        .card-stock span { color: #16a34a; font-weight: 600; }
        .btn-detail {
            margin-top: auto; display: block; width: 100%;
            background: #f1f5f9; color: var(--primary);
            border: 1px solid #cbd5e1; padding: 10px;
            border-radius: 8px; font-size: 13px; font-weight: 600;
            text-align: center; text-decoration: none;
            transition: all 0.2s; font-family: 'Inter', sans-serif;
        }
        .btn-detail:hover {
            background: var(--primary); color: #ffffff;
            border-color: var(--primary); box-shadow: 0 4px 14px rgba(37,99,235,0.3);
        }
        .no-product {
            grid-column: 1 / -1; text-align: center;
            padding: 60px 20px; color: var(--text-muted); font-size: 15px;
            background: #ffffff; border-radius: 14px; border: 1px solid var(--border);
        }
        .no-product i { font-size: 48px; display: block; margin-bottom: 12px; color: #cbd5e1; }

        /* Search Info Bar */
        .search-bar-info {
            background: #ffffff; border: 1px solid var(--border);
            border-left: 4px solid var(--primary);
            border-radius: 10px; padding: 14px 20px;
            margin-bottom: 24px; font-size: 14px; color: var(--text-muted);
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        .search-bar-info strong { color: var(--text-dark); }

        /* ===== FOOTER MODERN ===== */
        .footer {
            background: #0f172a;
            color: #94a3b8;
            padding-top: 50px;
            border-top: 3px solid #2563eb;
            font-size: 13.5px;
            margin-top: 60px;
        }
        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            display: grid;
            grid-template-columns: 2fr 1.3fr 1.5fr 1.2fr;
            gap: 36px;
            padding-bottom: 40px;
        }
        .footer-col-title {
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 18px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            padding-bottom: 8px;
        }
        .footer-col-title::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 36px; height: 2px;
            background: #38bdf8;
            border-radius: 2px;
        }
        .footer-contact-list { list-style: none; padding: 0; margin: 0; }
        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 12px;
            line-height: 1.5;
        }
        .footer-contact-item i {
            color: #38bdf8;
            font-size: 16px;
            margin-top: 2px;
            flex-shrink: 0;
        }
        .footer-contact-item a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-contact-item a:hover { color: #38bdf8; }

        .footer-links { list-style: none; padding: 0; margin: 0; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a {
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .footer-links a:hover {
            color: #38bdf8;
            transform: translateX(4px);
        }

        /* QR Payment Card */
        .qr-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 14px;
            text-align: center;
            box-shadow: 0 4px 16px rgba(0,0,0,0.3);
        }
        .qr-card-title {
            font-size: 12px;
            font-weight: 700;
            color: #38bdf8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .qr-img {
            width: 140px;
            height: 140px;
            object-fit: contain;
            border-radius: 8px;
            background: #ffffff;
            padding: 6px;
            margin: 0 auto 8px;
            display: block;
        }
        .qr-info-name { font-size: 13px; font-weight: 700; color: #ffffff; }
        .qr-info-sub { font-size: 11px; color: #94a3b8; }

        /* Social Buttons */
        .social-btn-group { display: flex; flex-direction: column; gap: 10px; }
        .social-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 10px;
            color: #ffffff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.25s;
        }
        .social-btn.fb { background: #1877f2; }
        .social-btn.fb:hover { background: #166fe5; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(24,119,242,0.4); }
        .social-btn.tiktok { background: #000000; border: 1px solid #334155; }
        .social-btn.tiktok:hover { background: #111111; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.5); }
        .social-btn.phone { background: linear-gradient(135deg, #10b981, #059669); }
        .social-btn.phone:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(16,185,129,0.4); }

        .footer-bottom {
            background: #020617;
            border-top: 1px solid #1e293b;
            padding: 20px 24px;
            text-align: center;
            font-size: 12.5px;
            color: #64748b;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .flash-sale-grid, .product-grid { grid-template-columns: repeat(3, 1fr); }
            .features { grid-template-columns: repeat(2, 1fr); }
            .footer-container { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 600px) {
            .flash-sale-grid, .product-grid { grid-template-columns: repeat(2, 1fr); }
            .features { grid-template-columns: 1fr; }
            .footer-container { grid-template-columns: 1fr; }
        }

        /* ===== TOAST THÔNG BÁO ===== */
        .toast-wrap {
            position: fixed; top: 24px; right: 24px; z-index: 9999;
            display: flex; flex-direction: column; gap: 10px;
        }
        .toast {
            display: flex; align-items: center; gap: 12px;
            background: #ffffff; color: var(--text-dark);
            border-left: 5px solid #22c55e;
            border-radius: 10px; padding: 14px 18px;
            min-width: 280px; max-width: 360px;
            box-shadow: 0 10px 30px rgba(15,23,42,0.18);
            font-size: 14px; font-weight: 600;
            opacity: 0; transform: translateX(30px);
            animation: toast-in 0.35s ease forwards, toast-out 0.4s ease forwards 3.2s;
        }
        .toast i.toast-icon { color: #22c55e; font-size: 20px; flex-shrink: 0; }
        .toast-close {
            margin-left: auto; cursor: pointer; color: #94a3b8;
            background: none; border: none; font-size: 14px; flex-shrink: 0;
        }
        .toast-close:hover { color: var(--text-dark); }
        @keyframes toast-in {
            from { opacity: 0; transform: translateX(30px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes toast-out {
            from { opacity: 1; transform: translateX(0); }
            to   { opacity: 0; transform: translateX(30px); }
        }
    </style>
</head>
<body>

<?php if (isset($_GET['login_success']) && $_GET['login_success'] == '1' && isset($_SESSION['user'])): ?>
<div class="toast-wrap" id="toastWrap">
    <div class="toast" id="loginToast">
        <i class="fa-solid fa-circle-check toast-icon"></i>
        <span>Đăng nhập thành công! Xin chào <?= htmlspecialchars($_SESSION['user']['username'] ?? '') ?> 👋</span>
        <button type="button" class="toast-close" onclick="this.closest('.toast').remove()">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
<script>
    // Tự động ẩn thông báo sau vài giây và xóa tham số login_success khỏi URL
    setTimeout(function () {
        var toast = document.getElementById('loginToast');
        if (toast) toast.remove();
    }, 3600);
    if (window.history && window.history.replaceState) {
        var url = new URL(window.location.href);
        url.searchParams.delete('login_success');
        window.history.replaceState({}, document.title, url.pathname + url.search + url.hash);
    }
</script>
<?php endif; ?>

<!-- ===== HEADER ===== -->
<header class="header">
    <div class="header-inner">
        <a href="index.php?role=client&action=home" class="logo">
            <span class="logo-icon"><i class="fa-solid fa-microchip"></i></span>
            <span class="logo-txt-tech">TECH</span><span class="logo-txt-zone">ZONE</span>
        </a>
        <div class="search-wrap">
            <form action="index.php" method="GET" class="search-form">
                <input type="hidden" name="role" value="client">
                <input type="hidden" name="action" value="search">
                <select name="category" class="search-select" onchange="this.form.submit()">
                    <option value="all">Tất cả danh mục</option>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"
                                <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <input type="text" name="keyword" class="search-input"
                       value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>"
                       placeholder="Nhập sản phẩm máy tính, linh kiện cần tìm...">
                <button type="submit" class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
        <div class="hdr-right">
            <?php
                $cartCount = array_sum(array_column($_SESSION['cart'] ?? [], 'quantity'));
            ?>
            <a href="index.php?role=client&action=cart" class="hdr-btn" style="background:#0284c7; color:#ffffff; position:relative;">
                <i class="fa-solid fa-cart-shopping"></i> Giỏ hàng
                <?php if ($cartCount > 0): ?>
                    <span style="background:#ef4444; color:#ffffff; font-size:10px; font-weight:700; padding:1px 6px; border-radius:10px; margin-left:4px;"><?= $cartCount ?></span>
                <?php endif; ?>
            </a>
            <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])): ?>
                <a href="index.php?role=client&action=profile" class="user-chip" style="text-decoration:none;">
                    <i class="fa-solid fa-circle-user"></i>
                    <?= htmlspecialchars($_SESSION['user']['username'] ?? 'User') ?>
                </a>
                <?php
                    $roleCheck = strtolower(trim($_SESSION['user']['role'] ?? ''));
                    if ($roleCheck === 'admin'):
                ?>
                    <a href="index.php?role=admin&action=home" class="hdr-btn admin">
                        <i class="fa-solid fa-gauge-high"></i> Trang Admin
                    </a>
                <?php endif; ?>
                <a href="index.php?role=client&action=logout" class="hdr-btn logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                </a>
            <?php else: ?>
                <a href="index.php?role=client&action=login" class="hdr-btn login">
                    <i class="fa-solid fa-right-to-bracket"></i> Đăng nhập
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- ===== NAVIGATION BAR ===== -->
<nav class="nav-bar">
    <div class="nav-inner">
        <a href="index.php?role=client&action=home"
           class="nav-link <?= (empty($_GET['category']) && (empty($_GET['action']) || $_GET['action'] === 'home')) ? 'active' : '' ?>">
            <i class="fa-solid fa-house"></i> Trang chủ
        </a>
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $cat): ?>
                <a href="index.php?role=client&action=search&category=<?= $cat['id'] ?>"
                   class="nav-link <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'active' : '' ?>">
                    <?= htmlspecialchars($cat['name']) ?>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
        <a href="index.php?role=client&action=cart" class="nav-link <?= (($_GET['action'] ?? '') === 'cart') ? 'active' : '' ?>">
            <i class="fa-solid fa-cart-shopping"></i> Giỏ hàng (<?= $cartCount ?>)
        </a>
        <a href="index.php?role=client&action=search" class="nav-link">
            <i class="fa-solid fa-layer-group"></i> Tất cả sản phẩm
        </a>
    </div>
</nav>

<!-- ===== MAIN CONTENT ===== -->
<div class="container">

<?php
    $isSearch  = isset($_GET['action']) && $_GET['action'] === 'search';
    $keyword   = trim($_GET['keyword'] ?? '');
    $catFilter = $_GET['category'] ?? 'all';
?>

<?php if (!$isSearch): ?>
<!-- HERO BANNER -->
<div class="hero">
    <div class="hero-text">
        <span class="hero-badge">✦ CHÍNH HÃNG 100%</span>
        <h1 class="hero-title">
            Thế giới <span>MÁY TÍNH</span> &amp; Công nghệ<br>Chất lượng hàng đầu!
        </h1>
        <p class="hero-sub">Laptop, PC Gaming, Màn hình &amp; Linh kiện chính hãng — Giá luôn tốt nhất.</p>
        <a href="index.php?role=client&action=search" class="btn-hero">
            <i class="fa-solid fa-cart-shopping"></i> Khám phá sản phẩm
        </a>
    </div>
    <div class="hero-icon"><i class="fa-solid fa-desktop"></i></div>
</div>

<!-- FEATURES STRIP -->
<div class="features">
    <div class="feature-card">
        <div class="feat-icon fi-blue"><i class="fa-solid fa-shield-halved"></i></div>
        <div class="feat-text"><h4>Hàng chính hãng</h4><p>100% tem bảo hành NSX</p></div>
    </div>
    <div class="feature-card">
        <div class="feat-icon fi-purple"><i class="fa-solid fa-truck-fast"></i></div>
        <div class="feat-text"><h4>Giao hàng siêu tốc</h4><p>Nội thành trong 2-4 giờ</p></div>
    </div>
    <div class="feature-card">
        <div class="feat-icon fi-green"><i class="fa-solid fa-arrows-rotate"></i></div>
        <div class="feat-text"><h4>Đổi trả 30 ngày</h4><p>Nếu có lỗi từ nhà sản xuất</p></div>
    </div>
    <div class="feature-card">
        <div class="feat-icon fi-orange"><i class="fa-solid fa-headset"></i></div>
        <div class="feat-text"><h4>Tư vấn 24/7</h4><p>Hỗ trợ kỹ thuật miễn phí</p></div>
    </div>
</div>

<!-- ===== FLASH SALE SECTION (Chỉ hiện khi có sản phẩm đang sale) ===== -->
<?php
    $saleProducts = $saleProducts ?? [];
?>
<?php if (!empty($saleProducts)): ?>
<div class="flash-sale-section" id="flash-sale-section">
    <!-- Header đỏ nổi bật -->
    <div class="flash-sale-header">
        <div class="flash-sale-title">
            <i class="fa-solid fa-bolt lightning-icon"></i>
            <div>
                <h2>FLASH SALE</h2>
                <div class="sale-sub">Ưu đãi có thời hạn – Săn ngay kẻo hết!</div>
            </div>
        </div>
        <div class="sale-wave"></div>
        <a href="index.php?role=client&action=search" class="flash-see-all">
            Xem tất cả <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <!-- Lưới sản phẩm sale -->
    <div class="flash-sale-body">
        <div class="flash-sale-grid">
            <?php foreach ($saleProducts as $sItem):
                $sImg      = !empty($sItem['image_url']) ? (BASE_ASSETS_UPLOADS . $sItem['image_url']) : 'https://placehold.co/300x300?text=No+Image';
                $sName     = $sItem['pro_name'] ?? $sItem['name'] ?? 'Sản phẩm';
                $sQty      = (int)($sItem['quantity'] ?? 0);
                $sOldPrice = (float)($sItem['price'] ?? 0);
                $sNewPrice = (float)($sItem['sale_price'] ?? 0);
                $sDiscount = ($sOldPrice > 0) ? round((($sOldPrice - $sNewPrice) / $sOldPrice) * 100) : 0;
                $maxQty    = max($sQty + 5, 15);
                $soldPct   = max(15, min(92, round((1 - $sQty / $maxQty) * 100)));
            ?>
            <div class="sale-card" onclick="window.location='index.php?role=client&action=product-detail&id=<?= $sItem['id'] ?>'">
                <div class="sale-discount-badge">-<?= $sDiscount ?>%</div>
                <div class="sale-card-img-wrap">
                    <img src="<?= htmlspecialchars($sImg) ?>"
                         alt="<?= htmlspecialchars($sName) ?>"
                         class="sale-card-img"
                         onerror="this.src='https://placehold.co/300x300?text=No+Image'">
                </div>
                <div class="sale-card-body">
                    <?php if (!empty($sItem['cat_name'])): ?>
                        <div class="sale-card-cat"><?= htmlspecialchars($sItem['cat_name']) ?></div>
                    <?php endif; ?>
                    <div class="sale-card-name"><?= htmlspecialchars($sName) ?></div>
                    <div class="sale-price-row">
                        <span class="sale-price-new"><?= number_format($sNewPrice, 0, ',', '.') ?> đ</span>
                        <span class="sale-price-old"><?= number_format($sOldPrice, 0, ',', '.') ?> đ</span>
                    </div>
                    <div class="sale-stock-bar">
                        <div class="sale-stock-label">
                            <span class="sold-txt">Đang bán chạy</span>
                            <span>Còn <?= $sQty ?></span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill" style="width:<?= $soldPct ?>%"></div>
                        </div>
                    </div>
                    <div class="sale-card-btn" onclick="event.stopPropagation()">
                        <a href="index.php?role=client&action=product-detail&id=<?= $sItem['id'] ?>" class="sale-btn detail">
                            <i class="fa-solid fa-eye"></i> Chi tiết
                        </a>
                        <a href="index.php?role=client&action=add-to-cart&id=<?= $sItem['id'] ?>&redirect=home" class="sale-btn cart">
                            <i class="fa-solid fa-cart-plus"></i> Giỏ
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php endif; ?>

<?php
    $now = new DateTime();
    $hotProducts = $hotProducts ?? [];
?>

<?php if (!$isSearch && !empty($hotProducts)): ?>
<!-- SẢN PHẨM NỔI BẬT (HOT) SECTION -->
<div class="section-header" style="margin-top: 10px;">
    <div class="section-title" style="color: #dc2626;">
        <i class="fa-solid fa-fire-flame-curved" style="color: #dc2626;"></i>
        SẢN PHẨM NỔI BẬT (HOT)
    </div>
    <a href="index.php?role=client&action=search" class="see-all">
        Xem tất cả <i class="fa-solid fa-arrow-right"></i>
    </a>
</div>

<div class="product-grid">
    <?php foreach ($hotProducts as $item):
        $imgSrc  = !empty($item['image_url']) ? (BASE_ASSETS_UPLOADS . $item['image_url']) : 'https://placehold.co/300x300?text=No+Image';
        $proName = $item['pro_name'] ?? $item['name'] ?? 'Sản phẩm';
        $qty     = (int)($item['quantity'] ?? 0);
        $hasSale = !empty($item['sale_price']) && $item['sale_price'] > 0 && $item['sale_price'] < ($item['price'] ?? 0)
                   && ( (empty($item['sale_start']) && empty($item['sale_end'])) || (!empty($item['sale_end']) && new DateTime($item['sale_end']) > $now) );
        $discount = ($hasSale && $item['price'] > 0)
                  ? round((($item['price'] - $item['sale_price']) / $item['price']) * 100) : 0;
    ?>
    <div class="product-card" onclick="window.location='index.php?role=client&action=product-detail&id=<?= $item['id'] ?>'">
        <div class="card-hot-badge"><i class="fa-solid fa-bolt"></i> HOT</div>
        <div class="card-img-wrap">
            <img src="<?= htmlspecialchars($imgSrc) ?>"
                 alt="<?= htmlspecialchars($proName) ?>"
                 class="card-img"
                 onerror="this.src='https://placehold.co/300x300?text=No+Image'">
        </div>
        <div class="card-body">
            <?php if (!empty($item['cat_name'])): ?>
                <div class="card-cat"><?= htmlspecialchars($item['cat_name']) ?></div>
            <?php endif; ?>
            <div class="card-name"><?= htmlspecialchars($proName) ?></div>
            <?php if ($hasSale): ?>
                <div class="card-price-original"><?= number_format($item['price'] ?? 0, 0, ',', '.') ?> đ</div>
                <div class="card-price">
                    <?= number_format($item['sale_price'], 0, ',', '.') ?> đ
                    <span class="card-sale-badge">-<?= $discount ?>%</span>
                </div>
            <?php else: ?>
                <div class="card-price"><?= number_format($item['price'] ?? 0, 0, ',', '.') ?> đ</div>
            <?php endif; ?>
            <div class="card-stock">Còn kho: <span><?= $qty ?> sản phẩm</span></div>
            <div style="display:flex; gap:6px; margin-top:auto;" onclick="event.stopPropagation()">
                <a href="index.php?role=client&action=product-detail&id=<?= $item['id'] ?>" class="btn-detail" style="flex:1;">
                    <i class="fa-solid fa-eye"></i> Chi tiết
                </a>
                <a href="index.php?role=client&action=add-to-cart&id=<?= $item['id'] ?>&redirect=home"
                   class="btn-detail" style="background:#2563eb; color:#ffffff; border-color:#2563eb; padding:10px 8px;">
                    <i class="fa-solid fa-cart-plus"></i> Giỏ
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php if ($isSearch): ?>
<!-- SEARCH RESULT BAR -->
<div class="search-bar-info">
    <?php
        $catName = 'Tất cả danh mục';
        if ($catFilter !== 'all' && is_numeric($catFilter) && !empty($categories)) {
            foreach ($categories as $c) {
                if ($c['id'] == $catFilter) { $catName = $c['name']; break; }
            }
        }
    ?>
    <i class="fa-solid fa-magnifying-glass" style="color:var(--primary); margin-right:6px;"></i>
    Kết quả tìm kiếm
    <?php if (!empty($keyword)): ?>
        cho từ khóa <strong>"<?= htmlspecialchars($keyword) ?>"</strong>
    <?php endif; ?>
    <?php if ($catFilter !== 'all'): ?>
        &nbsp;·&nbsp; Danh mục: <strong><?= htmlspecialchars($catName) ?></strong>
    <?php endif; ?>
    &nbsp;·&nbsp; Tìm thấy <strong><?= count($products ?? []) ?></strong> sản phẩm.
</div>
<?php endif; ?>

<!-- PRODUCTS SECTION -->
<div class="section-header">
    <div class="section-title">
        <i class="fa-solid fa-layer-group"></i>
        <?= $isSearch ? 'KẾT QUẢ TÌM KIẾM' : 'SẢN PHẨM MỚI NHẤT' ?>
    </div>
    <?php if (!$isSearch): ?>
        <a href="index.php?role=client&action=search" class="see-all">
            Xem tất cả <i class="fa-solid fa-arrow-right"></i>
        </a>
    <?php endif; ?>
</div>

<div class="product-grid">
<?php if (!empty($products)): ?>
    <?php foreach ($products as $item):
        $imgSrc  = !empty($item['image_url']) ? (BASE_ASSETS_UPLOADS . $item['image_url']) : 'https://placehold.co/300x300?text=No+Image';
        $proName = $item['pro_name'] ?? $item['name'] ?? 'Sản phẩm';
        $qty     = (int)($item['quantity'] ?? 0);
        $hasSale = !empty($item['sale_price']) && $item['sale_price'] > 0 && $item['sale_price'] < ($item['price'] ?? 0)
                   && ( (empty($item['sale_start']) && empty($item['sale_end'])) || (!empty($item['sale_end']) && new DateTime($item['sale_end']) > $now) );
        $discount = ($hasSale && $item['price'] > 0)
                  ? round((($item['price'] - $item['sale_price']) / $item['price']) * 100) : 0;
    ?>
    <div class="product-card" onclick="window.location='index.php?role=client&action=product-detail&id=<?= $item['id'] ?>'">
        <?php if ($hasSale): ?>
            <div class="card-hot-badge" style="background:linear-gradient(135deg,#dc2626,#ef4444);">
                <i class="fa-solid fa-tags"></i> SALE -<?= $discount ?>%
            </div>
        <?php elseif (!empty($item['is_hot'])): ?>
            <div class="card-hot-badge"><i class="fa-solid fa-bolt"></i> HOT</div>
        <?php endif; ?>
        <div class="card-img-wrap">
            <img src="<?= htmlspecialchars($imgSrc) ?>"
                 alt="<?= htmlspecialchars($proName) ?>"
                 class="card-img"
                 onerror="this.src='https://placehold.co/300x300?text=No+Image'">
        </div>
        <div class="card-body">
            <?php if (!empty($item['cat_name'])): ?>
                <div class="card-cat"><?= htmlspecialchars($item['cat_name']) ?></div>
            <?php endif; ?>
            <div class="card-name"><?= htmlspecialchars($proName) ?></div>
            <?php if ($hasSale): ?>
                <div class="card-price-original"><?= number_format($item['price'] ?? 0, 0, ',', '.') ?> đ</div>
                <div class="card-price">
                    <?= number_format($item['sale_price'], 0, ',', '.') ?> đ
                    <span class="card-sale-badge">-<?= $discount ?>%</span>
                </div>
            <?php else: ?>
                <div class="card-price"><?= number_format($item['price'] ?? 0, 0, ',', '.') ?> đ</div>
            <?php endif; ?>
            <div class="card-stock">Còn kho: <span><?= $qty ?> sản phẩm</span></div>
            <div style="display:flex; gap:6px; margin-top:auto;" onclick="event.stopPropagation()">
                <a href="index.php?role=client&action=product-detail&id=<?= $item['id'] ?>" class="btn-detail" style="flex:1;">
                    <i class="fa-solid fa-eye"></i> Chi tiết
                </a>
                <a href="index.php?role=client&action=add-to-cart&id=<?= $item['id'] ?>&redirect=home"
                   class="btn-detail" style="background:#2563eb; color:#ffffff; border-color:#2563eb; padding:10px 8px;">
                    <i class="fa-solid fa-cart-plus"></i> Giỏ
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="no-product">
        <i class="fa-regular fa-face-frown"></i>
        Không tìm thấy sản phẩm nào phù hợp.
    </div>
<?php endif; ?>
</div>

</div><!-- /container -->

<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div class="footer-container">
        <!-- Col 1: Thông tin thương hiệu & Liên hệ -->
        <div>
            <div class="logo" style="margin-bottom:14px; font-size:24px;">
                <span class="logo-icon" style="width:34px; height:34px; font-size:15px;"><i class="fa-solid fa-microchip"></i></span>
                <span class="logo-txt-tech">TECH</span><span class="logo-txt-zone">ZONE</span>
            </div>
            <p style="margin-bottom:16px; line-height:1.6; color:#94a3b8; font-size:13px;">
                Hệ thống bán lẻ máy tính, laptop, PC Gaming &amp; linh kiện công nghệ chính hãng hàng đầu Việt Nam.
            </p>
            <ul class="footer-contact-list">
                <li class="footer-contact-item">
                    <i class="fa-solid fa-phone-volume"></i>
                    <div>
                        <strong>Hotline tư vấn mua hàng:</strong><br>
                        <a href="tel:0971820307" style="font-size:16px; font-weight:700; color:#38bdf8;">0971 820 307</a>
                    </div>
                </li>
                <li class="footer-contact-item">
                    <i class="fa-solid fa-envelope"></i>
                    <div>
                        <strong>Email hỗ trợ:</strong><br>
                        <a href="mailto:lebinhquyet2103@gmail.com">lebinhquyet2103@gmail.com</a>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Col 2: Hỗ trợ khách hàng -->
        <div>
            <h4 class="footer-col-title">Hỗ trợ khách hàng</h4>
            <ul class="footer-links">
                <li><a href="#"><i class="fa-solid fa-angle-right" style="font-size:11px;"></i> Hướng dẫn mua hàng online</a></li>
                <li><a href="#"><i class="fa-solid fa-angle-right" style="font-size:11px;"></i> Chính sách bảo hành chính hãng</a></li>
                <li><a href="#"><i class="fa-solid fa-angle-right" style="font-size:11px;"></i> Chính sách đổi trả 30 ngày</a></li>
                <li><a href="#"><i class="fa-solid fa-angle-right" style="font-size:11px;"></i> Giao hàng siêu tốc 2h</a></li>
                <li><a href="#"><i class="fa-solid fa-angle-right" style="font-size:11px;"></i> Tra cứu đơn hàng</a></li>
            </ul>
        </div>

        <!-- Col 3: VietQR MBBank -->
        <div>
            <h4 class="footer-col-title">Thanh toán VietQR</h4>
            <div class="qr-card">
                <div class="qr-card-title"><i class="fa-solid fa-qrcode"></i> Quét mã MB Bank</div>
                <img src="https://img.vietqr.io/image/MB-0971820307-compact2.png?amount=0&addInfo=Thanh%20toan%20TechZone&accountName=LE%20BINH%20QUYET"
                     alt="VietQR MBBank LE BINH QUYET 0971820307"
                     class="qr-img">
                <div class="qr-info-name">LE BINH QUYET</div>
                <div class="qr-info-sub">MB Bank • STK: 0971820307</div>
            </div>
        </div>

        <!-- Col 4: Kết nối mạng xã hội -->
        <div>
            <h4 class="footer-col-title">Kết nối với chúng tôi</h4>
            <div class="social-btn-group">
                <a href="https://www.facebook.com/le.quyet.482262" target="_blank" rel="noopener noreferrer" class="social-btn fb">
                    <i class="fa-brands fa-facebook-f" style="font-size:16px;"></i> Facebook Lê Quyết
                </a>
                <a href="https://www.tiktok.com/@gauluoi_213" target="_blank" rel="noopener noreferrer" class="social-btn tiktok">
                    <i class="fa-brands fa-tiktok" style="font-size:16px;"></i> TikTok @gauluoi_213
                </a>
                <a href="tel:0971820307" class="social-btn phone">
                    <i class="fa-solid fa-phone" style="font-size:14px;"></i> Hotline: 0971 820 307
                </a>
            </div>
        </div>
    </div>

    <!-- Bản quyền cuối trang -->
    <div class="footer-bottom">
        <p>© <?= date('Y') ?> <strong>TechZone</strong> — Hệ thống máy tính &amp; linh kiện chính hãng. Thiết kế &amp; vận hành bởi <strong>Lê Bình Quyết</strong>.</p>
    </div>
</footer>

</body>
</html>