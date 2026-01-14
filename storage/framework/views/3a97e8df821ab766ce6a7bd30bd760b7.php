<?php $__env->startSection('title', 'Contact Us - Barangay Cubacub Relief and Donation Management Program'); ?>

<?php $__env->startSection('header', 'Contact Us'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">
        <div class="text-center mb-5">
            <h1 class="h2 fw-bold text-dark mb-3">Get In Touch</h1>
            <p class="lead text-muted">We'd love to hear from you. Get in touch with our team.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <!-- Contact Form -->
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 p-md-5">
                        <h2 class="h4 fw-semibold text-dark mb-4">Send us a message</h2>
                        
                        <?php if(session('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo e(session('success')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('donor.contact')); ?>" method="POST" class="needs-validation" novalidate>
                            <?php echo csrf_field(); ?>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label fw-medium text-dark">Full Name</label>
                                <input type="text" name="name" id="name" autocomplete="name" 
                                       value="<?php echo e(Auth::guard('donor')->check() ? Auth::guard('donor')->user()->name : ''); ?>" 
                                       class="form-control form-control-lg rounded-3" required>
                                <div class="invalid-feedback">
                                    Please enter your name.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium text-dark">Email</label>
                                <input id="email" name="email" type="email" autocomplete="email" 
                                       value="<?php echo e(Auth::guard('donor')->check() ? Auth::guard('donor')->user()->email : ''); ?>" 
                                       class="form-control form-control-lg rounded-3" required>
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label fw-medium text-dark">Subject</label>
                                <select id="subject" name="subject" class="form-select form-select-lg rounded-3" required>
                                    <option value="">Select a subject</option>
                                    <option value="donation">Donation Inquiry</option>
                                    <option value="volunteer">Volunteer Opportunities</option>
                                    <option value="partnership">Partnership</option>
                                    <option value="feedback">Feedback/Suggestions</option>
                                    <option value="other">Other</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a subject.
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label fw-medium text-dark">Message</label>
                                <textarea id="message" name="message" rows="5" 
                                          class="form-control form-control-lg rounded-3" 
                                          placeholder="Type your message here..." required></textarea>
                                <div class="invalid-feedback">
                                    Please enter your message.
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input id="privacy" name="privacy" type="checkbox" class="form-check-input" required>
                                <label for="privacy" class="form-check-label">
                                    I agree to the <a href="#" class="text-primary text-decoration-none">privacy policy</a>
                                </label>
                                <div class="invalid-feedback">
                                    You must agree to the privacy policy.
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill py-3 fw-medium">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Contact Information -->
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4 p-md-5">
                                <h2 class="h4 fw-semibold text-dark mb-4">Contact Information</h2>
                                <p class="text-muted mb-4">Have questions or need assistance? Reach out to us through any of the following channels.</p>
                                
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0 bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                        <i class="fas fa-map-marker-alt text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h3 class="h6 fw-semibold text-dark mb-2">Our Office</h3>
                                        <address class="mb-0 text-muted">
                                            123 Barangay Cubacub Relief Avenue<br>
                                            Manila, 1000<br>
                                            Philippines
                                        </address>
                                    </div>
                                </div>
                                
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0 bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                        <i class="fas fa-phone-alt text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h3 class="h6 fw-semibold text-dark mb-2">Phone & Email</h3>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-1">
                                                <span class="fw-medium">Phone:</span> 
                                                <a href="tel:+63281234567" class="text-decoration-none text-muted">+63 2 8123 4567</a>
                                            </li>
                                            <li class="mb-1">
                                                <span class="fw-medium">Mobile:</span> 
                                                <a href="tel:+639123456789" class="text-decoration-none text-muted">+63 912 345 6789</a> (Globe)<br>
                                                <a href="tel:+639987654321" class="text-decoration-none text-muted ms-4">+63 998 765 4321</a> (Smart)
                                            </li>
                                            <li>
                                                <span class="fw-medium">Email:</span> 
                                                <a href="mailto:contact@floodrelief.ph" class="text-decoration-none text-muted">contact@floodrelief.ph</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="d-flex">
                                    <div class="flex-shrink-0 bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                        <i class="far fa-clock text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h3 class="h6 fw-semibold text-dark mb-2">Office Hours</h3>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-1">
                                                <span class="fw-medium">Monday - Friday:</span> 8:00 AM - 6:00 PM
                                            </li>
                                            <li class="mb-1">
                                                <span class="fw-medium">Saturday:</span> 9:00 AM - 2:00 PM
                                            </li>
                                            <li class="mb-2">
                                                <span class="fw-medium">Sunday:</span> Closed
                                            </li>
                                            <li class="text-muted small">
                                                * Emergency hotline available 24/7
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4 p-md-5">
                                <h3 class="h5 fw-semibold text-dark mb-4">Follow Us</h3>
                                <div class="d-flex flex-wrap gap-3">
                                    <a href="#" class="btn btn-outline-primary rounded-circle p-3">
                                        <i class="fab fa-facebook-f fs-5"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-primary rounded-circle p-3">
                                        <i class="fab fa-twitter fs-5"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-primary rounded-circle p-3">
                                        <i class="fab fa-instagram fs-5"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-primary rounded-circle p-3">
                                        <i class="fab fa-linkedin-in fs-5"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-primary rounded-circle p-3">
                                        <i class="fab fa-youtube fs-5"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0 rounded-3 overflow-hidden">
                        <div class="ratio ratio-21x9">
                            <a href="https://www.google.com/maps?q=Flood+Relief+Ave,+Manila,+Metro+Manila" target="_blank" rel="noopener noreferrer">
                                <img src="<?php echo e(asset('images/static_map.png')); ?>" alt="Barangay Cubacub Relief and Donation Management Program Office Location" class="w-100 h-100 object-fit-cover">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-5">
            <h2 class="h3 fw-bold text-center text-dark mb-4">Frequently Asked Questions</h2>
            
            <div class="accordion accordion-flush" id="faqAccordion">
                <!-- FAQ Item 1 -->
                <div class="accordion-item border-0 mb-3 shadow-sm rounded-3">
                    <h3 class="accordion-header" id="faqHeading1">
                        <button class="accordion-button collapsed fw-medium rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="false" aria-controls="faqCollapse1">
                            How can I make a donation?
                        </button>
                    </h3>
                    <div id="faqCollapse1" class="accordion-collapse collapse" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                        <div class="accordion-body rounded-3">
                            <p class="mb-0">
                                You can make a donation through our secure online platform by clicking on the "Donate Now" button. We accept credit/debit cards, bank transfers, and other online payment methods. For large donations or in-kind contributions, please contact our office directly.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="accordion-item border-0 mb-3 shadow-sm rounded-3">
                    <h3 class="accordion-header" id="faqHeading2">
                        <button class="accordion-button collapsed fw-medium rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                            How can I volunteer?
                        </button>
                    </h3>
                    <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                        <div class="accordion-body rounded-3">
                            <p class="mb-0">
                                We welcome volunteers to join our cause. Please visit our Volunteer page to see current opportunities and fill out the volunteer application form. After reviewing your application, our volunteer coordinator will contact you with next steps. No prior experience is necessary for most positions.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="accordion-item border-0 mb-3 shadow-sm rounded-3">
                    <h3 class="accordion-header" id="faqHeading3">
                        <button class="accordion-button collapsed fw-medium rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                            How are my donations used?
                        </button>
                    </h3>
                    <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#faqAccordion">
                        <div class="accordion-body rounded-3">
                            <p class="mb-0">
                                85% of every donation goes directly to our programs and services, including emergency relief, community rebuilding, and disaster preparedness training. 10% supports our administrative costs, and 5% goes toward fundraising efforts. We are committed to transparency and publish annual reports detailing our financials and impact.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="accordion-item border-0 mb-3 shadow-sm rounded-3">
                    <h3 class="accordion-header" id="faqHeading4">
                        <button class="accordion-button collapsed fw-medium rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                            How can I get a receipt for my donation?
                        </button>
                    </h3>
                    <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#faqAccordion">
                        <div class="accordion-body rounded-3">
                            <p class="mb-0">
                                For online donations, you will receive an automated email receipt immediately after your donation is processed. If you need an additional copy or made your donation through other means, please contact our donor services team at donors@floodrelief.ph with your full name, donation amount, and date of donation. We'll be happy to assist you.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        // Form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('donor.layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\flood_control - Copy\ghost\resources\views/donor/contact.blade.php ENDPATH**/ ?>