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
    }
    .footer-bottom {
        background: #085c3c;
        color: #fff;
        text-align: center;
        padding: 18px 0 12px 0;
        font-size: 1rem;
        border-top: 1px solid #0b7a4c;
        
    }
    @media (max-width: 900px) {
        .footer-contact .container {
            flex-direction: column;
            gap: 24px;
        }
        .footer-contact .map {
            margin-bottom: 18px;
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