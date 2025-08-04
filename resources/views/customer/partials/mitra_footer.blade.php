@once
<style>
    .mitra-section {
        background: #fafbfa;
        padding: 48px 0 32px 0;
        border-top: 2px solid #f3f3f3;
    }
    .mitra-section h2 {
        color: #388E3C;
        font-size: 1.7rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .mitra-logos {
        display: flex;
        flex-wrap: wrap;
        gap: 18px;
        justify-content: center;
        margin-top: 24px;
    }
    .mitra-logo-box {
        width: 160px;
        height: 80px;
        background: #e0e0e0;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.10), 0 1.5px 4px rgba(0,0,0,0.08);
        transition: box-shadow 0.25s, transform 0.25s;
    }
    .mitra-logo-box:hover {
        box-shadow: 0 8px 32px rgba(0,0,0,0.18), 0 3px 12px rgba(0,0,0,0.12);
        transform: scale(1.07);
    }
    .mitra-logo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 1;
        padding: 0;
        margin: 0;
        display: block;
        transition: transform 0.25s;
    }
    .footer-contact {
        background: #085c3c;
        color: #fff;
        padding: 48px 0 0 0;
        margin-top: 0;
    }
    .footer-contact .container {
        display: flex;
        flex-wrap: wrap;
        gap: 32px;
        align-items: flex-start;
        justify-content: space-between;
        width: 100%;
    }
    .footer-contact .contact-info {
        flex: 1 1 320px;
        min-width: 280px;
    }
    .footer-contact .contact-info h3 {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 18px;
    }
    .footer-contact .contact-info ul {
        list-style: none;
        padding: 0;
        margin: 0 0 18px 0;
    }
    .footer-contact .contact-info li {
        margin-bottom: 8px;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .footer-contact .contact-info li i {
        width: 20px;
        text-align: center;
    }
    .footer-contact .contact-info address {
        font-style: normal;
        margin-bottom: 10px;
        font-size: 1rem;
    }
    .footer-contact .contact-info .socials {
        margin-top: 18px;
        display: flex;
    }
    .footer-contact .contact-info .socials a {
        color: #fff;
        font-size: 1.3rem;
        opacity: 0.85;
        transition: opacity 0.2s;
        margin-right: 10px;
    }
    .footer-contact .contact-info .socials a:last-child {
        margin-right: 0;
    }
    .footer-contact .contact-info .socials a:hover {
        opacity: 1;
    }
    .footer-contact .map {
        flex: 1 1 400px;
        min-width: 320px;
        margin-bottom: 24px;
        width: 100%;
    }
    .footer-bottom {
        background: #085c3c;
        color: #fff;
        text-align: center;
        padding: 18px 0 12px 0;
        font-size: 1rem;
        border-top: 1px solid #0b7a4c;
    }
    
    /* Mobile Responsive Styles */
    @media (max-width: 900px) {
        .mitra-section {
            padding: 32px 20px 24px 20px;
        }
        .mitra-section h2 {
            font-size: 1.6rem;
            text-align: center;
        }
        .mitra-section p {
            text-align: center;
            font-size: 0.95rem;
        }
        .mitra-logos {
            gap: 15px;
            margin-top: 20px;
        }
        .mitra-logo-box {
            width: 140px;
            height: 70px;
        }
        
        .footer-contact {
            padding: 32px 20px 0 20px;
        }
        .footer-contact .container {
            flex-direction: row;
            gap: 16px;
            align-items: flex-start;
        }
        .footer-contact .map {
            flex: 1;
            margin-bottom: 0;
        }
        .footer-contact .contact-info {
            flex: 0 0 320px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 20px 16px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-left: 0;
        }
        .footer-contact .contact-info h3 {
            font-size: 1.2rem;
            margin-bottom: 16px;
            text-align: center;
            color: #fff;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        .footer-contact .contact-info ul {
            margin-bottom: 16px;
        }
        .footer-contact .contact-info li {
            font-size: 0.9rem;
            margin-bottom: 10px;
            padding: 6px 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            border-left: 3px solid #4CAF50;
            transition: all 0.3s ease;
        }
        .footer-contact .contact-info li:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }
        .footer-contact .contact-info li i {
            margin-right: 8px;
            color: #4CAF50;
            width: 16px;
            text-align: center;
        }
        .footer-contact .contact-info address {
            font-size: 0.9rem;
            text-align: center;
            line-height: 1.5;
            padding: 12px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            margin-bottom: 16px;
        }
        .footer-contact .contact-info .socials {
            justify-content: center;
            margin-top: 16px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
        }
        .footer-contact .contact-info .socials a {
            font-size: 1.3rem;
            margin-right: 15px;
            padding: 6px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        .footer-contact .contact-info .socials a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }
        .footer-bottom {
            padding: 16px 20px 12px 20px;
            font-size: 0.9rem;
        }
    }
    
    @media (max-width: 768px) {
        .mitra-section {
            padding: 32px 16px 24px 16px;
        }
        .mitra-section h2 {
            font-size: 1.5rem;
            text-align: center;
        }
        .mitra-section p {
            text-align: center;
            font-size: 0.95rem;
        }
        .mitra-logos {
            gap: 12px;
            margin-top: 20px;
        }
        .mitra-logo-box {
            width: 120px;
            height: 60px;
        }
        
        .footer-contact {
            padding: 32px 16px 0 16px;
        }
        .footer-contact .container {
            gap: 20px;
        }
        .footer-contact .contact-info h3 {
            font-size: 1.1rem;
            margin-bottom: 16px;
            text-align: center;
        }
        .footer-contact .contact-info ul {
            margin-bottom: 16px;
        }
        .footer-contact .contact-info li {
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        .footer-contact .contact-info address {
            font-size: 0.9rem;
            text-align: center;
            line-height: 1.4;
        }
        .footer-contact .contact-info .socials {
            justify-content: center;
            margin-top: 20px;
        }
        .footer-contact .contact-info .socials a {
            font-size: 1.5rem;
            margin-right: 15px;
        }
        .footer-bottom {
            padding: 16px 16px 12px 16px;
            font-size: 0.9rem;
        }
    }
    
    @media (max-width: 720px) and (min-width: 601px) {
        .footer-contact .container {
            flex-direction: row;
            gap: 16px;
            align-items: flex-start;
        }
        .footer-contact .map {
            flex: 1;
            margin-bottom: 0;
        }
        .footer-contact .contact-info {
            flex: 1;
            padding: 20px 16px;
            border-radius: 12px;
            margin-left: 0;
        }
        .footer-contact .contact-info h3 {
            font-size: 1.2rem;
            margin-bottom: 18px;
        }
        .footer-contact .contact-info li {
            font-size: 0.9rem;
            padding: 6px 10px;
            margin-bottom: 10px;
        }
        .footer-contact .contact-info address {
            font-size: 0.9rem;
            padding: 12px;
            margin-bottom: 18px;
        }
        .footer-contact .contact-info .socials {
            padding: 12px;
            margin-top: 20px;
        }
        .footer-contact .contact-info .socials a {
            font-size: 1.4rem;
            margin-right: 16px;
            padding: 6px;
        }
    }
    
    @media (max-width: 600px) {
        .mitra-section {
            padding: 24px 16px 20px 16px;
        }
        .mitra-section h2 {
            font-size: 1.4rem;
        }
        .mitra-section p {
            font-size: 0.9rem;
        }
        .mitra-logos {
            gap: 12px;
        }
        .mitra-logo-box {
            width: 120px;
            height: 60px;
        }
        
        .footer-contact {
            padding: 24px 16px 0 16px;
        }
        .footer-contact .container {
            flex-direction: column;
            gap: 12px;
        }
        .footer-contact .map {
            margin-bottom: 0;
            width: 100%;
        }
        .footer-contact .contact-info {
            flex: none;
            padding: 20px 16px;
            border-radius: 12px;
            margin-left: 0;
            width: 100%;
        }
        .footer-contact .contact-info h3 {
            font-size: 1.2rem;
            margin-bottom: 18px;
        }
        .footer-contact .contact-info li {
            font-size: 0.9rem;
            padding: 6px 10px;
            margin-bottom: 10px;
        }
        .footer-contact .contact-info address {
            font-size: 0.9rem;
            padding: 12px;
            margin-bottom: 18px;
        }
        .footer-contact .contact-info .socials {
            padding: 12px;
            margin-top: 20px;
        }
        .footer-contact .contact-info .socials a {
            font-size: 1.4rem;
            margin-right: 16px;
            padding: 6px;
        }
        .footer-bottom {
            padding: 14px 16px 10px 16px;
            font-size: 0.85rem;
        }
    }
    
    @media (max-width: 600px) and (min-width: 481px) {
        .footer-contact .container {
            flex-direction: column;
            gap: 12px;
        }
        .footer-contact .map {
            margin-bottom: 0;
            width: 100%;
            min-width: 100%;
        }
        .footer-contact .contact-info {
            flex: none;
            padding: 20px 16px;
            border-radius: 12px;
            margin-left: 0;
            width: 100%;
            min-width: 100%;
        }
        .footer-contact .contact-info h3 {
            font-size: 1.2rem;
            margin-bottom: 18px;
        }
        .footer-contact .contact-info li {
            font-size: 0.9rem;
            padding: 6px 10px;
            margin-bottom: 10px;
        }
        .footer-contact .contact-info address {
            font-size: 0.9rem;
            padding: 12px;
            margin-bottom: 18px;
        }
        .footer-contact .contact-info .socials {
            padding: 12px;
            margin-top: 20px;
        }
        .footer-contact .contact-info .socials a {
            font-size: 1.4rem;
            margin-right: 16px;
            padding: 6px;
        }
    }
    
    @media (max-width: 480px) {
        .mitra-logos {
            gap: 8px;
        }
        .mitra-logo-box {
            width: 100px;
            height: 50px;
        }
        
        .footer-contact {
            padding: 16px 12px 0 12px;
        }
        .footer-contact .container {
            gap: 16px;
        }
        .footer-contact .contact-info {
            padding: 16px 12px;
            border-radius: 10px;
        }
        .footer-contact .contact-info h3 {
            font-size: 1.1rem;
            margin-bottom: 16px;
        }
        .footer-contact .contact-info li {
            font-size: 0.85rem;
            padding: 5px 8px;
            margin-bottom: 8px;
        }
        .footer-contact .contact-info address {
            font-size: 0.85rem;
            padding: 10px;
            margin-bottom: 16px;
        }
        .footer-contact .contact-info .socials {
            padding: 10px;
            margin-top: 16px;
        }
        .footer-contact .contact-info .socials a {
            font-size: 1.3rem;
            margin-right: 12px;
            padding: 5px;
        }
        .footer-bottom {
            padding: 12px 12px 8px 12px;
            font-size: 0.8rem;
        }
    }
    
    @media (max-width: 400px) {
        .mitra-section {
            padding: 20px 12px 16px 12px;
        }
        .mitra-section h2 {
            font-size: 1.3rem;
        }
        .mitra-section p {
            font-size: 0.85rem;
        }
        .mitra-logos {
            gap: 6px;
        }
        .mitra-logo-box {
            width: 90px;
            height: 45px;
        }
        
        .footer-contact {
            padding: 12px 8px 0 8px;
        }
        .footer-contact .container {
            gap: 12px;
        }
        .footer-contact .contact-info {
            padding: 12px 10px;
            border-radius: 8px;
        }
        .footer-contact .contact-info h3 {
            font-size: 1rem;
            margin-bottom: 14px;
        }
        .footer-contact .contact-info li {
            font-size: 0.8rem;
            padding: 4px 6px;
            margin-bottom: 6px;
        }
        .footer-contact .contact-info address {
            font-size: 0.8rem;
            padding: 8px;
            margin-bottom: 14px;
        }
        .footer-contact .contact-info .socials {
            padding: 8px;
            margin-top: 14px;
        }
        .footer-contact .contact-info .socials a {
            font-size: 1.2rem;
            margin-right: 10px;
            padding: 4px;
        }
        .footer-bottom {
            padding: 10px 10px 6px 10px;
            font-size: 0.75rem;
        }
    }
    
    @media (max-width: 360px) {
        .footer-contact {
            padding: 10px 6px 0 6px;
        }
        .footer-contact .container {
            gap: 8px;
        }
        .footer-contact .contact-info {
            padding: 10px 8px;
            border-radius: 6px;
        }
        .footer-contact .contact-info h3 {
            font-size: 0.95rem;
            margin-bottom: 12px;
        }
        .footer-contact .contact-info li {
            font-size: 0.75rem;
            padding: 3px 5px;
            margin-bottom: 5px;
        }
        .footer-contact .contact-info address {
            font-size: 0.75rem;
            padding: 6px;
            margin-bottom: 12px;
        }
        .footer-contact .contact-info .socials {
            padding: 6px;
            margin-top: 12px;
        }
        .footer-contact .contact-info .socials a {
            font-size: 1.1rem;
            margin-right: 8px;
            padding: 3px;
        }
        .footer-bottom {
            padding: 8px 8px 4px 8px;
            font-size: 0.7rem;
        }
    }
    
    .tiktok-icon {
        margin-left: -5px;
    }
</style>
@endonce
<div class="mitra-section">
    <div class="container">
        <h2>Mitra</h2>
        <p>Dalam melaksanakan tugas dan fungsinya, BRMP berkolaborasi dengan mitra dari dalam negeri dan mitra internasional.</p>
        <div class="mitra-logos">
            <a href="https://www.irri.org/" target="_blank"><div class="mitra-logo-box"><img src="{{ asset('images/IRRI.webp') }}" alt="IRRI"></div></a>
            <a href="https://www.fao.org/fao-who-codexalimentarius/en" target="_blank"><div class="mitra-logo-box"><img src="{{ asset('images/Codex.webp') }}" alt="Codex"></div></a>
            <a href="https://www.fao.org/home/en" target="_blank"><div class="mitra-logo-box"><img src="{{ asset('images/FAO.webp') }}" alt="FAO"></div></a>
            <a href="https://www.afaci.org/" target="_blank"><div class="mitra-logo-box"><img src="{{ asset('images/AFACI.webp') }}" alt="AFACI"></div></a>
            <a href="https://www.jircas.go.jp/en" target="_blank"><div class="mitra-logo-box"><img src="{{ asset('images/JIRCAS.webp') }}" alt="JIRCAS"></div></a>
            <a href="https://kan.or.id/" target="_blank"><div class="mitra-logo-box"><img src="{{ asset('images/KAN.webp') }}" alt="KAN"></div></a>
            <a href="https://www.bsn.go.id/" target="_blank"><div class="mitra-logo-box"><img src="{{ asset('images/BSN.webp') }}" alt="BSN"></div></a>
            <a href="https://www.ekon.go.id/" target="_blank"><div class="mitra-logo-box"><img src="{{ asset('images/Pancasila.webp') }}" alt="Pancasila"></div></a>
            <a href="https://www.pertanian.go.id/" target="_blank"><div class="mitra-logo-box"><img src="{{ asset('images/BRMP.webp') }}" alt="BRMP"></div></a>
        </div>
    </div>
</div>
<div class="footer-contact">
    <div class="container">
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2653.25834159555!2d112.62337852569887!3d-7.912831491927426!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd62a061e7881d7%3A0x75efe25fb5148e1a!2sBRMP%20JATIM%20-%20BALAI%20PENERAPAN%20MODERNISASI%20PERTANIAN%20JAWA%20TIMUR!5e1!3m2!1sen!2sid!4v1752202733481!5m2!1sen!2sid" width="100%" height="260" style="border:0; border-radius:12px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>        </div>
        <div class="contact-info">
            <h3>KONTAK</h3>
            <ul>
                <li><i class="fas fa-phone"></i> (021) 780 6202, WhatsApp Center 081181340678</li>
                <li><i class="fas fa-fax"></i> (021) 780 0644</li>
                <li><i class="fas fa-envelope"></i> brmp@pertanian.go.id</li>
            </ul>
            <address>
                Jalan Raya Karangploso No.Km.04<br>
                Kel. Turi Rejo, Kepuharjo, Kec. Karang Ploso<br>
                Malang - Jawa Timur<br>
                Indonesia<br>
                65152<br>
                <a href="https://www.brmp.pertanian.go.id" style="color:#fff;text-decoration:underline;">www.brmp.pertanian.go.id</a>
            </address>
            <div class="socials">
                <a href="https://brmp.pertanian.go.id/" target="_blank" title="Website"><i class="fas fa-globe"></i></a>
                <a href="https://wa.me/+6281181340678" target="_blank" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                <a href="https://www.facebook.com/brmpkementan" target="_blank" title="Facebook"><i class="fab fa-facebook-square"></i></a>
                <a href="https://www.youtube.com/@brmpkementan" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="https://www.instagram.com/brmpkementan" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://twitter.com/brmpkementan" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="https://tiktok.com/@brmpkementan" target="_blank" title="TikTok" class="tiktok-icon"><i class="fab fa-tiktok"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; 2024 - 2025 Badan Perakitan dan Modernisasi Pertanian. All Right Reserved
    </div>
</div> 