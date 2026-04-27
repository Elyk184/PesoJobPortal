<!-- FOOTER / CONTACT -->
<footer id="contact" class="peso-footer" style="background: linear-gradient(135deg, #0a1428 0%, #0f1f35 50%, #08141f 100%); color: #e0e7ff; padding: 4rem 2rem 1.5rem; margin-top: 6rem; border-top: 3px solid #d72638; box-shadow: 0 -8px 24px rgba(0, 0, 0, 0.3); width: 100%; display: block;">
    <div style="max-width: 1300px; margin: 0 auto;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 3rem; margin-bottom: 3rem;">
            <!-- About Section -->
            <div>
                <div style="display: flex; align-items: center; margin-bottom: 1.5rem; gap: 1rem;">
                    <img src="{{ asset('images/logo.png') }}" alt="PESO Logo" style="width: 48px; height: 42px; object-fit: cover; border-radius: 50%;">
                    <div>
                        <h4 style="color: #ffffff; font-weight: 800; font-size: 16px; margin: 0; letter-spacing: -0.3px;">PESO</h4>
                        <p style="margin: 0.25rem 0 0 0; font-size: 12px; color: #b0b8d4; font-weight: 600;">Manolo Fortich</p>
                    </div>
                </div>
                <p style="color: #cbd5e1; font-size: 14px; line-height: 1.6; margin-bottom: 1.5rem;">Public Employment Service Office — Connecting jobseekers with opportunities in Manolo Fortich, Bukidnon.</p>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <a href="https://www.facebook.com/lgupesomanolofortich" target="_blank" style="width: 40px; height: 40px; background: rgba(215, 38, 56, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #d72638; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.background='#d72638'; this.style.color='white'; this.style.transform='translateY(-3px)';" onmouseout="this.style.background='rgba(215, 38, 56, 0.15)'; this.style.color='#d72638'; this.style.transform='none';">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" style="width: 40px; height: 40px; background: rgba(215, 38, 56, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #d72638; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.background='#d72638'; this.style.color='white'; this.style.transform='translateY(-3px)';" onmouseout="this.style.background='rgba(215, 38, 56, 0.15)'; this.style.color='#d72638'; this.style.transform='none';">
                        <i class="bi bi-twitter"></i>
                    </a>
                </div>
            </div>

            <!-- Contact Section -->
            <div>
                <h4 style="color: #ffffff; font-weight: 800; font-size: 16px; margin-bottom: 1.5rem; letter-spacing: -0.3px;">Contact Us</h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 1rem; color: #cbd5e1; font-size: 14px;">
                        <i class="bi bi-geo-alt-fill" style="color: #d72638; font-size: 1rem; margin-top: 2px; flex-shrink: 0;"></i>
                        <span>Gen. Andres Bonifacio St. Cor. Albarece St., Brgy. Tankulan, Manolo Fortich, Bukidnon 8703</span>
                    </li>
                    <li style="display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 1rem; color: #cbd5e1; font-size: 14px;">
                        <i class="bi bi-envelope-fill" style="color: #d72638; font-size: 1rem; margin-top: 2px; flex-shrink: 0;"></i>
                        <span>peso@manolofortich.gov.ph</span>
                    </li>
                    <li style="display: flex; align-items: flex-start; gap: 0.75rem; color: #cbd5e1; font-size: 14px;">
                        <i class="bi bi-telephone-fill" style="color: #d72638; font-size: 1rem; margin-top: 2px; flex-shrink: 0;"></i>
                        <span>(088) 123-4567</span>
                    </li>
                </ul>
            </div>

            <!-- Quick Links Section -->
            <div>
                <h4 style="color: #ffffff; font-weight: 800; font-size: 16px; margin-bottom: 1.5rem; letter-spacing: -0.3px;">Quick Links</h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 0.75rem;"><a href="{{ url('/') }}" style="color: #cbd5e1; text-decoration: none; font-size: 14px; transition: all 0.3s ease;" onmouseover="this.style.color='#d72638';" onmouseout="this.style.color='#cbd5e1';">Home</a></li>
                    <li style="margin-bottom: 0.75rem;"><a href="{{ url('/#about-main') }}" style="color: #cbd5e1; text-decoration: none; font-size: 14px; transition: all 0.3s ease;" onmouseover="this.style.color='#d72638';" onmouseout="this.style.color='#cbd5e1';">About Us</a></li>
                    <li style="margin-bottom: 0.75rem;"><a href="{{ url('/#features') }}" style="color: #cbd5e1; text-decoration: none; font-size: 14px; transition: all 0.3s ease;" onmouseover="this.style.color='#d72638';" onmouseout="this.style.color='#cbd5e1';">Services</a></li>
                    <li style="margin-bottom: 0.75rem;"><a href="{{ route('login') }}" style="color: #cbd5e1; text-decoration: none; font-size: 14px; transition: all 0.3s ease;" onmouseover="this.style.color='#d72638';" onmouseout="this.style.color='#cbd5e1';">Login</a></li>
                    <li><a href="{{ url('/contact') }}" style="color: #cbd5e1; text-decoration: none; font-size: 14px; transition: all 0.3s ease;" onmouseover="this.style.color='#d72638';" onmouseout="this.style.color='#cbd5e1';">Contact</a></li>
                </ul>
            </div>

            <!-- Office Hours Section -->
            <div>
                <h4 style="color: #ffffff; font-weight: 800; font-size: 16px; margin-bottom: 1.5rem; letter-spacing: -0.3px;">Office Hours</h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; color: #cbd5e1; font-size: 14px;">
                        <span>Monday - Thursday</span>
                        <span style="color: #fff; font-weight: 600;">7:30 AM - 6:00 PM</span>
                    </li>
                    <li style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; color: #cbd5e1; font-size: 14px;">
                        <span>Friday</span>
                        <span style="color: #fff; font-weight: 600;">Closed</span>
                    </li>
                    <li style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; color: #cbd5e1; font-size: 14px;">
                        <span>Saturday</span>
                        <span style="color: #fff; font-weight: 600;">Closed</span>
                    </li>
                    <li style="display: flex; justify-content: space-between; color: #cbd5e1; font-size: 14px;">
                        <span>Sunday</span>
                        <span style="color: #fff; font-weight: 600;">Closed</span>
                    </li>
                </ul>
                <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(215, 38, 56, 0.2);">
                    <a href="https://www.facebook.com/lgupesomanolofortich" target="_blank" style="background: linear-gradient(135deg, #d72638 0%, #ff6b7a 100%); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.75rem; font-weight: 600; font-size: 14px; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(215, 38, 56, 0.3)';" onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                        <i class="bi bi-facebook"></i>
                        <span>Facebook</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div style="border-top: 1px solid rgba(215, 38, 56, 0.2); padding-top: 2rem; margin-top: 2rem; text-align: center;">
            <p style="margin: 0; font-size: 13px; color: #b0b8d4;">&copy; {{ date('Y') }} PESO Job Portal System — Manolo Fortich, Bukidnon. All rights reserved.</p>
        </div>
    </div>
</footer>
