<footer class="py-5 mt-auto" style="background-color: #fff; border-top: 1px solid var(--sandstorm-beige);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
                <h6 class="tenor-sans text-jungle mb-1" style="font-size: 0.85rem; letter-spacing: 0.2rem;">DAYÚNAN</h6>
                <p class="khula text-muted mb-0" style="font-size: 0.65rem; letter-spacing: 0.05rem;">
                    14th Lacson Street &middot; Bacolod City, Philippines
                </p>
            </div>

            <div class="col-md-4 text-center d-none d-md-block">
                <div style="width: 30px; height: 1px; background: var(--sandstorm-beige); margin: 0 auto 10px;"></div>
                <p class="khula text-muted mb-0" style="font-size: 0.6rem; opacity: 0.7; letter-spacing: 0.1rem; text-transform: uppercase;">
                    &copy; {{ date('Y') }} — Dayunan
                </p>
            </div>

            <div class="col-md-4 text-center text-md-end">
                <div class="d-flex justify-content-center justify-content-md-end gap-4">
                    <a href="https://www.facebook.com/dayunan.bcd" 
                       target="_blank" 
                       class="social-icon" 
                       title="Follow us on Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    
                    <a href="https://www.instagram.com/dayunan.bcd?igsh=cm56aDlpMDc1anN3" 
                       target="_blank" 
                       class="social-icon" 
                       title="Follow us on Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    
                    <a href="mailto:dayunan.bcd@gmail.com" 
                       class="social-icon" 
                       title="Email Us">
                        <i class="bi bi-envelope"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Social Icon Aesthetic Hover */
    .social-icon {
        color: var(--jungle-green);
        font-size: 1.15rem;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: inline-block;
        opacity: 0.8;
    }

    .social-icon:hover {
        color: var(--terracotta);
        transform: translateY(-3px);
        opacity: 1;
    }

    /* Logic to keep footer grounded with Body Flex */
    footer {
        flex-shrink: 0;
    }
</style>