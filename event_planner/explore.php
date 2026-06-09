<?php 
require_once 'db.php'; 
session_start();

// Fetch events directly from your newly populated MySQL data table
try {
    $stmt = $pdo->query("SELECT * FROM events ORDER BY event_date ASC");
    $events = $stmt->fetchAll();
} catch (Exception $e) {
    $events = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Events | EliteEvents</title>
    <style>
        /* Cute Pink & Pastel Aesthetic Theme Architecture */
        :root {
            --primary: #ff769f;          /* Bright pastel pink for buttons and focus */
            --primary-light: #ffb3c6;    /* Soft blush pink for borders and highlights */
            --primary-dark: #e0537d;     /* Deep rose pink for hover states */
            --secondary: #fcd34d;        /* Soft pastel gold for a tiny sparkle accent */
            --dark-bg: #2d1b22;          /* Cozy deep plum-brown instead of harsh black */
            --card-bg: #ffffff;          /* Clean white for event cards */
            --text-main: #4a2834;        /* Deep berry colored text instead of gray */
            --text-muted: #a78bfa;       /* Pastel lavender for secondary icons/text */
            --body-bg: #fff0f3;          /* Sweet, soft pastel pink-tinted background */
            --border-color: #ffe3e8;     /* Ultra soft pink borders */
            --radius-lg: 20px;           /* Rounder, cuter corners for cards and inputs */
            --radius-sm: 10px;          /* Rounder button edges */
            --shadow-sm: 0 8px 16px -4px rgba(255, 118, 159, 0.1);
            --shadow-lg: 0 20px 30px -10px rgba(74, 40, 52, 0.15);
            --transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Bouncy, playful transitions */
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: system-ui, -apple-system, sans-serif; }
        body { background-color: var(--body-bg); color: var(--text-main); }

        /* Navigation Style Layout */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 8%;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo { font-size: 24px; font-weight: 800; color: var(--dark-bg); text-decoration: none; }
        .logo span { background: linear-gradient(to right, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

        nav ul { display: flex; list-style: none; gap: 30px; align-items: center; }
        nav ul li a { text-decoration: none; color: var(--text-muted); font-weight: 600; }
        nav ul li a.active { color: var(--primary); }

        .btn-auth-nav {
            background: var(--dark-bg);
            color: white !important;
            padding: 8px 18px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            transition: var(--transition);
        }
        .btn-auth-nav:hover { background: var(--primary); }
        .btn-logout-nav { background: #ef4444; color: white !important; padding: 8px 18px; border-radius: var(--radius-sm); font-size: 14px; text-decoration: none;}
        .btn-logout-nav:hover { background: #dc2626; }

        /* Hero Showcase Header */
        .hero { background: linear-gradient(135deg, #0f172a 0%, #9a0f85 100%); color: white; padding: 60px 8%; text-align: center; }
        .hero h1 { font-size: 38px; margin-bottom: 12px; }

        .search-container {
            max-width: 600px;
            margin: 20px auto 0 auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 6px;
            border-radius: var(--radius-lg);
            display: flex;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .search-container input { flex: 1; background: transparent; border: none; outline: none; padding: 10px 15px; color: white; font-size: 16px; }
        .search-container input::placeholder { color: #94a3b8; }
        .search-container button { background: #ffffff; color: var(--dark-bg); border: none; padding: 0 24px; border-radius: calc(var(--radius-lg) - 4px); font-weight: 700; cursor: pointer; }

        /* Main Grid Wrapper Styling */
        .main-layout { padding: 40px 8%; }
        .category-strip { display: flex; justify-content: center; gap: 12px; margin-bottom: 40px; }
        .filter-pill { background: var(--card-bg); border: 1px solid var(--border-color); color: var(--text-muted); padding: 8px 20px; font-weight: 600; border-radius: 30px; cursor: pointer; transition: var(--transition); }
        .filter-pill.active, .filter-pill:hover { background: var(--dark-bg); color: #ffffff; }

        .events-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px; }
        .event-card { background: var(--card-bg); border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--border-color); display: flex; flex-direction: column; transition: var(--transition); }
        .event-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-lg); }

        .image-wrapper { height: 200px; background-size: cover; background-position: center; position: relative; }
        .pill-badge { position: absolute; top: 15px; left: 15px; background: rgba(255, 255, 255, 0.9); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; color: var(--primary-dark); }

        .card-body { padding: 25px; display: flex; flex-direction: column; flex: 1; }
        .card-body h3 { font-size: 20px; margin-bottom: 10px; }
        .info-row { font-size: 14px; color: var(--text-muted); margin-bottom: 6px; }
        .card-description { font-size: 14px; color: #475569; margin: 12px 0; line-height: 1.5; }

        .card-footer { display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 15px; border-top: 1px solid var(--border-color); }
        .price-tag { font-size: 20px; font-weight: 800; color: var(--text-main); }
        .price-tag.free { color: var(--primary-dark); } /* Sweet pink instead of green for free items */

        .action-btn { background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer; }
        .action-btn:hover { background: var(--primary-dark); }

        footer { background: var(--dark-bg); color: #94a3b8; text-align: center; padding: 30px; margin-top: 60px; }
        .user-greeting { font-weight: 700; color: var(--primary-dark); font-size: 15px; }
    </style>
</head>
<body>

    <!-- Header Navigation Section -->
    <header class="navbar">
        <a href="index.html" class="logo">Elite<span>Events</span></a>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="explore.php" class="active">Explore</a></li>
                
                <!-- Checks session data to change visible auth buttons dynamically -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="user-greeting">Hi, <?= htmlspecialchars($_SESSION['user_name']) ?>!</li>
                    <li><a href="logout.php" class="btn-logout-nav">Sign Out</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="btn-auth-nav">Sign In</a></li>
                    <li><a href="register.php" class="btn-auth-nav" style="background:var(--primary);">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- UI Filter Search Banner -->
    <section class="hero">
        <h1>Live Event Marketplace</h1>
        <div class="search-container">
            <input type="text" id="liveSearchInput" placeholder="Search events dynamically...">
            <button type="button">Search</button>
        </div>
    </section>

    <!-- Main View Content Area -->
    <main class="main-layout">
        <div class="category-strip">
            <button class="filter-pill active" data-filter="all">All Gatherings</button>
            <button class="filter-pill" data-filter="Technology">Technology</button>
            <button class="filter-pill" data-filter="Exhibitions">Exhibitions</button>
            <button class="filter-pill" data-filter="Music">Music</button>
        </div>

        <!-- Automated Event Loop Grid -->
        <section class="events-grid">
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $row): ?>
                    <div class="event-card" data-category="<?= htmlspecialchars($row['category']) ?>">
                        <div class="image-wrapper" style="background-image: url('<?= htmlspecialchars($row['image_url']) ?>');">
                            <span class="pill-badge"><?= htmlspecialchars($row['category']) ?></span>
                        </div>
                        <div class="card-body">
                            <h3 class="card-title"><?= htmlspecialchars($row['title']) ?></h3>
                            <div class="info-row">📅 <?= date('M d, Y', strtotime($row['event_date'])) ?></div>
                            <div class="info-row">📍 <span class="card-loc"><?= htmlspecialchars($row['location']) ?></span></div>
                            <p class="card-description"><?= htmlspecialchars(substr($row['description'], 0, 100)) ?>...</p>
                            <div class="card-footer">
                                <span class="price-tag <?= $row['price'] == 0 ? 'free' : '' ?>">
                                        <?= $row['price'] == 0 ? 'FREE' : 'KSh ' . number_format($row['price'], 0) ?>
                                </span>
                                <!-- Corrected handler referencing the external JavaScript file app.js mapping links -->
                                <button class="action-btn" onclick="bookEventBridge(<?= $row['id'] ?>)">Get Tickets</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center; width:100%; color:var(--text-muted);">No events found matching your data tables.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>&copy; 2026 EliteEvents Engine.</footer>

    <!-- Pass internal PHP status settings safely to your external script file app.js -->
    <script>
        const userIsAuthenticated = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;
        function bookEventBridge(id) {
            book(id, userIsAuthenticated);
        }
    </script>
    
    <!-- Connects directly to your clean external script logic -->
    <script src="app.js"></script>
</body>
</html>