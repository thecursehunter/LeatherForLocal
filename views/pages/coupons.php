<?php
session_start();
if (isset($_GET['utm_source'])) {
    $_SESSION['utm_source'] = $_GET['utm_source'];
}
$utm = $_SESSION['utm_source'] ?? 'General';
$voucher = ($utm === 'PlanB') ? 'QUACAMON20' : 'VIP20';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Priority Access - LeatherForLocal</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --neon-color: #00f2fe;
            --neon-secondary: #4facfe;
            --glass-bg: rgba(17, 17, 17, 0.7);
        }

        #gridCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            pointer-events: none;
        }

        body {
            background-color: #050505;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(0, 242, 254, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(79, 172, 254, 0.05) 0%, transparent 40%);
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow-x: hidden;
        }

        .capture-container {
            position: relative;
            max-width: 550px;
            width: 90%;
            padding: 3px; /* Space for neon border */
            border-radius: 24px;
            background: linear-gradient(90deg, #ff0000, #ff7300, #fffb00, #48ff00, #00ffd5, #002bff, #7a00ff, #ff00c8, #ff0000);
            background-size: 400%;
            animation: neon-glow 20s linear infinite;
        }

        @keyframes neon-glow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .glass-card {
            background: #0a0a0a; /* Solid background to block neon bleeding */
            border-radius: 22px;
            padding: 40px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .logo-text {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 4px;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            margin-bottom: 25px;
            display: block;
            white-space: nowrap;
        }

        h1 {
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: 15px;
            background: linear-gradient(to right, #fff, #888);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .voucher-frame {
            border: 1px solid rgba(0, 242, 254, 0.2);
            border-radius: 12px;
            padding: 12px 25px;
            margin: 10px auto 30px auto;
            display: inline-block;
            background: rgba(255, 255, 255, 0.02);
        }

        .voucher-highlight {
            font-size: 3rem;
            font-weight: 800;
            margin: 0;
            color: #fff;
            text-shadow: 0 0 10px rgba(0, 242, 254, 0.4);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.04) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            border-radius: 10px;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: rgba(0, 242, 254, 0.4) !important;
            box-shadow: 0 0 15px rgba(0, 242, 254, 0.2) !important;
            outline: none;
        }

        .btn-futuristic {
            background: linear-gradient(45deg, var(--neon-secondary), var(--neon-color));
            border: none;
            color: #000;
            border-radius: 12px;
            padding: 15px;
            font-weight: 700;
            font-size: 1.1rem;
            margin-top: 15px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            z-index: 2;
        }

        .btn-futuristic:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 30px rgba(0, 242, 254, 0.5);
            filter: brightness(1.1);
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #888;
            margin-bottom: 8px;
            display: block;
            text-align: left;
        }

        .success-icon {
            font-size: 5rem;
            background: linear-gradient(45deg, #00ffd5, #4facfe);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <canvas id="gridCanvas"></canvas>
    <div class="capture-container">
        <div class="glass-card">
            <span class="logo-text">LEATHERFORLOCAL</span>
            
            <?php if(isset($_SESSION['lead_success'])): ?>
                <div class="success-icon animate__animated animate__zoomIn">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h1>Verified</h1>
                <p class="text-muted mb-4 small">Mã ưu đãi của bạn đã sẵn sàng</p>
                
                <div class="voucher-frame">
                    <div class="voucher-highlight"><?php echo $voucher; ?></div>
                </div>
                
                <a href="product.php" class="btn btn-futuristic w-100">Mua Sắm Ngay</a>
                <script>
                    setTimeout(() => { window.location.href = 'product.php'; }, 4000);
                </script>
                <?php unset($_SESSION['lead_success']); ?>

            <?php else: ?>
                <h1>Kích Hoạt Ưu Đãi</h1>
                
                <div class="voucher-frame">
                    <div class="voucher-highlight"><?php echo $voucher; ?></div>
                </div>
                
                <p class="text-muted mb-4 small">Xác thực để nhận quyền lợi giảm giá 20%</p>

                <?php if(isset($_SESSION['lead_error'])): ?>
                    <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-20 text-danger small py-2">
                        <?php echo htmlspecialchars($_SESSION['lead_error']); unset($_SESSION['lead_error']); ?>
                    </div>
                <?php endif; ?>

                <form action="../../src/controllers/LeadController.php" method="POST">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="full_name" placeholder="Họ và tên" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Contact Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Địa chỉ email" required>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="form-label">Mobile Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Số điện thoại" required>
                    </div>
                    <button type="submit" class="btn btn-futuristic w-100">Xác Thực & Nhận Ưu Đãi</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('gridCanvas');
        const ctx = canvas.getContext('2d');

        let width, height;
        let mouse = { x: -1000, y: -1000 };
        let time = 0;

        function resize() {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        }

        window.addEventListener('resize', resize);
        window.addEventListener('mousemove', (e) => {
            mouse.x = e.clientX;
            mouse.y = e.clientY;
        });

        resize();

        function draw() {
            ctx.clearRect(0, 0, width, height);
            time += 0.01;
            
            const dotSpacing = 35; 
            const maxDist = 180;

            for (let x = 0; x < width; x += dotSpacing) {
                for (let y = 0; y < height; y += dotSpacing) {
                    // Fluid motion offset
                    const waveX = Math.sin(time + (x * 0.01)) * 5;
                    const waveY = Math.cos(time + (y * 0.01)) * 5;
                    
                    const posX = x + waveX;
                    const posY = y + waveY;

                    const dx = posX - mouse.x;
                    const dy = posY - mouse.y;
                    const dist = Math.sqrt(dx * dx + dy * dy);
                    
                    let opacity = 0.06;
                    let size = 0.8;
                    let color = '255, 255, 255';

                    if (dist < maxDist) {
                        const ratio = 1 - dist / maxDist;
                        opacity = 0.06 + ratio * 0.4;
                        size = 0.8 + ratio * 1.5;
                        color = '0, 242, 254'; 
                    }

                    ctx.fillStyle = `rgba(${color}, ${opacity})`;
                    ctx.beginPath();
                    ctx.arc(posX, posY, size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            requestAnimationFrame(draw);
        }

        draw();
    </script>
</body>
</html>
