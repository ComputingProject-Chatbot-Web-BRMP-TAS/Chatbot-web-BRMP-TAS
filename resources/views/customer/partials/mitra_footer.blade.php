@once
    <style>
        /* Sembunyikan mitra dan kontak di mobile */
        @media (max-width: 1023px) {
            .footer-contact {
                display: none;
            }
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
            flex-wrap: wrap;
            gap: 8px;
            justify-content: flex-start;
            align-items: center;
        }

        .footer-contact .contact-info .socials a {
            color: #fff;
            font-size: 1.2rem;
            opacity: 0.85;
            transition: all 0.3s ease;
            padding: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            flex-shrink: 0;
            text-decoration: none;
        }

        .footer-contact .contact-info .socials a:hover {
            background: rgba(255, 255, 255, 0.2);
            opacity: 1;
            transform: scale(1.1);
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


        .footer-contact .contact-info .socials a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }

        .footer-bottom {
            padding: 16px 20px 12px 20px;
            font-size: 0.9rem;
        }




        .tiktok-icon {
            margin-left: -5px;
        }

        .footer-contact .contact-info .socials {
            overflow: visible;
            max-width: 100%;
        }
    </style>
@endonce

<div class="footer-contact">
    <div class="container" style="margin-bottom: 20px;">
        <div class="map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2653.25834159555!2d112.62337852569887!3d-7.912831491927426!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd62a061e7881d7%3A0x75efe25fb5148e1a!2sBRMP%20JATIM%20-%20BALAI%20PENERAPAN%20MODERNISASI%20PERTANIAN%20JAWA%20TIMUR!5e1!3m2!1sen!2sid!4v1752202733481!5m2!1sen!2sid"
                width="100%" height="260" style="border:0; border-radius:12px;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
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
                <a href="https://www.brmp.pertanian.go.id"
                    style="color:#fff;text-decoration:underline;">www.brmp.pertanian.go.id</a>
            </address>
            <div class="socials">
                <a href="https://brmp.pertanian.go.id/" target="_blank" title="Website"><i class="fas fa-globe"></i></a>
                <a href="https://wa.me/+6281181340678" target="_blank" title="WhatsApp"><i
                        class="fab fa-whatsapp"></i></a>
                <a href="https://www.facebook.com/brmpkementan" target="_blank" title="Facebook"><i
                        class="fab fa-facebook-square"></i></a>
                <a href="https://www.youtube.com/@brmpkementan" target="_blank" title="YouTube"><i
                        class="fab fa-youtube"></i></a>
                <a href="https://www.instagram.com/brmpkementan" target="_blank" title="Instagram"><i
                        class="fab fa-instagram"></i></a>
                <a href="https://twitter.com/brmpkementan" target="_blank" title="Twitter"><i
                        class="fab fa-twitter"></i></a>
                <a href="https://tiktok.com/@brmpkementan" target="_blank" title="TikTok" class="tiktok-icon"><i
                        class="fab fa-tiktok"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; 2024 - 2025 Badan Perakitan dan Modernisasi Pertanian. All Right Reserved
    </div>
</div>
