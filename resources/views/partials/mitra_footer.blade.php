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
        width: 120px;
        height: 60px;
        background: #e0e0e0;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }
    .mitra-logo-box img {
        max-width: 90px;
        max-height: 40px;
        opacity: 0.7;
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
            <div class="mitra-logo-box"></div>
            <div class="mitra-logo-box"></div>
            <div class="mitra-logo-box"></div>
            <div class="mitra-logo-box"></div>
            <div class="mitra-logo-box"></div>
            <div class="mitra-logo-box"></div>
            <div class="mitra-logo-box"></div>
            <div class="mitra-logo-box"></div>
            <div class="mitra-logo-box"></div>
            <div class="mitra-logo-box"></div>
        </div>
    </div>
</div>
<div class="footer-contact">
    <div class="container">
        <div class="map">
            <iframe src="https://www.google.com/maps?q=Jl.+Raya+Ragunan+No.29,+RT.8%2FRW.6,+Jati+Padang,+Ps.+Minggu,+Kota+Jakarta+Selatan,+Daerah+Khusus+Ibukota+Jakarta+12540&output=embed" width="100%" height="260" style="border:0; border-radius:12px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="contact-info">
            <h3>KONTAK</h3>
            <ul>
                <li><i class="fas fa-phone"></i> (021) 780 6202, WhatsApp Center 081181340678</li>
                <li><i class="fas fa-fax"></i> (021) 780 0644</li>
                <li><i class="fas fa-envelope"></i> brmp@pertanian.go.id</li>
            </ul>
            <address>
                Jl. Raya Ragunan No. 29<br>
                Kel. Jati Padang, Kec. Ps Minggu<br>
                Jakarta Selatan - DKI Jakarta<br>
                Indonesia<br>
                12540<br>
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